<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
	$idemp=$_SESSION['identi'];
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_camcontra"){
		if(isset($_POST['pas1']) && !empty($_POST['pas1']) && isset($_POST['pas2']) && !empty($_POST['pas2'])){
			if($_POST['pas1']==$_POST['pas2']){
				$pas1=sha1(iseguro($cone,$_POST['pas1']));
				$fa=@date("Y-m-d");
				$cca=mysqli_query($cone,"SELECT Contrasena FROM empleado WHERE idEmpleado=$idemp");
				$rca=mysqli_fetch_assoc($cca);
				if($rca['Contrasena']!=$pas1){
					$sql="UPDATE empleado SET Contrasena='$pas1', FecCamContra='$fa' WHERE idEmpleado=$idemp";
					if(mysqli_query($cone,$sql)){
						echo "<h4 class='text-olive'>Listo: Se cambio la contraseña.</h4>";
						echo '<a href="dboard.php" class="btn btn-info" role="button">Continuar...</a>';
					}else{
						echo "<h4 class='text-maroon'>Error: ". mysqli_error($cone)."</h4>";
						echo '<a href="camcontra.php" class="btn btn-info" role="button">Continuar...</a>';
					}
				mysqli_close($cone);
				}else{
					echo "<h4 class='text-maroon'>Error: La nueva contraseña no puede ser igual a la anterior.</h4>";
					echo '<a href="camcontra.php" class="btn btn-info" role="button">Continuar...</a>';
				}
			}else{
				echo "<h4 class='text-maroon'>Error: Las contraseñas no coinciden.</h4>";
				echo '<a href="camcontra.php" class="btn btn-info" role="button">Continuar...</a>';
			}	
		}else{
			echo "<h4 class='text-maroon'>Error: No lleno correctamente el formulario.</h4>";
			echo '<a href="camcontra.php" class="btn btn-info" role="button">Continuar...</a>';
		}
	}
}else{
	echo accrestringidoa();
}
?>