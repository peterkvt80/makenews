<?php
// newsindex Make P102 index.
// Run after newsreader.php
// WARNING! There are hidden characters in this text that your editor may treat as whitespace.
// If you take them out then the page formatting may be disrupted.
// Use Notepad++ with Encoding UTF8 and Show all characters.
include "simple_html_dom.php";
include "replace.php";
include "header.php";

function writepageHeader()
{
	echo "DS,inserter\r\n";
	echo "SP,.\Pages\MENU102.tti\r\n";
	echo "DE,UK/World News Index\r\n";
	echo "CT,15,T\r\n";
}

function writeHeader($s)
{
	echo "PN,1020$s\r\n";
	echo "SC,000$s\r\n";
	echo "PS,8000\r\n";
	echo "MS,0\r\n";
	intHeader();
	echo "OL,1,„“|h4|h4 `h44|`<th<|h4h<t hth4|$|hh4|,$\r\n";
	echo "OL,2,„“oz%k48!*uu?*u?j7}juju? j7o51ozz%s{5\r\n";
	echo "OL,3,”//-,/,-.///,,./,.-.,-,-,./-.-.,.-,,/,,.\r\n";
}

function writeFooter()
{
	echo "OL,21,† \r\n";
	echo "OL,22,”ƒSummary‡103ƒExtra‡140ƒFront page ‡100\r\n";
	echo "OL,23,„ƒLottery‡555ƒFlash‡150ƒRegional   ‡160\r\n";
	echo "OL,24,Summary ‚1st story ƒLocalNews†Main Menu\r\n";
	echo "FL,103,104,160,100,F,199\r\n";
}

function getLines($i, $ft)
{
	$page="page$i.html";
	$html = file_get_html($page);
	$title=$html->find("meta[property=og:title]");
	$title=substr($title[0],35);
	$title=substr($title, 0, strpos($title, '"'));
	$headline = htmlspecialchars_decode($title, ENT_QUOTES);
	$title = strtr($headline, $ft);
	$headline = preg_replace("%,.*?,%", '', $title);
	$headline = myTruncate2($headline, 200, " ");
	$headline = iconv("UTF-8", "ASCII//TRANSLIT", $headline);
	$headline = wordwrap($headline, 35, "\r\n");
	return explode("\r\n", $headline);
}

function writePage($ft, $b=1)
{
	global $first;
	$first = [];
	$count=21;
	$OL=4;
	$MAXOL=17;

	for ($i=0; $i<$count && $OL<$MAXOL; $i++)
	{
		$lines = getLines($i, $ft);
		$numLines = count($lines);
		$textcol="\x87";	// white
		if ($OL<7) $textcol="\x86";

		$needed = $numLines + ($OL + $numLines < $MAXOL ? 1 : 0);
		if ($OL + $needed > $MAXOL) break;

		$output = "";
		foreach ($lines as $li => $line) {
			$line = substr(str_pad($line, 35), 0, 35);
			if ($li == $numLines-1) {
				$line .= "\x83";
				$row = "OL,$OL,$textcol$line".(104+$i)."\r\n";
			} else {
				$row = "OL,$OL,$textcol$line\r\n";
			}
			echo $row;
			$output .= $row;
			$OL++;
		}

		if ($OL < $MAXOL) {
			$sep = "OL,$OL, \r\n";
			echo $sep;
			$output .= $sep;
			$OL++;
		}

		$first[$i] = $output;
	}

	return count($first);
}

function writeSPage($startIndex, $b, $ft)
{
	$count=21;
	$OL=18;
	$MAXOL=21;

	echo "OL,17,\x83 Other news $b/3 \r\n";

	for ($i=$startIndex; $i<$count && $OL<$MAXOL; $i++)
	{
		$lines = getLines($i, $ft);
		$numLines = count($lines);
		$textcol="\x87";	// white

		if ($OL + $numLines > $MAXOL) break;

		foreach ($lines as $li => $line) {
			$line = substr(str_pad($line, 35), 0, 35);
			if ($li == $numLines-1) {
				$line .= "\x83";
				echo "OL,$OL,$textcol$line".(104+$i)."\r\n";
			} else {
				echo "OL,$OL,$textcol$line\r\n";
			}
			$OL++;
		}
	}

	return $i;
}


writepageHeader();

writeHeader(1);
$firstEndIndex = writePage($ft);
$p2start = writeSPage($firstEndIndex, 1, $ft);
writeFooter();

writeHeader(2);
foreach ($first as $item) echo $item;
$p3start = writeSPage($p2start, 2, $ft);
writeFooter();

writeHeader(3);
foreach ($first as $item) echo $item;
writeSPage($p3start, 3, $ft);
writeFooter();
?>
