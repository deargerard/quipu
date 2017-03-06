<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
	$q=iseguro($cone,$_GET['q']);
	$query="SELECT NombreCom, NumeroDoc FROM enombre";
	if(isset($q)){
		$query.=" WHERE NombreCom LIKE '%$q%'";
	}
	$res=array();
	if($cp=mysqli_query($cone,$query)){
		while($rp=mysqli_fetch_assoc($cp)){
			$res[]=$rp['NombreCom'];
		}
		mysqli_free_result($cp);
	}
	mysqli_close($cone);
	$json=json_encode($res);
	echo $json;
}else{
	echo accrestringidoa();
}
?>