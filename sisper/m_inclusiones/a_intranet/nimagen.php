<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_FILES["img"])){
    if($_FILES["img"]["error"]>0){
    	echo mensajeda("Erro: No se pudo obtener la imagen.");
    }else{
        $idu=$_SESSION['identi'];

        $permitidos=array("image/jpeg", "image/png");
    	$limite_kb=1024;
    	if(in_array($_FILES['img']['type'], $permitidos) && $_FILES['img']['size']<=$limite_kb*1024){
            $c="INSERT INTO slider (Estado, idEmpleado) VALUES (1,$idu)";
            if(mysqli_query($cone,$c)){
                $id=mysqli_insert_id($cone);
        		$nomadj='s'.$id.'_'.url($_FILES['img']['name']);
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
                if($an>1000){
                    $nal=round(($al*1000)/$an);
                    $nan=1000;
                }
                //reducimos alto
                if($al>550){
                    $nan=round(($an*550)/$al);
                    $nal=550;
                }
                //ubicacion de la imagen
                $ux=round((1000-$nan)/2);
                $uy=round((550-$nal)/2);

                $cop=imagecreatetruecolor(1000, 550);
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
        			$q="UPDATE slider SET Imagen='$nomadj' WHERE idSlider=$id";
        			if(mysqli_query($cone,$q)){
        				echo mensajesu("Listo: Imagen subida.");

        			}else{
        				unlink($ruta);
                        mysqli_query($cone,"DELETE FROM slider WHERE idSlider=$id");
        				echo mensajeda("Error: No se pudo registrar los datos de la imagen.");
        			}

        		}else{
                    mysqli_query($cone,"DELETE FROM slider WHERE idSlider=$id");
        			echo mensajeda("Error: No se pudo guardar la imagen.");
        		}
            }else{
                echo mensajeda("Error: No se pudo guardar la información.");
            }

    	}else{
    		echo mensajeda("Error: El tipo de archivo no es el permitido o supero el 1MB.");
    	}
    }
  }else{
    echo mensajesu("Error: No adjunto ninguna imagen.");
  }
}else{
  echo accrestringidoa();
}
?>