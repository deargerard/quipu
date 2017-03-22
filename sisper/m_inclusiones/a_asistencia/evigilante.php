<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['ape']) && !empty($_POST['ape']) && isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['dni']) && !empty($_POST['dni'])){
    $id=iseguro($cone,$_POST['id']);
    $ape=imseguro($cone,$_POST['ape']);
    $nom=imseguro($cone,$_POST['nom']);
    $dni=iseguro($cone,$_POST['dni']);
    $c=mysqli_query($cone,"SELECT * FROM vigilante WHERE idVigilante!=$id AND DNI='$dni'");
    if($r=mysqli_fetch_assoc($c)){
      echo mensajeda("Error: El DNI ingresado ya se encuentra registrado para otro vigilante.");
    }else{
      $q="UPDATE vigilante SET Apellidos='$ape', Nombres='$nom', DNI='$dni' WHERE idVigilante=$id";
      if(mysqli_query($cone,$q)){
        echo mensajesu("Listo: Vigilante editado.");
      }else{
        echo mensajeda("Error: No se pudo editar al vigilante, vuelva a intentarlo.");
      }
    }
  }else{
    echo mensajeda("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>