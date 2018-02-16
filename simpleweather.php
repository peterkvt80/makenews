<?php
/*
	simpleweather.php
	Nathan J. Dane, 2018.
	Gets a weather page, fetches what is needed from it and 
	returns it as a nice, plain, Tab Separated Variable.
   
You can copy/paste the following as a reference in different code

/*
City area	|			Array element numbers
AB	 2	|	Max Temperature							0
BE	 11	|	Min Temperature							1
CA	 7	|	Weather									2
CR	 6	|	Headline								3
ED	 3	|	Time (e.g. This Evening and tonight)	4
EX	 10	|	Summary									5
IN	 1	|	Time (e.g 19:00)						6
LO	 9	|
MA	 5	|
NE	 4	|
ST	 8	|
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
	$temp=str_replace('&nbsp;&deg;', '', $temp);
	$temp=str_replace(' ', '', $temp);
	$temp=str_replace('C', '', $temp);
	$maxtemp=$temp;
	$temp=$html->find('span[class=nightTemp]');
	$temp=$temp[$a]->plaintext;
	$temp=str_replace('	', '', $temp);
	$temp=str_replace('&nbsp;&deg;', '', $temp);
	$temp=str_replace(' ', '', $temp);
	$temp=str_replace('C', '', $temp);
	$mintemp=$temp;
	$weather=$html->find('tr[class="weatherWX"]');
	$weather=$weather[$a]->find('td');
	$weather=$weather[$c]->title;
	$time=$html->find('tr[class="weatherTime"]');
	$time=$time[$a]->find('td');
	$time=$time[$c]->plaintext;
	$forecast=$html->find('div[id=forecastTextContent]');
	$headline=$forecast[0]->find('p');
	$summary=$headline[$a+1]->plaintext;
	$headline=$headline[$b]->plaintext;
	$heading=$forecast[0]->find('h4');
	$heading=$heading[$a+1]->plaintext;
	$wind=$html->find('tr[class=weatherWind wxContent]');
	$direction=$wind[0]->find('span[class=direction]');
	$direction=$direction[1]->plaintext;
	$speed=$wind[0]->find('i[class=icon]');
	$speed=$speed[0]->plaintext;
	return "$maxtemp	$mintemp	$weather	$headline	$heading	$summary	$time	$direction\r\n";
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