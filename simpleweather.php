<?php
/*
	simpleweather.php
	Nathan J. Dane, 2018. Updated 2026.
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

require "simple_html_dom.php";

function getWeather($html,$day=0,$hour="n",$array=true)
{
	$snapshots = $html->find('div.snapshot.next-day');
	$snap = $snapshots[$day];

	$maxtemp = '';
	$mintemp = '';
	$temphigh = $html->find('span.tab-temp-high');
	if (isset($temphigh[$day]))
	{
		$raw = $temphigh[$day]->find('span[data-c]');
		if (isset($raw[0]))
		{
			$maxtemp = $raw[0]->getAttribute('data-c');
			$maxtemp = str_replace('°', '', $maxtemp);
			$maxtemp = trim($maxtemp);
		}
	}
	$templow = $html->find('span.tab-temp-low');
	if (isset($templow[$day]))
	{
		$raw = $templow[$day]->find('span[data-c]');
		if (isset($raw[0]))
		{
			$mintemp = $raw[0]->getAttribute('data-c');
			$mintemp = str_replace('°', '', $mintemp);
			$mintemp = trim($mintemp);
		}
	}

	$weather = '';
	if ($snap)
	{
		$wdesc = $snap->find('div.snapshot-weather-description');
		if (isset($wdesc[0]))
			$weather = trim($wdesc[0]->plaintext);
	}

	$direction = '';
	$speed = '';
	$windrows = $html->find('tr.wind-row');
	if (isset($windrows[$day]))
	{
		$windcells = $windrows[$day]->find('td');
		if (isset($windcells[0]))
		{
			$windicon = $windcells[0]->find('span[data-type=wind]');
			if (isset($windicon[0]))
				$direction = $windicon[0]->getAttribute('data-value');
			$celltext = trim($windcells[0]->plaintext);
			$speed = preg_replace('/[^0-9]/', '', $celltext);
		}
	}

	$headline = '';
	$heading  = '';
	$summary  = '';
	$time     = '';
	$sections = $html->find('div.forecast-text-section');
	if (isset($sections[0]))
	{
		$h4 = $sections[0]->find('h4');
		$p  = $sections[0]->find('p');
		if (isset($h4[0])) $headline = trim($h4[0]->plaintext);
		if (isset($p[0]))  $heading  = trim($p[0]->plaintext);
	}
	if (isset($sections[$day+1]))
	{
		$h4 = $sections[$day+1]->find('h4');
		$p  = $sections[$day+1]->find('p');
		if (isset($h4[0]))
		{
			$heading = trim($h4[0]->plaintext);
			$heading = str_replace(':', '', $heading);
		}
		$time = '';
		if (isset($p[0]))
		{
			$summary = $p[0]->innertext;
			$summary = strip_tags($summary);
			$summary = html_entity_decode($summary, ENT_QUOTES | ENT_HTML5, 'UTF-8');
			$summary = str_replace("\xc2\xa0", ' ', $summary);
			$summary = trim(preg_replace('/\s+/', ' ', $summary));
			$length = strrpos($summary, '.', -5);
			if ($length !== false)
				$summary = substr($summary, 0, $length+1);
		}
	}

	$dayname = '';
	$daytabs = $html->find('h3.tab-day');
	if (isset($daytabs[$day]))
	{
		$dateshort = $daytabs[$day]->find('span.date-short');
		if (isset($dateshort[0]))
			$dayname = trim($dateshort[0]->plaintext);
	}

	$location = '';
	$h1 = $html->find('h1');
	if (isset($h1[0]))
	{
		$location = $h1[0]->plaintext;
		$location = str_replace(' ', '', $location);
		$location = str_replace('weather', '', $location);
		$location = trim($location);
	}

	if ($array==true)
	{
		return array($maxtemp,$mintemp,$weather,$headline,$heading,$summary,$time,$direction,$speed,$dayname,$location);
	}
	else
	{
		return "$maxtemp\t$mintemp\t$weather\t$headline\t$heading\t$summary\t$time\t$direction\t$speed\t$dayname\t$location\r\n";
	}
}
?>
