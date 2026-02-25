<?php
include "simple_html_dom.php";

function gethtml($http)
{
	$opts = array('http' => array(
		'method' => 'GET',
		'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n"
	));
	$context = stream_context_create($opts);
	$html = file_get_contents($http, false, $context);

	preg_match('/<h1[^>]*>(.*?)<\/h1>/si', $html, $m);
	$location = isset($m[1]) ? strip_tags($m[1]) : 'unknown';
	$location = str_replace(' ', '', $location);
	$location = str_replace('weather', '', $location);

	preg_match('/<section class="snapshots">(.*?)<\/section>/si', $html, $snap);
	preg_match('/<ul[^>]*id="dayTabs"[^>]*>(.*?)<\/ul>/si', $html, $tabs);
	preg_match('/<section id="forecast-text"[^>]*>(.*?)<\/section>/si', $html, $ftext);
	preg_match_all('/<tr class="wind-row[^"]*">(.*?)<\/tr>/si', $html, $wind);

	$out  = "<html><body>\n";
	$out .= "<h1>" . htmlspecialchars(str_replace(array('(',')'),' ',$location)) . " weather</h1>\n";
	$out .= isset($snap[0])  ? $snap[0]  : '';
	$out .= "<ul id=\"dayTabs\">" . (isset($tabs[1]) ? $tabs[1] : '') . "</ul>\n";
	$out .= "<section id=\"forecast-text\">" . (isset($ftext[1]) ? $ftext[1] : '') . "</section>\n";
	foreach ($wind[0] as $windrow)
		$out .= "<table><tbody>" . $windrow . "</tbody></table>\n";
	$out .= "</body></html>\n";

	file_put_contents("$location".".html", $out);
	echo "$location\n";
}

gethtml("https://weather.metoffice.gov.uk/forecast/gfhyzzs9j");
gethtml("https://weather.metoffice.gov.uk/forecast/gfnt07u1s");
gethtml("https://weather.metoffice.gov.uk/forecast/gcvwr3zrw");
gethtml("https://weather.metoffice.gov.uk/forecast/gcey94cuf");
gethtml("https://weather.metoffice.gov.uk/forecast/gcybg0rne");
gethtml("https://weather.metoffice.gov.uk/forecast/gcw2hzs1u");
gethtml("https://weather.metoffice.gov.uk/forecast/gcqkrv0ge");
gethtml("https://weather.metoffice.gov.uk/forecast/u1214b469");
gethtml("https://weather.metoffice.gov.uk/forecast/gcjszmp44");
gethtml("https://weather.metoffice.gov.uk/forecast/gcpvj0v07");
gethtml("https://weather.metoffice.gov.uk/forecast/gcj2x8gt4");

$opts = array('http' => array(
	'method' => 'GET',
	'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n"
));
$context = stream_context_create($opts);
$str = file_get_contents("https://www.metoffice.gov.uk/", false, $context);
preg_match('/<div id="fiveDayText"[^>]*>(.*?)<\/div>\s*<\/div>/si', $str, $fiveday);
$out  = "<html><body>\n";
$out .= "<div id=\"fiveDayText\">" . (isset($fiveday[1]) ? $fiveday[1] : '') . "</div>\n";
$out .= "</body></html>\n";
file_put_contents("weather3.html", $out);
echo "weather3\n";

exit;
?>
