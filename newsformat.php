<?php
// Load a BBC news page and format it for a typical Ceefax news page.
// Uses simple_html_dom.php which can be downloaded from sourceforge
include "simple_html_dom.php";
include "replace.php";
//include "header.php";
// We can set up some template values here instead of hard coding them
// Cope a header. Find the starting line, style and number of lines.
// Also get ready to load in the footer
$line=4;	// The first line that we can write on.
/**
 * \param $file : Filename of the source page
 * \param $content : The Section attribute from the news page
 * \param $mppss : Magazine, Page number, subcode 10000 to 7FF99
 */
function outputheader($file,$content,$mppss)
{
	$next=sprintf("%1d%02d",$mppss[0],(substr($mppss,1,2)+1)%100);	// This is a bit crude. Next page
	echo "DS,Inserter\r\n";
	echo "SP,$file\r\n";
	echo "DE,$content\r\n";
	echo "CT,15,C\r\n";	// cycle/time TODO
	echo "PN,$mppss\r\n";	// Page number
	echo "SC,1\r\n";	// Not sure! Think we need this for subpages
	echo "PS,8040\r\n";	// Page settings TODO
	echo "MS,0\r\n";	// Not sure
	//intHeader();
	// Which header do we want?

	// Here we map from the RSS URL to the old category names. This table is obviously not complete!
	// If the category is not implemented, we will put out 'news'.
	switch ($content)
	{
	case "Health" : ;
		echo 'OL,1,ój#3kj#3kj#3kîùì | |h<$|,|h4h||4| | '."\r\n";
		echo 'OL,2,ój $kj $kj'." 'kîùì #jw1#ju0j5 #  "."\r\n";
		echo 'OL,3,ó"###"###"###î///,/,-,.,/,-,.-./,/,/////'."\r\n";
		echo 'OL,22,ÑùÉHome news digestá141ÉWorld digestá142'."\r\n";  
		echo 'OL,23,ÑùÉNews Indexá102ÉFlashá150ÉRegionalá160'."\r\n";  
		break;
	case "Technology" : ;
	case "Science and Environment" : ;
	case "Science &amp; Environment" : ;
		echo 'OL,1,Wj#3kj#3kj#3kT]S |,h<$|h<$|0|h<$|,      '."\r\n";
		echo 'OL,2,Wj $kj $kj \'kT]S sju0jw1)ju0s      '."\r\n";
		echo 'OL,3,W"###"###"###T///,,-,.,-,.,/,-,.,,//////'."\r\n";
		echo 'OL,22,ÑùÉHome news digestá141ÉWorld digestá142'."\r\n";  
		echo 'OL,23,ÑùÉNews Indexá102ÉFlashá150ÉRegionalá160'."\r\n";  
		break;
	case "Magazine" : ;
	case "Entertainment and Arts" : ;
	case "Entertainment &amp; Arts" : ;
	case "In Pictures" : ;
	case "Education" : ;
	case "BBC Trending" : ;
	case "Family &amp; Education" : ;
		echo 'OL,1,ój#3kj#3kj#3kîùì    h4h4|,|h<<|h<$'."\r\n";	// Home
		echo 'OL,2,ój $kj $kj \'kîùì    j7k5pj55jw1'."\r\n";
		echo 'OL,3,ó"###"###"###î//////-.-.,,,-..,-,.//////'."\r\n";
		echo 'OL,22,ÑùÉHome news digestá141ÉWorld digestá142'."\r\n";  
		echo 'OL,23,ÑùÉNews Indexá102ÉFlashá150ÉRegionalá160'."\r\n";
		break;
	// Use HOME for want of a better option
	case "Business" : ;	// For mag 1 news, not mag 2 business
	case "UK" : ;
	case "England" : ;
	case "Manchester" : ;
	case "England/Beds Bucks and Herts" : ;
	case "Stoke and Staffordshire" : ;
	case "Stoke &amp; Staffordshire" : ;
	case "Tyne and Wear" : ;
	case "South Yorkshire" : ;
	case "Lancashire" : ;
	case "Suffolk" : ;
	case "Sussex" : ;
	case "Somerset" : ;
	case "England/Birmingham and Black Country" : ;	
	case "Education &amp; Family" : ;
	case "Norfolk" : ;
	case "Hampshire &amp; Isle of Wight" : ;
	case "Devon" : ;
	case "Beds, Herts &amp; Bucks" : ;
	case "Leicester" : ;
	case "The Papers" : ;
	case "Leeds &amp; West Yorkshire" : ;
	case "Dorset" : ;
	case "Essex" : ;
	case "Berkshire" : ;
	case "Cambridgeshire" : ;
	case "Liverpool" : ;
	case "Sheffield &amp; South Yorkshire" : ;
	case "Coventry &amp; Warwickshire" : ;
	case "Nottingham" : ;
	case "Birmingham &amp; Black Country" : ;
	case "Lincolnshire" : ;
	case "Derby" : ;
	case "Highlands &amp; Islands" : ;
	case "Oxford" : ;
	case "Bristol" : ;
	case "Kent" : ;
	case "Humberside" : ;
	case "Surrey" : ;
	case "Northampton" : ;
	case "Tyne &amp; Wear" : ;
	case "Cornwall" : ;
	case "Shropshire" : ;
	case "York &amp; North Yorkshire" : ;
	case "Wiltshire" : ;
	case "Gloucestershire" : ;
	case "Hereford &amp; Worcester" : ;
	case "Tees" : ;
		echo 'OL,1,ój#3kj#3kj#3kîùì    h4h4|,|h<<|h<$'."\r\n";	// Home
		echo 'OL,2,ój $kj $kj \'kîùì    j7k5pj55jw1'."\r\n";
		echo 'OL,3,ó"###"###"###î//////-.-.,,,-..,-,.//////'."\r\n";
		echo 'OL,22,ÑùÉHome news digestá141ÉWorld digestá142'."\r\n";  
		echo 'OL,23,ÑùÉNews Indexá102ÉFlashá150ÉRegionalá160'."\r\n"; 
		break;
	case "Tayside and Central Scotland" : ;
	case "Scotland" : ;
	case "Scotland/Glasgow and West" : ;
	case "NE Scotland, Orkney &amp; Shetland" : ;
	case "Glasgow &amp; West Scotland" : ;
	case "Edinburgh, Fife &amp; East Scotland" : ;
	case "South Scotland" : ;
	case "Scotland/Scotland politics" : ;
	case "Scotland business" : ;
		echo 'OL,1,Wj#3kj#3kj#3kD]S`<$|,h<|(|$| `<l0|th4|l0'."\r\n";
		echo 'OL,2,Wj $kj $kj \'kT]Sb{%pju  pj7k5"o5x%'."\r\n";
		echo 'OL,3,W"###"###"###T//-,/,,-,,/,/,,-.-.,/-.,,/'."\r\n";
		echo 'OL,22,ÑùÉHome news digestá141ÉWorld digestá142'."\r\n";
		echo 'OL,23,ÑùÉNews Indexá102ÉFlashá150ÉRegionalá160'."\r\n";
		break;
	case "Northern Ireland" : ;
	case "Foyle &amp; West" : ;
	case "Northern Ireland Election 2017" : ;
	    echo 'OL,1,ój#3kj#3kj#3kîùì|0| h4|l4|,h4`<thth4|l0'."\r\n";	// N.I.
		echo 'OL,2,ój $kj $kj'." 'kîùì+`j5k4sjuj7j7o5z%"."\r\n";
		echo 'OL,3,ó"###"###"###î//,/,--.,-.,,-,-.,-.-.,,//'."\r\n";
		echo 'OL,22,T]GN IRELANDCHeadlinesG160CSport   G390 '."\r\n";
		echo 'OL,23,D]GNATIONALC Main menuG100CWeatherG 400 '."\r\n";
		break;
	case "Wales" : ;
	case "North West Wales" : ;
	case "North East Wales" : ;
	case "South East Wales" : ;
	case "South West Wales" : ;
		echo 'OL,1,Wj#3kj#3kj#3kD]S   h44|`<l0| h<$x,'."\r\n";
		echo 'OL,2,Wj $kj $kj \'kT]S   *uu?j7k5pjw1s?'."\r\n";
		echo 'OL,3,W"###"###"###T//////,,.-.-.,,-,.,.//////'."\r\n";
		echo 'OL,22,ÑùÉHome news digestá141ÉWorld digestá142'."\r\n";
		echo 'OL,23,ÑùÉNews Indexá102ÉFlashá150ÉRegionalá160'."\r\n";
		break;
	case "London" : ;
		echo 'OL,1,Wj#3kj#3kj#3kD]S | h<|h|0|h<th<|h|0|'."\r\n";
		echo 'OL,2,Wj $kj $kj \'kT]S pjuj5+ju>juj5+'."\r\n";
		echo 'OL,3,W"###"###"###T///,,-,,-./,-,.-,,-./,////'."\r\n";
		echo 'OL,22,ÑùÉHome news digestá141ÉWorld digestá142'."\r\n";
		echo 'OL,23,ÑùÉNews Indexá102ÉFlashá150ÉRegionalá160'."\r\n";
		break;
	case "Europe" : ;
	case "House of Commons" : ;
	case "Asia" : ;
	case "Africa" : ;
	case "Middle East" : ;
	case "World/Asia/China" : ;
	case "Latin America" : ;
	case "US and Canada" : ;
	case "US &amp; Canada" : ;
	case "World" : ;
	case "China" : ;
	case "Latin America &amp; Caribbean" : ;
	case "US Election 2016" : ;
	case "Australia" : ;
	case "India" : ;
	case "China blog" : ;
	case "Cumbria" : ;
	case "South Asia" : ;
		echo 'OL,1,ój#3kj#3kj#3kîùì   |hh4|,|h<l4| h<l0'."\r\n";    // World
		echo 'OL,2,ój $kj $kj \'kîùì   ozz%pj7k4pjuz%'."\r\n";        
		echo 'OL,3,ó"###"###"###î/////-,,/,,,-.-.,,-,,/////'."\r\n";
		echo 'OL,22,ÑùÉHome news digestá141ÉWorld digestá142'."\r\n";
		echo 'OL,23,ÑùÉNews Indexá102ÉFlashá150ÉRegionalá160'."\r\n";
		break;
	
	case "UK Politics" : ;
	case "Politics" : ;
	case "Scotland politics" : ;
	case "Wales politics" : ;
	case "N. Ireland Politics" : ;
		echo 'OL,1,ój#3kj#3kj#3kîùì h<|h<|h4 |(|$|h<$|,$ '."\r\n";	// Politics
		echo 'OL,2,ój $kj $kj \'kîùì j7#juju0  ju0s{5 '."\r\n";
		echo "OL,3,ó\"###\"###\"###î///-./-,,-,.,/,/,-,.,,.///\r\n";
		echo 'OL,22,ÑùÉParliament and politics digest...á144'."\r\n";  
		echo 'OL,23,ÑùÉNews Indexá102ÉFlashá150ÉRegionalá160'."\r\n";
		break;
	
	default;	// If all else fails, just say it's news. 
		echo "OL,1,Wj#3kj#3kj#3kT]S     xl0|,h44|h,$\r\n";
		echo 'OL,2,Wj $kj $kj \'kT]S     j5s*uu?bs5'."\r\n";
		echo 'OL,3,W"###"###"###T///////,-.,,/,,.-,.///////'."\r\n";
		echo "OL,22,D]CHome news digestG141CWorld digestG142\r\n";
		echo "OL,23,D]CNews IndexG102CFlashG150CRegionalG160\r\n";
		break;
		}
	if ($next>124)
		echo 'OL,24,ÅIn Depth ÇNews IndxÉHeadlinesÜMain Menu'."\r\n";
	else
		echo 'OL,24,ÅNext NewsÇNews IndxÉHeadlinesÜMain Menu'."\r\n";
	printf( "FL,%d,102,101,100,F,100\r\n",$next);
}

