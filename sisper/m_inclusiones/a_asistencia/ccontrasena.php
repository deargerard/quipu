<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['con']) && !empty($_POST['con']) && isset($_POST['ncon']) && !empty($_POST['ncon'])){
    $id=iseguro($cone,$_POST['id']);
    $con=iseguro($cone,$_POST['con']);
    $ncon=iseguro($cone,$_POST['ncon']);
    if($con==$ncon){
        $vcon=sha1($con);
        $q="UPDATE vigilante SET Contrasena='$vcon' WHERE idVigilante=$id";
        if(mysqli_query($cone,$q)){
          echo mensajesu("Listo: Contraseña cambiada.");
        }else{
          echo mensajeda("Error: No se pudo cambiar la contraseña, vuelva a intentarlo.");
        }

    }else{
      echo mensajeda("Error: Las contraseñas no coinciden.");
    }
  }else{
    echo mensajeda("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>