<?php
	ini_set('error_reporting',E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
# ini_set('error_reporting', E_ALL);
# ini_set('display_errors', 1);
?> 

<?php
	include_once "markdown.php";

	if (preg_match("/^local./", $_SERVER['HTTP_HOST']))
		$GLOBALS['local_access'] = true;

    $GLOBALS['tag_route'] = $_GET['tag'];

    if ($argv[1])
    	$GLOBALS['tag_route'] = $argv[1];

	$GLOBALS['files_dir'] = dirname(__FILE__) . "/../published/Files";
	$GLOBALS['logs_dir'] = dirname(__FILE__) . "/../published/Logs";

	$GLOBALS['essays'] = array();

	$GLOBALS['tag_to_essays'] = array();
	$GLOBALS['essay_to_tags'] = array();

	$GLOBALS['tag_to_title'] = array();

	# $GLOBALS['index'] = json_decode(file_get_contents("./content/index.json"));

	process_notes();
	process_logs();

	function print_nav_tags($tags) {
	    foreach ($tags as $tag) {
	    	$count = count($GLOBALS['tag_to_essays'][$tag]);
		    echo "<img src=\"/tag.png\"> <a href=\"$tag\">" . titleify($tag) . "</a> ($count)<br/>\n";
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

	function print_book() {

		echo <<<EOT
<h2>Philosophistry, the Book</h2>
<div class="note-body">
<center><a href="https://www.amazon.com/gp/product/1530775183/?tag=philosophistr-20">Available now in paperback and on Kindle<!-- <br/><br/><img src="books/philosophistry/cover-thumb.png" alt="Philosophistry book cover" /> --></a></center>
</div>
EOT;

	}

	function print_ideas_from_array($ideas) {
		foreach ($ideas as $idea) {
					$data = $GLOBALS['index']->ideas->$idea;

					echo "<b><a href='?tag=_$idea'>" . $data->title . "</b> — " . $data->subtitle . "</a><br/><br/>"; 
				}
	}

	function print_ideas() {

		echo '<div class="note-body">';

		print_ideas_from_array($GLOBALS['index']->live);

		if ($GLOBALS['local_access']) {

			echo "<br/>";

			$unlive_ideas = array_diff(array_keys((array) $GLOBALS['index']->ideas), $GLOBALS['index']->live);

			print_ideas_from_array($unlive_ideas);
		}	


		echo '</center></div>';
	}

	function print_top_essays() {

		echo <<<EOT
<h2>Top 9 Essays</h2>

<ol>
<li><a href="https://posts.philipkd.com/wobbly-tables-and-the-problem-with-futurism-934468d2308">Wobbly Tables and the Problem with Futurism</a></li>
<li><a href="http://philosophistry.com/archives/2010/07/todays-what-if-what-if-knights-were-just-gangstas.html">What if Knights were just Gangstas?</a></li>
<li><a href="https://www.reddit.com/r/writing/comments/1eje3d/random_thought_writing_is_attachment/">Writing is Attachment</a></li>
<li><a href="https://www.reddit.com/r/StonerPhilosophy/comments/19bfoc/drawing_a_line_through_multiverses/">Drawing a Line Through Multiverses</a></li>
<li><a href="https://www.reddit.com/r/politics/comments/c010j/southerners_like_to_believe_they_were_fighting/">Southerners like to believe they were fighting for their freedoms, when really they were fighting for Plantation owners' freedom to own slaves. You see a similar delusion with libertarians and their support of free markets.</a></li>
<li><a href="https://posts.philipkd.com/the-problem-with-self-improvement-da6c303b6ed6">The Problem with Self-Improvement</a></li>
<li><a href="https://posts.philipkd.com/the-wisdom-of-bored-inquiry-4e432d3ba46b">The Wisdom of Bored Inquiry</a></li>
<li><a href="https://posts.philipkd.com/maybe-the-world-needs-a-narrow-state-d24140f8aa14">Maybe the World Needs a Narrow State</a></li>
<li><a href="https://posts.philipkd.com/the-problem-with-our-understanding-of-ai-is-that-just-before-we-solve-a-challenge-like-mastering-aedd72d6a378">Hard vs Soft AI Problems</a>
</ol>
EOT;

	}

	function print_medium_plug() {

		echo <<<EOT
<h2><a href="https://medium.com/@philipkd/">New Essays on Medium</a></h2>
EOT;

	}

	function print_contexts() {
	    $tags = array_keys($GLOBALS['tag_to_essays']);
	    usort($tags, "tag_count_sort");

	    print "<h2>Special Tags</h2>";
	    print '<div class="note-body">';

	    foreach ($tags as $tag) {
	    	if (special_tag($tag)) {
		    	$count = count($GLOBALS['tag_to_essays'][$tag]);
			    echo "<a href=\"?tag=$tag\">#$tag</a> " . ($count) . "<br/>\n";

//			    echo "<a href=\"?tag=$tag\">" . capitalize_tag($tag) . "</a> ($count)<br/>\n";
			}
	    }

	    print '</div>';

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
		    	echo "<img src=\"/tag.png\"> <a href='$tag'>" . $tag . "</a>\n";
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

 	// 	print_book();

		// hr_tag();

 	// 	print_medium_plug();

		// hr_tag();

 		print_tag('_new');

 	}

 	print '<p/>
<a href="https://licensebuttons.net/l/by/4.0/"><img src="https://licensebuttons.net/l/by/4.0/80x15.png"></a><br/><br/>';

 	print "</div>";


?>

</div>

</body>