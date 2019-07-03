<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT idLocal, Direccion, NombreDis, NombrePro FROM local l INNER JOIN distrito di ON l.idDistrito=di.idDistrito INNER JOIN provincia pr ON di.idProvincia=pr.idProvincia WHERE Estado=1 AND Direccion LIKE '%$t%' OR NombreDis LIKE '%$t%' OR NombrePro LIKE '%$t%' ORDER BY Direccion ASC;");
    $json=[];
    if(mysqli_num_rows($c)>0){
	    while ($r=mysqli_fetch_assoc($c)) {
	        $json[]=['id'=>$r['idLocal'], 'text'=>html_entity_decode($r['Direccion'].' ['.$r['NombreDis'].' / '.$r['NombrePro'].']')];
	    }
    }else{
        $json[]=['id'=>0, 'text'=>'SIN RESULTADOS'];
    }
header('Content-type: application/json; charset=utf-8');
echo json_encode($json);
mysqli_free_result($c);
mysqli_close($cone);
?>
