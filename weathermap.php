<?php
/*
	weathermap.php
	Nathan J. Dane, 2018.
	Gets weather data from the Met Office to make an old style
	BBC Ceefax Weather map.
*/

/*
City area	|			Array element numbers
AB	 2	|	Max Temperature							0
BE	 11	|	Min Temperature							1
CA	 7	|	Weather									2
CR	 6	|	Headline								3
ED	 3	|	Title (e.g. This Evening and tonight)	4
EX	 10	|	Summary									5
IN	 1	|	Time (e.g 19:00)						6
LO	 9	|
MA	 5	|
NE	 4	|
ST	 8	|
*/

require "simpleweather.php";
include "header.php";

$inhtml=file_get_html("Inverness.html");
$IN=getWeather($inhtml,0);
$abhtml=file_get_html("Aberdeen.html");
$AB=getWeather($abhtml,0);
$edhtml=file_get_html("Edinburgh.html");
$ED=getWeather($edhtml,0);
$behtml=file_get_html("Belfast.html");
$BE=getWeather($behtml,0);
$nehtml=file_get_html("NewcastleUponTyne.html");
$NE=getWeather($nehtml,0);
$mahtml=file_get_html("Manchester.html");	// Get the latest weather, keep the html in the memory for later
$MA=getWeather($mahtml,0);
$sthtml=file_get_html("Stafford.html");
$ST=getWeather($sthtml,0);
$cahtml=file_get_html("Cambridge.html");
$CA=getWeather($cahtml,0);
$crhtml=file_get_html("Cardiff.html");
$CR=getWeather($crhtml,0);
$lohtml=file_get_html("London.html");
$LO=getWeather($lohtml,0);
$exhtml=file_get_html("Exeter.html");
$EX=getWeather($exhtml,0);

function writeHeader()
{
	echo "DE,Weather Map\r\n";
	echo "DS,Inserter\r\n";
	echo 'SP,\\192.168.1.9\ceefax\new.tti'."\r\n";
}

function findWeather($weather)
{
	$output=array();	// All the weather comparison stuff that was here was useless and kept breaking so it's gone.
	$weather=ucwords($weather);
	$weather = str_replace(' Night', '', $weather);
	if (strpos($weather, 'Rain') !== false) 
		$weather = str_replace(' Shower', '', $weather);
	$weather = str_replace(' Day', '', $weather);
	$output=array($weather);
	return $output;
}

