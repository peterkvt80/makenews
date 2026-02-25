<?php
include "simple_html_dom.php";

function fetchArticles($rssfeed, $prefix, $max)
{
	$rawFeed = file_get_contents($rssfeed);
	$xml = new SimpleXmlElement($rawFeed);
	$count = 0;
	foreach ($xml->channel->item as $chan)
	{
		$url = strtok((string)$chan->link, '?');
		$str = file_get_html($url);
		if (!$str) continue;
		$tags = $str->find("link[rel=canonical]");
		if (empty($tags)) continue;
		preg_match('/href="https?:\/\/[^\/]+(\/[^"]+)"/', (string)$tags[0], $m);
		$path = isset($m[1]) ? $m[1] : '';
		if (strpos($path, '/videos/') !== false) continue;
		if (strpos($path, '/sport/av/') !== false) continue;
		echo $chan->title."\n";
		file_put_contents("$prefix$count.html", $str);
		$count++;
		if ($count > $max) break;
	}
}

fetchArticles("https://feeds.bbci.co.uk/sport/football/rss.xml",        "foot", 12);
fetchArticles("https://feeds.bbci.co.uk/sport/northern-ireland/rss.xml", "nis",  12);
fetchArticles("https://feeds.bbci.co.uk/sport/formula1/rss.xml",         "f1",    8);
?>
