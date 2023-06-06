<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
	$r=array();
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ecomservicios"){
		if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['inicome']) && !empty($_POST['inicome']) && isset($_POST['fincome']) && !empty($_POST['fincome']) && isset($_POST['desc']) && !empty($_POST['desc']) && isset($_POST['doc']) && !empty($_POST['doc']) && isset($_POST['ori']) && !empty($_POST['ori']) && isset($_POST['des']) && !empty($_POST['des'])){
			$inicom=ftmysql(iseguro($cone,$_POST['inicome']));
			$fincom=ftmysql(iseguro($cone,$_POST['fincome']));
			$desc=iseguro($cone,$_POST['desc']);
			$veh=iseguro($cone,$_POST['veh'])== 1 ? 1 : 2;
			$sv=vacio(iseguro($cone, $_POST['sv']));
			$doc=iseguro($cone,$_POST['doc']);
			$idcs=iseguro($cone,$_POST['idcs']);
			$ide=iseguro($cone,$_POST['ide']);
			$ori=imseguro($cone,$_POST['ori']);
			$des=imseguro($cone,$_POST['des']);

			$cc=mysqli_query($cone, "SELECT idComServicios FROM comservicios WHERE idEmpleado=$ide AND idComServicios!=$idcs AND Estado=1 AND ((FechaIni BETWEEN '$inicom' AND '$fincom') OR (FechaFin BETWEEN '$inicom' AND '$fincom') OR ('$inicom' BETWEEN FechaIni AND FechaFin));");
			if(mysqli_num_rows($cc)>0){
				$r["msg"]=mensajewa("Ya existe una comisión que incluye o se cruza con las fechas ingresadas.");
				$r["e"]=false;
				$r["idcs"]=null;
			}else{

				$sql="UPDATE comservicios SET FechaIni='$inicom', FechaFin='$fincom', Descripcion='$desc', Vehiculo=$veh, idDoc=$doc, origen='$ori', destino='$des', estadoren=$sv WHERE idComServicios=$idcs";

				if(mysqli_query($cone,$sql)){
					$r["msg"]= mensajesu("Listo: se actualizó correctamente la comisión de servicios");
					$r["e"]=true;
				}else{
					$r["msg"]= mensajeda("Error: No se pudo actualizar la comisión de servicios.".mysqli_error($cone));
					$r["e"]=false;
				}

			}
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
