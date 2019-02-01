<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT idLocal, Alias, Direccion FROM local WHERE Estado=1 AND (Alias LIKE '%$t%' OR Direccion LIKE '%$t%') ORDER BY Alias, Direccion ASC;");
    $json=[];
    while ($r=mysqli_fetch_assoc($c)) {
        $json[]=['id'=>$r['idLocal'], 'text'=>html_entity_decode($r['Alias']." [".$r['Direccion']."]")];
    }
    mysqli_free_result($c);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_close($cone);

?>