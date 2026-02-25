<?php
// Character replacement table for teletext output.
// Replaces unicode/UTF-8 characters with teletext-safe equivalents.
$ft = array(
	// Quotes
	"\xe2\x80\x98" => "'",	// Left single quotation mark
	"\xe2\x80\x99" => "'",	// Right single quotation mark / apostrophe
	"\xe2\x80\x9c" => '"',	// Left double quotation mark
	"\xe2\x80\x9d" => '"',	// Right double quotation mark
	"\xe2\x80\x9e" => '"',	// Double low-9 quotation mark
	"\xe2\x80\x9f" => '"',	// Double high-reversed-9 quotation mark
	// Dashes
	"\xe2\x80\x93" => '-',	// En dash
	"\xe2\x80\x94" => '-',	// Em dash
	"\xe2\x80\x95" => '-',	// Horizontal bar
	// Ellipsis
	"\xe2\x80\xa6" => '...',	// Ellipsis
	// Bullets
	"\xe2\x80\xa2" => '*',	// Bullet
	"\xc2\xb7"     => '*',	// Middle dot
	// Accented characters - lowercase
	"\xc3\xa0" => 'a',	// a grave
	"\xc3\xa1" => 'a',	// a acute
	"\xc3\xa2" => 'a',	// a circumflex
	"\xc3\xa3" => 'a',	// a tilde
	"\xc3\xa4" => 'a',	// a umlaut
	"\xc3\xa5" => 'a',	// a ring
	"\xc3\xa6" => 'ae',	// ae
	"\xc3\xa7" => 'c',	// c cedilla
	"\xc3\xa8" => 'e',	// e grave
	"\xc3\xa9" => 'e',	// e acute
	"\xc3\xaa" => 'e',	// e circumflex
	"\xc3\xab" => 'e',	// e umlaut
	"\xc3\xac" => 'i',	// i grave
	"\xc3\xad" => 'i',	// i acute
	"\xc3\xae" => 'i',	// i circumflex
	"\xc3\xaf" => 'i',	// i umlaut
	"\xc3\xb0" => 'd',	// eth
	"\xc3\xb1" => 'n',	// n tilde
	"\xc3\xb2" => 'o',	// o grave
	"\xc3\xb3" => 'o',	// o acute
	"\xc3\xb4" => 'o',	// o circumflex
	"\xc3\xb5" => 'o',	// o tilde
	"\xc3\xb6" => 'o',	// o umlaut
	"\xc3\xb8" => 'o',	// o slash
	"\xc3\xb9" => 'u',	// u grave
	"\xc3\xba" => 'u',	// u acute
	"\xc3\xbb" => 'u',	// u circumflex
	"\xc3\xbc" => 'u',	// u umlaut
	"\xc3\xbd" => 'y',	// y acute
	"\xc3\xbf" => 'y',	// y umlaut
	// Accented characters - uppercase
	"\xc3\x80" => 'A',	// A grave
	"\xc3\x81" => 'A',	// A acute
	"\xc3\x82" => 'A',	// A circumflex
	"\xc3\x83" => 'A',	// A tilde
	"\xc3\x84" => 'A',	// A umlaut
	"\xc3\x85" => 'A',	// A ring
	"\xc3\x86" => 'AE',	// AE
	"\xc3\x87" => 'C',	// C cedilla
	"\xc3\x88" => 'E',	// E grave
	"\xc3\x89" => 'E',	// E acute
	"\xc3\x8a" => 'E',	// E circumflex
	"\xc3\x8b" => 'E',	// E umlaut
	"\xc3\x8c" => 'I',	// I grave
	"\xc3\x8d" => 'I',	// I acute
	"\xc3\x8e" => 'I',	// I circumflex
	"\xc3\x8f" => 'I',	// I umlaut
	"\xc3\x90" => 'D',	// Eth
	"\xc3\x91" => 'N',	// N tilde
	"\xc3\x92" => 'O',	// O grave
	"\xc3\x93" => 'O',	// O acute
	"\xc3\x94" => 'O',	// O circumflex
	"\xc3\x95" => 'O',	// O tilde
	"\xc3\x96" => 'O',	// O umlaut
	"\xc3\x98" => 'O',	// O slash
	"\xc3\x99" => 'U',	// U grave
	"\xc3\x9a" => 'U',	// U acute
	"\xc3\x9b" => 'U',	// U circumflex
	"\xc3\x9c" => 'U',	// U umlaut
	"\xc3\x9d" => 'Y',	// Y acute
	// Misc
	"\xc2\xa3" => '#',	// Pound sign -> # (teletext pound)
	"\xc2\xa0" => ' ',	// Non-breaking space
	"\xc2\xb0" => ' ',	// Degree sign
	"\xc2\xab" => '"',	// Left-pointing double angle quotation
	"\xc2\xbb" => '"',	// Right-pointing double angle quotation
);
?>
