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

        $permitidos=array("image/jpeg", "image/png");
        $limite_kb=1024;
        if(in_array($_FILES['img']['type'], $permitidos) && $_FILES['img']['size']<=$limite_kb*1024){
                $nomadj='n'.$inot."_".url($_FILES['img']['name']);
                $ruta="../../files_intranet/".$nomadj;
                

                $tem=$_FILES['img']['tmp_name'];
                $nom=$_FILES['img']['name'];

                if($_FILES['img']['type']=='image/jpeg'){
                    $ori=imagecreatefromjpeg($tem);
                    $an=imagesx($ori);
                    $al=imagesy($ori);
                }elseif($_FILES['img']['type']=='image/png'){
                    $ori=imagecreatefrompng($tem);
                    $an=imagesx($ori);
                    $al=imagesy($ori);
                }

                //nuevas longitudes
                $nan=$an;
                $nal=$al;

                //reducimos ancho
                if($an>600){
                    $nal=round(($al*600)/$an);
                    $nan=600;
                }
                //reducimos alto
                if($al>400){
                    $nan=round(($an*400)/$al);
                    $nal=400;
                }
                //ubicacion de la imagen
                $ux=round((600-$nan)/2);
                $uy=round((400-$nal)/2);

                $cop=imagecreatetruecolor(600, 400);
                $azul = imagecolorallocate($cop, 255, 255, 255);
                imagefill($cop, 0, 0, $azul);

                imagecopyresampled($cop, $ori, $ux, $uy, 0, 0, $nan, $nal, $an, $al);

                if($_FILES['img']['type']=='image/jpeg'){
                    $subir=imagejpeg($cop, $ruta, 80);
                }elseif($_FILES['img']['type']=='image/png'){
                    $subir=imagepng($cop, $ruta, 8);
                }
                imagedestroy($ori);
                imagedestroy($cop);


                if($subir){
                    $q="UPDATE noticia SET Imagen='$nomadj', Estado=1 WHERE idNoticia=$inot";
                    if(mysqli_query($cone,$q)){
                        echo mensajesu("Listo: Imagen subida.");
                    }else{
                        unlink($ruta);
                        echo mensajeda("Error: No se pudo guardar datos de la imagen.");
                    }

                }else{

                    echo mensajeda("Error: No se pudo guardar la imagen.");
                }

        }else{
            echo mensajeda("Error: El tipo de archivo no es el permitido o supero el 1MB.");
        }
    }
  }else{
    echo mensajeda("Error: No adjunto ninguna imagen.");
  }
}else{
  echo accrestringidoa();
}
?>