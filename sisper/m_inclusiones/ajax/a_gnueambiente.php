<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nueambiente"){
		if(isset($_POST['dep']) && !empty($_POST['den']) && isset($_POST['loc']) && !empty($_POST['pis']) && isset($_POST['ofi'])){
			$dep=iseguro($cone,$_POST['dep']);
			$den=imseguro($cone,$_POST['den']);
			$loc=iseguro($cone,$_POST['loc']);
			$pis=iseguro($cone,$_POST['pis']);
			$ofi=imseguro($cone,$_POST['ofi']);
			$sql="INSERT INTO dependencialocal (idDependencia, idTipoLocal, idLocal, idPiso, Oficina, Estado) VALUES ('$dep', '$den', $loc, '$pis', '$ofi', 1)";
				if(mysqli_query($cone,$sql)){
					echo mensajesu("Listo: El ambiente fue creado correctamente.");
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
