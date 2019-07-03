<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT p.idProducto, t.Tipo FROM maproducto p INNER JOIN matipo t ON p.idTipo=t.idTipo INNER JOIN masubcategoria s ON t.idSubCategoria=s.idSubCategoria INNER JOIN macategoria c ON s.idCategoria=c.idCategoria WHERE p.Estado=1 AND t.Tipo LIKE '%$t%';");
    $json=[];
    if(mysqli_num_rows($c)>0){
        while ($r=mysqli_fetch_assoc($c)) {
            $json[]=['id'=>$r['idProducto'], 'text'=>html_entity_decode($r['Tipo'])];
        }
    }else{
        $json[]=['id'=>0, 'text'=>'SIN RESULTADOS'];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_free_result($c);
    mysqli_close($cone);

?>