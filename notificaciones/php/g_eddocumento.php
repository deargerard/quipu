<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$d=array();
if(acceso($cone,$idusu,1)){

	if(isset($_POST['iddoce']) && !empty($_POST['iddoce']) && isset($_POST['doce']) && !empty($_POST['doce']) && isset($_POST['orie']) && !empty($_POST['orie']) && isset($_POST['dese']) && !empty($_POST['dese']) && isset($_POST['fece']) && !empty($_POST['fece']) && isset($_POST['pere']) && !empty($_POST['pere'])){
		$iddoce=iseguro($cone,$_POST['iddoce']);
		$doce=iseguro($cone,trim($_POST['doce']));
		$orie=iseguro($cone,trim($_POST['orie']));
		$dese=iseguro($cone,trim($_POST['dese']));
		$fece=iseguro($cone,$_POST['fece']);
		$note=iseguro($cone,$_POST['note']);
		$pere=iseguro($cone, $_POST['pere']);
		$res=iseguro($cone, $_POST['res']);
		$feca=explode('/',$fece);
		if(checkdate($feca[1],$feca[0],$feca[2])){
			$fece=fmysql($fece);
			$c="UPDATE documento SET Documento='$doce', Origen='$orie', Destino='$dese', FecRecepcion='$fece', idResponsable=$pere, idAsignador=$idusu WHERE idDocumento=$iddoce;";
			if(mysqli_query($cone,$c)){
				$d['exito']=true;
				$d['mensaje']=mensajesu("Documento editado.");
				$d['lugar']=$res;
			}else{
				$d['exito']=false;
				$d['mensaje']=mensajewa("Error al editar, vuelva a intantarlo.");
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