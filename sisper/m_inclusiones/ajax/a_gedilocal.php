<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_edilocal"){
		if(isset($_POST['dir']) && !empty($_POST['dir']) && isset($_POST['disubi']) && !empty($_POST['disubi'])){
			$idlo=imseguro($cone,$_POST['idlo']);
			$dir=imseguro($cone,$_POST['dir']);
			$urb=imseguro($cone,$_POST['urb']);
			$loc=iseguro($cone,$_POST['loc']);
			$disubi=iseguro($cone,$_POST['disubi']);
			$tel=imseguro($cone,$_POST['tel']);
			$obs=iseguro($cone,$_POST['obs']);
			$sql="UPDATE local SET Direccion='$dir', Urbanizacion='$urb', idDistrito=$disubi, Telefono='$tel', Observacion='$obs' WHERE idLocal=$idlo";
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: El local fue editado correctamente.</h4>";
			}else{
				echo "<h4 class='text-maroon'>Error: " . mysqli_error($cone)."</h4>";
			}
			mysqli_close($cone);			
		}else{
			echo "<h4 class='text-maroon'>Error: No lleno correctamente el formulario.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>