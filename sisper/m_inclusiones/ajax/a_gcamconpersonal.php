<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_camconpersonal"){
		if(isset($_POST['actcon']) && !empty($_POST['actcon']) && isset($_POST['nuecon']) && !empty($_POST['nuecon']) && isset($_POST['rnuecon']) && !empty($_POST['rnuecon']) && isset($_POST['idemp']) && !empty($_POST['idemp'])){
			$actcon=sha1(iseguro($cone,$_POST['actcon']));
			$nuecon=sha1(iseguro($cone,$_POST['nuecon']));
			$idemp=iseguro($cone,$_POST['idemp']);
			$ce=mysqli_query($cone,"SELECT Contrasena FROM empleado WHERE idEmpleado=$idemp");
			if($re=mysqli_fetch_assoc($ce)){
				if($re['Contrasena']===$actcon){
					if($re['Contrasena']!=$nuecon){
						$fa=@date("Y-m-d");
						$sql="UPDATE empleado SET Contrasena='$nuecon', FecCamContra='$fa' WHERE idEmpleado=$idemp";
						if(mysqli_query($cone,$sql)){
							echo "<h4 class='text-olive'>Listo: Se cambio la contraseña.</h4>";
						}else{
							echo "<h4 class='text-maroon'>Error: " . mysqli_error($cone)."</h4>";
						}
					}else{
						echo "<h4 class='text-maroon'>Error: La nueva contraseña no puede ser igual a la anterior.</h4>";
					}
				}else{
					echo "<h4 class='text-maroon'>Error: La contraseña actual no coincide.</h4>";
				}
			}
			mysqli_free_result($ce);	
			mysqli_close($cone);		
		}else{
			echo "<h4 class='text-maroon'>Error: No lleno correctamente el formulario.</h4>";
		}
	}
}else{
	echo accrestringidoa();
}
?>