<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
	$r=array();
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ecomservicios"){
		if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['inicom']) && !empty($_POST['inicom']) && isset($_POST['fincom']) && !empty($_POST['fincom']) && isset($_POST['desc']) && !empty($_POST['desc']) && isset($_POST['doc']) && !empty($_POST['doc'])){
			$inicom=fmysql(iseguro($cone,$_POST['inicom']));
			$fincom=fmysql(iseguro($cone,$_POST['fincom']));
			$desc=iseguro($cone,$_POST['desc']);
			$veh=iseguro($cone,$_POST['veh'])== 1 ? 1 : 2;
			$doc=iseguro($cone,$_POST['doc']);
			$idcs=iseguro($cone,$_POST['idcs']);

			$sql="UPDATE comservicios SET FechaIni='$inicom', FechaFin='$fincom', Descripcion='$desc', Vehiculo=$veh, idDoc=$doc WHERE idComServicios=$idcs";

				if(mysqli_query($cone,$sql)){
					$r["msg"]= mensajesu("Listo: se actualizó correctamente la comisión de servicios");
					$r["e"]=true;
				}else{
					$r["msg"]= mensajeda("Error: No se pudo actualizar la comisión de servicios.".mysqli_error($cone));
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
