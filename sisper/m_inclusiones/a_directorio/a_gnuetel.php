<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
  if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['tiptel']) && !empty($_POST['tiptel']) && isset($_POST['num']) && !empty($_POST['num'])){
    $id=iseguro($cone,$_POST['id']);
    $tiptel=iseguro($cone,$_POST['tiptel']);
    $num=iseguro($cone,$_POST['num']);
    $s="INSERT INTO telefonoemp (idEmpleado, idTipoTelefono, Numero, Estado) VALUES ($id, $tiptel, '$num', 1);";
    if(mysqli_query($cone,$s)){
      echo mensajesu("Listo: Telefono registrado.");
    }else{
      echo mensajewa("Error: No se pudo registrar el teléfono.");
    }

    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No lleno correctamente el formulario.");
  }
}else{
  echo accrestringidoa();
}
?>
        