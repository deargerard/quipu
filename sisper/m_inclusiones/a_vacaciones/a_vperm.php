<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
		if(isset($_POST['clave']) && !empty($_POST['clave'])){
			$j=array();
			if ($_POST['clave']=="12345") {
				$j['exito']=true;
				$j['mensaje']="correcto";
			}else {
				$j['exito']=false;
				$j['mensaje']= mensajewa("Contraseña incorrecta");
			}
		}else{
			$j['exito']=false;
			$j['mensaje']= mensajewa("Error: No ingreso ninguna clave.");
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($j);
		exit();
}else{
  echo accrestringidoa();
}
?>
