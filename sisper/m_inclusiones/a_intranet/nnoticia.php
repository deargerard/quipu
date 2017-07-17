<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if (isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['tit']) && !empty($_POST['tit']) && isset($_POST['con']) && !empty($_POST['con']))
    {
        $fec=fmysql(iseguro($cone,$_POST['fec']));
        $tit=iseguro($cone,$_POST['tit']);
        $con=iseguro($cone,$_POST['con']);
        $ide=$_SESSION['identi'];


        $q="INSERT INTO noticia (Fecha, Titular, Cuerpo, Estado, idEmpleado) VALUES ('$fec', '$tit', '$con', 0, $ide)";
        //echo $q;
        if(mysqli_query($cone,$q)){
            echo mensajesu("Listo: Se registró la noticia, para publicarla incluya la imagen principal.");
        }else{
            echo mensajeda("Error: No se pudo guardar la noticia, vuelva a intentarlo. ". mysqli_error($cone));
        }

    }else{
        echo mensajeda("Error: Todos los campos son obligatorios, vuelva a intentarlo.");
    }
}else{
  echo accrestringidoa();
}