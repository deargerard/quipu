<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$d=array();
if(acceso($cone,$idusu,3)){

	if(isset($_POST['iddo']) && !empty($_POST['iddo'])){
		$iddo=iseguro($cone,$_POST['iddo']);

		$c="DELETE FROM doc WHERE idDoc=$iddo;";
		if(mysqli_query($cone,$c)){
			$d['exito']=true;
			$d['mensaje']=mensajesu("Documento eliminado.");
		}else{
			$d['exito']=false;
			$d['mensaje']=mensajewa("Error, vuelva a intentarlo.");
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