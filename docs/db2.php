<?php

$root = '../db';

$di = new RecursiveDirectoryIterator($root);
$count = 0;
$total_count = 0;
$filtered = true;
$filter_name = "Not-Yet-Stbd";

if ($filtered) {
    echo "<h2>Filter: $filter_name<br/></h2>";
}

$files = array();

foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
    if (strpos($file,'.txt')) {
        if (strpos($file,'_stbd') === false && strpos($file,'_pi') === false) {
            array_push($files,$file);
            $count++;
        }
        $total_count++;
    }
    // echo $filename . ' - ' . $file->getSize() . ' bytes <br/>';
}

function fname_sort($a, $b) {
    $regex = '~.*/~';
    return strcasecmp(preg_replace($regex,'',$a),preg_replace($regex,'',$b));
}

foreach ($files as $file) {
    $last_component = preg_replace('~/\d+/~','',$file);        
}

usort($files,'fname_sort');

foreach ($files as $file) {
    // $display = preg_replace("~" . $root . "~",'',$file);
    $display = preg_replace('~.*/~','',$file);

    echo $display . ' - ' . $file->getSize() . ' bytes <br/>';
}



echo "$count" . ($filtered ? " of $total_count" : "") . " entries";

?>