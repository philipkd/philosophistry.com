<?php
	ini_set('error_reporting',E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
# ini_set('error_reporting', E_ALL);
# ini_set('display_errors', 1);
?> 

<?php

	$GLOBALS['files_dir'] = "./docs/content/Files";
	$GLOBALS['logs_dir'] = "./docs/content/Logs";

	$GLOBALS['essays'] = array();

	$GLOBALS['tag_to_essays'] = array();
	$GLOBALS['essay_to_tags'] = array();

	$GLOBALS['tag_to_title'] = array();

	process_notes();
	process_logs();

	function print_nav_tags($tags) {
	    foreach ($tags as $tag) {

	    	$cmd = "php docs/db.php $tag > docs/db/$tag.html";

	    	print "$cmd\n";

	    	# $count = count($GLOBALS['tag_to_essays'][$tag]);
		    # echo "<img src=\"/tag.png\"> <a href=\"$tag\">" . titleify($tag) . "</a> ($count)<br/>\n";
		}
	}

	function print_nav() {

		echo "<div id=\"nav\">";
	    
		echo "<b><a href=\"/\">Philosophistry:<br/>The Love of Rhetoric</b></a><br/><br/>";

		echo "<a href='.'>";

	    echo count($GLOBALS['essays']);

	    echo " Entries</a><br/> by <a href='http://philipkd.com/'>Philip Dhingra</a><br/>\n";

	    $tags = array_keys($GLOBALS['tag_to_essays']);
	    usort($tags, "tag_count_sort");

	    $main_tags = array();
	    $special_tags = array();

	    foreach ($tags as $tag) {
	    	if (special_tag($tag))
	    		array_push($special_tags,$tag);
	    	else
	    		array_push($main_tags,$tag);
	    }

	    print "<br/>Tags<br/>";
	    	print_nav_tags($main_tags);

	}

	function hash_tags_and_title($tags,$title) {
		if (in_array("_pi",$tags) && !$GLOBALS['local_access'])
			return;

		foreach ($tags as $tag) {

    		if (!$GLOBALS['tag_to_essays'][$tag]) {
    			$GLOBALS['tag_to_essays'][$tag] = array();
    		}
    		array_push($GLOBALS['tag_to_essays'][$tag],$title);

    		if (!$GLOBALS['essay_to_tags'][$title]) {
    			$GLOBALS['essay_to_tags'][$title] = array();
    		}
    		array_push($GLOBALS['essay_to_tags'][$title],$tag);
		}
	}

	function process_notes() {
		$folder = $GLOBALS['files_dir'];
		if ($subfolder_handle = opendir($folder)) {
			while (false !== ($subfolder = readdir($subfolder_handle))) {
        		if (preg_match('/^[A-Za-z0-9]/',$subfolder)) {

        			$subfolder = $folder . "/" . $subfolder;

        			$note_handle = opendir($subfolder);

        			while (false !== ($note = readdir($note_handle))) {
				        if (preg_match('/.txt$/',$note)) {
				        	$note_file = $subfolder . "/" . $note;
							$contents = file_get_contents($note_file);

							$title = $note;

							$GLOBALS['essays'][$title] = $contents;

							if ($tags = get_tags($note))
								hash_tags_and_title($tags,$title);
				        }
        			}        			        			
				}
			}
		}
	}

	function process_logs() {
		$folder = $GLOBALS['logs_dir'];
		if ($log_handle = opendir($folder)) {
			while (false !== ($log = readdir($log_handle))) {
        		if (preg_match('/^[A-Za-z0-9]/',$log)) {
		        	$log_file = $folder . "/" . $log;

		        	$contents = file_get_contents($log_file);

		        	$lines = preg_split('/\n/',$contents);

		        	foreach ($lines as $line) {
		        		if (preg_match('/^- /',$line)) {
		        			$line = preg_replace('/^- /','',$line);
		        			$line = preg_replace('/\s*$/','',$line);
		        			$tags = get_tags($line);
		        			$line = remove_tags($line);

		        			$body = "";

							if (preg_match('/^(.*?)\.(.*)$/',$line,$matches)) {
								$title = $matches[1];
								$body = $matches[2];
							} else {
								$title = $line;
							}

							$GLOBALS['essays'][$title] = $body;

							if ($tags)
								hash_tags_and_title($tags,$title);
							
		        		}
		        	}
        		}
			}
		}
	}



	function tag_count_sort($a,$b) {
		return count($GLOBALS['tag_to_essays'][$b]) - count($GLOBALS['tag_to_essays'][$a]);
	}

	function get_tags($line) {
    	if (preg_match_all('/#(.*?)([\. ]|$)/',$line,$matches)) {
    		$tags = $matches[1];
    		return $tags;
    	}
    	return false;
	}		


	function format_tag($tag) {

		$tag = ltrim($tag,"_");

		if ($GLOBALS['index']->ideas->$tag) {
			return $GLOBALS['index']->ideas->$tag->title;
		}

		$tag = preg_replace('/_/',' ',$tag);
		$tag = preg_replace('/^ /','',$tag);
		$tag = preg_replace('/self-improvement/','Self-Improvement',$tag);
		$tag = preg_replace('/^new$/','New',$tag);

		$tag = ucwords($tag);
		return $tag;
	}

	function remove_tags($text) {
		$text = preg_replace('/ *#.*/','',$text);
		return $text;
	}

	function titleify($text) {
		$text = preg_replace('/\.txt/','',$text);
		$text = preg_replace('/^ _/','',$text);
		$text = remove_tags($text);
		return $text;
	}

	function special_tag($tag) {
		return preg_match("/^_/",$tag);
	}

	print_nav();

?>