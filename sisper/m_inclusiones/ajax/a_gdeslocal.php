<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_deslocal"){
		if(isset($_POST['idlo']) && !empty($_POST['idlo'])){
			$idlo=iseguro($cone,$_POST['idlo']);
			$sql="UPDATE local SET Estado=0 WHERE idLocal=$idlo";
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: El local fue desactivado.</h4>";
			}else{
				echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
			}
			mysqli_close($cone);	
		}else{
			echo "<h4 class='text-maroon'>Error: No se seleciono un local.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>