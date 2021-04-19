<?php

$mserviceID=1;
$file = fopen("/test.txt","w");
    echo fwrite($file,$mserviceID);
    fclose($file);
?>
