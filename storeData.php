<?php
// error_reporting(null);

echo "hello";
$data = $_GET["data"];

$current = fopen("current.txt",'w') or die ;
fwrite($current,$data);

$avg = fopen("avg.txt", 'a') or die;
fwrite($avg, $data . " ");

date_default_timezone_set('Asia/Kolkata');
$timestamp = date("h:i:a");


$date = date('d-m-Y h:i:s:a');
$myfile = fopen("temp.txt", "a") or die("unable to open file");
$wd = $date . " Temperature :" . $data . "°C" . "\n";
echo $wd;
echo $timestamp;
fwrite($myfile, $wd);
fclose($myfile);
$checkH = date('H');
$checkm = date('i');
$checks = date('s');
echo "\n" . $checkm;
echo "\n" . $checks;
if ($checkm % 10 == 0 & $checks <= 9) {
    $myfile = fopen("check.csv", "a") or die("unable to open file");
    $wd = $timestamp . "," . $data . "\n";
    fwrite($myfile, $wd);
    fclose($myfile);

    $myfile_1 = fopen("log.csv", "a") or die("unable to open file");
    $wd_1 = $date . "," . $data . "\n";
    fwrite($myfile_1, $wd_1);
    fclose($myfile_1);
}
if ($checkH == 23 & $checkm > 50) {
    $myfile = fopen("check.csv", "w") or die("unable to open file");
    fwrite($myfile, "");
    fclose($myfile);
}

?>
