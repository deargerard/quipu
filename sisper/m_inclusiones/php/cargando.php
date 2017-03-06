<?php
session_start();
include ("conexion_sp.php");
include ("funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	if(vcontrasena($cone,$_SESSION['identi'])){
		header('Location: ../../camcontra.php');
	}else{
			header('Location: ../../dboard.php');
	}
}else{
	header('Location: ../../index.php');
}
?>
