<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nuecoordinacion"){
		if(isset($_POST['den']) && !empty($_POST['den'])){
			$den=imseguro($cone,$_POST['den']);
			if(isset($_POST['ofi']) && $_POST['ofi']==1){
				$ofi=1;
			}else{
				$ofi=0;
			}
			$c=mysqli_query($cone,"SELECT Denominacion FROM coordinacion WHERE Denominacion='$den'");
			if($r=mysqli_fetch_assoc($c)){
				echo mensajewa("Error: Ya existe una coordinación con la misma denominación.");
			}else{
				$sql="INSERT INTO coordinacion (Denominacion, Oficial, Estado) VALUES ('$den', '$ofi', 1)";
				if(mysqli_query($cone,$sql)){
					echo mensajesu("Listo: La coordinacion fue creada correctamente.");
				}else{
					echo mensajeda("Error: " . mysqli_error($cone));
				}
			}
			mysqli_free_result($c);
			mysqli_close($cone);
		}else{
			echo mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
}else{
  echo accrestringidoa();
}
?>
