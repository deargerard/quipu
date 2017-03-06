<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if (isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['fecb']) && !empty($_POST['fecb']))
    {
        $idbol=iseguro($cone,$_POST['idbol']);
        $des=iseguro($cone,$_POST['des']);
        $fecb=fmysql(iseguro($cone,$_POST['fecb']));

        $q="UPDATE boletin SET Descripcion='$des', Fecha='$fecb' WHERE idboletin=$idbol";
        if(mysqli_query($cone,$q)){
            echo mensajesu("Listo: Se editó la información del boletín.");
        }else{
            echo mensajeda("Error: No se pudo editar la información del boletín, vuelva a intentarlo.");
        }

    }else{
        echo mensajeda("Error: Todos los campos son obligatorios, vuelva a intentarlo.");
    }
}else{
  echo accrestringidoa();
}