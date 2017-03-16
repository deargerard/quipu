<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_descoordinacion"){
		if(isset($_POST['idco']) && !empty($_POST['idco'])){
			$idco=iseguro($cone,$_POST['idco']);
			$sql="UPDATE coordinacion SET Estado=0 WHERE idCoordinacion=$idco";
			if(mysqli_query($cone,$sql)){
				echo mensajesu("Listo: Coordinación desactivada.");
			}else{
				echo mensajeda("Error: ".mysqli_error($cone));
			}
			mysqli_close($cone);
		}else{
			echo mensajewa("Error: No se seleccionó un local.");
		}
	}
}else{
  echo accrestringidoa();
}
?>
