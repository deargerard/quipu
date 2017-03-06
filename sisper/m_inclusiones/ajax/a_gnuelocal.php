<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nuelocal"){
		if(isset($_POST['dir']) && !empty($_POST['dir']) && isset($_POST['disubi']) && !empty($_POST['disubi'])){
			$dir=imseguro($cone,$_POST['dir']);
			$urb=imseguro($cone,$_POST['urb']);
			$loc=iseguro($cone,$_POST['loc']);
			$disubi=iseguro($cone,$_POST['disubi']);
			$tel=imseguro($cone,$_POST['tel']);
			$obs=iseguro($cone,$_POST['obs']);
			$cloc=mysqli_query($cone,"SELECT Direccion FROM local WHERE Direccion='$dir'");
			if($rloc=mysqli_fetch_assoc($cloc)){
				echo "<h4 class='text-maroon'>Error: Ya existe un local con la dirección ingresada.</h4>";
			}else{
				$sql="INSERT INTO local (Direccion, Urbanizacion, idDistrito, Telefono, Observacion, Estado) VALUES ('$dir', '$urb', $disubi, '$tel', '$obs', 1)";
				if(mysqli_query($cone,$sql)){
					echo "<h4 class='text-olive'>Listo: El local fue creado correctamente.</h4>";
				}else{
					echo "<h4 class='text-maroon'>Error: " . mysqli_error($cone)."</h4>";
				}
			}
			mysqli_free_result($cloc);
			mysqli_close($cone);
		}else{
			echo "<h4 class='text-maroon'>Error: No lleno correctamente el formulario.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>