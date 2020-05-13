<?php

$current =  file_get_contents('current.txt');
$a = array_filter(explode(" ", $current));
$average = round(array_sum($a) / count($a));
echo $current;


?>