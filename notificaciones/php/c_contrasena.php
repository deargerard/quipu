<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$r=array();
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
	if(isset($_POST['cact']) && !empty($_POST['cact']) && isset($_POST['cnue']) && !empty($_POST['cnue']) && isset($_POST['crep']) && !empty($_POST['crep'])){
		$cact=iseguro($cone,$_POST['cact']);
		$cnue=iseguro($cone,$_POST['cnue']);
		$crep=iseguro($cone,$_POST['crep']);
		$cu=mysqli_query($cone,"SELECT Contrasena FROM usuario WHERE idUsuario=$idusu;");
		if($ru=mysqli_fetch_assoc($cu)){
			if($ru['Contrasena']==$cact){
				if($cnue==$crep){
					if(mysqli_query($cone,"UPDATE usuario SET Contrasena='$cnue' WHERE idUsuario=$idusu;")){
						$r['m']=mensajesu("Contraseña cambiada.");
						$r['e']=true;	
					}else{
						$r['m']=mensajewa("Error al cambiar la contrasena, vuelva a intentarlo.");
						$r['e']=false;						
					}
				}else{
					$r['m']=mensajewa("Las nuevas contraseñas no coinciden.");
					$r['e']=false;	
				}
			}else{
				$r['m']=mensajewa("La contraseña actual no coincide.");
				$r['e']=false;		
			}

		}else{
			$r['m']=mensajewa("Todos los campos son obligatorios.");
			$r['e']=false;		
		}
	}else{
		$r['m']=mensajewa("Todos los campos son obligatorios.");
		$r['e']=false;
	}
}else{
	$r['m']=mensajewa("Acceso restingido.");
	$r['e']=false;
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
exit();
mysqli_close($cone);
?>