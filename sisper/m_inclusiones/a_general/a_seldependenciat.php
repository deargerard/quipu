<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 AND Denominacion LIKE '%$t%' ORDER BY Denominacion ASC;");
    $json=[];
    $json[]=['id'=>'t', 'text'=>'TODAS LAS DEPENDENCIAS'];
    while ($r=mysqli_fetch_assoc($c)) {
        $json[]=['id'=>$r['idDependencia'], 'text'=>html_entity_decode($r['Denominacion'])];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_free_result($c);
    mysqli_close($cone);

?>
