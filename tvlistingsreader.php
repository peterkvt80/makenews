<?php
$str = file_get_contents("http://www.bleb.org/tv/channel.html?ch=bbc1_n_ireland&all");		
file_put_contents("BBC10.html",$str);
$str = file_get_contents("http://www.bleb.org/tv/channel.html?ch=bbc2_n_ireland&all");		
file_put_contents("BBC20.html",$str);
$str = file_get_contents("http://www.ontvtonight.co.uk/guide/listings/channel/69036087/utv.html");		
file_put_contents("UTV0.html",$str);
$str = file_get_contents("http://www.bleb.org/tv/channel.html?ch=ch4&all");		
file_put_contents("C40.html",$str);
$str = file_get_contents("http://www.bleb.org/tv/channel.html?ch=five&all");		
file_put_contents("C50.html",$str);
$str = file_get_contents("http://www.bleb.org/tv/channel.html?ch=bbc1_n_ireland&all&day=1");		
file_put_contents("BBC13.html",$str);
$str = file_get_contents("http://www.bleb.org/tv/channel.html?ch=bbc2_n_ireland&all&day=1");		
file_put_contents("BBC23.html",$str);
//$str = file_get_contents("http://www.ontvtonight.co.uk/guide/listings/channel/69036087/utv.html");
//file_put_contents("UTV3.html",$str);	// Can't find tomorrow's listings for UTV, Doesn't work anyway.
$str = file_get_contents("http://www.bleb.org/tv/channel.html?ch=ch4&all&day=1");		
file_put_contents("C43.html",$str);
$str = file_get_contents("http://www.bleb.org/tv/channel.html?ch=five&all&day=1");		
file_put_contents("C53.html",$str);
exit;
?>