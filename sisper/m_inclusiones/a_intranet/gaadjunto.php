<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_FILES["adj"])){
    $idcom=iseguro($cone,$_POST['idcom']);
    if($_FILES["adj"]["error"]>0){
    	echo mensajeda("Erro: No se pudo obtener el archivo adjunto.");
    }else{
    	$limite_kb=6144;
    	if($_FILES['adj']['size']<=$limite_kb*1024){
    		$nomadj='c'.$idcom.'_'.url($_FILES['adj']['name']);
    		$ruta="../../files_intranet/".$nomadj;
    		$subir=@move_uploaded_file($_FILES['adj']['tmp_name'], $ruta);
    		if($subir){
    			$q="UPDATE comunicado SET Adjunto='$nomadj' WHERE idComunicado=$idcom";
    			if(mysqli_query($cone,$q)){
    				echo mensajesu("Listo: Adjunto subido.");
    			}else{
    				unlink($ruta);
    				echo mensajeda("Error: No se pudo registrar los datos de la imagen.");
    			}

    		}else{
    			echo mensajeda("Error: No se pudo guardar la imagen.");
    		}
    	}else{
    		echo mensajeda("Error: El archivo supero los 2Mb permitidos.");
    	}
    }
  }else{
    echo mensajesu("Error: No adjunto ningún archivo.");
  }
}else{
  echo accrestringidoa();
}
?>