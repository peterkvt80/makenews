<?php
// newsindex Make P100 carousel.
// Run after newsreader.php
// WARNING! There are hidden characters in this text that your editor may treat as whitespace.
// If you take them out then the page formatting may be disrupted.
// I used Notepad++ switched to Encoding-UTF8 in order to create this.
include "simple_html_dom.php";
include 'replace.php';
include "header.php";

function writeHeader()
{
	echo "DS,inserter\r\n";
	echo "SP,c:\Minited\inserter\ONAIR\P100.tti\r\n";
	echo "DE,Service Front Page\r\n";
	echo "CT,8,T\r\n";
}

// CEEFAX P100
function writePage($ss)
{
	printf("PN,100%02d\r\n",$ss);
	printf("SC,%04d\r\n",$ss);
	echo "PS,8000\r\n";
	echo "MS,0\r\n";
	intHeader();
	echo "OL,1,—`ppp`ppp`ppp”||,,,<,,<,,<,,|,,,|,l<,|||\r\n";
	echo 'OL,2,—j $zj $zj tz”“7#jsjsjshs4ouz?” '."\r\n";
	echo "OL,3,—j %jj %jj 'k”“upjpjpj j 55j” \r\n";
	echo "OL,4,—\"###\"###\"###”##########################\r\n";
	echo "OL,8,„```````````````````````````````````````\r\n";
	/*
	echo "OL,10,D]CM --  IMPORTANT INFORMATION  --      \r\n";
	echo "OL,11,D]G                                     \r\n";
	echo "OL,12,D]G                                     \r\n";
	echo "OL,13,D]GDue to electrical work on Tuesday    \r\n";
	echo "OL,14,D]Gthe 27th of February, all NMP        \r\n";
	echo "OL,15,D]Gservices, including Ceefax, will     \r\n";
	echo "OL,16,D]Gexperiance disruption.               \r\n";
	echo "OL,17,D]G                                     \r\n";
	echo "OL,18,D]GCeefax will not be coming on-air     \r\n";
	echo "OL,19,D]Guntil after 1700, when the work is   \r\n";
	echo "OL,20,D]Gfinished.                            \r\n";
	echo "OL,21,D]G                                     \r\n";
	echo "OL,21,Q]Rppppp|||||||||||ppppppp\r\n";
	echo "OL,22,B]                                      \r\n";
	*/
	echo "OL,9,ƒA-Z INDEX     ‡199ƒNEWS HEADLINES  ‡101\r\n";
	echo "OL,10,ƒBBC INFO      ‡695ƒNEWS FOR REGION ‡160\r\n";
	echo "OL,11,ƒCHESS         ‡568ƒNEWSROUND       ‡570\r\n";
	echo "OL,12,ƒCOMMUNITY‡BBC2‡650ƒRADIO      ‡BBC1‡640\r\n";
	echo "OL,13,ƒENTERTAINMENT ‡500ƒREAD HEAR  ‡BBC2‡640\r\n";
	echo "OL,14,ƒ                                       \r\n";
	echo "OL,15,ƒFILM REVIEWS  ‡526ƒSPORT           ‡300\r\n";
	echo "OL,16,ƒFINANCE‡  BBC2‡200ƒSUBTITLING      ‡888\r\n";
	echo "OL,17,ƒFLIGHTS       ‡440ƒTOP 40          ‡528\r\n";
	echo "OL,18,ƒGAMES REVIEWS ‡527ƒTRAVEL          ‡430\r\n";
	echo "OL,19,ƒHORSERACING   ‡660ƒTV LINKS        ‡615\r\n";
	echo "OL,20,ƒLOTTERY       ‡555ƒTV LISTINGS     ‡600\r\n";
	echo "OL,21,ƒSCI-TECH      ‡154ƒWEATHER         ‡400\r\n";
	
	echo "OL,22,                                        \r\n";
	echo "OL,23,„ƒCeefax: The world at your fingertips \r\n";
	echo "OL,24,Headlines  ‚Sport ƒN.Ire TV †A-Z Index \r\n";
	echo "FL,101,300,600,199,F,199\r\n";
}

function makeHead($page,$mpp,$ft)
{
	$html = file_get_html($page);	// Get the whole file
	$title=$html->find("meta[property=og:title]");
	$title=substr ($title[0],35);
	$title=substr($title, 0, strpos( $title, '"'));
	$headline=	htmlspecialchars_decode ($title,ENT_QUOTES);		// Decode html entities	
	$title = strtr($headline, $ft);
	$headline = preg_replace("%,.*?,%", '', $title);
	$headline=myTruncate2($headline, 35, " ");
	if (strlen($headline<36))
	{
		$headline=substr(str_pad($headline,35),0,35);
		$headline.='ƒ';
	}
	$headline=strtoupper($headline);
	return 'OL,6,'."$headline"."$mpp\r\n";
}
writeHeader();
writePage('01');
echo "OL,5,ƒNorthern Ireland News\r\n";
echo makeHead('page21.html','161',$ft);
writePage('02');
echo "OL,5,ƒNorthern Ireland Sport\r\n";
echo makeHead('nis0.html','391',$ft);
writePage('03');
echo "OL,5,ƒNorthern Ireland Extra\r\n";
echo "OL,6,POLITICS NEWS AND COMMUNITY DETAILSƒ170\r\n";
writePage('04');
echo "OL,5,ƒNorthern Ireland Sport\r\n";
echo "OL,6,ALL THE LATEST SPORT FROM YOUR AREAƒ390\r\n";
writePage('05');
echo "OL,5,ƒNews\r\n";
echo makeHead('page0.html','104',$ft);
writePage('06');
echo "OL,5,ƒEntertainment News\r\n";
echo makeHead('ent0.html','502',$ft);
writePage('07');
echo "OL,5,ƒNMPTV\r\n";
echo "OL,6,SATURDAY BROADCAST PROGRAMME GUIDE ƒ608\r\n";

?>
