<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$d=array();
if(acceso($cone,$idusu,1)){

	if(isset($_POST['doc']) && !empty($_POST['doc']) && isset($_POST['ori']) && !empty($_POST['ori']) && isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['per']) && !empty($_POST['per'])){
		$doc=iseguro($cone,trim($_POST['doc']));
		$ori=iseguro($cone,trim($_POST['ori']));
		$des=iseguro($cone,trim($_POST['des']));
		$fec=iseguro($cone,$_POST['fec']);
		$not=iseguro($cone,$_POST['not']);
		$per=iseguro($cone, $_POST['per']);
		$feca=explode('/',$fec);
		if(checkdate($feca[1],$feca[0],$feca[2])){
			$fec=fmysql($fec);
			$c="INSERT INTO documento (Documento, Origen, Destino, FecRegistro, FecRecepcion, Estado, idResponsable, idAsignador) VALUES ('$doc', '$ori', '$des', NOW(),'$fec', 1, $per, $idusu);";
			if(mysqli_query($cone,$c)){
				$d['exito']=true;
				$d['mensaje']=mensajesu("Documento registrado y asignado.");
			}else{
				$d['exito']=false;
				$d['mensaje']=mensajewa("Error al registrar, vuelva a intantarlo. ");
			}
		}else{
			$d['exito']=false;
			$d['mensaje']=mensajewa("No ingresó una fecha válida.");
		}

	}else{
		$d['exito']=false;
		$d['mensaje']=mensajewa("Todos los campos son obligatorios");
	}


}else{
	$d['exito']=false;
	$d['mensaje']=mensajewa("Acceso restringido.");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($d);
exit();
mysqli_close($cone);
?>