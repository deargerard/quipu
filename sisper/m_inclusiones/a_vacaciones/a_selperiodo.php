<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
    $t=iseguro($cone,$_GET['q']);
    $c=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE PeriodoVacacional LIKE '%$t%' ORDER BY PeriodoVacacional DESC;");
    $json=[];
    while ($r=mysqli_fetch_assoc($c)) {
        $json[]=['id'=>$r['idPeriodoVacacional'], 'text'=>html_entity_decode($r['PeriodoVacacional'])];
    }
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($json);
    mysqli_free_result($c);
    mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
