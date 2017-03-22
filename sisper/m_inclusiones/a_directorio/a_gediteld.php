<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_etelefono"){
		if(isset($_POST['amb']) && !empty($_POST['amb']) && isset($_POST['tiptel']) && !empty($_POST['tiptel']) && isset($_POST['num']) && !empty($_POST['num'])){
			$idtel=iseguro($cone, $_POST['idtd']);
			$amb=iseguro($cone,$_POST['amb']);
			$tiptel=iseguro($cone,$_POST['tiptel']);
			$num=iseguro($cone,$_POST['num']);
			$sql="UPDATE telefonodep SET idTipoTelefono = $tiptel, Numero='$num', idDependenciaLocal=$amb WHERE idTelefonoDep=$idtel";
			if(mysqli_query($cone,$sql)){
				echo mensajesu("Listo: El teléfono fue editado correctamente");
			}else{
				echo mensajewa("Error: " . mysqli_error($cone));
			}
			mysqli_close($cone);
		}else{
			echo mensajewa("No lleno correctamente el formulario");
		}
	}
}else{
  echo accrestringidoa();
}
?>
