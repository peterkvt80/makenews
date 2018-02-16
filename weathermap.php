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

$IN=loadData('0','1');
$AB=loadData('1','1');
$ED=loadData('2','1');
$BE=loadData('3','1');
$NE=loadData('4','1');
$MA=loadData('5','1');
$ST=loadData('6','1');
$CA=loadData('7','1');
$CR=loadData('8','1');
$LO=loadData('9','1');
$EX=loadData('10','1');

function writeHeader()
{
	echo "DE,Weather Map\r\n";
	echo "DS,Inserter\r\n";
	echo 'SP,\\192.168.1.9\ceefax\new.tti'."\r\n";
}

function findWeather($weather)
{
	$output=array();
	$weather=strtolower($weather);
	if (strpos($weather, 'cloudy') !== false) {
		array_push($output,'Cloudy');
	}
	if (strpos($weather, 'overcast') !== false) {
		array_push($output,'Cloudy');
	}
	if (strpos($weather, 'heavy rain') !== false) {
		array_push($output,'Heavy Rain');
	}
	if (strpos($weather, 'light rain') !== false) {
		array_push($output,'Light Rain');
	}
	if (strpos($weather, 'sunny') !== false) {
		array_push($output,'Sunny');
	}
	if (strpos($weather, 'sleet') !== false) {
		array_push($output,'Sleet');
	}
	if (strpos($weather, 'light shower') !== false) {
		array_push($output,'Light Rain');
	}
	if (strpos($weather, 'heavy shower') !== false) {
		array_push($output,'Heavy Rain');
	}
	if (strpos($weather, 'clear') !== false) {
		array_push($output,'Clear');
	}
	if (strpos($weather, 'mist') !== false) {
		array_push($output,'Mist');
	}
	return $output;
}

