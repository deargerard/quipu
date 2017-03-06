<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
	$dexiste = "true";
	$numdoc=iseguro($cone,$_GET['numdoc']);
	$cdoc=mysqli_query($cone,"SELECT NumeroDoc FROM empleado WHERE NumeroDoc=$numdoc");
	if (mysqli_num_rows($cdoc) > 0) {
		$dexiste = "false";
	}
	header('Content-type: application/json');
	echo $dexiste;
	mysqli_free_result($cdoc);
	mysqli_close($cone);
}else{
	echo accrestringidoa();
}
?>