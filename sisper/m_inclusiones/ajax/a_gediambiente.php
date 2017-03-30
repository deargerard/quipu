<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ediambiente"){
		if(isset($_POST['dep']) && !empty($_POST['den']) && isset($_POST['loc']) && !empty($_POST['pis']) && !empty($_POST['ofi'])){
			$idamb=imseguro($cone,$_POST['amb']);
			$dep=imseguro($cone,$_POST['dep']);
			$den=imseguro($cone,$_POST['den']);
			$loc=imseguro($cone,$_POST['loc']);
			$pis=iseguro($cone,$_POST['pis']);
			$ofi=iseguro($cone,$_POST['ofi']);
			$sql="UPDATE dependencialocal SET idDependencia=$dep, idTipoLocal=$den, idLocal=$loc, IdPiso=$pis, Oficina='$ofi' WHERE idDependenciaLocal=$idamb";
			if(mysqli_query($cone,$sql)){
				echo mensajesu("Listo: El ambiente fue editado correctamente.");
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
