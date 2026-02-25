<?php
include "simple_html_dom.php";
include "replace.php";
include "header.php";

$line=4;	// The first line that we can write on.

function outputheader($file,$content,$mppss)
{
	// Calculate the next page
	// $next=$mppss[0].(substr($mppss,1,2)+1)%100;
	$next=sprintf("%1d%02d",$mppss[0],(substr($mppss,1,2)+1)%100);	// This is a bit crude. Next page
	//echo "RE,$next\r\n";
	echo "DS,Inserter\r\n";
	echo "SP,$file\r\n";
	echo "DE,$content\r\n";
	echo "PN,$mppss\r\n";	// Page number
	// echo "RE,$content\n";
	echo "CT,15,C\r\n";	// cycle/time TODO
	echo "SC,1\r\n";	// Not sure! Think we need this for subpages
	echo "PS,8040\r\n";	// Page settings TODO
	echo "MS,0\r\n";	// Not sure
	intHeader();
	echo 'OL,1,—j#3kj#3kj#3k”’ h<h<|h<|(|$|l4|l4| |'."\r\n";	// N.I.
    echo 'OL,2,—j $kj $kj '."'k”’ j7juju  {4k500"."\r\n";
	echo 'OL,3,—"###"###"###”///-.-,,-,,/,/,,.,-.,.,.//'."\r\n";
	echo 'OL,22,„ƒCEEFAX FOOTBALL SECTION PAGE 302'."\r\n";  
	echo 'OL,23,„ƒBBC WEBSITE: bbc.co.uk/football'."\r\n";  		
	echo 'OL,24,Next page  ‚Football ƒHeadlines †Sport'."\r\n";	
	printf( "FL,%d,302,301,300,F,199\r\n",$next);
}

function outputline($lineNumber,$colour,$text,$maxline,$ft)
{
	$utext=	htmlspecialchars_decode ($text,ENT_QUOTES);		// Decode html entities
	$utext=explode('\r\n',wordwrap($utext,39,'\r\n'));		// Wrap the text into separate lines
	if (count($utext)+$lineNumber>$maxline)					// This would overflow so forget it
	{	
		return 0;
	}
	$count=0;
	foreach ($utext as $key=>&$value) {
		if (strlen($value) < 2) {
			unset($utext[$key]);
		}
	}
	foreach ($utext as $line)							// Output all the lines
	{
		$line = strtr($line, $ft);
		$ln=$lineNumber+$count;
		echo "OL,".$ln.",$colour$line\r\n";
		$count++;
	}
	return $count; 	// return the number lines used
}

$page="Page0.html";		// The default input name
$mpp="10000";
/* From the command line?
 * newsformat.php <source news page> <target text page>
 * Example: php newsformat.php page0.html 10000
 */
if (isset($argc))
{
	$page=$argv[1];
	if ($argc>2)
		$mpp=$argv[2];
}

$html = file_get_html($page);	// Get the whole file

$cat = $html->find('meta[property="article:section"]');
$section = isset($cat[0]) ? $cat[0]->content : 'Sport';
outputheader($page, $section, $mpp);

$element = $html->find("title");
$rawtitle = html_entity_decode($element[0]->plaintext, ENT_QUOTES, 'UTF-8');
$title = substr($rawtitle, 0, strrpos($rawtitle, ' - '));
$strpos = strpos($title, ': ');
if (!$strpos) $strpos = -2;
$title = substr($title, $strpos + 2);
$title = preg_replace("%,.*?,%", '', $title);
$title = str_replace(["\xe2\x80\x98","\xe2\x80\x99","\xe2\x80\x9c","\xe2\x80\x9d"],["'","'",'"','"'],$title);
$line += outputline($line, "\x82", $title, 21, $ft);

$paras = $html->find('p.e1jhz7w10');
$paracount = 0;
$first = true;
foreach ($paras as $element)
{
	if ($paracount > 5) break;
	if ($line > 22) break;
	$parent = $element->parent();
	while ($parent)
	{
		if (strpos($parent->class, 'FigureCaption') !== false || $parent->tag === 'figcaption')
			break;
		$parent = $parent->parent();
	}
	if ($parent && (strpos($parent->class, 'FigureCaption') !== false || $parent->tag === 'figcaption'))
		continue;
	$text = html_entity_decode($element->plaintext, ENT_QUOTES, 'UTF-8');
	$text = str_replace(["\xe2\x80\x98","\xe2\x80\x99","\xe2\x80\x9c","\xe2\x80\x9d"],["'","'",'"','"'],$text);
	if (strlen(trim($text)) < 10) continue;
	if ($first)
	{
		$line += outputline($line, " ", $text, 22, $ft);
		$line++;
		$first = false;
	}
	else
	{
		if (strlen($text) < 60) continue;
		$used = outputline($line, "\x86", $text, 22, $ft);
		if ($used == 0) break;
		$line += $used;
		if ($line < 22) $line++;
	}
	$paracount++;
}
if ($first)
	echo "OL,8,Sorry, this story can not be displayed\r\n";
?>