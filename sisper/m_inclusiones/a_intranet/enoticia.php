<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if (isset($_POST['idno']) && !empty($_POST['idno']) && isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['tit']) && !empty($_POST['tit']) && isset($_POST['con']) && !empty($_POST['con']))
    {
        $fec=fmysql(iseguro($cone,$_POST['fec']));
        $idno=iseguro($cone,$_POST['idno']);
        $tit=iseguro($cone,$_POST['tit']);
        $con=iseguro($cone,$_POST['con']);
        $ide=$_SESSION['identi'];


        $q="UPDATE noticia SET Fecha='$fec', Titular='$tit', Cuerpo='$con', idEmpleado=$ide WHERE idNoticia=$idno";
        //echo $q;
        if(mysqli_query($cone,$q)){
            echo mensajesu("Listo: Se editó la noticia");
        }else{
            echo mensajeda("Error: No se pudo editar la noticia, vuelva a intentarlo. ". mysqli_error($cone));
        }

    }else{
        echo mensajeda("Error: Todos los campos son obligatorios, vuelva a intentarlo.");
    }
}else{
  echo accrestringidoa();
}