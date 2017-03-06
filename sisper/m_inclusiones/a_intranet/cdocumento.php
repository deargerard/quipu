<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_FILES["doc"])){
    if($_FILES["doc"]["error"]>0){
    	echo mensajeda("Error: No se pudo obtener el archivo adjunto.");
    }else{

        $iddoc=$_POST['iddoc'];
        $idu=$_SESSION['identi'];

        $cdoc=mysqli_query($cone,"SELECT * FROM documento WHERE idDocumento=$iddoc");
        if($rdoc=mysqli_fetch_assoc($cdoc)){
            $adj=$rdoc['Adjunto'];

            	$limite_kb=6144;
            	if($_FILES['doc']['size']<=$limite_kb*1024){

                		$nomadj='d'.$iddoc.'_'.url($_FILES['doc']['name']);
                		$ruta="../../files_intranet/".$nomadj;
                		$subir=@move_uploaded_file($_FILES['doc']['tmp_name'], $ruta);
                		if($subir){
                			$q="UPDATE documento SET Adjunto='$nomadj', idEmpleado=$idu WHERE idDocumento=$iddoc";
                			if(mysqli_query($cone,$q)){
                				echo mensajesu("Listo: Documento guardado.");
                                if (file_exists('../../files_intranet/'.$adj)) {
                                    unlink('../../files_intranet/'.$adj);
                                }
                			}else{
                				unlink($ruta);
                				echo mensajeda("Error: No se pudo registrar la información.");
                			}

                		}else{
                			echo mensajeda("Error: No se pudo guardar el documento.");
                		}

            	}else{
            		echo mensajeda("Error: El archivo supero los 2Mb permitidos.");
            	}

        }else{
            echo mensajeda("Error: Los datos enviados son incorrectos.");
        }
    }
  }else{
    echo mensajesu("Error: No adjunto ningún archivo.");
  }
}else{
  echo accrestringidoa();
}
?>