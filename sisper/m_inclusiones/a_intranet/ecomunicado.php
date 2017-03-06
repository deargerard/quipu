<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if (isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['con']) && !empty($_POST['con']))
    {
        $idcom=iseguro($cone,$_POST['idcom']);
        $fec=fmysql(iseguro($cone,$_POST['fec']));
        $des=iseguro($cone,$_POST['des']);
        $con=iseguro($cone,$_POST['con']);
        $ide=$_SESSION['identi'];

        $q="UPDATE comunicado SET Fecha='$fec', Descripcion='$des', Contenido='$con', idEmpleado=$ide WHERE idComunicado=$idcom";
        if(mysqli_query($cone,$q)){
            echo mensajesu("Listo: Se actualizó el comunicado.");
        }else{
            echo mensajeda("Error: No se pudo actualizar el comunicado, vuelva a intentarlo.");
        }

    }else{
        echo mensajeda("Error: Todos los campos son obligatorios, vuelva a intentarlo.");
    }
}else{
  echo accrestringidoa();
}