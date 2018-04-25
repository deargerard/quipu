<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
$d=array();
if(acceso($cone,$idusu,3)){

	if(isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['des']) && !empty($_POST['des'])){
		$fec=iseguro($cone,$_POST['fec']);
		$des=imseguro($cone,$_POST['des']);
		$feca=explode('/',$fec);
		if(checkdate($feca[1],$feca[0],$feca[2])){
			$ano=$feca[2];
			$cng=mysqli_query($cone, "SELECT MAX(Numero) as num FROM guia WHERE DATE_FORMAT(Fecha,'%Y')='$ano';");
			if($rng=mysqli_fetch_assoc($cng)){
				$num=$rng["num"]+1;
			}else{
				$num=0;
			}
			mysqli_free_result($cng);
			$fec=fmysql($fec);
			$c="INSERT INTO guia (Numero, Fecha, idDestino) VALUES ($num, '$fec', $des);";
			if(mysqli_query($cone,$c)){
				$d['exito']=true;
				$d['mensaje']="<p class='text-success'><i class='fa fa-check-circle'></i> Guía Generada.</p>";
			}else{
				$d['exito']=false;
				$d['mensaje']="<p class='text-warning'><i class='fa fa-exclamation-triangle'></i> Error al generar la guía, vuelva a intantarlo.</p>";
			}
		}else{
			$d['exito']=false;
			$d['mensaje']="<p class='text-warning'><i class='fa fa-exclamation-triangle'></i> No ingreso una fecha válida.</p>";
		}
	}else{
		$d['exito']=false;
		$d['mensaje']="<p class='text-warning'><i class='fa fa-exclamation-triangle'></i> Ambos campos son obligatorios.</p>";
	}


}else{
	$d['exito']=false;
	$d['mensaje']="<p class='text-warning'><i class='fa fa-exclamation-triangle'></i> Acceso restringido.</p>";
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($d);
exit();
mysqli_close($cone);
?>