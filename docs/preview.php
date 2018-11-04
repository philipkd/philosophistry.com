<?php
	ini_set('error_reporting',E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
# ini_set('error_reporting', E_ALL);
# ini_set('display_errors', 1);
?> 

<?

	include_once "markdown.php";

	date_default_timezone_set('America/Chicago');

    $route = $_GET['route'];
    if (!$route) {
    	$route = "index";
    }

	$GLOBALS['note_to_slug'] = array();
	$GLOBALS['tag_to_notes'] = array();
	$GLOBALS['slug_to_note'] = array();
	$GLOBALS['note_to_contents'] = array();

	$GLOBALS['note_dir'] = "../preview";

	process_notes();

	$note = $GLOBALS['slug_to_note'][$route];

    $GLOBALS['scope'] = 'none';
	if ($route == 'all') {
		$GLOBALS['scope'] = 'all';
	} else if ($route == 'index') {
    	$GLOBALS['scope'] = '_new';
    } else if ($route == 'featured') {
    	$GLOBALS['scope'] = '_book';
	} else if (array_key_exists($route,$GLOBALS['tag_to_notes'])) {
		$GLOBALS['scope'] = $route;
	}

	if ($note) {
		$title = titleify($note);
	} else {
		if ($GLOBALS['scope'] == 'all') {
			$title = "Archives";
		} else if ($GLOBALS['scope'] == '_new') {
			$title = "Updated Notes";
		} else if ($GLOBALS['scope'] != 'none') {
			$title = "Notes Tagged &ldquo;" . $GLOBALS['scope'] . "&rdquo;";
		}
	}

	function print_note($name) {

		echo "<div class=\"blogentry\">";

		$url = "/posts/" . $GLOBALS['note_to_slug'][$name];

		echo "<div class='blogbody'>";

		echo Markdown($GLOBALS['note_to_contents'][$name]);

		echo "</div>";

		echo "</div>";

	}

	function parse_note($note) {
		$contents = file_get_contents($GLOBALS['note_dir'] . "/$note");

		$GLOBALS['note_to_fmod'][$note] = filemtime($GLOBALS['note_dir'] . "/$note");

		if (preg_match('#^(\d+-\d+-\d+)#',$note,$matches)) {
			$date_str = $matches[1];
			$time = strtotime($date_str);

			$GLOBALS['note_to_date'][$note] = $time;

		} else {
			$GLOBALS['note_to_date'][$note] = $GLOBALS['note_to_fmod'][$note];
		}
		$GLOBALS['note_to_contents'][$note] = $contents;
	}

	function special_tag($tag) {
		return preg_match("/^_/",$tag);
	}

	function process_notes() {

		if ($handle = opendir($GLOBALS['note_dir'])) {

			while (false !== ($entry = readdir($handle))) {
		        if (preg_match('/.txt$/',$entry)) {

		        	$slug = titleify($entry);
		        	$slug = slugify($slug);

		        	$GLOBALS['note_to_slug'][$entry] = $slug;
		        	$GLOBALS['slug_to_note'][$slug] = $entry;

		        }
		    }

		}

	}	

	function get_tags($filename) {
    	if (preg_match_all('/#(.*?)[\. ]/',$filename,$matches)) {
    		$tags = $matches[1];
    		return $tags;
    	}
    	return false;
	}		

	function date_sort($a,$b) {

		$diff = $GLOBALS['note_to_date'][$b] - $GLOBALS['note_to_date'][$a];

		if ($diff == 0)
			return $GLOBALS['note_to_fmod'][$b] - $GLOBALS['note_to_fmod'][$a];

		return $diff;
	}


	function slugify($text)
	{
	    // Strip out date
	    $text = preg_replace('/^\d+-\d+\d+ /','',$text);

	    // Swap out Non "Letters" with a -
	    $text = preg_replace('/[^\\pL\d]+/u', '-', $text); 

	    // Trim out extra -'s
	    $text = trim($text, '-');

	    // Convert letters that we have left to the closest ASCII representation
	    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	    // Make text lowercase
	    $text = strtolower($text);

	    // Strip out anything we haven't been able to convert
	    $text = preg_replace('/[^-\w]+/', '', $text);

	    return $text;
	}

	function titleify($text) {
	    $text = preg_replace('/^\d+-\d+-\d+ /','',$text);
		return preg_replace('/ #.*/','',$text);
	}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Markdown Preview</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="shortcut icon" href="/favicon.ico" >
<link rel="stylesheet" href="/preview.css" type="text/css" />
</head>

<body>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-18069474-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


<div id="main">


<?

	$notes = array_keys($GLOBALS['note_to_slug']);

	foreach ($notes as $note)
    	parse_note($note);

	sort($notes);

	foreach ($notes as $note)
    	print_note($note);

?>

</div> <!-- main -->


</body></html>