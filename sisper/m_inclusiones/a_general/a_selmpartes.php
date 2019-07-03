<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT idtdmesapartes, denominacion FROM tdmesapartes WHERE estado=1 AND denominacion LIKE '%$t%' ORDER BY denominacion ASC;");
    $json=[];
    if(mysqli_num_rows($c)>0){
        while ($r=mysqli_fetch_assoc($c)) {
            $json[]=['id'=>$r['idtdmesapartes'], 'text'=>html_entity_decode($r['denominacion'])];
        }
    }else{
        $json[]=['id'=>0, 'text'=>'SIN RESULTADOS'];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_free_result($c);
    mysqli_close($cone);

?>