<?php
// newsindex Make P101 headlines.
// Run after newsreader.php
// WARNING! There are hidden characters in this text that your editor may treat as whitespace.
// If you take them out then the page formatting may be disrupted.
// Use Notepad++ with Encoding UTF8 and Show all characters.
include "simple_html_dom.php";
include "replace.php";
include "header.php";

function writeHeader($header)
{
	echo "DS,inserter\r\n";
	echo "SP,c:\Minited\inserter\ONAIR\P302.tti\r\n";
	echo "DE,Football Headlines\r\n";
	echo "CT,99,C\r\n";
	echo "PN,30200\r\n";
	echo "SC,0000\r\n";
	echo "PS,8000\r\n";
	echo "MS,0\r\n";
	intHeader();
	echo "OL,1,—j#3kj#3kj#3k”’ h<h<|h<|(|$|l4|l4| |\r\n";
	echo 'OL,2,—j $kj $kj'." 'k”’ j7juju  {4k500"."\r\n";
	echo 'OL,3,—"###"###"###”///-.-,,-,,/,/,,.,-.,.,.//'."\r\n";
}

function writeFooter()
{
	echo "OL,22,„ƒRESULTS AND FIXTURES SECTION‡339 \r\n";
	echo "OL,23,„ƒBBC WEBSITE: bbc.co.uk/football\r\n";
	echo "OL,24,Top story  ‚Regional ƒHeadlines †Sport\r\n";
	echo "FL,303,300,301,300,F,199\r\n";
}

$count=13;	// Number of headlines
writeHeader();
$OL=4;
for ($i=0;$i<$count && $OL<22;$i++)
{
	$page="foot$i.html";		// The default input name
	$html = file_get_html($page);	// Get the whole file
	$element=$html->find("title");
	$title = substr($element[0]->plaintext, 0, strpos($element[0]->plaintext, '- '));
	$strpos = strpos($title,': '); 
	if(!$strpos) $strpos = -2;
	$title   = substr($title, $strpos + strlen(': ')); 
	$headline=	htmlspecialchars_decode ($title,ENT_QUOTES);		// Decode html entities	
	$textcol='†';	// white
	$title = strtr($headline, $ft);
	$headline = preg_replace("%,.*?,%", '', $title);
	if ($OL<5) $textcol='';	// Double Height
	
	$headline=myTruncate2($headline, 70, " ");
	$headline = iconv("UTF-8", "ASCII//TRANSLIT", $headline);
	$headline=wordwrap($headline,35,"\r\n");
	$headline=explode("\r\n",$headline);
	if (strlen($headline[0])<36)
	{
		$headline[0]=substr(str_pad($headline[0],35),0,35);
		$headline[0].='‡';
		if ($OL==4) $headline[0]=strtoupper($headline[0]);
		
	}
	echo "OL,$OL,$textcol$headline[0]".(303+$i)."\r\n";
	if ($OL==4) $OL++;
	if ($OL==10) $OL++;
	if ($OL==15) $OL++;
	$OL++;
}
writeFooter();
?>