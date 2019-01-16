<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],16)){
	if(isset($_POST['idg']) && !empty($_POST['idg']) && isset($_POST['ide']) && !empty($_POST['ide'])){
		$idg=iseguro($cone, $_POST['idg']);
		$ide=iseguro($cone, $_POST['ide']);
		if(mysqli_query($cone, "UPDATE tegasto SET idteentrega=$ide WHERE idtegasto=$idg;")){
			$r['e']=true;
			$r['m']="¡Listo! Comprobante agregado.";
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