<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],16)){
	if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['idr']) && !empty($_POST['idr']) && isset($_POST['ord']) && !empty($_POST['ord'])){
		$idcs=iseguro($cone, $_POST['idcs']);
		$idr=iseguro($cone, $_POST['idr']);
		$ord=iseguro($cone, $_POST['ord']);
		if(is_int(intval($ord))){
			if(mysqli_query($cone, "UPDATE comservicios SET idterendicion=$idr, orden=$ord WHERE idComServicios=$idcs;")){
				$r['e']=true;
				$r['m']="¡Listo! Víatico agregado.";
			}else{
				$r['m']="Error, vuelva a intentarlo.";
			}
		}else{
			$r['m']="No ingreso un número en orden, vuelva a intentarlo.";
		}
	}else{
		$r['m']="Faltan datos.";
	}
}else{
  $r['m']="Acceso restringido.";
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>