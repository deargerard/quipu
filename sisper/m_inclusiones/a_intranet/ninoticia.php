<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_FILES["img"])){
    if($_FILES["img"]["error"]>0){
        echo mensajeda("Erro: No se pudo obtener la imagen.");
    }else{
        $inot=$_POST['inot'];
        $limite_kb=1024;
        if($_FILES['img']['size']<=$limite_kb*1024){
                $ext=explode(".",$_FILES['img']['name']);
                $nomadj='inoticia'.$inot.".".$ext[1];
                $ruta="../../files_intranet/".$nomadj;
                $subir=move_uploaded_file($_FILES['img']['tmp_name'], $ruta);
                if($subir){
                    $q="UPDATE noticia SET Imagen='$nomadj', Estado=1 WHERE idNoticia=$inot";
                    if(mysqli_query($cone,$q)){
                        echo mensajesu("Listo: Imagen subida.");
                    }else{
                        echo mensajeda("Error: No se pudo guardar datos de la imagen.");
                    }

                }else{

                    echo mensajeda("Error: No se pudo guardar la imagen.");
                }

        }else{
            echo mensajeda("Error: El archivo supero el 1Mb permitido.");
        }
    }
  }else{
    echo mensajeda("Error: No adjunto ninguna imagen.");
  }
}else{
  echo accrestringidoa();
}
?>