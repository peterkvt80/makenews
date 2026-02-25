<?php
function intHeader()
{
	echo "OL,0,TemplateCEEFAX 1 %%# %%a %d %%bC%H:%M/%S\r\n";
}

function myTruncate2($string, $limit, $break=" ", $pad="")
{
	if (strlen($string) <= $limit)
		return $string.$pad;
	$string = substr($string, 0, $limit);
	$breakpoint = strrpos($string, $break);
	if ($breakpoint !== false)
		$string = substr($string, 0, $breakpoint);
	return $string.$pad;
}
?>
