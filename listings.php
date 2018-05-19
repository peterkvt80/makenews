<?php
// listings.php
// Get tv listings from bleb.org and format for Ceefax listings
// Programmed for BBC1, 2, C4 & C5. UTV's headers are implemented, but I can't get 
// a good listings page for it...
// Adds a summary if there's room for one, tries to make the page 3 subpages long if possible
// By Nathan Dane, avrovulcanxh607@gmail.org.

include "simple_html_dom.php";
if (isset($argc))
{
	$chan=$argv[1];					// Command line: php listings.php <channel> <0(today)/3(tomorrow)>
	$when=$argv[2];
}

$file=$chan.$when.".html";
$html = file_get_html($file);	// Get the page required

function fileHeader($p,$s,$chan)
{
	echo "SC,000$s\r\n";
	echo "PS,8000\r\n";
	switch ($chan)
	{
	case "BBC1" : ;
		echo "PN,6$p"."10$s\r\n";										// Page Number: m0pss=today m3pss=tomorrow
		break;
	case "BBC2" : ;
		echo "PN,6$p"."20$s\r\n";
		break;
	case "UTV" : ; // UTV Doesn't work
		echo "PN,6$p"."30$s\r\n";
		break;
	case "C4" : ;
		echo "PN,6$p"."40$s\r\n";
		break;
	case "C5" : ;
		echo "PN,6$p"."50$s\r\n";
		break;
	}
}

function pageHeader($p,$s,$chan,$first,$last)
{
	switch ($p)
	{
		case "0" : ;
			$day = date('l');
			$day = strtoupper($day);
			$m = 3;
			break;
		case "3" : ;
			$day  = $date = date("l", strtotime("tomorrow"));
			$day = strtoupper($day);
			$m = 4;
	}
	
	switch ($chan)
	{
	case "BBC1" : ;
		echo "OL,1,ñ|,,,,,,l|4Ü````````````````````````````\r\n";
		printf("OL,2,ñ\"!j5j=5ì{%%{%%+%%(á %15s\r\n",$day);
		echo "OL,3,ñ  +>!j5ìz5z5z5`0á      $first-$last\r\n";
		echo "OL,4,ñ/,,,,,,.-%Ü``````````````````````á $s/$m \r\n";
		break;
	case "BBC2" : ;
		echo "OL,1,ñ|,,,,,,l|4Ü````````````````````````````\r\n";
		printf("OL,2,ñ\"!j5j=5ì{%%{%%+%%bsá%15s\r\n",$day);
		echo "OL,3,ñ  +>!j5ìz5z5z5jupá      $first-$last\r\n";
		echo "OL,4,ñ/,,,,,,.-%Ü``````````````````````á $s/$m \r\n";
		break;
	case "UTV" : ; // UTV Doesn't work
		echo "OL,1,ñ|,,,,,,l|4Ü````````````````````````````\r\n";
		printf("OL,2,ñ\"!j5j=5ìj5##j5á %15s\r\n",$day);
		echo "OL,3,ñ  +>!j5ìoz%  \"m'                   \r\n";
		echo "OL,4,ñ/,,,,,,.-%Ü``````````````````````á $s/$m \r\n";
		break;
	case "C4" : ;
		echo "OL,1,ñ|,,,,,,l|4Ü````````````````````````````\r\n";
		printf("OL,2,ñ\"!j5j=5ì+%%p0 h4 á %15s\r\n",$day);
		echo "OL,3,ñ  +>!j5ìx4j5 #k7á        $first-$last\r\n";
		echo "OL,4,ñ/,,,,,,.-%Ü``````````````````````á $s/$m \r\n";
		break;
	case "C5" : ;
		echo "OL,1,ñ|,,,,,,l|4Ü````````````````````````````\r\n";
		printf("OL,2,ñ\"!j5j=5ì#b1|h4<l  á %15s\r\n",$day);
		echo "OL,3,ñ  +>!j5ì#j5oz%wsá         $first-$last\r\n";
		echo "OL,4,ñ/,,,,,,.-%Ü``````````````````````á $s/$m \r\n";
		break;
	}
}

