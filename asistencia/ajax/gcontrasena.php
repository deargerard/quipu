<?php
session_start();
include ("../../sisper/m_inclusiones/php/conexion_sp.php");
include ("../../sisper/m_inclusiones/php/funciones.php");
if(valaccasi($cone,$_SESSION['iden'],$_SESSION['docv'])){
	if(isset($_POST['con']) && !empty($_POST['con']) && isset($_POST['ncon']) && !empty($_POST['ncon']) && isset($_POST['rncon']) && !empty($_POST['rncon'])){

			$idv=$_SESSION['iden'];
			$con=sha1(iseguro($cone,$_POST['con']));
			$ncon=sha1(iseguro($cone,$_POST['ncon']));
			$rncon=sha1(iseguro($cone,$_POST['rncon']));
			$ce=mysqli_query($cone,"SELECT Contrasena FROM vigilante WHERE idVigilante=$idv");
			if($re=mysqli_fetch_assoc($ce)){
				if($re['Contrasena']===$con){
					if($ncon===$rncon){
						$q="UPDATE vigilante SET Contrasena='$ncon' WHERE idVigilante=$idv";
						if(mysqli_query($cone,$q)){
							echo mensajesu("Listo: Se cambío la contraseña.");
						}else{
							echo mensajeda("Error: No se pudo cambiar la contraseña.");
						}
					}else{
						echo mensajeda("Error: Las nuevas contraseñas no coinciden.");
					}

				}else{
					echo mensajeda("Error: la contraseña actual es incorrecta.");
				}
			}else{
				echo mensajeda("Error: No se encuentra registrado.");
			}
			mysqli_free_result($ce);

	}else{
		echo mensajeda("Error: No se enviaron todos los datos.");
	}
}else{
    header('Location: index.html');
}
?>