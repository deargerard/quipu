<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT idEmpleado, NombreCom FROM enombre WHERE NombreCom LIKE '%$t%' ORDER BY NombreCom ASC;");
    $json=[];
    if(mysqli_num_rows($c)>0){
        while ($r=mysqli_fetch_assoc($c)) {
            $json[]=['id'=>$r['idEmpleado'], 'text'=>html_entity_decode($r['NombreCom'])];
        }
    }else{
        $json[]=['id'=>0, 'text'=>'SIN RESULTADOS'];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_free_result($c);
    mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
