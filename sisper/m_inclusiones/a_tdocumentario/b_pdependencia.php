<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
$r['e']=false;
if(acceso($cone,$_SESSION['identi'])){
	if(isset($_POST['per']) && !empty($_POST['per'])){
		$per=iseguro($cone, $_POST['per']);
		$r['o']="<option value='".iddependenciae($cone,$per)."'>".dependenciae($cone,$per)."</option>";
		$r['s']=html_entity_decode(abrdependencia($cone, iddependenciae($cone,$per)));
		$r['e']=true;
	}else{
		$r['m']="Faltan datos.";
	}
}else{
	$r['m']="Acceso restringido";
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>