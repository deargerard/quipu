<?php include("conect.php");
$link=Conect(); 
$id=$_GET['id'];
 mysqli_query($link,"delete from empleados where dni='$id'");
header("Location: personal.php");
 ?>