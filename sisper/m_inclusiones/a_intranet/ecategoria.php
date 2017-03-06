<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if (isset($_POST['cat']) && !empty($_POST['cat']) && isset($_POST['idcat']) && !empty($_POST['idcat']))
    {
        $idcat=iseguro($cone,$_POST['idcat']);
        $cat=iseguro($cone,$_POST['cat']);

        $q="UPDATE catdocumento SET CatDocumento='$cat' WHERE idCatDocumento=$idcat";
        if(mysqli_query($cone,$q)){
            echo mensajesu("Listo: Se editó la categoría.");
        }else{
            echo mensajeda("Error: No se pudo editar la categoría, vuelva a intentarlo.");
        }

    }else{
        echo mensajeda("Error: Todos los campos son obligatorios, vuelva a intentarlo.");
    }
}else{
  echo accrestringidoa();
}