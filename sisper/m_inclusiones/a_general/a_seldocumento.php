<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

    $t=iseguro($cone,$_GET['q']);
    //separar por guion
    $t=explode("-",$t);
    //si existe $t[1]
    if(isset($t[1])){
        $t[0]=trim($t[0]);
        $t[1]=trim($t[1]);
        $c=mysqli_query($cone,"SELECT iddoc, Numero, Ano, Siglas, TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE Numero LIKE '%$t[0]%' AND Ano='$t[1]' ORDER BY Numero, Ano DESC;");
    }else{
        $t[0]=trim($t[0]);
        $c=mysqli_query($cone,"SELECT iddoc, Numero, Ano, Siglas, TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE Numero LIKE '%$t[0]%' ORDER BY Numero, Ano DESC;");
    }
    
    $json=[];
    if(mysqli_num_rows($c)>0){
        while ($r=mysqli_fetch_assoc($c)) {
            $json[]=['id'=>$r['iddoc'], 'text'=>html_entity_decode($r['Numero']."-".$r['Ano']."-".$r['Siglas']." (".$r['TipoDoc'].")")];
        }
    }else{
        $json[]=['id'=>0, 'text'=>'SIN RESULTADOS'];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_free_result($c);
    mysqli_close($cone);

?>