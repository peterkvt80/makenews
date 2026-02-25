<?php
// newsindex Make P101 headlines.
// Run after newsreader.php
// WARNING! There are hidden characters in this text that your editor may treat as whitespace.
// If you take them out then the page formatting may be disrupted.
// Use Notepad++ with Encoding UTF8 and Show all characters.
include "simple_html_dom.php";
include "replace.php";
include "header.php";

function writeHeader()
{
	echo "DS,inserter\r\n";
	echo "SP,c:\Minited\inserter\ONAIR\P101.tti\r\n";
	echo "DE,Headlines\r\n";
	echo "CT,99,C\r\n";
	echo "PN,10100\r\n";
	echo "SC,0000\r\n";
	echo "PS,8000\r\n";
	echo "MS,0\r\n";
	intHeader();
	echo "OL,1,Wj#3kj#3kj#3kT]Sh4|h<h<|h<th4h4xl0|$|,\r\n";
	echo 'OL,2,Wj $kj $kj \'kT]Sj7jwj7ju?juj5j51s'."\r\n";
	echo "OL,3,W\"###\"###\"###T//-.,-,-.,-,.-,-.,-.,.,,//\r\n";
}

function writeFooter()
{
	echo "OL,22,W]D     From the BBC News website \r\n";
	echo "OL,23,D]CCATCH UP WITH REGIONAL NEWS      G160\r\n";
	echo "OL,24,ANews IndexBTop StoryCTV/RadioFMain Menu\r\n";
	echo "FL,102,104,600,100,100,199\r\n";
}

$count=13;	// Number of headlines
writeHeader();
$OL=4;
for ($i=0;$i<$count && $OL<22;$i++)
{
	$page="page$i.html";		// The default input name
	$html = file_get_html($page);	// Get the whole file
	$element=$html->find("meta[property=og:title]");
	$rawtitle=substr($element[0],35);
	$title=substr($rawtitle, 0, strpos($rawtitle, '"'));
	$headline= htmlspecialchars_decode ($title,ENT_QUOTES);		// Decode html entities
	$textcol="\x87";	// white
	$title = strtr($headline, $ft);
	$headline = preg_replace("%,.*?,%", '', $title);
	if ($OL<5) $textcol="\x8d";	// Double Height
	
	$headline=myTruncate2($headline, 200, " ");
	$headline = iconv("UTF-8", "ASCII//TRANSLIT", $headline);
	$headline=wordwrap($headline,35,"\r\n");
	$headline=explode("\r\n",$headline);

	$last = count($headline) - 1;
	foreach ($headline as $idx => $line) {
		if ($OL >= 22) break;
		$line = substr(str_pad($line, 35), 0, 35);
		if ($i == 0) $line = strtoupper($line);
		if ($idx == $last) $line .= "\x83" . (104 + $i);
		echo "OL,$OL,$textcol$line\r\n";
		$OL++;
		if ($i == 0) $OL++;
	}
	if ($OL < 22) { echo "OL,$OL, \r\n"; $OL++; }
}
writeFooter();
?>