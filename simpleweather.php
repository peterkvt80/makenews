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
Inverness	IN	 1	|	Time (e.g 19:00)						6
London		LO	9	|	Wind Direction							7
Manchester	MA	5	|	Wind Speed								8
Newcastle	NE	4	|	
Strafford	ST	8	|	
*/
include "simple_html_dom.php";

$cities=array('AB','BE','CA','CR','ED','EX','IN','LO','MA','NE','ST');

function saveData($file,$day)
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
		$c=6;
		break;
	}
	$html=file_get_html("$file");
	$temp=$html->find('span[class=dayTemp]');
	$temp=$temp[$a]->plaintext;
	$temp=str_replace('	', '', $temp);
	$temp=str_replace('&nbsp;&deg;', '', $temp);	// Max Day Temperature
	$temp=str_replace(' ', '', $temp);
	$temp=str_replace('C', '', $temp);
	$maxtemp=$temp;
	
	$temp=$html->find('span[class=nightTemp]');
	$temp=$temp[$a]->plaintext;
	$temp=str_replace('	', '', $temp);
	$temp=str_replace('&nbsp;&deg;', '', $temp);	// Min Night Temperature
	$temp=str_replace(' ', '', $temp);
	$temp=str_replace('C', '', $temp);
	$mintemp=$temp;
	
	$weather=$html->find('tr[class="weatherWX"]');
	$weather=$weather[$a]->find('td');
	$weather=$weather[$c]->title;
	$time=$html->find('tr[class="weatherTime"]');	// Time 
	$time=$time[$a]->find('td');
	$time=$time[$c]->plaintext;
	
	$forecast=$html->find('div[id=forecastTextContent]');	// Headline weather
	$headline=$forecast[0]->find('p');
	
	$summary=$headline[$a+1]->plaintext;	// Weather Summary
	$summary=substr($summary, 0, -29);
	$summary=rtrim($summary,',');
	$summary=rtrim($summary).'.';
	
	$headline=$headline[$b]->plaintext;
	$heading=$forecast[0]->find('h4');	// Weather Heading
	$heading=$heading[$a+1]->plaintext;
	
	$wind=$html->find('tr[class=weatherWind wxContent]');
	$direction=$wind[$a]->find('span[class=direction]');	// Wind Direction
	$direction=$direction[1]->plaintext;
	$direction=str_replace(' ', '', $direction);
	
	$speed=$wind[$a]->find('i[class=icon]');
	$speed=$speed[1]->plaintext;
	$speed=str_replace('	', '', $speed);
	$speed=str_replace('&nbsp;&deg;', '', $speed);	// Wind Speed
	$speed=str_replace(' ', '', $speed);
	$speed=str_replace('C', '', $speed);
	
	return "$maxtemp	$mintemp	$weather	$headline	$heading	$summary	$time	$direction	$speed\r\n";
}

function loadData($field,$t)
{
	if($t=='1')
	{
		$rawdata=file("weather.txt");
	}
	else
	{
		$rawdata=file("weather2.txt");
	}
 
	$data=str_getcsv($rawdata[$field],"	");
	return $data;
}
//loadData('0');