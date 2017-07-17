<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id=iseguro($cone,$_POST['id']);
        $c=mysqli_query($cone,"SELECT Estado FROM noticia WHERE idNoticia=$id;");
        if($r=mysqli_fetch_assoc($c)){
            $e=$r['Estado']==1 ? 0 : 1;
            $co="UPDATE noticia SET Estado=$e WHERE idNoticia=$id;";
            if(mysqli_query($cone,$co)){
                echo mensajesu("Listo: Se cambio de estado a la noticia.");
            }else{
                echo mensajeda("Error: No se pudo cambiar de estado a la noticia.");
            }           
        }else{
            echo mensajewa("Error: Los datos enviados no son válidos.");
        }
        mysqli_free_result($c);
    }else{
        echo mensajeda("Error: No envió datos.");
    }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>