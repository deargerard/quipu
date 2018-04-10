<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$d=array();
if(acceso($cone,$idusu,2)){

	if(isset($_POST['iddoc']) && !empty($_POST['iddoc']) && isset($_POST['est']) && !empty($_POST['est']) && isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['mnot']) && !empty($_POST['mnot'])){
		$iddoc=iseguro($cone,$_POST['iddoc']);
		$est=iseguro($cone,$_POST['est']);
		$mnot=iseguro($cone,$_POST['mnot']);
		$fec=iseguro($cone,$_POST['fec']);
		$obs=iseguro($cone,$_POST['obs']);
		$feca=explode('/',$fec);
		if(checkdate($feca[1],$feca[0],$feca[2])){
			$fec=fmysql($fec);
			$c="UPDATE documento SET Estado=$est, ModNotificacion=$mnot, FecNotificacion='$fec', FecDevolucion=NOW(), Observaciones='$obs' WHERE idDocumento=$iddoc;";
			if(mysqli_query($cone,$c)){
				$d['exito']=true;
				$d['mensaje']=mensajesu("Documento reportado.");
			}else{
				$d['exito']=false;
				$d['mensaje']=mensajewa("Error al reportar, vuelva a intantarlo.");
			}
		}else{
			$d['exito']=false;
			$d['mensaje']=mensajewa("No ingresó una fecha válida.");
		}

	}else{
		$d['exito']=false;
		$d['mensaje']=mensajewa("Estado, modo notificacion y fecha not./dev. son campos obligarios.");
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