function pageFooter($when,$chan)
{
	$chan=$chan.$when;
	switch ($when)
	{
		case "0" : ; // Could probably ditch this and add these lines below
		{
			echo "OL,22,ÜùÑS=Subtitles  R=Repeat  W=Widescreen\r\n";
			echo "OL,23,ÑùÜBBC1Å601ÜBBC2Å602Ü C4Å604ÜOn nowÅ606 \r\n";
			break;
		}
	}
	switch ($chan)
	{
		case "BBC10" : ;
		{
			echo "OL,24,ÅBBC2    ÇUTV     ÉCh 4   ÜNow & Next  \r\n";
			echo "FL,602,603,604,606,F,600\r\n";
			break;
		}
		case "BBC20" : ;
		{
			echo "OL,24,ÅUTV     ÇCh 4  ÉNow and Next ÜTV Links\r\n";
			echo "FL,603,604,606,615,F,600\r\n";
			break;
		}
		case "UTV0" : ; // UTV doesn't work yet
		{
			echo "OL,24,ÅCh 4    ÇFive  ÉNow and Next ÜTV Links \r\n";
			echo "FL,604,605,606,620,100,100\r\n";
			break;
		}
		case "C40" : ;
		{
			echo "OL,24,ÅCh 5   ÇNow & NextÉ TV LinksÜN.Irel. TV\r\n";
			echo "FL,605,606,615,600,F,600\r\n";
			break;
		}
		case "C50" : ;
		{
			echo "OL,24,ÅNow & NextÇ  Prime  ÉBBC1  ÜN.Irel. TV \r\n";
			echo "FL,606,607,601,600,F,600\r\n";
			break;
		}
		case "BBC13" : ;
		{
			echo 'OL,22,F]DBBC2A602D UTVA602D C4A604DOn nowA606'."\r\n";
			echo 'OL,23,D]CFront pageG100CSportG300CRegionsG608'."\r\n";
			echo 'OL,24,ABBC2 Tmrw B UTV TmrwCCh 4 TmrwFTomorrow'."\r\n";
			echo "FL,632,633,634,630,F,100\r\n";
			break;
		}
		case "BBC23" : ;
		{
			echo 'OL,22,F]DBBC1A601D UTVA602D C4A604DOn nowA606'."\r\n";
			echo 'OL,23,D]CFront pageG100CSportG300CRegionsG609'."\r\n";
			echo 'OL,24,AUTV  TmrwBCh 4 TmrwCSatelliteFMain Menu'."\r\n";
			echo "FL,633,634,636,600,F,100\r\n";
			break;
		}
		case "UTV3" : ; // UTV Doesn't actually work...
		{
			echo 'OL,22,F]DBBC1A601DBBC2A602D C4A604DOn nowA606'."\r\n";
			echo 'OL,23,D]CFront pageG100CSportG300CWeatherG400'."\r\n";
			echo 'OL,24,ACh 4 Tmrw BBBC1 TmrwCTomorrowFMain Menu'."\r\n";
			echo "FL,634,631,630,600,F,100\r\n";
			break;
		}
		case "C43" : ;
		{
			echo 'OL,22,F]DBBC1A601DBBC2A602DUTVA603DOn nowA606'."\r\n";
			echo 'OL,23,D]CFront pageG100CSportG300CWeatherG400'."\r\n";
			echo 'OL,24,AFive Tmrw BN.Irel TVCTomorrowFMain Menu'."\r\n";
			echo "FL,635,600,630,600,F,100\r\n";
			break;
		}
		case "C53" : ;
		{
			echo 'OL,22,F]DBBC1A601DBBC2A602D C4A604DOn nowA606'."\r\n";
			echo 'OL,23,D]CFront pageG100CSportG300CWeatherG400'."\r\n";
			echo 'OL,24,ARadio   BN.Irel TVCTomorrow FMain Menu'."\r\n";
			echo "FL,640,600,630,100,F,100\r\n";
			break;
		}
		
	}
	
}

