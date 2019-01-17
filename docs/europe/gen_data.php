<?php
	header('Content-type: text/xml');
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
	$selected_question = $_REQUEST{question};
	if ($_REQUEST{question}) {
		$selected_question = $_REQUEST{question};	
	} else {
		$selected_question = 1;	
	}

?>
<countrydata>

<state id="hover">
	<font_size>18</font_size>
	<font_color>ffffff</font_color>
	<background_color>333333</background_color>
</state>

<state id="default_color">
	<color>7f7f6f</color>
</state>

<state id="background_color">
	<color>333333</color>
</state>

<state id="outline_color">
	<color>000000</color>
	<opacity>20</opacity>
</state>

<state id="scale_points">
	<data>50</data>
</state>

<?php include("colors.php"); ?>

<state id="zoom_out_center">
	<loc>48.63,7.567</loc>
</state>

<state id="zoom_out_scale">
	<data>300</data>
</state>

<?php

$fh = fopen('2005.csv','r');
while (($line = fgetcsv($fh,1000)) !== FALSE) { ?>
<state id="<?=$line[6];?>">
	<name><?=$line[0];?> - <?=$line[$selected_question];?>%</name>
	<data><?=$line[$selected_question];?></data>
</state>
<?php }
fclose($fh);

?>

</countrydata>