<?php

# $cmd = `php docs/wiki.php 

function slug($str) {
	return preg_replace('/ /','_',$str);
}


$folder = './published/Wiki';
if ($folder_handle = opendir($folder)) {
	while (false !== ($file = readdir($folder_handle))) {
		if (preg_match('/\.txt$/',$file)) {
			$efile = str_replace("\"","\\\"",$file);
			$outfile = str_replace(".txt",".html",slug($efile));
			$infile = str_replace(".txt","",$efile);
			$cmd = "php docs/wiki.php \"$infile\" > \"./docs/wiki/$outfile\"";
			print "$cmd\n";
			`$cmd`;
		}
	}
}



?>