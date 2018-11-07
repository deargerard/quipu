<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT idteproveedor, razsocial FROM teproveedor WHERE (razsocial LIKE '%$t%' OR ruc LIKE '%$t%') ORDER BY razsocial ASC;");
    $json=[];
    while ($r=mysqli_fetch_assoc($c)) {
        $json[]=['id'=>$r['idteproveedor'], 'text'=>html_entity_decode($r['razsocial'])];
    }
    mysqli_free_result($c);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_close($cone);

?>