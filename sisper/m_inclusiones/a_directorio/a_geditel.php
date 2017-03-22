<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['tiptel']) && !empty($_POST['tiptel']) && isset($_POST['num']) && !empty($_POST['num'])){
    $id=iseguro($cone,$_POST['id']);
    $tiptel=iseguro($cone,$_POST['tiptel']);
    $num=iseguro($cone,$_POST['num']);
    $s="UPDATE telefonoemp SET idTipoTelefono=$tiptel, Numero='$num' WHERE idTelefonoEmp=$id;";
    if(mysqli_query($cone,$s)){
      echo mensajesu("Listo: Telefono editado.");
    }else{
      echo mensajewa("Error: No se pudo editar el teléfono.");
    }

    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No lleno correctamente el formulario.");
  }
}else{
  echo accrestringidoa();
}
?>
        