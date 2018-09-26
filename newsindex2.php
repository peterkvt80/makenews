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

function writePage($a,$b,$ft)
{
	$count=21;	// Number of headlines in P100
	$OL=4;
	for ($i=0;$i<$count && $OL<21;$i++)
		{
		$page="page$i.html";		// The default input name
		$html = file_get_html($page);	// Get the whole file
		$title=$html->find("meta[property=og:title]");
		$title=substr ($title[0],35);
		$title=substr($title, 0, strpos( $title, '"'));
		$headline=	htmlspecialchars_decode ($title,ENT_QUOTES);		// Decode html entities	
		$textcol='‡';	// white
		$title = strtr($headline, $ft);
		$headline = preg_replace("%,.*?,%", '', $title);
		if ($OL<7) $textcol='†';	// cyan
	
		$headline=myTruncate2($headline, 35, " ");
		if (strlen($headline)<36)
		{
			$headline=substr(str_pad($headline,35),0,35);
			$headline.='ƒ';
		
		}
		global $first;
		
		if ($OL==10)
			$OL++;
		if ($OL==17)
		{
			echo "OL,17,ƒ Other news $b/3 \r\n";
			$i-=$a;
		}
		else
		{
			echo "OL,$OL,$textcol$headline".(104+$i)."\r\n";
		}
		if ($OL<17) 
			$first[$i] = "OL,$OL,$textcol$headline".(104+$i)."\r\n";
		$OL++;
}
}
function writeSPage($a,$b)
{
	$count=21;	// Number of headlines in P100
	$OL=17;
	
	for ($i=12;$i<$count && $OL<21;$i++)
		{
		$page="page$i.html";		// The default input name
		$html = file_get_html($page);	// Get the whole file
		$cat=$html->find("title");
		$headline=	htmlspecialchars_decode ($cat[0]->plaintext,ENT_QUOTES);		// Decode html entities	
		$textcol='‡';	// white
	
		$headline=myTruncate2($headline, 33, " ");
		if (strlen($headline)<36)
		{
			$headline=substr(str_pad($headline,35),0,35);
			$headline.='ƒ';
		
		}
		if ($OL==17)
		{
			echo "OL,17,ƒ Other news $b/3 \r\n";
			$i-=$a;
		}
		else
			echo "OL,$OL,$textcol$headline".(104+$i)."\r\n";
		$OL++;
}
}
writepageHeader();
writeHeader(1);
writePage(1,1,$ft);
writeFooter();

writeHeader(2);
foreach ( $first as $item ) {
	echo $item;
}
writeSPage(-2,2);
writeFooter();

writeHeader(3);
foreach ( $first as $item ) {
	echo $item;
}
writeSPage(-5,3,$first);
writeFooter();
?>