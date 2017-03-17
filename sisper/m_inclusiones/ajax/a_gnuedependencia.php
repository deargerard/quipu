<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nuedependencia"){
		if(isset($_POST['den']) && !empty($_POST['den']) && isset($_POST['pad']) && !empty($_POST['pad']) && isset($_POST['sig']) && !empty($_POST['sig']) && isset($_POST['jef']) && !empty($_POST['jef']) && isset($_POST['coo']) && !empty($_POST['coo']) && isset($_POST['disfis']) && !empty($_POST['disfis'])){
			$den=imseguro($cone,$_POST['den']);
			$pad=iseguro($cone,$_POST['pad']);
			$sig=imseguro($cone,$_POST['sig']);
			$jef=iseguro($cone,$_POST['jef']);
			$coo=iseguro($cone,$_POST['coo']);
			$disfis=iseguro($cone,$_POST['disfis']);
			$cdep=mysqli_query($cone,"SELECT Denominacion FROM dependencia WHERE Denominacion='$den'");
			if($rdep=mysqli_fetch_assoc($cdep)){
				echo mensajewa("Error: Ya existe una dependencia con el mismo nombre.");
			}else{
				$sql="INSERT INTO dependencia (idDistritoFiscal, Denominacion, Siglas, Observacion, Estado, idDependenciaPadre, idCoordinacion, Jefe) VALUES ($disfis, '$den', '$sig', 'Ninguna', 1, $pad, $coo, $jef)";
				if(mysqli_query($cone,$sql)){
					echo mensajesu("Listo: La dependencia fue creada correctamente");
				}else{
					echo mensajewa("Error: No se pudo guardar la dependencia. ".mysqli_error($cone));
				}
			}
			mysqli_free_result($cdep);
			mysqli_close($cone);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
}else{
  echo accrestringidoa();
}
?>
