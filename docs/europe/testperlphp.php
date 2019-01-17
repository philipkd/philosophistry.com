<?php

$newRGB = HSBtoRGB(340,100,73);

echo $newRGB[0];
echo $newRGB[1];
echo $newRGB[2];

function HSBtoRGB($h, $s, $v) {
    $rgb = array();
    $rgb_dec = array();
    $h = $h/60;
    $s = $s/100;
    $v = $v/100;
    if ($s == 0) {
        $rgb[0] = $v*255;
        $rgb[1] = $v*255;
        $rgb[2] = $v*255;
    } else {
        $i = round($h);
        $p = $v * (1 - $s);
        $q = $v * (1 - $s * ($h - $i));
        $t = $v * (1 - $s * (1 - ($h - $i)));
        if ($i == 0) {
            $rgb_dec[0] = $v;
            $rgb_dec[1] = $t;
            $rgb_dec[2] = $p;
        } elseif ($i == 1) {
            $rgb_dec[0] = $q;
            $rgb_dec[1] = $v;
            $rgb_dec[2] = $p;
        } elseif ($i == 2) {
            $rgb_dec[0] = $p;
            $rgb_dec[1] = $v;
            $rgb_dec[2] = $t;
        } elseif ($i == 3) {
            $rgb_dec[0] = $p;
            $rgb_dec[1] = $q;
            $rgb_dec[2] = $v;
        } elseif ($i == 4) {
            $rgb_dec[0] = $t;
            $rgb_dec[1] = $p;
            $rgb_dec[2] = $v;
        } elseif ($i == 5) {
            $rgb_dec[0] = $v;
            $rgb_dec[1] = $p;
            $rgb_dec[2] = $q;
        } elseif ($i == 6) {
            $rgb_dec[0] = $v;
            $rgb_dec[1] = $p;
            $rgb_dec[2] = $q;
        }

        $rgb[0]  = sprintf("%1.0f", $rgb_dec[0] * 255);
        $rgb[1]  = sprintf("%1.0f", $rgb_dec[1] * 255);
        $rgb[2]  = sprintf("%1.0f", $rgb_dec[2] * 255);
    }
    return $rgb;
}

?>