<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
	$r=array();
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ccomservicios"){
		if(isset($_POST['idcs']) && !empty($_POST['idcs'])){
			$idcs=iseguro($cone,$_POST['idcs']);
				$sql="UPDATE comservicios SET Estado=2 WHERE idComServicios=$idcs";
				if(mysqli_query($cone,$sql)){
					$r["msg"]= mensajesu("Listo: se canceló correctamente la comisión de servicios");
					$r["e"]=true;
				}else{
					$r["msg"]= mensajeda("Error: No se pudo cancelar la comisión de servicios.".mysqli_error($cone));
					$r["e"]=false;
				}
				mysqli_close($cone);
		}else{
			$r["msg"]=mensajewa("Error: No lleno correctamente el formulario");
			$r["e"]=false;
		}
	}
		header('Content-type: application/json; charset=utf-8');
	  echo json_encode($r);
	  exit();
	  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
