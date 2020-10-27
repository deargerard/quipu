<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_cvacaciones"){
		if(isset($_POST['idvac']) && !empty($_POST['idvac']) && isset($_POST['estado']) && !empty($_POST['estado'])){
			$idvac=iseguro($cone,$_POST['idvac']);
			$estado=iseguro($cone,$_POST['estado']);
				$sql="UPDATE provacaciones SET Estado=$estado WHERE idProVacaciones=$idvac";
				if(mysqli_query($cone,$sql)){
					echo mensajesu("Listo: Se cambio el estado de las vacaciones");
				}else{
					echo mensajeda("Error: No se pudo cambiar el estado de las vacaciones. ".mysqli_error($cone));
				}
			mysqli_close($cone);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
}else{
  echo accrestringidoa();
}
?>