function writePage($AB,$BE,$CA,$CR,$ED,$EX,$IN,$LO,$MA,$NE,$ST,$s)
{
	$red="Q";
	$green="R";
	$yellow="S";
	$magenta="U";
	$cyan="V";
	$colours=array($cyan,$green,$magenta,$yellow,$red);
	$cities=array('IN','AB','ED','NE','MA','CR','CA','ST','LO','EX','BE');//array('AB','BE','CA','CR','ED','EX','IN','LO','MA','NE','ST');
	$a1=$red;
	$a2=$red;
	$a3=$red;
	$a4=$red;
	$a6=$red;
	$a5=$red;
	$a8=$red;
	$a7=$red;
	$a9=$red;
	$a10=$red;
	$a11=$red;

	$units=0;
	$tens=0;
	$places=array();
	$missedcities=array('IN','AB','ED','NE','MA','CR','CA','ST','LO','EX','BE');
	while ($tens<10)
	{
		if($units==$tens)	// Don't compare the same weather (duh)
		{
			$units++;
		}
		$return=array_intersect(findWeather(${$cities[$tens]}[2]),findWeather(${$cities[$units]}[2]));
		if (!empty($return))
		{
			array_push($places,(array($tens,$units,$return)));
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
			array_push($grouptitle,$arrayname);
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
		array_push($weather,(array((${$arrayname}[0]),$arrayname,$colours[0])));
		foreach($$arrayname as $area)
		{
			$missedcities[($area)]='';
			$area='a'.($area+1);
			$$area=$colours[0];
		}
		array_shift($colours);
	}
	$missedcities=array_filter($missedcities);
	foreach($missedcities as $test)
	{
		$lcity=strtolower($test);
		switch($lcity)
		{
			case 'be' : ;
				$no=11;
				$no2=2;
				break;
			case 'ca' : ;
				$no=7;
				$no2=3;
				break;
			case 'cr' : ;
				$no=6;
				$no2=4;
				break;
			case 'ex' : ;
				$no=10;
				$no2=6;
				break;
			case 'st' : ;
				$no=8;
				$no2=11;
				break;
			case 'ed' : ;
				$no=3;
				$no2=5;
				break;
			case 'in' : ;
				$no=1;
				$no2=7;
				break;
			case 'ab' : ;
				$no=2;
				$no2=1;
				break;
			case 'lo' : ;
				$no=9;
				$no2=8;
				break;
			case 'ma' : ;
				$no=5;
				$no2=9;
				break;
			case 'ne' : ;
				$no=4;
				$no2=10;
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
				$len=8;
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
		$$city1=str_pad(" ",$len,' ',$pad);
		$$city2=str_pad(" ",$len,' ',$pad);
	}
	foreach($weather as $text)
	{
		$pad=STR_PAD_LEFT;
		switch(($text[0]+1))
		{
			case '01': ;
				$city='in';
				$len=17;
				break;
			case '02': ;
				$city='ab';
				$len=17;
				break;
			case '03': ;
				$city='ed';
				$len=16;
				break;
			case '04': ;
				$city='ne';
				$len=15;
				break;
			case '05': ;
				$city='ma';
				$len=12;
				break;
			case '06': ;
				$city='cr';
				$pad=STR_PAD_RIGHT;
				$len=14;
				break;
			case '07': ;
				$city='ca';
				$len=9;
					break;
			case '08': ;
				$city='st';
				$pad=STR_PAD_RIGHT;
				$len=14;
				break;
			case '09': ;
				$city='lo';
				$len=11;
				break;
			case '10': ;
				$city='ex';
				$pad=STR_PAD_RIGHT;
				$len=14;
				break;
			case '11': ;
				$city='be';
				$pad=STR_PAD_RIGHT;
				$len=12;
				break;
			}
			switch($text[2])
			{
				case "Q": ;
					$textcol="A";
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
			}
			$city1=$city.'1';
			$city2=$city.'2';
			$A=1;
			$utext=explode('\r\n',wordwrap($text[1],$len,'\r\n'));		// Wrap the text into separate lines
			foreach ($utext as $text)
			{
				$city1=$city.$A;
				$$city1=str_pad("$textcol$text",$len,' ',$pad);
				$A++;
			}
		}
	$de = date('d');
	$mh = date('m');
	$hr = date('H');
	$mn = date('i');
	$header = "P401CCX E$hr$mn $de$mhFWeathermap      AAuto";
	$temp=0;
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
	echo "OL,0,$header\r\n";
	echo "OL,1,T]G$title\r\n";
	echo "OL,2,           ^Z$a1 4`~|}            G $s/2 \r\n";
	printf ("OL,3,           Z$a1`?0~G%1$02d$a1%\   $in1\r\n",$IN[$temp]);
	echo "OL,4,           $a1Zj**gppp $in2\r\n";
	echo "OL,5,           ^Z$a2({5                \r\n";
	printf ("OL,6,           ^Z$a2!'~G %1$02d"."$a2"."!$ab1\r\n",$AB[$temp]);
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
	echo "OL,22,            Z$a10"."8?' \"'    \"               \r\n";
	echo "OL,23,D]G        From the Met Office          \r\n";
	echo "OL,24,AN.Ire WeathBSportCTrav Head FMain Menu \r\n";
	echo "FL,402,300,430,100,0,199\r\n";
}
writeHeader();
writePage($AB,$BE,$CA,$CR,$ED,$EX,$IN,$LO,$MA,$NE,$ST,1);
$AB=loadData('0','2');
$BE=loadData('1','2');
$CA=loadData('2','2');
$CR=loadData('3','2');
$ED=loadData('4','2');
$EX=loadData('5','2');
$IN=loadData('6','2');
$LO=loadData('7','2');
$MA=loadData('8','2');
$NE=loadData('9','2');
$ST=loadData('10','2');
writePage($AB,$BE,$CA,$CR,$ED,$EX,$IN,$LO,$MA,$NE,$ST,2);
