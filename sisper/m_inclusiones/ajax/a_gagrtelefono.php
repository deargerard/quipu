<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_agrtelefono"){
		if(isset($_POST['idpe']) && !empty($_POST['idpe']) && isset($_POST['tiptel']) && !empty($_POST['tiptel']) && isset($_POST['num']) && !empty($_POST['num'])){
			$idpe=iseguro($cone,$_POST['idpe']);
			$tiptel=iseguro($cone,$_POST['tiptel']);
			$num=iseguro($cone,$_POST['num']);
			$sql="INSERT INTO telefonoemp (idEmpleado, idTipoTelefono, Numero, Estado) VALUES ($idpe, $tiptel, '$num', 1)";
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: Teléfono agregado correctamente.</h4>";
			}else{
				echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
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