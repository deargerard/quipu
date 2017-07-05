<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ejvacaciones"){
		if(isset($_POST['idvac']) && !empty($_POST['idvac'])){
			$idvac=iseguro($cone,$_POST['idvac']);
			$nom=iseguro($cone,$_POST['nom']);
				$sql="UPDATE provacaciones SET Estado=3 WHERE idProVacaciones=$idvac";
				if(mysqli_query($cone,$sql)){
					echo mensajesu("Listo: Las vacaciones de ".$nom." empezaron a ejecutarse.");
				}else{
					echo mensajeda("Error: Las vacaciones no se pueden ejecutar. ".mysqli_error($cone));
				}
			mysqli_close($cone);
		}else{
			echo mensajewa("Error: No hay datos que procesar");
		}
	}
}else{
  echo accrestringidoa();
}
?>
