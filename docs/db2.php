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

$by_year = array();

foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
    if (strpos($file,'.txt')) {
        if (($filtered === true && preg_match('~/- ~',$file) === 0 && strpos($file,'_pi') === false) || $filtered === false) {
            array_push($files,$file);
            if (preg_match('~/(\d+)/~',$file,$matches)) {
                $year = $matches[1];
                if (!array_key_exists($year,$by_year))
                    $by_year[$year] = array();

                array_push($by_year[$year],$file);
            }
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

function year_alpha_sort($a, $b) {
    return strcasecmp($b,$a);
}

usort($files,'fname_sort');

foreach ($files as $file) {
    // $display = preg_replace("~" . $root . "~",'',$file);
    $display = preg_replace('~.*/~','',$file);

    echo $display . ' - ' . $file->getSize() . ' bytes <br/>';
}



echo "<br/> $count" . ($filtered ? " of $total_count" : "") . " entries";

?>