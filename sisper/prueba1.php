<?php
$f1="2017-04-01";
$f=date($f1);
$f=strtotime('+10 month',strtotime($f));
$fi=date('j-m-Y',$f);
$ff= strtotime('+29 day',strtotime($fi));
$ff= date('j-m-Y',$ff);
echo $f1 ."---". $fi."---". $ff;


 ?>
