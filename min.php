<?php

$avg = file_get_contents('avg.txt');
$a = array_filter(explode(" ", $avg));
// $average = round(array_sum($a) / count($a));
echo round(min($a));

?>