<?php

# $cmd = `php docs/wiki.php 

function slug($str) {
	return preg_replace('/ /','_',$str);
}

function unslug($str) {
	return preg_replace('/_/',' ',$str);
}

$folder = './content/Wiki';
if ($folder_handle = opendir($folder)) {
	while (false !== ($file = readdir($folder_handle))) {
		if (preg_match('/\.txt$/',$file)) {
			$justfile = addslashes(slug($file));
			$cmd = "php docs/wiki.php " . str_replace(".txt","",$justfile) . " > \"./docs/wiki/" . str_replace(".txt",".html",$justfile) . "\"";
			print "$cmd\n";
			`$cmd`;
		}
	}
}



?>