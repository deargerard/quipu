<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],12)){
	if(isset($_POST['idtd']) && !empty($_POST['idtd'])){
			$idtd=iseguro($cone, $_POST['idtd']);
			$sql="DELETE FROM telefonodep WHERE idTelefonoDep=$idtd";
			if(mysqli_query($cone,$sql)){
				echo mensajesu("Listo: El teléfono ha sido eliminado correctamente");
			}else{
				echo mensajewa("Error: " . mysqli_error($cone));
			}
			mysqli_close($cone);
		}else{
			echo mensajewa("No envío datos");
		}

}else{
  echo accrestringidoa();
}
?>
