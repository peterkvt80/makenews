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

$cat= $html->find('meta[property="article:section"]');	// Category of story
outputheader($page,$cat[0]->content,$mpp); 
$body= $html->find('div[class=story-body]');	// Extract the body part as HTML
$body=str_get_html($body[0]);	// Convert it back to DOM
$element=$html->find("title");
$title = substr($element[0]->plaintext, 0, strpos($element[0]->plaintext, '- '));
$strpos = strpos($title,': '); 
if(!$strpos) $strpos = -2;
$title   = substr($title, $strpos + strlen(': '));
$title = preg_replace("%,.*?,%", '', $title);
$line+=outputline($line,'‚',$title,21,$ft);	// Green

$intro=$body->find('p[class=sp-story-body__introduction]');	// Intro para is white

// If there is no introduction we won't be able to render this page
if (!count($intro))
	$line+=outputline($line,' ',"Missing introduction error",21,$ft);
else
	$line+=outputline($line,' ',$intro[0]->plaintext,21,$ft);
$line++;	// And an extra line space
$found=false;
$paracount=0;
foreach ($body->find('p') as $element)
{
	if ($paracount>4)
		break;
	if ($line>21)
		break;
	if ($found) 
	{
		$line+=outputline($line++,'†',$element->plaintext,21,$ft);
		$paracount++;
	}
	// We output nothing until we get to class=introduction
	// This is the white opening paragraph.
	// Then we do more p tags until we run out of space
	if (strpos($element,"introduction"))
		$found=true;	
}
if (!$found)
	echo "OL,8,Sorry.this story can not be displayed";
?>