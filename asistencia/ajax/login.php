<?php
session_start();
include ("../../sisper/m_inclusiones/php/conexion_sp.php");
include ("../../sisper/m_inclusiones/php/funciones.php");
if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="logina"){
	$jres=array();
	if(isset($_POST['dni']) && !empty($_POST['dni']) && isset($_POST['pas']) && !empty($_POST['pas'])){
		$dni=iseguro($cone,$_POST['dni']);
		//$pas=sha1(iseguro($cone,$_POST['pas']));
		$pas=sha1(iseguro($cone,$_POST['pas']));
		$q=mysqli_query($cone,"SELECT * FROM vigilante WHERE DNI='$dni'");
		if($p=mysqli_fetch_assoc($q)){
			if($p['Contrasena']===$pas){
				if($p['Estado']==1){
					$_SESSION['iden']=$p['idVigilante'];
					$_SESSION['nomv']=$p['Apellidos'].", ".$p['Nombres'];
					$_SESSION['docv']=$p['DNI'];
					$jres["exito"]=true;
					$jres["mensaje"]="Bienvenido.";
					$fa=@date("Y-m-d H:i:s");
					mysqli_query($cone,"UPDATE vigilante SET UltIngreso='$fa' WHERE idVigilante=".$p['idVigilante']);
				}else{
					$jres["exito"]=false;
					$jres["mensaje"]="Usuario desactivado.";
				}
			}else{
				$jres["exito"]=false;
				$jres["mensaje"]="Contraseña incorrecta.";
			}
		}else{
			$jres["exito"]=false;
			$jres["mensaje"]="Número de DNI incorrecto.";
		}
		mysqli_free_result($q);
	}else{
		$jres["exito"]=false;
		$jres["mensaje"]="Ingrese documento de identidad y contraseña.";
	}

	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jres);
	mysqli_close($cone);
	exit();
}
?>