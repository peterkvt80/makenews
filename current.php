<?php
// current.php makes the Current UK Weather on P404. 
// Written by Nathan Dane (c) 2017
include "simple_html_dom.php";

echo "DE,UK Cities\r\n";
echo "DS,Inserter\r\n";
echo "SP,\\192.168.1.9\ceefax\MENU404.tti\r\n";
echo "CT,20,T\r\n";

function writeHeader($s)
{
	echo "PN,4040$s\r\n";
	echo "SC,000$s\r\n";
	echo "PS,8040\r\n";
	echo "OL,1,Wj#3kj#3kj#3kT]S |hh4|$|l4l<h4|h<h<4\r\n";
	echo "OL,2,Wj \$kj \$kj 'kT]S ozz%1k5j5j7jwj7}\r\n";
	echo "OL,3,W\"###\"###\"###T///-,,/,.,-.-.-.,-,-.,////\r\n";
	echo "OL,4,                                     $s/3\r\n";
	echo "OL,7,C            temp   wind  pres\r\n";
	echo "OL,8,                C    mph    mB\r\n";
	echo "OL,20,C   pressureFRCrisingGSCsteadyBFCfalling\r\n";
	echo "OL,24,AWarningsB NIreTV CTrav Head FMain Menu\r\n";
	echo "FL,405,600,430,100,100,100\r\n";
}
$mintemp=100;

function getData($html,$c,$mintemp)
{
	global $mintemp;
	global $title;
	
	$page=file_get_html("https://www.metoffice.gov.uk/mobile/observation/$html");
	$html=$page->find('div[id=divDayModule1]',-1);
	if ($html == null)
	{
		$html=$page->find('div[id=divDayModule0]',-1);
		//echo "No divDayModule1, falling back to div[id=divDayModule0]";
	}
	
	$title=$html->find('tr[class="weatherTime"]',-1);
	$title=$title->find('td',-1)->plaintext;
	$title=str_replace(':', '', $title);
	$title=str_replace(' ', '', $title);
	
	$weather=$html->find('tr[class=weatherWX]',-1);	// Weather
	$weather=$weather->find('td',-1);
	$weather=$weather->title;
	$weather=str_replace('day', '', $weather);
	$weather=str_replace('night', '', $weather);
	
	$temp=$html->find('tr[class="weatherTemp"]',-1);	// Temperature
	$temp=$temp->find('i[class="icon icon-animated"]',-1)->plaintext;
	$temp=str_replace('	', '', $temp);
	$temp=str_replace('&nbsp;&deg;', '', $temp);
	$temp=str_replace(' ', '', $temp);
	$temp=str_replace('C', '', $temp);
	$temp=round ($temp);
	if($temp<$mintemp) $mintemp=$temp;
	$temp=str_pad($temp,2,' ',STR_PAD_LEFT);
	
	$wind=$html->find('tr[class="weatherWind wxContent"]',-1);	// Wind
	$dir=$wind->find('span[class="direction"]',-1)->plaintext;	// Direction
	$dir=str_replace(' ', '', $dir);
	$dir=str_pad($dir,3,' ',STR_PAD_LEFT);
	
	$spd=$wind->find('i[class="icon]',-1)->plaintext;	// Speed
	$spd=str_replace('	', '', $spd);
	$spd=str_replace('&nbsp;&deg;', '', $spd);
	$spd=str_replace(' ', '', $spd);
	$spd=str_pad($spd,2,' ',STR_PAD_LEFT);
	
	$press=$html->find('tr[class="weatherPressure wxContent"]',-1);	// Pressure
	$press=$press->find('td',-1)->plaintext;
	$press=str_replace('	', '', $press);
	$press=str_replace('&nbsp;&deg;', '', $press);
	$press=str_replace(' ', '', $press);
	$press=str_pad($press,4,' ',STR_PAD_LEFT);
	
	$tend=$html->find('tr[class="weatherPressureTendency wxContent last"]',-1);
	$tend=$tend->find('td',-1)->plaintext;
	$tend=str_replace(' ', '', $tend);
	
	switch ($weather)
	{
	case "Light cloud" : ;
		$weather = "lt cld";
		break;
	case "Thick cloud" : ;
		$weather = "tk cld";
		break;
	case "Partly cloudy" : ;
		$weather = "pt cldy";
		break;
	case "LightRainShower" : ;
	case "HeavyRainShower" : ;
		$weather = "showers";
		break;
	case "Overcast" : ;
		$weather = "cloudy";
		break;
	case "Sunny intervals" : ;
		$weather = "sun int";
		break;
	case "Thunderstorm" : ;
	case "Thunder" : ;
		$weather = "thunder";
		break;
	case "Heavy rain" : ;
		$weather="hy rain";
		break;
	case "Light rain" : ;
		$weather="lt rain";
		break;
	case "Clear sky" : ;
		$weather="clear";
		break;
	}
	$weather=substr(trim($weather),0,7);
	$weather=str_pad($weather,7,' ');
	$weather=strtolower($weather);
	
	switch ($tend)
	{
	case "R" : ;
		$rf="FR"."$c";
		break;
	case "S" : ;
		$rf="GS"."$c";
		break;
	case "F" : ;
		$rf="BF"."$c";
		break;
	}
	
	return "$temp $dir $spd  $press$rf$weather";
}

