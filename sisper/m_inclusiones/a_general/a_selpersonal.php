<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT e.idEmpleado, CONCAT(ApellidoPat,' ',ApellidoMat,', ',Nombres) AS nomemp FROM empleado e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE ec.idEstadoCar=1 AND CONCAT(ApellidoPat,' ',ApellidoMat,', ',Nombres) LIKE '%$t%' ORDER BY nomemp ASC;");
    $json=[];
    while ($r=mysqli_fetch_assoc($c)) {
        $json[]=['id'=>$r['idEmpleado'], 'text'=>html_entity_decode($r['nomemp'])];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_free_result($c);
    mysqli_close($cone);

?>