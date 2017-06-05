<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT iddoc, Numero, Ano, Siglas, FechaDoc, TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE Numero LIKE '%$t%' OR Ano LIKE '%$t%' OR Siglas LIKE '%$t%' ORDER BY Ano, Siglas, Numero DESC;");
    $json=[];
    while ($r=mysqli_fetch_assoc($c)) {
        $json[]=['id'=>$r['iddoc'], 'text'=>html_entity_decode($r['Numero']."-".$r['Ano']."-".$r['Siglas']." ".$r['TipoDoc'])];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_free_result($c);
    mysqli_close($cone);

?>