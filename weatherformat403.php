<?php
/*
	weatherformat403.php
	Nathan J. Dane, 2018.
	Gets the UK weather page from the Met Office
	and turns it into Ceefax P403.
*/

include "simple_html_dom.php";
$line=7;	// The first line that we can write on.

function outputinsert($file)
{
	echo "DS,Inserter\r\n";
	echo "SP,$file\r\n";
	echo "DE,National Weather\r\n";
	echo "CT,35,C\r\n";	// cycle/time TODO
}

function outputheader($s) //Header
{
	$de = date('d');
	$mh = date('m');
	$hr = date('H');
	$mn = date('i');
	$header = "P403CCX E$hr$mn $de$mhFUK Outlook      AAuto";
	echo "PN,4030$s\r\n";									// Page number
	echo "SC,000$s\r\n";									// Not sure! Think we need this for subpages
	echo "PS,8040\r\n";										// Page settings TODO
	echo "MS,0\r\n";										// Not sure
	echo "OL,0,$header\r\n";
	echo "OL,1,—j#3kj#3kj#3k”“ |hh4|$|l4l<h4|h<h<4    \r\n";
	echo "OL,2,—j \$kj \$kj 'k”“ ozz%1k5j5j7jwj7}    \r\n";
	echo "OL,3,—\"###\"###\"###”///-,,/,.,-.-.-.,-,-.,////\r\n";
	echo "OL,4,                                    $s/2 \r\n";
	echo "OL,5, UK WEATHER OUTLOOK                     \r\n";
}

function outputfooter()
{
	echo "OL,23,D]G        From the Met Office          \r\n";	// Not from the 'BBC Weather Centre' any more.
	echo "OL,24,UK cities ‚Sport ƒTrav Head †Main Menu \r\n";
	echo "FL,404,300,430,100,100,100\r\n";
}

function outputline($lineNumber,$colour,$text,$maxline)	// 'Borrowed' from Peter Kwan
{
	$utext=	htmlspecialchars_decode ($text,ENT_QUOTES);		// Decode html entities
	$utext=explode('\r\n',wordwrap($utext,39,'\r\n'));		// Wrap the text into separate lines
	if (count($utext)+$lineNumber>$maxline)					// This would overflow so forget it
	{	
		return 0;
	}
	$count=0;
	foreach ($utext as $line)								// Output all the lines
	{
		$ln=$lineNumber+$count;
		echo "OL,".$ln.",$colour$line\r\n";
		$count++;
	}
	return $count; 	// return the number lines used
}

$page="weather3.html";		// UK weather forecast
$html=file_get_html($page);
$forecast=$html->find("div[id=forecastSummaryContent]");
$forecast=$forecast[0]->find("div[data-content-id=0]");
$titles=$forecast[0]->find("h4");
$contents=$forecast[0]->find("p");
array_shift($titles);	// First one is the 'headline', not needed here
array_shift($contents);
$count=0;
outputinsert('MENU403.tti');
outputheader(1);
foreach($titles as $title)
{
	$title=$title->plaintext;
	$content=$contents[$count]->plaintext;
	$title=str_replace(':', '', $title);
	$line+=outputline($line,' ',$title,22);
	$line+=outputline($line,'†',$content,22);
	$line++;
	if ($count==1) 
	{
		$line=7;
		outputfooter();
		outputheader(2);
	}
	$count++;
}
outputfooter();
?>
