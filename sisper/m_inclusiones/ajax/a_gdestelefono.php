<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_destelefono"){
		if(isset($_POST['idte']) && !empty($_POST['idte'])){
			$idte=iseguro($cone,$_POST['idte']);
			$sql="UPDATE telefonoemp SET Estado=0 WHERE idTelefonoEmp=$idte";
			if(mysqli_query($cone,$sql)){
				echo "<h4 class='text-olive'>Listo: El teléfono fue desactivado.</h4>";
			}else{
				echo "<h4 class='text-maroon'>Error: " . mysqli_error($cone)."</h4>";
			}
			mysqli_close($cone);	
		}else{
			echo "<h4 class='text-maroon'>Error: No se eligió un teléfono.</h4>";
		}
	}
}else{
  echo accrestringidoa();
}
?>