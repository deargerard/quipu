<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="login"){
	$jres=array();
	if(isset($_POST['doc']) && !empty($_POST['doc']) && isset($_POST['pas']) && !empty($_POST['pas'])){
		$doc=iseguro($cone,$_POST['doc']);
		$pas=sha1(iseguro($cone,$_POST['pas']));
		$q=mysqli_query($cone,"SELECT idEmpleado, ApellidoPat, ApellidoMat, Nombres, NumeroDoc, Contrasena, Estado FROM empleado WHERE NumeroDoc='$doc'");
		if($p=mysqli_fetch_assoc($q)){
			if($p['Contrasena']===$pas){
				if($p['Estado']==1){
					$_SESSION['identi']=$p['idEmpleado'];
					$_SESSION['nomusu']=$p['ApellidoPat']." ".$p['ApellidoMat'].", ".$p['Nombres'];
					$_SESSION['docide']=$p['NumeroDoc'];
					$jres["exito"]=true;
					$jres["mensaje"]="Bienvenido.";
					$fa=@date("Y-m-d");
					mysqli_query($cone,"UPDATE empleado SET FecUltIng='$fa' WHERE idEmpleado=".$p['idEmpleado']);
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
			$jres["mensaje"]="Número de documento de identidad incorrecto.";
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