function writePage($AB,$BE,$CA,$CR,$ED,$EX,$IN,$LO,$MA,$NE,$ST,$s)
{
	$red="Q";
	$green="R";
	$yellow="S";
	$magenta="U";	// Colours defined here
	$cyan="V";
	$blue="T";
	$white="W";
	$colours=array($cyan,$green,$magenta,$yellow,$blue,$red,$white);
	$cities=array('IN','AB','ED','NE','MA','CR','CA','ST','LO','EX','BE');	// Cities should be in THIS order or things won't work
	$missedcities=$cities;
	$a1=$red;
	$a2=$red;
	$a3=$red;
	$a4=$red;
	$a6=$red;	// All areas are red to begin with
	$a5=$red;
	$a8=$red;
	$a7=$red;
	$a9=$red;
	$a10=$red;
	$a11=$red;

	$units=0;
	$tens=0;
	$places=array();
	while ($tens<10)	// Compare everywhere with everywhere
	{
		if($units==$tens)	// Don't compare the same weather (duh)
		{
			$units++;
		}
		$return=array_intersect(findWeather(${$cities[$tens]}[2]),findWeather(${$cities[$units]}[2]));
		if (!empty($return))
		{
			array_push($places,(array($tens,$units,$return)));	// Add all similar areas to the array
		}
		if($units==10)
		{
			$units=$tens+1;	// No need to compare things twice
			$tens++;
		}
		else
		{
			$units++;
		}
	}
	$grouptitle=array();
	foreach($places as $area)
	{
		$arrayname=$area[2][0];
		if (!isset($$arrayname))
		{
			$$arrayname=array();
			array_push($grouptitle,$arrayname);	// If it isn't there already, add it to the list
		}
		if(!in_array($area[0],$$arrayname))
		{
			array_push($$arrayname,$area[0]);
		}
		if(!in_array($area[1],$$arrayname))
		{
			array_push($$arrayname,$area[1]);
		}
	}
	$weather=array();
	foreach($grouptitle as $arrayname)
	{
		array_push($weather,(array((${$arrayname}[0]),$arrayname,$colours[0])));	// Possibly make the colours more random
		foreach($$arrayname as $area)
		{
			$missedcities[($area)]='';
			$area='a'.($area+1);
			$$area=$colours[0];
		}
		array_shift($colours);
	}
	$missedcities=array_filter($missedcities);	// These are all the places that weren't in groups
	foreach($missedcities as $test)
	{
		$lcity=strtolower($test);
		switch($lcity)
		{
			case 'be' : ;	// Convert cities to numbers.
				$no=11;
				break;
			case 'ca' : ;
				$no=7;
				break;
			case 'cr' : ;
				$no=6;
				break;
			case 'ex' : ;
				$no=10;
				break;
			case 'st' : ;
				$no=8;
				break;
			case 'ed' : ;
				$no=3;
				break;
			case 'in' : ;
				$no=1;
				break;
			case 'ab' : ;
				$no=2;
				break;
			case 'lo' : ;
				$no=9;
				break;
			case 'ma' : ;
				$no=5;
				break;
			case 'ne' : ;
				$no=4;
				break;
		}
		$extra=findweather(${$test}[2]);
		array_push($weather,(array(($no-1),$extra[0],$colours[0])));
		$area='a'.($no);
		$$area=$colours[0];
		if (count($colours)>1)
			array_shift($colours);
	}
	foreach($cities as $city)
	{
		$city=strtolower($city);
		$city1=$city.'1';
		$city2=$city.'2';
		$pad=STR_PAD_LEFT;
		switch($city)
		{
			case 'be' : ;
				$pad=STR_PAD_RIGHT;
				$len=11;
				break;
			case 'ca' : ;
				$len=8;		// Get how long each text area is
				break;
			case 'cr' : ;
			case 'ex' : ;
			case 'st' : ;
				$pad=STR_PAD_RIGHT;
				$len=13;
				break;
			case 'ed' : ;
				$len=15;
				break;
			case 'in' : ;
			case 'ab' : ;
				$len=16;
				break;
			case 'lo' : ;
				$len=10;
				break;
			case 'ma' : ;
				$len=11;
				break;
			case 'ne' : ;
				$len=14;
				break;
		}
		$$city1=str_pad(" ",$len,' ',$pad);		// Make sure they all exist even if they're empty
		$$city2=str_pad(" ",$len,' ',$pad);
	}
	foreach($weather as $text)
	{
		$pad=STR_PAD_LEFT;
		switch(($text[0]+1))	// If space was a problem, these could become a separate function, but it's not so it won't.
		{
			case '01': ;
				$city='in';
				$len=15;
				break;
			case '02': ;
				$city='ab';
				$len=15;
				break;
			case '03': ;
				$city='ed';
				$len=14;
				break;
			case '04': ;
				$city='ne';
				$len=13;
				break;
			case '05': ;
				$city='ma';
				$len=10;
				break;
			case '06': ;
				$city='cr';
				$pad=STR_PAD_RIGHT;
				$len=12;
				break;
			case '07': ;
				$city='ca';
				$len=7;
					break;
			case '08': ;
				$city='st';
				$pad=STR_PAD_RIGHT;
				$len=12;
				break;
			case '09': ;
				$city='lo';
				$len=9;
				break;
			case '10': ;
				$city='ex';
				$pad=STR_PAD_RIGHT;
				$len=12;
				break;
			case '11': ;
				$city='be';
				$pad=STR_PAD_RIGHT;
				$len=10;
				break;
			}
			switch($text[2])
			{
				case "Q": ;
					$textcol="A";	// Make sure the text is the same colour as the area it describes
					break;
				case "R": ;
					$textcol="B";
					break;
				case "S": ;
					$textcol="C";
					break;
				case "U": ;
					$textcol="E";
					break;
				case "V": ;
					$textcol="F";
					break;
				case "T": ;
					$textcol="D";
					break;
				case "W": ;
					$textcol="G";
					break;
			}
			$city1=$city.'1';
			$city2=$city.'2';
			$A=1;
			$utext=explode('\r\n',wordwrap($text[1],$len,'\r\n',true));
			foreach ($utext as $text)
			{
				$city1=$city.$A;
				$$city1=str_pad("$textcol$text",$len+2,' ',$pad); // +2 to take the control code into account.
				$A++;
			}
		}
	$temp=0;				// If its nighttime, get the minimum temp, otherwise get max
	if ($s=='2') $temp=1;
	$title=$AB[4].' '.$AB[6];
	$title=str_replace(':', '', $title);
	$title=str_pad($title,40,' ',STR_PAD_BOTH);	// Centered Title
	$title=substr($title,3);
	echo "PN,4010$s\r\n";
	echo "SC,000$s\r\n";
	echo "PS,8000\r\n";
	echo "CT,15,T\r\n";
	echo "RE,0\r\n";
	intHeader();
	echo "OL,1,T]G$title\r\n";
	echo "OL,2,           ^Z$a1 4`~|}            G $s/2 \r\n";
	printf ("OL,3,           Z$a1`?0~G%1$02d$a1"."%%  $in1\r\n",$IN[$temp]);
	echo "OL,4,           $a1Zj**gppp $in2\r\n";
	echo "OL,5,           ^Z$a2({5                \r\n";
	printf ("OL,6,            Z$a2!'~G%1$02d"."$a2"."!$ab1\r\n",$AB[$temp]);		// This is a real mess, but it works
	echo "OL,7,           ^Z$a2 ~ow1 $ab2\r\n";
	echo "OL,8,$be1^Z$a3*y?sp  $ed1\r\n";
	printf ("OL,9,           ^Z$a3"."j)\"G %1$02d$a3} $ed2\r\n",$ED[$temp]);
	echo "OL,10,       ^Z$a11"."p|t $a3"."x$a4"."g0 $ne1\r\n";
	printf ("OL,11,       Z$a11"."nG%1$02d$a11"."t$a3+\""."$a4".'G%2$02d'."$a4"." $ne2\r\n",$BE[$temp],$NE[$temp]);
	echo "OL,12,       Z$a11+$a4`4$a4+|0             \r\n";
	echo "OL,13,        Z$a11+%*o!$a4\" $a5 *u  $ma1\r\n";
	printf ("OL,14,$be2  ^Z$a6`  $a5"."*G %1$02d"."$a5"."} $ma2\r\n",$MA[$temp]);
	echo "OL,15,$st1^Z$a6"."k|"."$a7"."            \r\n";
	printf ("OL,16,$st2^Z$a6'oG %1$02d"."$a8"."}zt $ca1\r\n",$ST[$temp]);
	printf ("OL,17,$cr1  Z$a6"."j^"."$a7"."G %1$02d"."$a8"." $ca2\r\n",$CA[$temp]);
	printf ("OL,18,$cr2Z$a6"."x|^G %1$02d"."$a8"."'         \r\n",$CR[$temp]);
	echo "OL,19,             ^Z$a6"."! +/'i"."$a9"."qp0        \r\n";
	printf ("OL,20,$ex1^Z$a10  tG %1$02d"."$a9"."/!        \r\n",$LO[$temp]);
	printf ("OL,21,$ex2Z$a10 zG%1$02d"."$a10"."^/s/$a9/? $lo1\r\n",$EX[$temp]);
	echo "OL,22,            Z$a10"."8?' \"'    \"    $lo2\r\n";
	echo "OL,23,D]G        From the Met Office          \r\n";
	echo "OL,24,AN.Ire WeathBSportCTrav Head FMain Menu \r\n";
	echo "FL,402,300,430,100,0,199\r\n";
}
writeHeader();
writePage($AB,$BE,$CA,$CR,$ED,$EX,$IN,$LO,$MA,$NE,$ST,1);

$IN=getWeather($inhtml,1);
$AB=getWeather($abhtml,1);
$ED=getWeather($edhtml,1);
$BE=getWeather($behtml,1);
$NE=getWeather($nehtml,1);
$MA=getWeather($mahtml,1);	// Get the next time
$ST=getWeather($sthtml,1);
$CA=getWeather($cahtml,1);
$CR=getWeather($crhtml,1);
$LO=getWeather($lohtml,1);
$EX=getWeather($exhtml,1);

writePage($AB,$BE,$CA,$CR,$ED,$EX,$IN,$LO,$MA,$NE,$ST,2);
