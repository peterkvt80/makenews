<?php
include "simple_html_dom.php";
$rssfeed="http://feeds.bbci.co.uk/sport/football/rss.xml?edition=uk";	// Football
$rawFeed = file_get_contents($rssfeed);
$xml = new SimpleXmlElement($rawFeed);
$count=0;
foreach($xml->channel->item as $chan) {
	$url=$chan->link; 
	$str = file_get_html($url);
	if (!$str)
	continue 1;
	echo $chan->title."\n";
	file_put_contents("foot$count.html",$str);	// Save each as Page<x>.html
	$count++;
	if ($count>12) break;	// Stop after we get the pages that we want
}
$rssfeed="http://feeds.bbci.co.uk/sport/northern-ireland/rss.xml?edition=uk";	// NI sport
$rawFeed = file_get_contents($rssfeed);
$xml = new SimpleXmlElement($rawFeed);
$count=0;
foreach($xml->channel->item as $chan) {
	$url=$chan->link; 
	$str = file_get_html($url);
	if (!$str)
	continue 1;
	echo $chan->title."\n";
	file_put_contents("nis$count.html",$str);	// Save each as Page<x>.html
	$count++;
	if ($count>12) break;	// Stop after we get the pages that we want
}
$rssfeed="http://feeds.bbci.co.uk/sport/formula1/rss.xml?edition=uk";	// F1
$rawFeed = file_get_contents($rssfeed);
$xml = new SimpleXmlElement($rawFeed);
$count=0;
foreach($xml->channel->item as $chan) {
	$url=$chan->link; 
	$str = file_get_html($url);
	if (!$str)
	continue 1;
	echo $chan->title."\n";
	file_put_contents("f1$count.html",$str);	// Save each as Page<x>.html
	$count++;
	if ($count>8) exit;	// Stop after we get the pages that we want
}
?>