<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_FILES["doc"])){
    if($_FILES["doc"]["error"]>0){
    	echo mensajeda("Erro: No se pudo obtener el archivo adjunto.");
    }else{
        if(isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['cat']) && !empty($_POST['cat'])){
            $des=iseguro($cone,$_POST['des']);
            $cat=iseguro($cone,$_POST['cat']);
            $idu=$_SESSION['identi'];

            	$limite_kb=6144;
            	if($_FILES['doc']['size']<=$limite_kb*1024){
                    $c="INSERT INTO documento (Descripcion, idCatDocumento, Estado, idEmpleado) VALUES ('$des', $cat, 1, $idu)";
                    if(mysqli_query($cone,$c)){
                        $id=mysqli_insert_id($cone);
                		$nomadj='d'.$id.'_'.url($_FILES['doc']['name']);
                		$ruta="../../files_intranet/".$nomadj;
                		$subir=@move_uploaded_file($_FILES['doc']['tmp_name'], $ruta);
                		if($subir){
                			$q="UPDATE documento SET Adjunto='$nomadj' WHERE idDocumento=$id";
                			if(mysqli_query($cone,$q)){
                				echo mensajesu("Listo: Documento guardado.");
                			}else{
                				unlink($ruta);
                                mysqli_query($cone,"DELETE FROM documento WHERE idDocumento=$id");
                				echo mensajeda("Error: No se pudo registrar la información.");
                                echo $q;
                			}

                		}else{
                			echo mensajeda("Error: No se pudo guardar la imagen.");
                		}
                    }else{
                        echo mensajeda("Error: No se pudo registrar la información.");
                    }
            	}else{
            		echo mensajeda("Error: El archivo supero los 2Mb permitidos.");
            	}

        }else{
            echo mensajeda("Error: Todos los campos son obligatorios.");
        }
    }
  }else{
    echo mensajesu("Error: No adjunto ningún archivo.");
  }
}else{
  echo accrestringidoa();
}
?>