<head>

<title>Philosophistry: The Love of Rhetoric</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>

<h1>Philosophistry: The Love of Rhetoric</h1>
<a href="http://philipkd.com/">Philip Dhingra</a>’s musings on everything including futurism, evolution, psychology, philosophy, and self-improvement (<a href="https://medium.com/philosophistry/about-philosophistry-2eb831ee5ab2">est. 2003</a>). To see a preview of what I'm working on, visit <a href="wiki/">the wiki</a> or <a href="db/">the db</a>.

<style>
body {
	font-size: 16pt;
}
a {
	/*color: black;*/
}
a:visited {
	color: black;
}
</style>

<?php

$GLOBALS['indices'] = dirname(__FILE__) . "/../published/Indices";

$GLOBALS['topics'] = array();

function process_indices() {
	$folder = $GLOBALS['indices'];
	$handle = opendir($folder);
	while (false !== ($index = readdir($handle))) {
        if (preg_match('/.txt$/',$index)) {
        	$file = $folder . "/" . $index;
        	$topic = preg_replace('/.txt$/',"",$index);

        	$GLOBALS['topics'][$topic] = array();

        	$i = 0;
        	$title = "";
        	$subtitle = "";
        	$url = "";
        	foreach(file($file) as $line) {
        		$line = rtrim($line);
				if ($i % 4 == 0)
					$title = $line;
				if ($i % 4 == 1)
					$subtitle = $line;
				if ($i % 4 == 2)
					$url = $line;
				if ($i % 4 == 3)
					array_push($GLOBALS['topics'][$topic],array($title, $subtitle, $url));
				$i++;
			}
        }
	}
	        			
}

function print_topics() {
	$topics = array_keys($GLOBALS['topics']);
	natsort($topics);
	foreach ($topics as $topic) {
		print_topic($topic);
		echo "\n";
	}
}

function print_topic($topic) {
	echo "<h3>$topic</h3>\n";
	foreach ($GLOBALS['topics'][$topic] as $post)
		echo "<a href=\"{$post[2]}\">{$post[0]}</a><br/>{$post[1]}<p/>\n";
}

?>

<h2>Start Here</h2>

<a href="https://medium.com/@philipkd/wobbly-tables-and-the-problem-with-futurism-934468d2308">A hundred years in the future, 25% of restaurant tables will still wobble</a><br/>It's like in Minority Report, how everybody still catches the cold<p/>

<?php

process_indices();
# print_r($GLOBALS['topics']);
print_topics();
# print_topic("Futurism");

?>

<p/>
<a href="https://licensebuttons.net/l/by/4.0/"><img src="https://licensebuttons.net/l/by/4.0/80x15.png"></a>