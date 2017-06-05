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
    	$limite_kb=1024;
    	if($_FILES['img']['size']<=$limite_kb*1024){
            $c="INSERT INTO slider (Estado, idEmpleado) VALUES (1,$idu)";
            if(mysqli_query($cone,$c)){
                $id=mysqli_insert_id($cone);
        		$nomadj='s'.$id.'_'.url($_FILES['img']['name']);
        		$ruta="../../files_intranet/".$nomadj;
        		$subir=move_uploaded_file($_FILES['img']['tmp_name'], $ruta);
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
    		echo mensajeda("Error: El archivo supero el 1Mb permitido.");
    	}
    }
  }else{
    echo mensajesu("Error: No adjunto ninguna imagen.");
  }
}else{
  echo accrestringidoa();
}
?>