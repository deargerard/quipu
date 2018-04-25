<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$d=array();
if(acceso($cone,$idusu,3)){

	if(isset($_POST['mfec']) && !empty($_POST['mfec']) && isset($_POST['mdes']) && !empty($_POST['mdes'])){
		$idg=iseguro($cone,$_POST['idg']);
		$anoa=imseguro($cone,$_POST['ano']);
		$fec=iseguro($cone,$_POST['mfec']);
		$des=imseguro($cone,$_POST['mdes']);
		$feca=explode('/',$fec);
		if(checkdate($feca[1],$feca[0],$feca[2])){
			$ano=$feca[2];
			if($anoa==$ano){
				$fec=fmysql($fec);
				$c="UPDATE guia SET Fecha='$fec', idDestino=$des WHERE idGuia=$idg;";
				if(mysqli_query($cone,$c)){
					$d['exito']=true;
					$d['mensaje']=mensajesu("Guía editada.");
				}else{
					$d['exito']=false;
					$d['mensaje']=mensajewa("Error al editar la guía, vuelva a intantarlo.");
				}
			}else{
				$d['exito']=false;
				$d['mensaje']=mensajewa("Sólo puede elegir una fecha que corresponda al $ano.");
			}
		}else{
			$d['exito']=false;
			$d['mensaje']=mensajewa("No ingreso una fecha válida.");
		}
	}else{
		$d['exito']=false;
		$d['mensaje']=mensajewa("Ambos campos son obligatorios.");
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