function c2f($in)
{
	$out=$in*9/5+32;
	$out=substr(trim($out),0,2);
	$out=str_pad($out,2,' ',STR_PAD_LEFT);
	return $out;
}

writeHeader(1);
echo "OL,9,FAberdeen      ".(getData("gfnt07u10",'F',$mintemp))."\r\n";
echo "OL,5,CCURRENT UK WEATHER: Report at $title\r\n";
echo "OL,10, Aberystwyth   ".(getData("gcm45jgg9",'G',$mintemp))."\r\n";
echo "OL,11,FBelfast       ".(getData("gcey94cuf",'F',$mintemp))."\r\n";
echo "OL,12, Birmingham    ".(getData("gcqdt4b2x",'G',$mintemp))."\r\n";
echo "OL,13,FBristol       ".(getData("gcnhtnumz",'F',$mintemp))."\r\n";
echo "OL,14, Cardiff       ".(getData("gcjszmp44",'G',$mintemp))."\r\n";
echo "OL,15,FEastbourne    ".(getData("u100y9uwn",'F',$mintemp))."\r\n";
echo "OL,16, Edinburgh     ".(getData("gcvwr3zrw",'G',$mintemp))."\r\n";
echo "OL,17,FGlasgow       ".(getData("gcuvz3bch",'F',$mintemp))."\r\n";
echo "OL,18, Inverness     ".(getData("gfhyzzs9j",'G',$mintemp))."\r\n";
echo "OL,22,D]GC= ".(str_pad($mintemp,2,' ',STR_PAD_LEFT))." ".(str_pad(($mintemp+1),2,' ',STR_PAD_LEFT))." ".str_pad(($mintemp+2),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+3),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+4),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+5),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+6),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+7),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+8),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+9),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+10),2,' ',STR_PAD_LEFT)." \r\n";
echo "OL,23,D]GF= ".c2f($mintemp)." ".c2f($mintemp+1)." ".c2f($mintemp+2)." ".c2f($mintemp+3)." ".c2f($mintemp+4)." ".c2f($mintemp+5)." ".c2f($mintemp+6)." ".c2f($mintemp+7)." ".c2f($mintemp+8)." ".c2f($mintemp+9)." ".c2f($mintemp+10)." \r\n";
$mintemp=100;
writeHeader(2);
echo "OL,9,FIpswich       ".(getData("u12b4ht3f",'F',$mintemp))."\r\n";
echo "OL,5,CCURRENT UK WEATHER: Report at $title\r\n";
echo "OL,10, Isle of Man   ".(getData("gcsewwnue",'G',$mintemp))."\r\n";
echo "OL,11,FLeeds         ".(getData("gcwfhf1w0",'F',$mintemp))."\r\n";
echo "OL,12, Lerwick       ".(getData("gfxnjyxk4",'G',$mintemp))."\r\n";
echo "OL,13,FLincoln       ".(getData("gcrwgdr98",'F',$mintemp))."\r\n";
echo "OL,14, London        ".(getData("gcpvj0v07",'G',$mintemp))."\r\n";
echo "OL,15,FManchester    ".(getData("gcw2hzs1u",'F',$mintemp))."\r\n";
echo "OL,16, Margate       ".(getData("u10ure55u",'G',$mintemp))."\r\n";
echo "OL,17,FNewcastle     ".(getData("gcyc1db7v",'F',$mintemp))."\r\n";
echo "OL,18, Newquay       ".(getData("gbuqu9f0x",'G',$mintemp))."\r\n";
echo "OL,22,D]GC= ".(str_pad($mintemp,2,' ',STR_PAD_LEFT))." ".(str_pad(($mintemp+1),2,' ',STR_PAD_LEFT))." ".str_pad(($mintemp+2),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+3),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+4),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+5),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+6),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+7),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+8),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+9),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+10),2,' ',STR_PAD_LEFT)." \r\n";
echo "OL,23,D]GF= ".c2f($mintemp)." ".c2f($mintemp+1)." ".c2f($mintemp+2)." ".c2f($mintemp+3)." ".c2f($mintemp+4)." ".c2f($mintemp+5)." ".c2f($mintemp+6)." ".c2f($mintemp+7)." ".c2f($mintemp+8)." ".c2f($mintemp+9)." ".c2f($mintemp+10)." \r\n";
$mintemp=100;
writeHeader(3);
echo "OL,9,FNorwich       ".(getData("gfnt07u1s",'F',$mintemp))."\r\n";
echo "OL,5,CCURRENT UK WEATHER: Report at $title\r\n";
echo "OL,10, Oxford        ".(getData("gcpn7mp10",'G',$mintemp))."\r\n";
echo "OL,11,FPeterborough  ".(getData("gcrg49fhe",'F',$mintemp))."\r\n";
echo "OL,12, Plymouth      ".(getData("gbvn9cv4h",'G',$mintemp))."\r\n";
echo "OL,13,FSt Andrews    ".(getData("gfn082k8z",'F',$mintemp))."\r\n";
echo "OL,14, St Helier     ".(getData("gbwxb1tp2",'G',$mintemp))."\r\n";
echo "OL,15,FSalisbury     ".(getData("gcndx0wq3",'F',$mintemp))."\r\n";
echo "OL,16, Shrewsbury    ".(getData("gcq5c6uw4",'G',$mintemp))."\r\n";
echo "OL,17,FSouthampton   ".(getData("gcp185f25",'F',$mintemp))."\r\n";
echo "OL,18, York          ".(getData("gcx4zrw25",'G',$mintemp))."\r\n";
echo "OL,22,D]GC= ".(str_pad($mintemp,2,' ',STR_PAD_LEFT))." ".(str_pad(($mintemp+1),2,' ',STR_PAD_LEFT))." ".str_pad(($mintemp+2),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+3),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+4),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+5),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+6),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+7),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+8),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+9),2,' ',STR_PAD_LEFT)." ".str_pad(($mintemp+10),2,' ',STR_PAD_LEFT)." \r\n";
echo "OL,23,D]GF= ".c2f($mintemp)." ".c2f($mintemp+1)." ".c2f($mintemp+2)." ".c2f($mintemp+3)." ".c2f($mintemp+4)." ".c2f($mintemp+5)." ".c2f($mintemp+6)." ".c2f($mintemp+7)." ".c2f($mintemp+8)." ".c2f($mintemp+9)." ".c2f($mintemp+10)." \r\n";
