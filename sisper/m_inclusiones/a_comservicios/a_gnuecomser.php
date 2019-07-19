<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
	$r=array();
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_ncomservicios"){
		if(isset($_POST['ide']) && !empty($_POST['ide']) && isset($_POST['inicom']) && !empty($_POST['inicom']) && isset($_POST['fincom']) && !empty($_POST['fincom']) && isset($_POST['desc']) && !empty($_POST['desc']) && isset($_POST['doc']) && !empty($_POST['doc']) && isset($_POST['ori']) && !empty($_POST['ori']) && isset($_POST['des']) && !empty($_POST['des'])){
			$inicom=ftmysql(iseguro($cone,$_POST['inicom']));
			$fincom=ftmysql(iseguro($cone,$_POST['fincom']));
			$desc=iseguro($cone,$_POST['desc']);
			$veh=iseguro($cone,$_POST['veh'])== 1 ? 1 : 2;
			$doc=iseguro($cone,$_POST['doc']);
			$ide=iseguro($cone,$_POST['ide']);
			$ori=imseguro($cone,$_POST['ori']);
			$des=imseguro($cone,$_POST['des']);

			$cc=mysqli_query($cone, "SELECT idComServicios FROM comservicios WHERE idEmpleado=$ide AND Estado=1 AND ((FechaIni BETWEEN '$inicom' AND '$fincom') OR (FechaFin BETWEEN '$inicom' AND '$fincom') OR ('$inicom' BETWEEN FechaIni AND FechaFin));");
			if(mysqli_num_rows($cc)>0){
				$r["msg"]=mensajewa("Ya existe una comisión que incluye o se cruza con las fechas ingresadas.");
				$r["e"]=false;
				$r["idcs"]=null;
			}else{
				$sql="INSERT INTO comservicios (FechaIni, FechaFin, Descripcion, Vehiculo, idDoc, idEmpleado, Estado, origen, destino) VALUES ('$inicom', '$fincom', '$desc', $veh, $doc, $ide, 1, '$ori', '$des')";

				if(mysqli_query($cone,$sql)){
					$r["msg"]= mensajesu("Listo: se guardó correctamente la comisión de servicios");
					$r["e"]=true;
					$r["idcs"]=mysqli_insert_id($cone);
				}else{
					$r["msg"]= mensajeda("Error: No se pudo guardar la comisión de servicios.".mysqli_error($cone));
					$r["e"]=false;
					$r["idcs"]=null;
				}
			}
		}else{
			$r["msg"]=mensajewa("Error: No lleno correctamente el formulario");
			$r["e"]=false;
			$r["idcs"]= null;
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
