<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  $idu=$_SESSION['identi'];
  $r=array();
  if(isset($_POST['ida']) && !empty($_POST['ida']) && isset($_POST['solu']) && !empty($_POST['solu'])){
    $ida=iseguro($cone,$_POST['ida']);
    $solu=iseguro($cone,$_POST['solu']);
    $hoy=date('Y-m-d H:i');

    $c="UPDATE maatencion SET Solucion='$solu', Medio=5, Estado=3, FecSolucion='$hoy' WHERE idAtencion=$ida";
    if(mysqli_query($cone,$c)){
      $r['exito']=true;
      $r['mensaje']=mensajesu("Atención cancelada.");
    }else{
      $r['exito']=false;
      $r['mensaje']=mensajeda("Error al cancelar, vuelva a intentarlo.");
    }

  }else{
    $r['exito']=false;
    $r['mensaje']=mensajeda("Todos los campos son obligatorios.");
  }

  header('Content-type: application/json; charset=utf-8');
  echo json_encode($r);
  exit();
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
