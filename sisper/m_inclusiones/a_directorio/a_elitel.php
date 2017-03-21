<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id=iseguro($cone,$_POST["id"]);

    $s="DELETE FROM telefonoemp WHERE idTelefonoEmp=$id;";
    if(mysqli_query($cone,$s)){
      echo mensajesu("Listo: telefóno eliminado.");
    }else{
      echo mensajewa("Error: No se pudo eliminar el teléfono.");
    }

    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se eligio ningún teléfono.");
  }
}else{
  echo accrestringidoa();
}
?>