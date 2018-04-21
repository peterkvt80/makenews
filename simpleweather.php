<?php
/*
	simpleweather.php
	Nathan J. Dane, 2018.
	Gets a weather page, fetches what is needed from it and 
	returns it as a nice, plain, Tab Separated Variable.
   
You can copy/paste the following as a reference in different code

/*
City area	abr	no	|	Array element numbers
Aberdeen	AB	2	|	Max Temperature							0
Belfast		BE	11	|	Min Temperature							1
Cambridge	CA	7	|	Weather									2
Cardiff		CR	6	|	Headline								3
Edinburgh	ED	3	|	Time (e.g. This Evening and tonight)	4
Exeter		EX	10	|	Summary									5
Inverness	IN	1	|	Time (e.g 19:00)						6
London		LO	9	|	Wind Direction							7
Manchester	MA	5	|	Wind Speed								8
Newcastle	NE	4	|	Day										9
Strafford	ST	8	|	Location								10
*/
include "simple_html_dom.php";

function saveData($http,$day=0,$hour="n")
{
	switch($day)
	{
	case "0" : ;
		$a=0;
		$b=0;
		$c=1;
		break;
	case "1" : ;
		$a=1;
		$b=2;
		$c=1;
		break;
	}
	$html=file_get_html("$http");
	
	if ($hour=="n")
	{
	$val=1;
	$temp=$html->find('span[class=dayTemp]');
	$temp=$temp[$day]->plaintext;
	$temp=str_replace('	', '', $temp);
	$temp=str_replace('&nbsp;&deg;', '', $temp);	// Max Day Temperature
	$temp=str_replace(' ', '', $temp);
	$temp=str_replace('C', '', $temp);
	$maxtemp=$temp;
	
	$temp=$html->find('span[class=nightTemp]');
	$temp=$temp[$day]->plaintext;
	$temp=str_replace('	', '', $temp);
	$temp=str_replace('&nbsp;&deg;', '', $temp);	// Min Night Temperature
	$temp=str_replace(' ', '', $temp);
	$temp=str_replace('C', '', $temp);
	$mintemp=$temp;
	}
	else
	{
	$val=$hour;
	$temp=$html->find('tr[class="weatherTemp"]');
	$temp=$temp[$day]->find('i[class="icon icon-animated"]');
	$temp=$temp[$hour]->plaintext;
	$temp=str_replace('	', '', $temp);
	$temp=str_replace('&nbsp;&deg;', '', $temp);	// Hour Temperature
	$temp=str_replace(' ', '', $temp);
	$temp=str_replace('C', '', $temp);
	$maxtemp=$temp;
	$mintemp=$temp;
	}
	
	if ($hour=="n")
	{
		$weather=$html->find('img[class="icon wxIcon"]');	// Weather
		$weather=$weather[$day]->title;
	}
	else
	{
		$weather=$html->find('tr[class="weatherWX"]');
		$weather=$weather[$day]->find('td');
		$weather=$weather[$hour]->title;
	}
	
	if ($hour=="n")
	{
	$timer=$html->find('tr[class="weatherTime"]');	// Time 
	$time=$timer[$day]->find('td',1);
	$time=$time->plaintext;
	$time2=$timer[$day]->find('td',-1);
	$time.="-";
	$time.=$time2->plaintext;
	}
	else
	{
	$time=$html->find('tr[class="weatherTime"]');
	$time=$time[$day]->find('td');
	$time=$time[$hour]->plaintext;
	}
	
	$forecast=$html->find('div[id=forecastTextContent]');	// Headline weather
	$headline=$forecast[0]->find('p');
	
	$summary=$headline[$day+1]->plaintext;	// Weather Summary
	$summary=substr($summary, 0, -29);
	$summary=rtrim($summary,',');
	$summary=rtrim($summary).'.';
	
	$headline=$headline[$b]->plaintext;
	$heading=$forecast[0]->find('h4');	// Weather Heading
	$heading=$heading[$day+1]->plaintext;
	
	$wind=$html->find('tr[class=weatherWind wxContent]');
	$direction=$wind[$day]->find('span[class=direction]');	// Wind Direction
	$direction=$direction[$val]->plaintext;
	$direction=str_replace(' ', '', $direction);
	
	$speed=$wind[$day]->find('i[class=icon]');
	$speed=$speed[$val]->plaintext;
	$speed=str_replace('	', '', $speed);
	$speed=str_replace('&nbsp;&deg;', '', $speed);	// Wind Speed
	$speed=str_replace(' ', '', $speed);
	$speed=str_replace('C', '', $speed);
	
	$day2=$day;
	if ($hour=="n" && $day=="0") $day="Now";
	else
	{
	$day=$html->find("span[class=short-date]");
	$day=$day[$day2]->plaintext;
	$day=str_replace('	', '', $day);
	$day=str_replace(' ', '', $day);
	}
	
	$location=$html->find('h1');	// Location
	$location=$location[0]->plaintext;
	$location=str_replace(' ', '', $location);
	$location=str_replace('weather', '', $location);
	
	// Any new fields are added at the end of the string to keep backwards compatibility
	return "$maxtemp	$mintemp	$weather	$headline	$heading	$summary	$time	$direction	$speed	$day	$location\r\n";
}

function loadData($field,$t)
{
	if($t=='1')
	{
		$rawdata=file("weather1.txt");
	}
	else
	{
		$rawdata=file("weather2.txt");
	}
 
	$data=str_getcsv($rawdata[$field],"	");
	return $data;
}
//loadData('0');