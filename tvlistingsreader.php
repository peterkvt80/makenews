<?php
// tvlistingsreader.php
// Downloads TV listings from Freeview EPG XML and saves per channel
// Replaces old bleb.org scraper

$epgurl = "https://raw.githubusercontent.com/dp247/Freeview-EPG/master/epg.xml";
$epgfile = "epg.xml";

// Download the EPG file
echo "Downloading EPG...\n";
$data = file_get_contents($epgurl);
if (!$data) { die("Failed to download EPG\n"); }
file_put_contents($epgfile, $data);
echo "Done.\n";

// Channels we want: label => channel id in epg.xml
$channels = array(
	"BBC1" => "BBCOneNorthernIreland.uk",
	"BBC2" => "BBCTwoNorthernIreland.uk",
	"UTV"  => "UTV.uk",
	"C4"   => "Channel4Ulster.uk",
	"C5"   => "5.uk",
);

$xml = simplexml_load_file($epgfile);
if (!$xml) { die("Failed to parse EPG XML\n"); }

$now       = time();
$today_start = mktime(0,0,0, date('n'), date('j'),   date('Y'));
$today_end   = mktime(0,0,0, date('n'), date('j')+1, date('Y'));
$tom_start   = $today_end;
$tom_end     = mktime(0,0,0, date('n'), date('j')+2, date('Y'));

foreach ($channels as $label => $chanid) {
	$today_progs = array();
	$tom_progs   = array();

	foreach ($xml->programme as $prog) {
		if ((string)$prog['channel'] !== $chanid) continue;

		// Parse start time: "20250224183000 +0000"
		$startstr = (string)$prog['start'];
		$ts = strtotime(substr($startstr,0,8).'T'.substr($startstr,8,6).' '.substr($startstr,15));

		$title = (string)$prog->title;
		$desc  = (string)$prog->desc;
		$time  = date('H:i', $ts);

		$entry = array('time'=>$time, 'title'=>$title, 'desc'=>$desc);

		if ($ts >= $today_start && $ts < $today_end)
			$today_progs[] = $entry;
		elseif ($ts >= $tom_start && $ts < $tom_end)
			$tom_progs[] = $entry;
	}

	// Save today as <label>0.html and tomorrow as <label>3.html
	// Format as simple HTML table to match old bleb.org format
	file_put_contents("{$label}0.html", buildHtml($today_progs, $label, 'today'));
	file_put_contents("{$label}3.html", buildHtml($tom_progs,   $label, 'tomorrow'));
	echo "$label: ".count($today_progs)." today, ".count($tom_progs)." tomorrow\n";
}

function buildHtml($progs, $chan, $when) {
	$out = "<html><body><table>\n";
	foreach ($progs as $p) {
		$title = $p['title'];
		$desc  = $p['desc'];
		$time  = $p['time'];
		$out  .= "<tr><td><b>{$time}</b></td><td><b>{$title}</b></td><td>&nbsp;{$desc}&nbsp;</td></tr>\n";
	}
	$out .= "</table></body></html>\n";
	return $out;
}
?>
