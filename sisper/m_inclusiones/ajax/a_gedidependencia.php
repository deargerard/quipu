<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edidependencia"){
		if(isset($_POST['iddep']) && !empty($_POST['iddep']) && isset($_POST['den']) && !empty($_POST['den']) && isset($_POST['pad']) && !empty($_POST['pad']) && isset($_POST['sig']) && !empty($_POST['sig']) && isset($_POST['jef']) && !empty($_POST['jef']) && isset($_POST['coo']) && !empty($_POST['coo']) && isset($_POST['disfis']) && !empty($_POST['disfis'])){
			$iddep=iseguro($cone,$_POST['iddep']);
			$den=imseguro($cone,$_POST['den']);
			$pad=iseguro($cone,$_POST['pad']);
			$sig=imseguro($cone,$_POST['sig']);
			$jef=iseguro($cone,$_POST['jef']);
			$coo=iseguro($cone,$_POST['coo']);
			$disfis=iseguro($cone,$_POST['disfis']);
			$sql="UPDATE dependencia SET idDistritoFiscal=$disfis, Denominacion='$den', Siglas='$sig', idDependenciaPadre=$pad, idCoordinacion=$coo, Jefe=$jef WHERE idDependencia=$iddep";
			if(mysqli_query($cone,$sql)){
				echo mensajesu("Listo: La dependencia fue editada correctamente.");
			}else{
				echo mensajewa("Error: ".mysqli_error($cone));
			}
			mysqli_close($cone);
		}else{
			echo mensajewa("No lleno correctamente el formulario.");
		}
	}
}else{
  echo accrestringidoa();
}
?>
