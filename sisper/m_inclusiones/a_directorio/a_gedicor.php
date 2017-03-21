<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['cor']) && !empty($_POST['cor']) && isset($_POST['tc']) && !empty($_POST['tc'])){
    $id=iseguro($cone,$_POST['id']);
    $cor=iseguro($cone,$_POST['cor']);
    $tc=iseguro($cone,$_POST['tc']);
    $tcor=$tc==1 ? "CorreoIns" : "CorreoPer";
    $s="UPDATE empleado SET $tcor='$cor' WHERE idEmpleado=$id;";
    if(mysqli_query($cone,$s)){
      echo mensajesu("Listo: Correo editado.");
    }else{
      echo mensajewa("Error: No se pudo editar el correo.");
    }

    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No lleno correctamente el formulario.");
  }
}else{
  echo accrestringidoa();
}
?>
        