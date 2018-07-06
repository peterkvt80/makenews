<?php
include "simple_html_dom.php";

function gethtml($http)
{
	$html=file_get_contents($http);
	$file=str_get_html($html);
	$location=$file->find('h1');	// Location
	$location=$location[0]->plaintext;
	$location=str_replace(' ', '', $location);
	$location=str_replace('weather', '', $location);
	file_put_contents("$location".".html",$html);
	echo "$location\n";
}

gethtml("https://www.metoffice.gov.uk/mobile/forecast/gfhyzzs9j");
gethtml("https://www.metoffice.gov.uk/mobile/forecast/gfnt07u1s");
gethtml("https://www.metoffice.gov.uk/mobile/forecast/gcvwr3zrw");
gethtml("https://www.metoffice.gov.uk/mobile/forecast/gcey94cuf");	// Belfast
gethtml("https://www.metoffice.gov.uk/mobile/forecast/gcybg0rne");
gethtml("https://www.metoffice.gov.uk/mobile/forecast/gcw2hzs1u");
gethtml("https://www.metoffice.gov.uk/mobile/forecast/gcqkrv0ge");
gethtml("https://www.metoffice.gov.uk/mobile/forecast/u1214b469");
gethtml("https://www.metoffice.gov.uk/mobile/forecast/gcjszmp44");
gethtml("https://www.metoffice.gov.uk/mobile/forecast/gcpvj0v07");
gethtml("https://www.metoffice.gov.uk/mobile/forecast/gcj2x8gt4");


$str = file_get_contents("https://www.metoffice.gov.uk/public/weather/forecast");
file_put_contents("weather3.html",$str);

exit;	// Stop after we get the pages that we want
?>