<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $id=iseguro($cone,$_POST['id']);
        $co=mysqli_query($cone,"SELECT * FROM slider WHERE idSlider=$id");
        if($re=mysqli_fetch_assoc($co)){
            $img=$re['Imagen'];
            $co="DELETE FROM slider WHERE idSlider=$id";
            if(mysqli_query($cone,$co)){
                echo mensajesu("Listo: Se eliminó la imagen.");
                if(file_exists('../../files_intranet/'.$img)){
                    unlink('../../files_intranet/'.$img);
                }
            }else{
                echo mensajeda("Error: No se pudo eliminar la imagen.");
            }
        }else{
            echo mensajeda("Error: No se encontró el registro.");
        }
    }else{
        echo mensajeda("Error: No envió datos.");
    }
}else{
  echo accrestringidoa();
}
?>