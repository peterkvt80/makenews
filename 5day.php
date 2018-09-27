<?php
// 5day.php makes the Five Day Forecast on P406. 
// Written by Nathan Dane (c) 2017
include "simpleweather.php";
//include "header.php";

function writeHeader()
{
	$date = date('j').' '.date('M');
	echo "DE,Five Day Forecast\r\n";
	echo "DS,Inserter\r\n";
	echo "SP,\\192.168.1.9\ceefax\MENU406.tti\r\n";
	echo "CT,35,C\r\n";
	echo "PN,40601\r\n";
	echo "SC,0000\r\n";
	echo "PS,8040\r\n";
	intHeader();
	echo "OL,1,Wj#3kj#3kj#3kT]S |hh4|$|l4l<h4|h<h<4\r\n";
	echo "OL,2,Wj \$kj \$kj 'kT]S ozz%1k5j5j7jwj7}\r\n";
	echo "OL,3,W\"###\"###\"###T///-,,/,.,-.-.-.,-,-.,////\r\n";
	echo "OL,5,CUK FIVE DAY FORECAST FROM $date\r\n";
	echo "OL,6,Bmax for 0600-1800   min for 1800-0600\r\n";
	echo "OL,7,C    max minGC          Cmax minGC\r\n";
	echo "OL,8, Belfast             Cardiff\r\n";
	echo "OL,15, Edinburgh           London\r\n";
	echo "OL,24,AReview  B Sport  CTrav Head FMain Menu\r\n";
	echo "FL,406,600,430,100,100,100\r\n";
}

function getData($html,$d,$mintemp)
{
	global $mintemp;
	$data=getWeather($html,$d);
	$Mt=$data[0];
	$mt=$data[1];
	$wt=$data[2];
	$wt = str_replace(' ', '', $wt);
	$wt=strtolower($wt);
	$day=$data[9];
	if ($day=="Today")
		$day=date('D');

	if($mt<$mintemp) $mintemp=$mt;

	switch ($wt)
	{
	case "lightcloud" : ;
		$wt = "lt cld";
		break;
	case "thickcloud" : ;
		$wt = "tk cld";
		break;
	case "partlycloudy" : ;
		$wt = "pt cldy";
		break;
	case "lightrainshower" : ;
	case "heavyrainshower" : ;
		$wt = "showers";
		break;
	case "overcast" : ;
		$wt = "ovrcast";
		break;
	case "sunnyintervals" : ;
		$wt = "sun int";
		break;
	case "thunderstorm" : ;
	case "thunder" : ;
		$wt = "thunder";
		break;
	case "heavyrain" : ;
		$wt="hy rain";
		break;
	case "lightrain" : ;
		$wt="lt rain";
		break;
	case "clearsky" : ;
		$wt="clear";
		break;
	case "sunnyday" : ;
		$wt = "sunny";
		break;
	}
	$wt=substr(trim($wt),0,7);
	$wt=str_pad($wt,7,' ');
	$wt=strtolower($wt);
	
	$mt=str_pad($mt,2,'0',STR_PAD_LEFT);
	$Mt=str_pad($Mt,2,'0',STR_PAD_LEFT);
	
	$day = str_replace('Now', date('D'), $day);
	return "$day  $Mt  $mt $wt";
}

function writeLine($nm,$url1,$url2,$d,$c,$mintemp)
{	
	$ol = getData($url1,$d,$mintemp).' '.getData($url2,$d,$mintemp);
	echo "OL,$nm,$c"."$ol\r\n";
}

function c2f($in)
{
	$out=$in*9/5+32;
	$out=substr(trim($out),0,2);
	$out=str_pad($out,2,' ',STR_PAD_LEFT);
	return $out;
}

$mintemp=100;
writeHeader();
$BE=file_get_html("Belfast".".html");
$CR=file_get_html("Cardiff".".html");
$ED=file_get_html("Edinburgh".".html");
$LO=file_get_html("London".".html");

writeLine(9,$BE,$CR,0,'F',$mintemp);
writeLine(10,$BE,$CR,1,' ',$mintemp);
writeLine(11,$BE,$CR,2,'F',$mintemp);
writeLine(12,$BE,$CR,3,' ',$mintemp);
writeLine(13,$BE,$CR,4,'F',$mintemp);
writeLine(16,$ED,$LO,0,'F',$mintemp);
writeLine(17,$ED,$LO,1,' ',$mintemp);
writeLine(18,$ED,$LO,2,'F',$mintemp);
writeLine(19,$ED,$LO,3,' ',$mintemp);
writeLine(20,$ED,$LO,4,'F',$mintemp);

echo "OL,22,D]GC= ".(str_pad($mintemp,2,' ',STR_PAD_LEFT))." ".(str_pad(($mintemp+2),2,' ',STR_PAD_LEFT))." ".str_pad(($mintemp+4),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+6),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+8),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+10),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+12),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+14),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+16),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+18),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+20),2,' ',STR_PAD_LEFT)." \r\n";
echo "OL,23,D]GF= ".c2f($mintemp)." ".c2f($mintemp+2)." ".c2f($mintemp+4)." ".c2f($mintemp+6)." ".c2f($mintemp+8)." ".c2f($mintemp+10)." ".c2f($mintemp+12)." ".c2f($mintemp+14)." ".c2f($mintemp+16)." ".c2f($mintemp+18)." ".c2f($mintemp+20)." \r\n";
