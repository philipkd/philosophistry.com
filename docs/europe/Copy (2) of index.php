<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Flash Map of Attitudes Toward Jews in 12 European Countries (2005)</title>
	<link rel="stylesheet" href="styles.css" type="text/css" />
</head>

<?php
	$questions[] = "Jews are more loyal to Israel than their own country";
	$questions[] = "Jews have too much power in the business world";
	$questions[] = "Jews have too much power in international final markets";
	$questions[] = "Jews still talk too much about what happened to them in the Holocaust";
	$questions[] = "Jews are responsible for the death of Christ";

	$selected_question = $_REQUEST{question};
	if ($_REQUEST{question}) {
		$selected_question = $_REQUEST{question};	
	} else {
		$selected_question = 1;	
	}
?>

</ul>

<body>

<h3>Question <?=$selected_question;?>:</h3>
<h2>What percentage of Europeans agree that ...</h2>
<h1>"<?=$questions[$selected_question-1];?>?"</h1>

<div style="width: 700px; margin:0; padding:0; float: left;">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="700" height="500" id="zoom_map" align="top">
<param name="movie" value="europe.swf?data_file=gen_data.php?question=<?=$selected_question;?>" />
<param name="quality" value="high" />
<param name="bgcolor" value="#333333" />
<embed src="europe.swf?data_file=gen_data.php?question=<?=$selected_question;?>" quality="high" bgcolor="#333333"  width="700" height="500" name="Clickable europe Map" align="top" 
type="application/x-shockwave-flash" 
pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
</object>
</div>

<div style="width: 260px; float: left; margin-left: 20px;">
What percentage responded "probably true" to the following statements:
<ol>
<?php
	for($i=1; $i <= count($questions); $i++) {
		print "\t<li";
		if ($i == $selected_question) {
			print " class=\"selected\"";
		}
		print "><a href=\"question_" . $i . ".html\">" . $questions[$i-1] . ".</a></li>\n";
	}
?>
</ol>
<span style="font-size: .9em;">&laquo; Move your mouse over countries to see individual percentages
<p/>

Surveyed Countries: Austria, Belgium, Denmark, France, Germany, The Netherlands, Hungary, Italy, Poland, Spain, Switzerland, UK

</span>
</div>


<p class="boxright"><a href="http://backspace.com/mapapp/">Powered by DIY Map</a> | <a href="http://www.macromedia.com/go/getflashplayer">Requires Flash</a></p>


<p class="boxright">Source: <a href="http://www.adl.org/main_Anti_Semitism_International/as_survey_2005.htm">2005 Anti-Defamation League Survey</a></p>

<p class="footnote">Created by <a href="mailto:philblog@dhingra.org">Philip Dhingra</a> and posted on <a href="http://www.philosophistry.com/">Philosophistry</a>. Discuss this page on the <a href="http://www.philosophistry.com/bbs/index.php?c=2">Philosophistry BBS</a>.</p>

<p class="footnote">

Furthur reading: <a href="http://en.wikipedia.org/wiki/Anti-semitism">wikipedia on Anti-Semitism</a>, <a href="http://www.adl.org/">Anti-Defamation League</a>'s website

<br/>

<a href="http://del.icio.us/">del.icio.us</a> tags: <a href="http://del.icio.us/tags/anti-semitism">anti-semitism</a> <a href="http://del.icio.us/tags/map">map</a> <a href="http://del.icio.us/tags/maps">maps</a> <a href="http://del.icio.us/tags/Europe">Europe</a> <a href="http://del.icio.us/tags/European">European</a> <a href="http://del.icio.us/tags/flash">flash</a> <a href="http://del.icio.us/tags/visualization">visualization</a> <a href="http://del.icio.us/tags/infoviz">infoviz</a> <a href="http://del.icio.us/tags/jews">jews</a> <a href="http://del.icio.us/tags/jew">jew</a>

</p>

<p class="footnote"><!-- Creative Commons License -->
This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution 2.5 License</a>.
<!-- /Creative Commons License -->


<!--

<rdf:RDF xmlns="http://web.resource.org/cc/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Work rdf:about="">
   <license rdf:resource="http://creativecommons.org/licenses/by/2.5/" />
</Work>

<License rdf:about="http://creativecommons.org/licenses/by/2.5/">
   <permits rdf:resource="http://web.resource.org/cc/Reproduction" />
   <permits rdf:resource="http://web.resource.org/cc/Distribution" />
   <requires rdf:resource="http://web.resource.org/cc/Notice" />
   <requires rdf:resource="http://web.resource.org/cc/Attribution" />
   <permits rdf:resource="http://web.resource.org/cc/DerivativeWorks" />
</License>

</rdf:RDF>

--></p>




</body>
</html>