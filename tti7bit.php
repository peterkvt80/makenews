<?php
// Convert MRG tti file to 7 bit escaped tti
function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

// Open the current directory
$dir=".";
if (!is_dir($dir)) return;

$dh=opendir($dir);
// List the files
while (($file = readdir($dh)) !== false)
{
	// Filter the tti files
	if (endsWith($file,".tti") || endsWith($file,".TTI"))
	{
		echo $file."\n";
		// Open each file in turn
		$fn=$dir."/".$file;
		echo "Opening $fn\n";
		$h=fopen($fn,"rb");
		$h2=fopen($fn."x","wb");
		$foundCR=false;
		// scan through the file
		while (!feof($h))
		{
			$ch=fgetc($h);
			$c=ord($ch) & 0x7f;
			if ($c==0x10) $c=0x0d; // Unmap double height
			// If there is any character >0x7f then escape it
			// ..but don't know until the next character if CR needs to be escaped
			if ($c==13) // Don't send this yet. Either end of line or double height.
			{
				$foundCR=true;
			}
			else
			{
				// Is there a deferred CR?
				if ($foundCR) // Last was CR
					if ($c==0xa) // followed by LF?
						fwrite($h2,chr(0x0d),1);	// deferred CR/LF end of line
					else
					{
						fwrite($h2,chr(0x1b),1);	// escaped double height
						fwrite($h2,chr(0x0d | 0x40),1);
					}
				if ($c>=0x20 || $c==10) // Not escaped
					fwrite($h2,chr($c),1);
				else
				{ // escaped
					fwrite($h2,chr(0x1b),1);
					fwrite($h2,chr($c | 0x40),1);
				}
				$foundCR=false;
			}
		}
		// write the file back
		// close files
		fclose($h);
		fclose($h2);
	}
}
	closedir($dh);


?>
