<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['ape']) && !empty($_POST['ape']) && isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['dni']) && !empty($_POST['dni'])){
    $ape=imseguro($cone,$_POST['ape']);
    $nom=imseguro($cone,$_POST['nom']);
    $dni=iseguro($cone,$_POST['dni']);
    $c=mysqli_query($cone,"SELECT * FROM vigilante WHERE DNI='$dni'");
    if($r=mysqli_fetch_assoc($c)){
      echo mensajeda("Error: El DNI ingresado ya se encuentra registrado.");
    }else{
      $co=RandomString(6);
      $con=sha1($co);
      $q="INSERT INTO vigilante (Apellidos, Nombres, DNI, Contrasena, Estado, UltIngreso) VALUES ('$ape', '$nom', '$dni', '$con', 1, '0000-00-00 00:00:00')";
      if(mysqli_query($cone,$q)){
        echo mensajesu("Listo: Vigilante registrado<br>Contraseña: $co");
      }else{
        echo mensajeda("Error: No se pudo registrar al vigilante, vuelva a intentarlo.");
      }
    }
  }else{
    echo mensajeda("Error: No se enviaron datos");
  }
}else{
  echo accrestringidoa();
}
?>