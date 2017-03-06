<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],7)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_camcontrasena"){
		if(isset($_POST['nuecon']) && !empty($_POST['nuecon']) && isset($_POST['rnuecon']) && !empty($_POST['rnuecon']) && isset($_POST['idemp']) && !empty($_POST['idemp'])){
			if($_POST['nuecon']==$_POST['rnuecon']){
				$nuecon=sha1(iseguro($cone,$_POST['nuecon']));
				$idemp=iseguro($cone,$_POST['idemp']);
				$fa=@date("Y-m-d");
				$sql="UPDATE empleado SET Contrasena='$nuecon', FecCamContra='$fa' WHERE idEmpleado=$idemp";
				if(mysqli_query($cone,$sql)){
					echo "<h4 class='text-olive'>Listo: Se cambio la contraseña.</h4>";
				}else{
					echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
				}
				mysqli_close($cone);
			}else{
				echo "<h4 class='text-maroon'>Error: Las contraseñas no coinciden.</h4>";
			}	
		}else{
			echo "<h4 class='text-maroon'>Error: No lleno correctamente el formulario.</h4>";
		}
	}
}else{
	echo accrestringidoa();
}
?>