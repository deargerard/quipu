<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edidependencia"){
		$jres=array();
		if(isset($_POST['iddep']) && !empty($_POST['iddep']) && isset($_POST['den']) && !empty($_POST['den']) && isset($_POST['sig']) && !empty($_POST['sig']) && isset($_POST['loc']) && !empty($_POST['loc']) && isset($_POST['disfis']) && !empty($_POST['disfis'])){
			$iddep=iseguro($cone,$_POST['iddep']);
			$den=imseguro($cone,$_POST['den']);
			$sig=imseguro($cone,$_POST['sig']);
			$loc=iseguro($cone,$_POST['loc']);
			$disfis=iseguro($cone,$_POST['disfis']);
			$sql="UPDATE dependencia SET idDistritoFiscal=$disfis, idLocal=$loc, Denominacion='$den', Siglas='$sig' WHERE idDependencia=$iddep";
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: La dependencia fue editada correctamente.</h4>";
			}else{
				echo "<h4 class='text-maroon'>Error: " . mysqli_error($cone)."</h4>";
			}
			mysqli_close($cone);		
		}else{
			echo "<h4 class='text-maroon'>No lleno correctamente el formulario.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>