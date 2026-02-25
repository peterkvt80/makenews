<?php
// current.php makes the Current UK Weather on P404.
// Written by Nathan Dane (c) 2017, updated 2026.
include "simple_html_dom.php";

echo "DE,UK Cities\r\n";
echo "DS,Inserter\r\n";
echo "SP,\\192.168.1.9\ceefax\MENU404.tti\r\n";
echo "CT,20,T\r\n";

function writeHeader($s)
{
	echo "PN,4040$s\r\n";
	echo "SC,000$s\r\n";
	echo "PS,8040\r\n";
	echo "OL,1,Wj#3kj#3kj#3kT]S |hh4|$|l4l<h4|h<h<4\r\n";
	echo "OL,2,Wj \$kj \$kj 'kT]S ozz%1k5j5j7jwj7}\r\n";
	echo "OL,3,W\"###\"###\"###T///-,,/,.,-.-.-.,-,-.,////\r\n";
	echo "OL,4,                                     $s/2\r\n";
	echo "OL,7,C            temp   wind\r\n";
	echo "OL,8,                C    mph   \r\n";
	echo "OL,20,C   pressureFRCrisingGSCsteadyBFCfalling\r\n";
	echo "OL,24,AWarningsB NIreTV CTrav Head FMain Menu\r\n";
	echo "FL,405,600,430,100,100,100\r\n";
}

$mintemp = 100;
$title   = date('H:i');

function getData($filename)
{
	global $mintemp;

	$html = file_get_html($filename);
	if (!$html) return " --  ---  --  --    ";

	$temp = '--';
	$snap = $html->find('div.snapshot.next-hour', 0);
	if (!$snap) $snap = $html->find('div.snapshot.next-day', 0);
	if ($snap)
	{
		$tspan = $snap->find('span[aria-hidden=true]', 0);
		if ($tspan)
		{
			$raw = preg_replace('/[^0-9\-]/', '', $tspan->plaintext);
			if ($raw !== '')
			{
				$temp = (int)$raw;
				if ($temp < $mintemp) $mintemp = $temp;
				$temp = str_pad($temp, 2, ' ', STR_PAD_LEFT);
			}
		}
	}

	$dir = '   ';
	$spd = '  ';
	$windrows = $html->find('tr.wind-row');
	if (isset($windrows[0]))
	{
		$tds = $windrows[0]->find('td');
		if (isset($tds[0]))
		{
			$icon = $tds[0]->find('span[data-type=wind]', 0);
			if ($icon) $dir = str_pad($icon->getAttribute('data-value'), 3, ' ', STR_PAD_LEFT);
			$spd = preg_replace('/[^0-9]/', '', $tds[0]->plaintext);
			$spd = str_pad($spd, 2, ' ', STR_PAD_LEFT);
		}
	}

	$weather = '       ';
	if ($snap)
	{
		$wd = $snap->find('div.heading-l', 0);
		if (!$wd) $wd = $snap->find('div.snapshot-weather-description', 0);
		if ($wd)
		{
			$w = strtolower(trim(preg_replace('/\s+/', '', $wd->plaintext)));
			switch ($w)
			{
				case 'lightcloud':      $weather = 'lt cld '; break;
				case 'thickcloud':      $weather = 'tk cld '; break;
				case 'partlycloudy':    $weather = 'pt cldy'; break;
				case 'lightrainshower':
				case 'heavyrainshower': $weather = 'showers'; break;
				case 'overcast':        $weather = 'cloudy '; break;
				case 'sunnyintervals':  $weather = 'sun int'; break;
				case 'thunderstorm':
				case 'thunder':         $weather = 'thunder'; break;
				case 'heavyrain':       $weather = 'hy rain'; break;
				case 'lightrain':       $weather = 'lt rain'; break;
				case 'clearsky':        $weather = 'clear  '; break;
				case 'sunnyday':        $weather = 'sunny  '; break;
				default: $weather = substr(str_pad(strtolower($w), 7), 0, 7); break;
			}
		}
	}

	return "$temp $dir $spd  $weather";
}

function c2f($in)
{
	$out = $in * 9 / 5 + 32;
	$out = substr(trim($out), 0, 2);
	return str_pad($out, 2, ' ', STR_PAD_LEFT);
}

function tempbar($min)
{
	$out = "C=";
	for ($i = 0; $i <= 10; $i++) $out .= " ".str_pad($min+$i, 2, ' ', STR_PAD_LEFT);
	echo "OL,22,D]G$out \r\n";
	$out = "F=";
	for ($i = 0; $i <= 10; $i++) $out .= " ".c2f($min+$i);
	echo "OL,23,D]G$out \r\n";
}

function row($ol, $colour, $name, $file)
{
	$name = str_pad($name, 14);
	echo "OL,$ol,${colour}$name".(getData($file))."\r\n";
}

writeHeader(1);
row( 9, 'F', 'Aberdeen',   'Aberdeen(Aberdeen).html');
echo "OL,5,CCURRENT UK WEATHER: Report at $title\r\n";
row(10, ' ', 'Belfast',    'Belfast(CountyAntrim).html');
row(11, 'F', 'Cambridge',  'Cambridge(Cambridgeshire).html');
row(12, ' ', 'Cardiff',    'GlamorganC.C.C.(Cardiff).html');
row(13, 'F', 'Edinburgh',  'Edinburgh(Edinburgh).html');
row(14, ' ', 'Exeter',     'Exeter(Devon).html');
row(15, 'F', 'Inverness',  'Inverness(Highland).html');
row(16, ' ', 'London',     'London(GreaterLondon).html');
row(17, 'F', 'Manchester', 'Manchester(GreaterManchester).html');
row(18, ' ', 'Newcastle',  'NewcastleUponTyne(NewcastleuponTyne).html');
tempbar($mintemp);

$mintemp = 100;
writeHeader(2);
row( 9, 'F', 'Stafford',   'Stafford(Staffordshire).html');
echo "OL,5,CCURRENT UK WEATHER: Report at $title\r\n";
tempbar($mintemp);

?>
