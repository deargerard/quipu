<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);

        $q="UPDATE vigilante SET Estado=0 WHERE idVigilante=$id";
        if(mysqli_query($cone,$q)){
          echo mensajesu("Listo: Vigilante desactivado.");
        }else{
          echo mensajeda("Error: No se pudo desactivar al vigilante, vuelva a intentarlo.");
        }

  }else{
    echo mensajeda("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>