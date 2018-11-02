<?php

function slug($str) {
	return preg_replace('/ /','_',$str);
}

function unslug($str) {
	return preg_replace('/_/',' ',$str);
}

function MyMarkdown2($contents) {

	include_once "markdown.php";

	preg_match_all('/\[\[(.*?)\]\]/',$contents,$links, PREG_SET_ORDER);	

	$contents = preg_replace('/\[\[((.*\/){0,1}(.*?))\]\]/','[\3](\1)',$contents);

	foreach ($links as $link) {

		$link = $link[1];
		$newlink = slug($link);

		$contents = preg_replace("#\($link\)#","($newlink)",$contents);
	}

	return Markdown($contents);
}


if ($_GET['note'])
	$note = unslug($_GET['note']);
elseif ($argv[1])
	$note = $argv[1];
else
	$note = "index";

$contents = file_get_contents(dirname(__FILE__) . '/../content/Wiki/' . $note . '.txt');

$title = preg_replace('/(.*){0,1}\/(.*)/','\2',$note);
if ($title == 'index')
	$title = 'Home';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="/wiki.css">

<title><?= $title ?> (Philosophistry)</title>

</head>

<div class="site-title"><a href="./">Philosophistry: The Love of Rhetoric</a></div>

<div class="entry">

<div class="page-title"><?= $title ?></div>

<?= MyMarkdown2($contents) ?>