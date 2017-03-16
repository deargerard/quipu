<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_desambiente"){
		if(isset($_POST['idamb']) && !empty($_POST['idamb'])){
			$idamb=iseguro($cone,$_POST['idamb']);
			$sql="UPDATE dependencialocal SET Estado=0 WHERE idDependenciaLocal=$idamb";
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: El Ambiente fue desactivado.</h4>";
			}else{
				echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
			}
			mysqli_close($cone);
		}else{
			echo "<h4 class='text-maroon'>Error: No se seleciono ningun Ambiente.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>
