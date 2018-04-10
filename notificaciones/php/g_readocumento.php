<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$d=array();
if(acceso($cone,$idusu,1)){

	if(isset($_POST['iddoce']) && !empty($_POST['iddoce']) && isset($_POST['res']) && !empty($_POST['res'])){
		$iddoce=iseguro($cone,$_POST['iddoce']);
		$res=iseguro($cone,$_POST['res']);

		$c="UPDATE documento SET Estado=4, Reabierto=1, idAsignador=$idusu WHERE idDocumento=$iddoce;";
		if(mysqli_query($cone,$c)){
			$d['exito']=true;
			$d['mensaje']=mensajesu("Documento reabierto.");
			$d['lugar']=$res;
		}else{
			$d['exito']=false;
			$d['mensaje']=mensajewa("Error al reabierto, vuelva a intantarlo.");
		}

	}else{
		$d['exito']=false;
		$d['mensaje']=mensajewa("No envio datos.");
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