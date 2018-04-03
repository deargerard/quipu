<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['idm']) && !empty($_POST['idm'])){
    $idm=iseguro($cone,$_POST['idm']);
    if(mysqli_query($cone, "DELETE FROM marcacion WHERE idMarcacion=$idm;")){
      $r['m']=mensajesu("Marcación eliminada.");
      $r['e']=true;
    }else{
      $r['m']=mensajewa("Error al eliminar la marcación, vuelva a intentarlo.");
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