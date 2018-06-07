<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_elitelefonop"){
		if(isset($_POST['idte']) && !empty($_POST['idte'])){
			$idte=iseguro($cone,$_POST['idte']);
			$sql="DELETE FROM telefonoemp WHERE idTelefonoEmp=$idte";
			if(mysqli_query($cone,$sql)){
				echo mensajesu("Listo: El teléfono fue eliminado.");
			}else{
				echo mensajewa("Error: Vuelva a intentarlo");
			}
			mysqli_close($cone);	
		}else{
			echo mensajewa("Error: No se eligió un teléfono.");
		}
	}
}else{
  echo accrestringidoa();
}
?>