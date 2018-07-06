<?php
/*
	simpleweather.php - version 1
	Nathan J. Dane, 2018.
	Gets a weather page, fetches what is needed from it and 
	returns it as a nice, plain, array or Tab Separated Variable.
	
	Array index
	Max Temperature			0
	Min Temperature			1
	Weather					2
	Headline				3
	Time (e.g. Tonight)		4
	Summary					5
	Time (e.g 19:00)		6
	Wind Direction			7
	Wind Speed				8
	Day						9
	Location				10
	
*/

require "simple_html_dom.php";	// Won't work without this

function getWeather($html,$day=0,$hour="n",$array=true)
{
	switch($day)
	{
	case "0" : ;
		$b=0;
		break;
	case "1" : ;
		$b=2;
		break;
	case "2" : ;
		$b=4;
		break;
	}
	
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
		
		$timer=$html->find('tr[class="weatherTime"]');	// Time 
		$time=$timer[$day]->find('td',1);
		$time=$time->plaintext;
		$time2=$timer[$day]->find('td',-1);
		$time.="-";
		$time.=$time2->plaintext;
	}
	else
	{
		$weather=$html->find('tr[class="weatherWX"]');
		$weather=$weather[$day]->find('td');
		$weather=$weather[$hour]->title;
		
		$time=$html->find('tr[class="weatherTime"]');
		$time=$time[$day]->find('td');
		$time=$time[$hour]->plaintext;
	}

	$forecast=$html->find('div[id=forecastTextContent]');	// Headline weather
	$headline=$forecast[0]->find('p');
	
	$summary=$headline[$day+1]->plaintext;	// Weather Summary
	$length=strrpos($summary,".",-5);
	$length++;
	$summary=substr($summary,0,$length);	// Remove "Maximum temperature", but leave the fullstop
	
	if($day<3)
		$headline=$headline[$b]->plaintext;
	else
		$headline='';
	
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
	if($array==true)	// By default, we return an array
	{
		return array($maxtemp,$mintemp,$weather,$headline,$heading,$summary,$time,$direction,$speed,$day,$location);
	}
	else
	{
		return "$maxtemp	$mintemp	$weather	$headline	$heading	$summary	$time	$direction	$speed	$day	$location\r\n";
	}
	
}
?>