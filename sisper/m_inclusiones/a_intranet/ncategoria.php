<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if (isset($_POST['cat']) && !empty($_POST['cat']))
    {
        $cat=iseguro($cone,$_POST['cat']);

        $q="INSERT INTO catdocumento (CatDocumento, Estado) VALUES ('$cat', 1)";
        if(mysqli_query($cone,$q)){
            echo mensajesu("Listo: Se registró la categoría.");
        }else{
            echo mensajeda("Error: No se pudo guardar la categoría, vuelva a intentarlo.");
        }

    }else{
        echo mensajeda("Error: Todos los campos son obligatorios, vuelva a intentarlo.");
    }
}else{
  echo accrestringidoa();
}