<?php
/*	newsreader.php
	Nathan J. Dane, 2018
	Takes advantage of the new BBC News AMP project to get stories 
	for Ceefax that aren't a pain to scrape, use less internet and so
	can be generated quicker.
*/
$nr=21;	// How many stories do we need?
$li="https://www.bbc.co.uk/news/ampstories/headlines/index.html";	// BBC News AMP index

include "simple_html_dom.php";	// Yup, still need this tho

$html=file_get_html($li);	// Download the main index
$i=0;
foreach($html->find('amp-story-page') as $story)
{
	if($i == 0)	// Skip the first one because it's just a title page
	{
		$i++;
		continue 1;	// Probably a better way to do this
	}
	$n=($i-1);	// Page Number is $i-1 for backwards compatibility
	
	$link=$story->find('a',0);	// Get the URL
	$URL=$link->href;
	
	$title=$story->find('h1',0);	// Might as well echo the title
	echo "$n: ".$title->plaintext."\n";	// Also add the page number. Could be useful for de-bugging later
	
	$page=file_get_contents($URL);	// Get the page!
	file_put_contents("page$n.html",$page);	// Save it
	
	if($i >= $nr)	// When we've got everything we need, break
		break;
	$i++;
}
?>