function processPage($html,$when)
{
	switch ($when)
	{
		case "0" : ;
			$count=48;
			break;
		case "3" : ;
			$count=64;
	}
	global $lines;
	$lines=array();
	$n=6;
	$t=7;
	$nl=0;
	for ($i=-1;$i<$count;$i++)
	{
		$b= $html->find('b');
		if (!$b[$n]) break;
		$time=	htmlspecialchars_decode ($b[$n]->plaintext,ENT_QUOTES);		// Decode html entities
		$time= str_replace(':', '', $time);
		$title=	htmlspecialchars_decode ($b[$t]->plaintext,ENT_QUOTES);
		$title=substr(trim($title),0,36);		$textcol='É';	// yellow
		$col='á';		// White
	
		array_push($lines,"$textcol$time$col$title");						// Add all lines to the array
		$n+=2;
		$t+=2;
	}
	
	global $uln;
	$uln = count($lines);	// Count the entries, returns Used LiNes
	global $eln;
	$eln = $count - $uln;	// Work out how many Empty LiNes there are.
	$de= $html->find('tr');
	global $des;
	$des=array();
	foreach ($de as $ul)
	{
		$strpos = strpos($ul,'&nbsp;'); 	// extract the decription
		if(!$strpos) $strpos = -2;
		$title=substr($ul, $strpos + strlen('&nbsp;')); 
		$utext=substr($title, 0, strpos($title, '&nbsp;'));
		$utext=strip_tags($title);
		$utext=str_replace(' Also in HD.', '', $utext);		// Don't need to know if its in HD or not, wastes space!
		$utext=preg_replace("/\[[^)]+\]/", '', $utext);		// These tags should be in the title, remove them from here
		$utext=str_replace('&nbsp;', '', $utext);			// Remove '&nbsp;'
		$utext=explode('\r\n',wordwrap($utext,34,'\r\n'));
		if ($utext==' ') continue 1;
		array_push($des,$utext);							// Send all to the array
	}
}
function outputPage($lines,$uln,$when,$chan,$des,$eln)
{
	global $sp;
	global $first;
	global $last;
	$count=0;
	$OL=5;
	$sp=1;
	switch ($when)
	{
		case "0" : ;
			$p=3;
			break;
		case "3" : ;
			$p=4;
	}
	for ($i=0;$i<$uln && $OL<21;$i++)
	{
		//echo $eln; 								// Debug: Uncomment to show how many emtpy lines there are
		echo "OL,$OL,$lines[$i]\r\n";
		if ($OL==5) 
		{
			$first=$lines[$i];
			$first=substr($first,1,4);
		}
		$l = count($des[$i]);
		//echo "Summary Length: $l\r\n";			// Debug: Uncomment to show summary length
		$ml = $OL+count($des[$i]);
		$OL++;
		$count++;
		//echo "Summary will go to line: $ml\r\n";	// Debug: Uncomment to show what line it will go to
		if ($l <= $eln && $ml < 21) // If there's still room for it, add a summary
		{
		if (!substr_compare($lines[$i],"BBC News",6,8)) continue 1;			// Programs we don't want/need described
		if (!substr_compare($lines[$i],"Breakfast",6,9)) continue 1;
		if (!substr_compare($lines[$i],"BBC Newsline",6,12)) continue 1;
		if (!substr_compare($lines[$i],"Weather for the Week Ahead",6,26)) continue 1;
		if (!substr_compare($lines[$i],"This Is BBC Two",6,15)) continue 1;
		if (!substr_compare($lines[$i],"Channel 4 News",6,14)) continue 1;
		if (!substr_compare($lines[$i],"Little Princess",6,15)) continue 1;
		if (!substr_compare($lines[$i],"Wissper",6,7)) continue 1;
		if (!substr_compare($lines[$i],"Poppy Cat",6,9)) continue 1;
		if (!substr_compare($lines[$i],"Milkshake Monkey",6,16)) continue 1;
		if (!substr_compare($lines[$i],"Secret Life Of Puppies",6,22)) continue 1;
		if (!substr_compare($lines[$i],"Mofy",6,4)) continue 1;			// Don't want any of the CGI children's 
		if (!substr_compare($lines[$i],"Peppa Pig",6,9)) continue 1;	// rubbish they show on C5
		if (!substr_compare($lines[$i],"Paw Patrol",6,10)) continue 1;
		if (!substr_compare($lines[$i],"Thomas and Friends",6,18)) continue 1;
		if (!substr_compare($lines[$i],"Fireman Sam",6,11)) continue 1;
		if (!substr_compare($lines[$i],"Olly the Little White Van",6,25)) continue 1;
		if (!substr_compare($lines[$i],"Rusty Rivets",6,12)) continue 1;
		if (!substr_compare($lines[$i],"Nella the Princess Knight",6,25)) continue 1;
		if (!substr_compare($lines[$i],"Noddy Toyland Detective",6,23)) continue 1;
		if (!substr_compare($lines[$i],"Floogals",6,8)) continue 1;
		if (!substr_compare($lines[$i],"Ben and Holly's Little Kingdom",6,30)) continue 1;
		if (!substr_compare($lines[$i],"Shimmer and Shine",6,17)) continue 1;
		if (!substr_compare($lines[$i],"Digby Dragon",6,12)) continue 1;
		if (!substr_compare($lines[$i],"Teenage Mutant Ninja Turtles",6,28)) continue 1;
		if (!substr_compare($lines[$i],"5 News Weekend",6,14)) continue 1;
		foreach($des[$i] as $ln)
			{
				$ln = str_replace('&nbsp;', '', $ln); // Remove '&nbsp;'
				echo "OL,$OL,Ü     $ln\r\n"; // Output the summary with an indent
				$OL++;
				$count++;
				
			}
			$eln = $eln - $l;
		}
		$last=substr($lines[$i],1,4);
		if ($OL > 20 && $sp < $p)
		{
			pageHeader($when,$sp,$chan,$first,$last);
			pageFooter($when,$chan);
			fileHeader($when,$sp+1,$chan);
			$sp++;
			$OL=5;
		}
	}
}

echo "SP,c:\Minited\inserter\ONAIR\P102.tti\r\n";
echo "DE,$chan Listings\r\n";
echo "CT,24,T\r\n";

fileHeader($when,1,$chan);
processPage($html,$when);
outputPage($lines,$uln,$when,$chan,$des,$eln);
pageHeader($when,$sp,$chan,$first,$last);
pageFooter($when,$chan);