function outputline($lineNumber,$colour,$text,$maxline,$if,$ft)
{
	$utext=htmlspecialchars_decode ($text,ENT_QUOTES);		// Decode html entities
	$utext=preg_replace('/\s+/', ' ',$utext);
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
	if ($if=='y')
		$count++;
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
$title=$html->find("meta[property=og:title]");
$title=substr ($title[0],35);
$title=substr($title, 0, strpos( $title, '"'));
$line+=outputline($line,'É',$title,21,'n',$ft);	// Yellow (edit)

$intro=$html->find('p[class=amp-o-paragraph--bold]');	// Intro para is white

// If there is no introduction we won't be able to render this page
if (!count($intro))
	$line+=outputline($line,'á',"Missing introduction error",21,'n',$ft);
else
	$line+=outputline($line,'á',$intro[0]->plaintext,21,'n',$ft);
$line++;
$found=false;
$count=0;
foreach ($html->find('p[class="amp-o-paragraph"]') as $element)
{
	if ($count==0)
	{
		$count++;	// Skip the first one because it's a message about cookies, which aren't applicable here.
		continue 1;	// Should probably change this so that it checks if it's the cookie message
	}
	if ($line>21)
		break;
	$line+=outputline($line,'Ü',$element->plaintext,21,'y',$ft);
}
?>