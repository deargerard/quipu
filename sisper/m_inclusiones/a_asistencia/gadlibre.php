<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$idu=$_SESSION['identi'];
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['desdl']) && !empty($_POST['desdl']) && isset($_POST['fecdl']) && !empty($_POST['fecdl'])){
    $desdl=iseguro($cone,$_POST['desdl']);
    $fecdl=fmysql(iseguro($cone,$_POST['fecdl']));
    $cdl=mysqli_query($cone,"SELECT idDiaLibre FROM dialibre WHERE Fecha='$fecdl';");
    if($rdl=mysqli_fetch_assoc($cdl)){
      $r['m']=mensajewa("Ya existe un día libre con la misma fecha.");
      $r['e']=false;
    }else{
      if(mysqli_query($cone,"INSERT INTO dialibre (Descripcion, Fecha, Por, Estado) VALUES ('$desdl', '$fecdl', $idu, 1);")){
        $r['m']=mensajesu("Día libre registrado.");
        $r['e']=true;
      }else{
        $r['m']=mensajewa("No se pudo registrar el día libre. Vuelva a intentarlo.");
        $r['e']=false;
      }
    }
  }else{
    $r['m']=mensajewa("Todos los campos son obligatorios.");
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