<?php
include "simpleweather.php";

$t = saveData("https://www.metoffice.gov.uk/mobile/forecast/gfhyzzs9j",0);	
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gfnt07u1s",0);	
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcvwr3zrw",0);	
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcey94cuf",0);	// Belfast
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcybg0rne",0);	
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcw2hzs1u",0);	
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcqkrv0ge",0);	
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/u1214b469",0);	
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcjszmp44",0);	
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcpvj0v07",0);	
$t.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcj2x8gt4",0);	
file_put_contents("weather1.txt",$t);
$s = saveData("https://www.metoffice.gov.uk/mobile/forecast/gfhyzzs9j",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gfnt07u1s",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcvwr3zrw",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcey94cuf",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcybg0rne",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcw2hzs1u",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcqkrv0ge",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/u1214b469",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcjszmp44",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcpvj0v07",1);
$s.= saveData("https://www.metoffice.gov.uk/mobile/forecast/gcj2x8gt4",1);
file_put_contents("weather2.txt",$s);
$str = file_get_contents("https://www.metoffice.gov.uk/public/weather/forecast");
file_put_contents("weather3.html",$str);

exit;	// Stop after we get the pages that we want
?>