<?php include("conect.php");
$link=Conect(); 
$id=$_GET['id'];
 mysqli_query($link,"delete from user where user='$id'");
header("Location: user_personal.php");
 ?>