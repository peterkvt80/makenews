<?php
// This grabs the rss feed, extracts the story links and copies each page.
// Best not to run this too often to reduce the extra load on the BBC website!
$rssfeed="http://feeds.bbci.co.uk/news/rss.xml";	// BBC top stories
//$rssfeed="rss.xml";	// Debug offline
$rawFeed = file_get_contents($rssfeed);
$xml = new SimpleXmlElement($rawFeed);
echo $xml->channel->title;
echo $xml->asXML;
$count=0;
foreach($xml->channel->item as $chan) {
	// Don't want video stories. They don't render too well on teletext
	if (strncmp($chan->title,"VIDEO:",6))
	{
		$url=$chan->link;
		echo $url."\n";
		echo $chan->title."\n"; 
		$str = file_get_contents($url);		
		file_put_contents("page$count.html",$str);	// Save each as Page<x>.html
		//echo "$str\n";
		$count++;
		if ($count>30) exit;	// Stop after we get the pages that we want
	}
} 
?>