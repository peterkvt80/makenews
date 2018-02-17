<?php
/*
	weatherformat.php
	Nathan J. Dane, 2018.
	Gets weather data from the Met Office to make an old style
	BBC Ceefax Weather page.
	If you want to see your area, change the number below to match your nearest city.
	You might also want to change the area title in the header.
*/
$area=3; // City. Currently set to Belfast.
/*
City area	abr	no	|	Array element numbers
Aberdeen	AB	1	|	Max Temperature							0
Belfast		BE	3	|	Min Temperature							1
Cambridge	CA	7	|	Weather									2
Cardiff		CR	8	|	Headline								3
Edinburgh	ED	2	|	Time (e.g. This Evening and tonight)	4
Exeter		EX	10	|	Summary									5
Inverness	IN	0	|	Time (e.g 19:00)						6
London		LO	9	|	Wind Direction							7
Manchester	MA	5	|	Wind Speed								8
Newcastle	NE	4	|	
Stafford	ST	6	|	
*/
include "simpleweather.php";
include "replace.php";
$line=6;
function outputheader()
{
	echo "DE,Weather for NI\r\n";
	echo "DS,Inserter\r\n";
	echo "SP,Weather 402\r\n";
}
function outputpage($a)
{
	$de = date('d');
	$mh = date('m');
	$hr = date('H');
	$mn = date('i');
	$header = "P100CCX E$hr$mn $de$mhFN Irel Weather  AAuto";
	echo "CT,15,C\r\n";	// cycle/time TODO
	echo "PS,8040\r\n";	// Page settings TODO
	echo "PN,4020$a\r\n";	// Page number
	echo "SC,000$a\r\n";	// Not sure! Think we need this for subpages
	echo "MS,0\r\n";	// Not sure
	echo "OL,0,$header\r\n";
	echo 'OL,1,—h,,lh,,lh,,l”||,<<l,,|,,|,,<l<l,,<,,l||'."\r\n";	// N.I.
    echo 'OL,2,—j 1nj 1nj'." =n”“jj5shw{4k7juz5sjw{%  "."\r\n";
	echo 'OL,3,—*,,.*,,.*,,.”“ozz%pj5j5j5j5j5pj5j5  '."\r\n";
	echo 'OL,4,  N IRELAND  ”//-,,/,,-.-.-.-.-.,,-.-.//'."\r\n";
	echo "OL,21,                                    $a/2 \r\n";
	echo 'OL,22,T]GN IRELANDCHeadlinesG160CSport   G390 '."\r\n";  
	echo 'OL,23,D]GNATIONALC Main menuG100CWeatherG 400 '."\r\n";  		
	echo 'OL,24,Outlook‚ NIrelTravƒ Trav Head†Main Menu'."\r\n";	
	printf( "FL,403,437,430,100,F,199\r\n");
}
function makepage($BE)
{
	global $title;
	$n=1;
	$A=1;
	$title=str_replace(':', '',(strtoupper($BE[4])));	// title
	$utext=$BE[5];	// body
	$utext=myTruncate2($utext,228,'.','.');
	$utext=explode('\r\n',wordwrap($utext,19,'\r\n'));		// Wrap the text into separate lines
	if (count($utext)>13)
	{
		$utext=array_slice($utext,0,13);
		$ttext=array_reverse($utext);
		$c=count($ttext);
		foreach ($ttext as $test)
		{
			$c--;
			$result=strchr($test,'.');
			if ($result=false)
			{
				break;
			}
		}
		$utext=array_splice($utext,$c);
	}
	$text=array_pad($utext,13,' ');
	foreach ($text as $line)		// Output all the lines
	{
		if (strlen($line<20))
		{
			$$A=substr(str_pad($line,19),0,19);
			$A++;
		}
	}
	$ht=$BE[0];	// max temp
	$lt=$BE[1];	// min temp
	$dir=$BE[7];	// wind dir
	$spd = $BE[8];	// wind spd
	$spd.='mph';	// Add MPH
	
	$A=1;
	echo "OL,6,ƒ$title\r\n";
	echo "OL,8,‚${$A}“5ƒSTATISTICS       \r\n";  // Output Page
	$A++;
	echo "OL,9,‚${$A}“5ƒ \r\n";
	$A++;
	echo "OL,10,‚${$A}“5‡   Maximum       \r\n";
	$A++;
	echo "OL,11,‚${$A}“5‡Temperatureƒ$ht"."C \r\n";
	$A++;
	echo "OL,12,‚${$A}“5‡                 \r\n";
	$A++;
	echo "OL,13,‚${$A}“5‡   Minumum       \r\n";
	$A++;
	echo "OL,14,‚${$A}“5‡Temperatureƒ$lt"."C \r\n";
	$A++;
	echo "OL,15,‚${$A}“5ƒ                 \r\n";
	$A++;
	echo "OL,16,‚${$A}“5‡       Wind      \r\n";
	$A++;
	echo "OL,17,‚${$A}“5‡  Directionƒ$dir \r\n";
	$A++;
	echo "OL,18,‚${$A}“5‡                 \r\n";
	$A++;
	echo "OL,19,‚${$A}“5‡       Wind      \r\n";
	$A++;
	echo "OL,20,‚${$A}“5‡      Speedƒ$spd\r\n";
	
}

$BE=loadData($area,'1');
outputheader();
outputpage(1);
makepage($BE);
$BE=loadData($area,'2');
outputpage(2);
makepage($BE);
