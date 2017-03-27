<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ntelefono"){
		if(isset($_POST['amb']) && !empty($_POST['amb']) && isset($_POST['tiptel']) && !empty($_POST['tiptel']) && isset($_POST['num']) && !empty($_POST['num'])){
			$amb=imseguro($cone,$_POST['amb']);
			$tiptel=imseguro($cone,$_POST['tiptel']);
			$num=iseguro($cone,$_POST['num']);
			$eqtra=imseguro($cone,$_POST['eqtra']);
			$sql="INSERT INTO telefonodep (idTipoTelefono, Numero, Estado, idDependenciaLocal, EquipoTra) VALUES ('$tiptel', '$num', 1, '$amb', '$eqtra')";
			if(mysqli_query($cone,$sql)){
				echo mensajesu("Listo: El número de teléfono fue insertado correctamente.");
			}else{
				echo mensajeda("Error: " . mysqli_error($cone));
			}
			mysqli_close($cone);
		}else{
			echo mensajewa("No lleno correctamente el formulario");
		}
	}
}else{
  echo accrestringidoa();
}
?>
