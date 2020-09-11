<?php 
   include("conect.php");
   $link=Conect();
   $id=$_GET['id']; 
   mysqli_query($link,"delete from inventario where id='$id'"); 
  
   header("Location: inventario.php"); 
?>