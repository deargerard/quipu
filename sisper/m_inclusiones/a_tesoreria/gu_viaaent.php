<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],16)){
	if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['ide']) && !empty($_POST['ide'])){
		$idcs=iseguro($cone, $_POST['idcs']);
		$ide=iseguro($cone, $_POST['ide']);
		if(mysqli_query($cone, "UPDATE comservicios SET idteentrega=$ide WHERE idComServicios=$idcs;")){
			$r['e']=true;
			$r['m']="¡Listo! Viático agregado.";
		}else{
			$r['m']="Error, vuelva a intentarlo.";
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