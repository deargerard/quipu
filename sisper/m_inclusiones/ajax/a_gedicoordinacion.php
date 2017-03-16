<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edicoordinacion"){
		if(isset($_POST['idco']) && !empty($_POST['idco']) && isset($_POST['den']) && !empty($_POST['den'])){
			$idco=iseguro($cone,$_POST['idco']);
			$den=imseguro($cone,$_POST['den']);
			// if(isset($_POST['ofi']) && $_POST['ofi']==1){
			// 	$ofi=1;
			// }else{
			// 	$ofi=0;
			// }
			$ofi = $_POST['ofi']==1 ? 1 : 0;
			$sql="UPDATE coordinacion SET Denominacion='$den', Oficial=$ofi WHERE idCoordinacion=$idco";
			if(mysqli_query($cone,$sql)){
				echo mensajesu("Listo: La coordinacion fue editada correctamente.");
			}else{
				echo mensajeda("Error: " . mysqli_error($cone));
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
