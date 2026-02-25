<?php
include "simple_html_dom.php";
$rssfeed="https://feeds.bbci.co.uk/news/uk/rss.xml";	// BBC UK stories
$rawFeed = file_get_contents($rssfeed);
$xml = new SimpleXmlElement($rawFeed);
$count=0;
foreach($xml->channel->item as $chan) {
	// Don't want video/sport stories. They don't render too well on teletext
	if (strncmp($chan->title,"VIDEO:",6)) 
	if (strpos($chan->link,"bbc.co.uk/sport/")===false && strpos($chan->link,"bbc.com/sport/")===false)
	{
		$url=$chan->link; 
		$str = file_get_html($url);
		if (!$str) continue;
		$tags=$str->find("link[rel=canonical]");
		if (empty($tags)) continue;
		preg_match('/href="https?:\/\/[^\/]+(\/[^"]+)"/', (string)$tags[0], $m);
		$title = isset($m[1]) ? $m[1] : '';
		echo $title."\n";
		if (strncmp($title,"/news/av/",9)===0)
			continue 1;
		if (strncmp($title,"/weather/",9)===0)
			continue 1;
		echo $chan->title."\n";
		file_put_contents("page$count.html",$str);	// Save each as Page<x>.html
		$count++;
		if ($count>10) break;	// Stop after we get the pages that we want
	}
} 
$rssfeed="https://feeds.bbci.co.uk/news/world/rss.xml";	// BBC world stories
$rawFeed = file_get_contents($rssfeed);
$xml = new SimpleXmlElement($rawFeed);
foreach($xml->channel->item as $chan) {
	// Don't want video/sport stories. They don't render too well on teletext
	if (strncmp($chan->title,"VIDEO:",6)) 
	if (strpos($chan->link,"bbc.co.uk/sport/")===false && strpos($chan->link,"bbc.com/sport/")===false)
	{
		$url=$chan->link; 
		$str = file_get_html($url);
		if (!$str) continue;
		$tags=$str->find("link[rel=canonical]");
		if (empty($tags)) continue;
		preg_match('/href="https?:\/\/[^\/]+(\/[^"]+)"/', (string)$tags[0], $m);
		$title = isset($m[1]) ? $m[1] : '';
		echo $title."\n";
		if (strncmp($title,"/news/av/",9)===0)
			continue 1;
		if (strncmp($title,"/weather/",9)===0)
			continue 1;
		echo $chan->title."\n";
		file_put_contents("page$count.html",$str);	// Save each as Page<x>.html
		$count++;
		if ($count>20) exit;	// Stop after we get the pages that we want
	}
} 
?>
