<?php 
$datetime1 = date_create('2016-05-01');
$datetime2 = date_create('2017-05-04');
$interval = date_diff($datetime1, $datetime2);
echo $interval->format('%R%a días');
?>