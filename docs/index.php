<?php
	ini_set('error_reporting',E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
# ini_set('error_reporting', E_ALL);
# ini_set('display_errors', 1);

	include_once "markdown.php";
	
	$GLOBALS['content_dir'] = dirname(__FILE__) . "/../content/live";

	if (preg_match("/^local./", $_SERVER['HTTP_HOST']))
		$GLOBALS['local_access'] = true;

    $GLOBALS['tag_route'] = $_GET['tag'];

    if ($argv[1])
    	$GLOBALS['tag_route'] = $argv[1];

	$GLOBALS['files_dir'] = $GLOBALS['content_dir'] . "/Files";
	$GLOBALS['logs_dir'] = $GLOBALS['content_dir'] . "/Logs";

	$GLOBALS['essays'] = array();

	$GLOBALS['tag_to_essays'] = array();
	$GLOBALS['essay_to_tags'] = array();

	$GLOBALS['tag_to_title'] = array();

	# $GLOBALS['index'] = json_decode(file_get_contents("./content/index.json"));

	process_notes();
	process_logs();

	if ($argv[1] == 'list') {
		$tags = array_keys($GLOBALS['tag_to_essays']);
	    foreach ($tags as $tag)
	    	if (!special_tag($tag))
	    		print "$tag\n";		
	    exit;
	}

	function print_nav_tags($tags) {
	    foreach ($tags as $tag) {
	    	$count = count($GLOBALS['tag_to_essays'][$tag]);
		    echo "<img src=\"/images/icons/tag.png\"> <a href=\"/db/$tag\">" . titleify($tag) . "</a> ($count)<br/>\n";
		}
	}

	function print_nav() {

		echo "<div id=\"nav\">";
	    
		echo "<b><a href=\"/\">Philosophistry</b></a><br/><br/>";

		echo "<a href='/'>";

	    echo count($GLOBALS['essays']);

	    echo " Micro-essays</a><br/> by <a href='http://philipkd.com/'>Philip Dhingra</a><br/>\n";

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

		/* if ($GLOBALS['local_access']) {
		    print "<br/>Special Tags<br/>";
		    print_nav_tags($special_tags);
		} */

	    echo "</div>";
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


	function print_tag($tag) {
 		$essays = $GLOBALS['tag_to_essays'][$tag];
 		natsort($essays);

		echo "<h2>" . format_tag($tag) . "</h2>\n";

		$idea = ltrim($tag, "_");

		if ($idea_data = $GLOBALS['index']->ideas->$idea) {

			echo "<div class='tag-description'>";

			if ($subtitle = $idea_data->subtitle)
				echo "<p><b>" . $subtitle . "</b></p>";

			if ($description = $idea_data->description) {
				echo MyMarkdown($description);
			}			

			echo "</div>";
			echo "<h3>Entries</h3>";
		}



		// $i = 0;
 		foreach ($essays as $essay) {
			print_essay($essay);

			// if($i < count($essays) - 1)
			// 	hr_tag();
			// $i++;
 		}
	}

	function print_about() {
		echo <<<EOT
		
		<h2>Philosophistry: The Love of Rhetoric</h2>

<div class="note-body"><p><i>Philosophistry</i> is a collection of <a href="http://philipkd.com/">Philip Dhingra</a>’s musings on everything including futurism, evolution, psychology, philosophy, and self-improvement. You can view my <a href="https://medium.com/philosophistry">complete essays on Medium</a>, or you can browse my scratchpad on the site you are reading now. Below is a wiki, and to the left are micro-essays. (<a href="/archives">est. 2003</a>)</p></div>

EOT;
	}

	function wiki_slug($str) {
		$str = preg_replace('/ /','_',$str);
		$str = "/wiki/$str";
		return $str;
	}


	function wiki_markdown($contents) {

		include_once "markdown.php";

		$contents = str_replace("#","####",$contents);

		preg_match_all('/\[\[(.*?)\]\]/',$contents,$links, PREG_SET_ORDER);	

		$contents = preg_replace('/\[\[((.*\/){0,1}(.*?))\]\]/','[\3](\1)',$contents);

		foreach ($links as $link) {

			$link = $link[1];
			$newlink = wiki_slug($link);

			$contents = preg_replace("#\($link\)#","($newlink)",$contents);
		}

		return Markdown($contents);
	}

	function print_wiki() {

		echo wiki_markdown(file_get_contents($GLOBALS['content_dir'] . "/Wiki/index.txt"));

	}

	function print_book() {

		echo <<<EOT
<h2>Philosophistry, the Book</h2>
<div class="note-body">
<center><a href="https://www.amazon.com/gp/product/1530775183/?tag=philosophistr-20">Available now in paperback and on Kindle<!-- <br/><br/><img src="books/philosophistry/cover-thumb.png" alt="Philosophistry book cover" /> --></a></center>
</div>
EOT;

	}

	function print_essay($title) {

		echo "<h4>" . ucfirst(titleify($title)) . "</h4>\n";		
		echo "<div class=\"note-body\">";
		echo MyMarkdown($GLOBALS['essays'][$title]);
		echo "</div>\n\n";

		$tags = $GLOBALS['essay_to_tags'][$title];

		echo "<div class=\"note-tags\">";
	    foreach ($tags as $tag) {
	    	if (special_tag($tag) && $GLOBALS['local_access'] || !special_tag($tag))
		    	echo "<img src=\"/images/icons/tag.png\"> <a href='/db/$tag'>" . $tag . "</a>\n";
		}
		echo "</div>";

	}


	function hr_tag() {
		$spaces = str_repeat('&nbsp;',5);
		$diamond = '&diams;';
		print "<div class='hr'>" . $diamond . $spaces . $diamond . $spaces . $diamond . "</div>";
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
		$tag = preg_replace('/^new$/','New Micro-essays',$tag);

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

	function MyMarkDown($text) {
		$text = Markdown($text);
		// $text = preg_replace('/<blockquote>\s*?<p>/','<blockquote>',$text);
		// $text = preg_replace('/<\/p>\s*?<\/blockquote>/','</blockquote>',$text);
		return $text;
	}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<title>Philosophistry: The Love of Rhetoric</title>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" href="/db.css">

</head>

<body style="font-family: palatino; line-height: 135%;">

<div id="page">

<?php

	print_nav();

	print "<div id='content'>";

	if ($GLOBALS['tag_route']) {
 		print_tag($GLOBALS['tag_route']);
 	} else {

 		print_about();

 		print_wiki();

		// hr_tag();

		print_tag("_new");

 	// 	print_medium_plug();

		// hr_tag();

 	}

 	print '<br/><p/>
<a href="https://licensebuttons.net/l/by/4.0/"><img src="https://licensebuttons.net/l/by/4.0/80x15.png"></a><br/><br/>';

 	print "</div>";


?>

</div>

</body>