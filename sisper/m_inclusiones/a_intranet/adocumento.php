<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id=iseguro($cone,$_POST['id']);
        $co="UPDATE documento SET Estado=1 WHERE idDocumento=$id";
        if(mysqli_query($cone,$co)){
            echo mensajesu("Listo: Se activo el documento.");
        }else{
            echo mensajeda("Error: No se pudo activar el documento.");
        }
    }else{
        echo mensajeda("Error: No envió datos.");
    }
}else{
  echo accrestringidoa();
}
?>