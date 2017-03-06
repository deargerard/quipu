<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if (isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['cat']) && !empty($_POST['cat']))
    {
        $iddoc=iseguro($cone,$_POST['iddoc']);
        $des=iseguro($cone,$_POST['des']);
        $cat=iseguro($cone,$_POST['cat']);

        $q="UPDATE documento SET Descripcion='$des', idCatDocumento=$cat WHERE idDocumento=$iddoc";
        if(mysqli_query($cone,$q)){
            echo mensajesu("Listo: Se editó la información del documento.");
        }else{
            echo mensajeda("Error: No se pudo editar la información del documento, vuelva a intentarlo.");
        }

    }else{
        echo mensajeda("Error: Todos los campos son obligatorios, vuelva a intentarlo.");
    }
}else{
  echo accrestringidoa();
}