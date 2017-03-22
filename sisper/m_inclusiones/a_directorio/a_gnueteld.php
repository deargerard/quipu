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
			$sql="INSERT INTO telefonodep (idTipoTelefono, Numero, Estado, idDependenciaLocal) VALUES ('$tiptel', '$num', 1, '$amb')";
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: El número de teléfono fue insertado correctamente.</h4>";
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
