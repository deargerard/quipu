<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],3)){
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_cvacaciones"){
		if(isset($_POST['idvac']) && !empty($_POST['idvac']) && isset($_POST['estado']) && !empty($_POST['estado'])){
			$idvac=iseguro($cone,$_POST['idvac']);
			$estado=iseguro($cone,$_POST['estado'])=="p" ? "0" : iseguro($cone,$_POST['estado']);
			$obse=vacio(iseguro($cone, $_POST['obse']));
			
			$sql="UPDATE provacaciones SET Estado=$estado, Observaciones=$obse WHERE idProVacaciones=$idvac";
			if(mysqli_query($cone,$sql)){
				$r['e']=true;
				$r['m']="Listo: Se cambio el estado de las vacaciones.";
			}else{
				$r['m']=mensajewa("Error: No se pudo cambiar el estado de las vacaciones."." - ".$sql);
			}

		}else{
			$r['m']=mensajewa("Error: No lleno correctamente el formulario.");
		}
	}
}else{
  $r['m']=mensajewa("Acceso restringido.");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>
