<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  $idu=$_SESSION['identi'];
  $r=array();
  if(isset($_POST['ida']) && !empty($_POST['ida']) && isset($_POST['sol']) && !empty($_POST['sol'])){
    $ida=iseguro($cone,$_POST['ida']);
    $sol=iseguro($cone,$_POST['sol']);
    $ca=mysqli_query($cone,"SELECT ms.idEmpleado FROM maatencion ma INNER JOIN masolucionador ms ON ma.idSolucionador=ms.idSolucionador WHERE ma.idAtencion=$ida;");
    if($ra=mysqli_fetch_assoc($ca)){

      if($ra['idEmpleado']==$sol){
        $r['exito']=false;
        $r['mensaje']=mensajewa("No puedes reasignarte tu atención.");
      }else{
        $c="UPDATE maatencion SET idSolucionador=$sol, Registrador=$idu WHERE idAtencion=$ida";
        if(mysqli_query($cone,$c)){
          $r['exito']=true;
          $r['mensaje']=mensajesu("Atención reasignada.");
        }else{
          $r['exito']=false;
          $r['mensaje']=mensajeda("Error al reasignar, vuelva a intentarlo.");
        }
      }
    }else{
      $r['exito']=false;
      $r['mensaje']=mensajeda("Los datos recibidos no son válidos.");
    }
    mysqli_free_result($ca);
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
