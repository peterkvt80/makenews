<?php
// Character replacement table for teletext output.
// Replaces unicode/UTF-8 characters with teletext-safe equivalents.
// Based on nathan's legaliser.py.

$ft = array(

	// =========================================================
	// QUOTES
	// =========================================================
	"\xe2\x80\x98" => "'",	// ' Left single quotation mark
	"\xe2\x80\x99" => "'",	// ' Right single quotation mark / apostrophe
	"\xe2\x80\x9a" => "'",	// ‚ Single low-9 quotation mark
	"\xe2\x80\x9c" => '"',	// " Left double quotation mark
	"\xe2\x80\x9d" => '"',	// " Right double quotation mark
	"\xe2\x80\x9e" => '"',	// „ Double low-9 quotation mark
	"\xe2\x80\x9f" => '"',	// ‟ Double high-reversed-9 quotation mark
	"\xc2\xab"     => '"',	// « Left angle quotation
	"\xc2\xbb"     => '"',	// » Right angle quotation

	// =========================================================
	// DASHES & HYPHENS
	// =========================================================
	"\xe2\x80\x92" => '-',	// ‒ Figure dash
	"\xe2\x80\x93" => '-',	// – En dash
	"\xe2\x80\x94" => '-',	// — Em dash
	"\xe2\x80\x95" => '-',	// ― Horizontal bar

	// =========================================================
	// ELLIPSIS
	// =========================================================
	"\xe2\x80\xa6" => '...',	// … Ellipsis

	// =========================================================
	// BULLETS & CIRCLES
	// =========================================================
	"\xe2\x80\xa2" => '*',	// • Bullet
	"\xc2\xb7"     => '*',	// · Middle dot
	"\xe2\x97\x8f" => '*',	// ● Black circle (legaliser canonical)
	"\xe2\xac\xa4" => '*',	// ⬤ Large black circle
	"\xe2\x97\xaf" => 'O',	// ◯ Large white circle

	// =========================================================
	// ARROWS
	// =========================================================
	"\xe2\x86\x90" => '<',	// ← Left arrow
	"\xe2\x86\x91" => '^',	// ↑ Up arrow
	"\xe2\x86\x92" => '>',	// → Right arrow
	"\xe2\x86\x93" => 'v',	// ↓ Down arrow

	// =========================================================
	// FRACTIONS
	// =========================================================
	"\xc2\xbc" => '1/4',	// ¼
	"\xc2\xbd" => '1/2',	// ½
	"\xc2\xbe" => '3/4',	// ¾
	"\xe2\x85\x9b" => '1/8',	// ⅛
	"\xe2\x85\x9c" => '3/8',	// ⅜
	"\xe2\x85\x9d" => '5/8',	// ⅝
	"\xe2\x85\x9e" => '7/8',	// ⅞

	// =========================================================
	// MATH & SYMBOLS
	// =========================================================
	"\xc2\xb1" => '+/-',	// ± Plus-minus
	"\xc2\xb2" => '2',		// ² Superscript 2
	"\xc2\xb3" => '3',		// ³ Superscript 3
	"\xc2\xb9" => '1',		// ¹ Superscript 1
	"\xc3\x97" => 'x',		// × Multiplication sign
	"\xc2\xb5" => 'u',		// µ Micro sign
	"\xc3\xb7" => '/',		// ÷ Division sign
	"\xe2\x80\xb0" => '%o',	// ‰ Per mille
	"\xce\xa9" => 'O',		// Ω Ohm/Omega

	// =========================================================
	// LEGAL / TRADEMARK
	// =========================================================
	"\xc2\xae" => '(R)',		// ® Registered
	"\xc2\xa9" => '(C)',		// © Copyright
	"\xe2\x84\xa2" => '(TM)',	// ™ Trade mark

	// =========================================================
	// CURRENCY
	// =========================================================
	"\xc2\xa3" => '#',		// £ Pound -> # (teletext pound glyph)
	"\xc2\xa2" => 'c',		// ¢ Cent
	"\xc2\xa5" => 'Y',		// ¥ Yen
	"\xe2\x82\xac" => 'E',	// € Euro

	// =========================================================
	// MISC PUNCTUATION & SYMBOLS
	// =========================================================
	"\xc2\xa0" => ' ',		// Non-breaking space
	"\xc2\xb0" => ' ',		// ° Degree sign
	"\xc2\xa1" => '!',		// ¡ Inverted exclamation
	"\xc2\xbf" => '?',		// ¿ Inverted question mark
	"\xc2\xa7" => 'S',		// § Section sign
	"\xc2\xb6" => ' ',		// ¶ Pilcrow / paragraph
	"\xe2\x84\x94" => 'lb',	// ℔ Pound weight
	"\xe2\x99\xaa" => '*',	// ♪ Musical note
	"\xc2\xaa" => 'a',		// ª Feminine ordinal
	"\xc2\xba" => 'o',		// º Masculine ordinal

	// =========================================================
	// LIGATURES & DIGRAPHS (from legaliser charsub)
	// =========================================================
	"\xef\xac\x80" => 'ff',		// ﬀ
	"\xef\xac\x81" => 'fi',		// ﬁ
	"\xef\xac\x82" => 'fl',		// ﬂ
	"\xef\xac\x83" => 'ffi',	// ﬃ
	"\xef\xac\x84" => 'ffl',	// ﬄ
	"\xef\xac\x85" => 'ft',		// ﬅ
	"\xef\xac\x86" => 'st',		// ﬆ
	"\xc3\x86" => 'AE',	// Æ
	"\xc3\xa6" => 'ae',	// æ
	"\xc5\x92" => 'OE',	// Œ
	"\xc5\x93" => 'oe',	// œ
	"\xc4\xb2" => 'IJ',	// Ĳ
	"\xc4\xb3" => 'ij',	// ĳ
	"\xc3\x9f" => 'ss',	// ß Sharp s
	"\xc7\xb1" => 'DZ',	// Ǳ
	"\xc7\xb2" => 'Dz',	// ǲ
	"\xc7\xb3" => 'dz',	// ǳ
	"\xc7\x84" => 'DZ',	// Ǆ (DŽ)
	"\xc7\x85" => 'Dz',	// ǅ (Dž)
	"\xc7\x86" => 'dz',	// ǆ (dž)
	"\xc7\x87" => 'LJ',	// Ǉ
	"\xc7\x88" => 'Lj',	// ǈ
	"\xc7\x89" => 'lj',	// ǉ
	"\xc7\x8a" => 'NJ',	// Ǌ
	"\xc7\x8b" => 'Nj',	// ǋ
	"\xc7\x8c" => 'nj',	// ǌ
	"\xe1\xb5\xba" => 'th',	// ᵺ
	"\xea\x9c\xb2" => 'AA',	// Ꜳ
	"\xea\x9c\xb3" => 'aa',	// ꜳ
	"\xea\x9c\xb4" => 'AO',	// Ꜵ
	"\xea\x9c\xb5" => 'ao',	// ꜵ
	"\xea\x9c\xb6" => 'AU',	// Ꜷ
	"\xea\x9c\xb7" => 'au',	// ꜷ
	"\xea\x9c\xb8" => 'AV',	// Ꜹ
	"\xea\x9c\xb9" => 'av',	// ꜹ
	"\xea\x9c\xba" => 'AV',	// Ꜻ
	"\xea\x9c\xbb" => 'av',	// ꜻ
	"\xea\x9c\xbc" => 'AY',	// Ꜽ
	"\xea\x9c\xbd" => 'ay',	// ꜽ
	"\xf0\x9f\x99\xb0" => 'et',	// 🙰
	"\xc6\x96" => 'Hv',	// Ƕ
	"\xc6\x95" => 'hv',	// ƕ
	"\xe1\xbb\xba" => 'lL',	// Ỻ
	"\xe1\xbb\xbb" => 'll',	// ỻ
	"\xea\x9d\x8e" => 'OO',	// Ꝏ
	"\xea\x9d\x8f" => 'oo',	// ꝏ
	"\xea\x9c\xa8" => 'TZ',	// Ꜩ
	"\xea\x9c\xa9" => 'tz',	// ꜩ
	"\xe1\xb5\xab" => 'ue',	// ᵫ
	"\xea\xad\xa3" => 'uo',	// ꭣ
	"\xea\x9d\xa0" => 'VY',	// Ꝡ
	"\xea\x9d\xa1" => 'vy',	// ꝡ

	// =========================================================
	// LATIN EXTENDED - special letters
	// =========================================================
	"\xc3\x90" => 'D',	// Ð Uppercase Eth
	"\xc3\xb0" => 'd',	// ð Lowercase Eth
	"\xc3\x9e" => 'Th',	// Þ Uppercase Thorn
	"\xc3\xbe" => 'th',	// þ Lowercase Thorn
	"\xc4\xb1" => 'i',	// ı Dotless i
	"\xc4\x90" => 'D',	// Đ Crossed D
	"\xc4\x91" => 'd',	// đ Crossed d
	"\xc4\xa6" => 'H',	// Ħ Barred H
	"\xc4\xa7" => 'h',	// ħ Barred h
	"\xc4\xbf" => 'L',	// Ŀ L middle dot
	"\xc5\x80" => 'l',	// ŀ l middle dot
	"\xc5\x81" => 'L',	// Ł L stroke
	"\xc5\x82" => 'l',	// ł l stroke
	"\xc3\x98" => 'O',	// Ø O stroke
	"\xc3\xb8" => 'o',	// ø o stroke
	"\xc5\xa6" => 'T',	// Ŧ T stroke
	"\xc5\xa7" => 't',	// ŧ t stroke
	"\xc5\x8a" => 'N',	// Ŋ Eng
	"\xc5\x8b" => 'n',	// ŋ eng
	"\xc5\x89" => 'n',	// ŉ n preceded by apostrophe
	"\xc4\xb8" => 'k',	// ĸ Greenlandic k

	// =========================================================
	// ACCENTED - LOWERCASE
	// =========================================================

	// a
	"\xc3\xa0" => 'a',	// à grave
	"\xc3\xa1" => 'a',	// á acute
	"\xc3\xa2" => 'a',	// â circumflex
	"\xc3\xa3" => 'a',	// ã tilde
	"\xc3\xa4" => 'a',	// ä umlaut
	"\xc3\xa5" => 'a',	// å ring
	"\xc4\x81" => 'a',	// ā macron
	"\xc4\x83" => 'a',	// ă breve
	"\xc4\x85" => 'a',	// ą ogonek

	// c
	"\xc3\xa7" => 'c',	// ç cedilla
	"\xc4\x87" => 'c',	// ć acute
	"\xc4\x89" => 'c',	// ĉ circumflex
	"\xc4\x8b" => 'c',	// ċ dot
	"\xc4\x8d" => 'c',	// č caron

	// d
	"\xc4\x8f" => 'd',	// ď caron

	// e
	"\xc3\xa8" => 'e',	// è grave
	"\xc3\xa9" => 'e',	// é acute
	"\xc3\xaa" => 'e',	// ê circumflex
	"\xc3\xab" => 'e',	// ë umlaut
	"\xc4\x93" => 'e',	// ē macron
	"\xc4\x95" => 'e',	// ĕ breve
	"\xc4\x97" => 'e',	// ė dot
	"\xc4\x99" => 'e',	// ę ogonek
	"\xc4\x9b" => 'e',	// ě caron

	// g
	"\xc4\x9d" => 'g',	// ĝ circumflex
	"\xc4\x9f" => 'g',	// ğ breve
	"\xc4\xa1" => 'g',	// ġ dot
	"\xc4\xa3" => 'g',	// ģ cedilla

	// h
	"\xc4\xa5" => 'h',	// ĥ circumflex

	// i
	"\xc3\xac" => 'i',	// ì grave
	"\xc3\xad" => 'i',	// í acute
	"\xc3\xae" => 'i',	// î circumflex
	"\xc3\xaf" => 'i',	// ï umlaut
	"\xc4\xa9" => 'i',	// ĩ tilde
	"\xc4\xab" => 'i',	// ī macron
	"\xc4\xad" => 'i',	// ĭ breve
	"\xc4\xaf" => 'i',	// į ogonek

	// j
	"\xc4\xb5" => 'j',	// ĵ circumflex

	// k
	"\xc4\xb7" => 'k',	// ķ cedilla

	// l
	"\xc4\xb9" => 'l',	// ĺ acute
	"\xc4\xbb" => 'l',	// ļ cedilla
	"\xc4\xbd" => 'l',	// ľ caron

	// n
	"\xc3\xb1" => 'n',	// ñ tilde
	"\xc5\x84" => 'n',	// ń acute
	"\xc5\x86" => 'n',	// ņ cedilla
	"\xc5\x88" => 'n',	// ň caron

	// o
	"\xc3\xb2" => 'o',	// ò grave
	"\xc3\xb3" => 'o',	// ó acute
	"\xc3\xb4" => 'o',	// ô circumflex
	"\xc3\xb5" => 'o',	// õ tilde
	"\xc3\xb6" => 'o',	// ö umlaut
	"\xc5\x8d" => 'o',	// ō macron
	"\xc5\x8f" => 'o',	// ŏ breve
	"\xc5\x91" => 'o',	// ő double acute

	// r
	"\xc5\x95" => 'r',	// ŕ acute
	"\xc5\x97" => 'r',	// ŗ cedilla
	"\xc5\x99" => 'r',	// ř caron

	// s
	"\xc5\x9b" => 's',	// ś acute
	"\xc5\x9d" => 's',	// ŝ circumflex
	"\xc5\x9f" => 's',	// ş cedilla
	"\xc5\xa1" => 's',	// š caron

	// t
	"\xc5\xa3" => 't',	// ţ cedilla
	"\xc5\xa5" => 't',	// ť caron

	// u
	"\xc3\xb9" => 'u',	// ù grave
	"\xc3\xba" => 'u',	// ú acute
	"\xc3\xbb" => 'u',	// û circumflex
	"\xc3\xbc" => 'u',	// ü umlaut
	"\xc5\xa9" => 'u',	// ũ tilde
	"\xc5\xab" => 'u',	// ū macron
	"\xc5\xad" => 'u',	// ŭ breve
	"\xc5\xaf" => 'u',	// ů ring
	"\xc5\xb1" => 'u',	// ű double acute
	"\xc5\xb3" => 'u',	// ų ogonek

	// w
	"\xc5\xb5" => 'w',	// ŵ circumflex

	// y
	"\xc3\xbd" => 'y',	// ý acute
	"\xc3\xbf" => 'y',	// ÿ umlaut
	"\xc5\xb7" => 'y',	// ŷ circumflex

	// z
	"\xc5\xba" => 'z',	// ź acute
	"\xc5\xbc" => 'z',	// ż dot
	"\xc5\xbe" => 'z',	// ž caron

	// =========================================================
	// ACCENTED - UPPERCASE
	// =========================================================

	// A
	"\xc3\x80" => 'A',	// À grave
	"\xc3\x81" => 'A',	// Á acute
	"\xc3\x82" => 'A',	// Â circumflex
	"\xc3\x83" => 'A',	// Ã tilde
	"\xc3\x84" => 'A',	// Ä umlaut
	"\xc3\x85" => 'A',	// Å ring
	"\xc4\x80" => 'A',	// Ā macron
	"\xc4\x82" => 'A',	// Ă breve
	"\xc4\x84" => 'A',	// Ą ogonek

	// C
	"\xc3\x87" => 'C',	// Ç cedilla
	"\xc4\x86" => 'C',	// Ć acute
	"\xc4\x88" => 'C',	// Ĉ circumflex
	"\xc4\x8a" => 'C',	// Ċ dot
	"\xc4\x8c" => 'C',	// Č caron

	// D
	"\xc4\x8e" => 'D',	// Ď caron

	// E
	"\xc3\x88" => 'E',	// È grave
	"\xc3\x89" => 'E',	// É acute
	"\xc3\x8a" => 'E',	// Ê circumflex
	"\xc3\x8b" => 'E',	// Ë umlaut
	"\xc4\x92" => 'E',	// Ē macron
	"\xc4\x94" => 'E',	// Ĕ breve
	"\xc4\x96" => 'E',	// Ė dot
	"\xc4\x98" => 'E',	// Ę ogonek
	"\xc4\x9a" => 'E',	// Ě caron

	// G
	"\xc4\x9c" => 'G',	// Ĝ circumflex
	"\xc4\x9e" => 'G',	// Ğ breve
	"\xc4\xa0" => 'G',	// Ġ dot
	"\xc4\xa2" => 'G',	// Ģ cedilla

	// H
	"\xc4\xa4" => 'H',	// Ĥ circumflex

	// I
	"\xc3\x8c" => 'I',	// Ì grave
	"\xc3\x8d" => 'I',	// Í acute
	"\xc3\x8e" => 'I',	// Î circumflex
	"\xc3\x8f" => 'I',	// Ï umlaut
	"\xc4\xa8" => 'I',	// Ĩ tilde
	"\xc4\xaa" => 'I',	// Ī macron
	"\xc4\xac" => 'I',	// Ĭ breve
	"\xc4\xae" => 'I',	// Į ogonek
	"\xc4\xb0" => 'I',	// İ dot above

	// J
	"\xc4\xb4" => 'J',	// Ĵ circumflex

	// K
	"\xc4\xb6" => 'K',	// Ķ cedilla

	// L
	"\xc4\xb8" => 'L',	// Ĺ acute
	"\xc4\xba" => 'L',	// Ļ cedilla
	"\xc4\xbc" => 'L',	// Ľ caron

	// N
	"\xc3\x91" => 'N',	// Ñ tilde
	"\xc5\x83" => 'N',	// Ń acute
	"\xc5\x85" => 'N',	// Ņ cedilla
	"\xc5\x87" => 'N',	// Ň caron

	// O
	"\xc3\x92" => 'O',	// Ò grave
	"\xc3\x93" => 'O',	// Ó acute
	"\xc3\x94" => 'O',	// Ô circumflex
	"\xc3\x95" => 'O',	// Õ tilde
	"\xc3\x96" => 'O',	// Ö umlaut
	"\xc5\x8c" => 'O',	// Ō macron
	"\xc5\x8e" => 'O',	// Ŏ breve
	"\xc5\x90" => 'O',	// Ő double acute

	// R
	"\xc5\x94" => 'R',	// Ŕ acute
	"\xc5\x96" => 'R',	// Ŗ cedilla
	"\xc5\x98" => 'R',	// Ř caron

	// S
	"\xc5\x9a" => 'S',	// Ś acute
	"\xc5\x9c" => 'S',	// Ŝ circumflex
	"\xc5\x9e" => 'S',	// Ş cedilla
	"\xc5\xa0" => 'S',	// Š caron

	// T
	"\xc5\xa2" => 'T',	// Ţ cedilla
	"\xc5\xa4" => 'T',	// Ť caron

	// U
	"\xc3\x99" => 'U',	// Ù grave
	"\xc3\x9a" => 'U',	// Ú acute
	"\xc3\x9b" => 'U',	// Û circumflex
	"\xc3\x9c" => 'U',	// Ü umlaut
	"\xc5\xa8" => 'U',	// Ũ tilde
	"\xc5\xaa" => 'U',	// Ū macron
	"\xc5\xac" => 'U',	// Ŭ breve
	"\xc5\xae" => 'U',	// Ů ring
	"\xc5\xb0" => 'U',	// Ű double acute
	"\xc5\xb2" => 'U',	// Ų ogonek

	// W
	"\xc5\xb4" => 'W',	// Ŵ circumflex

	// Y
	"\xc3\x9d" => 'Y',	// Ý acute
	"\xc5\xb6" => 'Y',	// Ŷ circumflex
	"\xc5\xb8" => 'Y',	// Ÿ umlaut

	// Z
	"\xc5\xb9" => 'Z',	// Ź acute
	"\xc5\xbb" => 'Z',	// Ż dot
	"\xc5\xbd" => 'Z',	// Ž caron

);
?>
