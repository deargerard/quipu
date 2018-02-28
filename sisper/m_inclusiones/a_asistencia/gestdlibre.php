<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['iddl']) && !empty($_POST['iddl'])){
    $iddl=iseguro($cone,$_POST['iddl']);
    $ch=mysqli_query($cone,"SELECT Estado FROM dialibre WHERE idDiaLibre=$iddl;");
    if($rh=mysqli_fetch_assoc($ch)){
      $est=$rh['Estado']==1 ? 0 : 1;
      if(mysqli_query($cone,"UPDATE dialibre SET Estado=$est WHERE idDiaLibre=$iddl;")){
        $r['m']=mensajesu("Se cambio el estado del día libre.");
        $r['e']=true;
      }else{
        $r['m']=mensajewa("No se pudo cambiar el estado. Intentelo nuevamente.");
        $r['e']=false;
      }
    }else{
      $r['m']=mensajewa("Los datos no son válidos.");
      $r['e']=false;
    }
  }else{
    $r['m']=mensajewa("No envió datos.");
    $r['e']=false;
  }
  header('Content-type: application/json; charset=utf-8');
  echo json_encode($r);
  exit();
}else{
  echo accrestringidoa();
}
  mysqli_close($cone);
?>