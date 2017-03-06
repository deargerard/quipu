<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
if (isset($_FILES['foto'])) {
    $archivo = $_FILES['foto'];
    $nombre=$_POST['numdoc'];
    $tipo=$archivo['type'];
    $ruta_provisional=$archivo['tmp_name'];
    $size=$archivo['size'];
    if ($tipo != 'image/jpg' && $tipo != 'image/jpeg'){
    	echo "<span class='text-maroon'>Error: Sólo se admiten imágenes JPG</span>";
    }elseif($size>1024*512){
    	echo "<span class='text-maroon'>Error: El tamaño máximo permitido es de 512Kb</span>";
    }else{
	    //$extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
	    $nombre = "../../m_fotos/$nombre.jpg";
	    if (move_uploaded_file($ruta_provisional, "$nombre")) {
	        echo "<span class='text-olive'>Listo: La foto ha sido subida correctamente</span>";
	    }else{
	        echo "<span class='text-maroon'>Error: La foto NO se ha podido subir.</span>";
	    }
    }
}else{
	echo "<span class='text-maroon'>Error: No se envio el archivo</span>";
}
}else{
  echo accrestringidoa();
}
?>
