<?php 
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
    $locale = iseguro($cone,$_GET['term']);
    $q = mysqli_query($cone,"Select NumeroDoc, NombreCom From enombre Where NombreCom like '%$locale%' or NumeroDoc like '%$locale%'");
    $i=0;
    if(mysqli_num_rows($q)>0){
    	while($r = mysqli_fetch_assoc($q)){
    		$resul[$i]["label"]=html_entity_decode($r["NombreCom"]);
    		$resul[$i]["value"]=$r["NumeroDoc"];
    		$i++;
    	}
    }else{
    	$resul[$i]["label"]="No se encontraron coincidencias";
    	$resul[$i]["value"]="";
    }
    header('Content-type: application/json; charset=utf-8');
	echo json_encode($resul);
    mysqli_free_result($q);
    mysqli_close($cone);
}else{
    echo accrestringidoa();
}
?>