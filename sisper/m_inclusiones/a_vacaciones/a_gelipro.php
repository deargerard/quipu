<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],9) || escoordinador($cone,$_SESSION['identi'])){
	if(isset($_POST['idvac']) && !empty($_POST['idvac'])){
		$idvac=iseguro($cone, $_POST['idvac']);
		if(mysqli_query($cone, "DELETE FROM provacaciones WHERE idProVacaciones=$idvac;")){
			$r['m']="Listo, programación de vacaciones eliminada";
			$r['e']=true;
		}else{
			$r['m']="Error al eliminar, vuelva a intentarlo.";
		}
	}else{
		$r['m']="Error, faltan datos";
	}
}else{
  $r['m']="Acceso restringido";
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($r);

mysqli_close($cone);
?>
