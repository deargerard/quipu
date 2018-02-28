<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
	$r=array();
	if(isset($_POST["NomForm"]) && $_POST["NomForm"]=="f_nencargatura"){
		if(isset($_POST['idcs']) && !empty($_POST['idcs']) && isset($_POST['inienc']) && !empty($_POST['inienc']) && isset($_POST['finenc']) && !empty($_POST['finenc']) && isset($_POST['enc']) && !empty($_POST['enc']) && isset($_POST['tip']) && !empty($_POST['tip'])){
			$idcs=iseguro($cone,$_POST['idcs']);
			$inienc=fmysql(iseguro($cone,$_POST['inienc']));
			$finenc=fmysql(iseguro($cone,$_POST['finenc']));
			$enc=iseguro($cone,$_POST['enc']);
			$tip=iseguro($cone,$_POST['tip']);

			$sql="INSERT INTO encargatura (Inicio, Fin, Estado, Tipo, idComServicios, idEmpleado) VALUES ('$inienc', '$finenc', 1, $tip, $idcs, $enc)";

				if(mysqli_query($cone,$sql)){
					$r["msg"]= mensajesu("Listo: se guardó correctamente la encargatura");
					$r["e"]=true;
					$r['idcs']=$idcs;
				}else{
					$r["msg"]= mensajeda("Error: No se pudo guardar la encargatura.".mysqli_error($cone));
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
