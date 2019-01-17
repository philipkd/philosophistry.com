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

<state id="default_color">
	<color>9999ff</color>
</state>
<state id="background_color">
	<color>333399</color>
</state>
<state id="outline_color">
	<color>5C5CBD</color>
</state>

<state id="default_point">
	<color>ffff00</color>
	<size>5</size>
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


<state id="AU">
	<name>Austria</name>
	<data>75</data>
</state>
<state id="BE">
	<name>Belgium</name>
	<data>54</data>
</state>
<state id="DA">
	<name>Denmark</name>
	<data>29</data>
</state>
<state id="FR">
	<name>France</name>
	<data>25</data>
</state>
<state id="GM">
	<name>Germany</name>
	<data>83</data>
</state>
<state id="HU">
	<name>Hungary</name>
	<data>75</data>
</state>
<state id="IT">
	<name>Italy</name>
	<data>88</data>
</state>
<state id="NL">
	<name>Netherlands</name>
	<data>25</data>
</state>
<state id="PL">
	<name>Poland</name>
	<data>100</data>
</state>
<state id="SP">
	<name>Spain</name>
	<data>75</data>
</state>
<state id="SZ">
	<name>Switzerland</name>
	<data>83</data>
</state>
<state id="UK">
	<name>United Kingdom</name>
	<data>0</data>
</state>
</countrydata>