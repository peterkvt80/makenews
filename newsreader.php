<?php
include "simple_html_dom.php";
$rssfeed="http://feeds.bbci.co.uk/news/uk/rss.xml?edition=uk";	// BBC UK stories
$rawFeed = file_get_contents($rssfeed);
$xml = new SimpleXmlElement($rawFeed);
$count=0;
foreach($xml->channel->item as $chan) {
	// Don't want video/sport stories. They don't render too well on teletext
	if (strncmp($chan->title,"VIDEO:",6)) 
	if (strncmp($chan->link,"http://www.bbc.co.uk/sport/",26))
	{
		$url=$chan->link; 
		$str = file_get_html($url);
		$title=$str->find("link[rel=canonical]");
		$title=substr ($title[0],35);
		$title=substr($title, 0, strpos( $title, '"'));
		echo $title."\n";
		if (!strncmp($title,"www.bbc.co.uk/news/av/",21))
		{
			continue 1;
		}
		echo $chan->title."\n";
		file_put_contents("page$count.html",$str);	// Save each as Page<x>.html
		$count++;
		if ($count>10) break;	// Stop after we get the pages that we want
	}
} 
$rssfeed="http://feeds.bbci.co.uk/news/world/rss.xml?edition=uk";	// BBC world stories
$rawFeed = file_get_contents($rssfeed);
$xml = new SimpleXmlElement($rawFeed);
foreach($xml->channel->item as $chan) {
	// Don't want video/sport stories. They don't render too well on teletext
	if (strncmp($chan->title,"VIDEO:",6)) 
    if (strncmp($chan->link,"http://www.bbc.co.uk/sport/",25))
	{
		$url=$chan->link; 
		$str = file_get_html($url);
		$title=$str->find("link[rel=canonical]");
		$title=substr ($title[0],35);
		$title=substr($title, 0, strpos( $title, '"'));
		echo $title."\n";
		if (!strncmp($title,"www.bbc.co.uk/news/av/",21))
		{
			continue 1;
		}
		echo $chan->title."\n";
		file_put_contents("page$count.html",$str);	// Save each as Page<x>.html
		$count++;
		if ($count>20) exit;	// Stop after we get the pages that we want
	}
} 
?>