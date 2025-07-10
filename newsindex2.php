<?php
// newsindex Make P100 carousel, P101 headlines, P102 index.
// Run after newsreader.php
// WARNING! There are hidden characters in this text that your editor may treat as whitespace.
// If you take them out then the page formatting may be disrupted.
// Use Notepad++ with Encoding UTF8 and Show all characters.
include "simple_html_dom.php";

function writeHeader()
{
	echo "SP,c:\Minited\inserter\ONAIR\P102.tti\r\n";
	echo "DE,Read back page  20/11/07\r\n";
	echo "PN,10200\r\n";
	echo "CT,99,C\r\n";
	echo "SC,0000\r\n";
	echo "PS,8000\r\n";
	echo "MS,0\r\n";
	echo "OL,0,XXXXXXXXCEEFAX 1 mpp DAY dd MTH hh:nn/ss\r\n"; // An inserter will not use row 0, but wxTED and Muttlee do.	
	echo "OL,1,„“|h4|h4 `h44|`<th<|h4h<t hth4|$|hh4|,$\r\n";
	echo "OL,2,„“oz%k48!*uu?*u?j7}juju? j7o51ozz%s{5\r\n";
	echo "OL,3,”//-,/,-.///,,./,.-.,-,-,./-.-.,.-,,/,,.	\r\n";
}

function writeFooter()
{
	echo "OL,21,† \r\n";
	echo "OL,22,”ƒSummary‡103ƒExtra‡140ƒFront page ‡100\r\n";
	echo "OL,23,„ƒLottery‡555ƒFlash‡150ƒRegional   ‡160\r\n";
	echo "OL,24,Summary ‚1st story ƒLocalNews†Main Menu\r\n";
	echo "FL,103,104,160,100,F,109\r\n";
}

$count=21;	// Number of pages in P100
$mpp="10000";
writeHeader();
$OL=4;
for ($i=0;$i<$count && $OL<21;$i++)
{
	$page="page$i.html";		// The default input name
	$html = file_get_html($page);	// Get the whole file

	//echo $page."\r\n";
	$cat= $html->find('meta[property=og:type]');	// Category of story
	//echo "stuff=".$cat[0]->content."\r\n";

	//$cat= $html->find('meta[name=Headline]');	// Category of story
	$cat=$html->find("title");
	//$headline=$cat[0]->plaintext;
	$headline=	htmlspecialchars_decode ($cat[0]->plaintext,ENT_QUOTES);		// Decode html entities	
	//echo "headline=$headline\r\n";
	$textcol='‡';	// white
	if ($OL<7) $textcol='†';	// cyan
	
	$headline=substr(trim($headline),0,36);
	// echo "headline=".strlen($headline)."\r\n";
	if (strlen($headline)<36)
	{
		$headline=substr(str_pad($headline,35),0,35);
		$headline.='ƒ';
		
	}
	if ($OL==17)
		echo "OL,17,ƒ Other news 3/3 \r\n";
	else
		echo "OL,$OL,$textcol$headline".(104+$i)."\r\n";
	$OL++;
}
writeFooter();
?>