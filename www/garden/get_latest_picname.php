<?php
/*
if ($handle = opendir('./pictures')) {

    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            echo "$entry\n";
            echo 
        }
    }
    closedir($handle);
*/
	$dir = './pictures';
	$files = scandir($dir);
	rsort($files);
	echo "latest :".$files[0]."\n";
	foreach ($files as $file) {
	if ($file != '.' && $file != '..') {
		echo "> $file \n";
		}
	}
	

?>