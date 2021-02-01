<?php session_start(); 
$tipouser=$_SESSION['tipo'];
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($tipouser!="admin") 
{ //echo "Personal del area:",$_SESSION['tipo'];
    //si no existe, envio a la página de autentificacion 
   header("Location: home.php"); 
    //ademas salgo de este script 
   exit(); 
} 
?>