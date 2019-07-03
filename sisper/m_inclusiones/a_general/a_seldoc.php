<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT d.idDoc, CONCAT_WS('-', d.Numero, d.Ano, d.Siglas) doc, d.numdoc, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.numdoc=$t OR CONCAT_WS('-' , d.Numero, d.Ano, d.Siglas) LIKE '%$t%' ORDER BY d.numdoc, doc ASC;");
    $json=[];
    if(mysqli_num_rows($c)>0){
        while ($r=mysqli_fetch_assoc($c)) {
            $json[]=['id'=>$r['idDoc'], 'text'=>html_entity_decode((!is_null($r['numdoc']) ? $r['numdoc'].' | ' : '').$r['TipoDoc'].' | '.$r['doc'])];
        }
    }else{
        $json[]=['id'=>0, 'text'=>'SIN RESULTADOS'];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_free_result($c);
    mysqli_close($cone);

?>