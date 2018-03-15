<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['des']) && !empty($_POST['des'])){
    $des=iseguro($cone,$_POST['des']);
    $rmar=iseguro($cone,$_POST['rmar']);
    $gu=false;
    if($rmar==""){
      $gu=true;
      $pq="(Descripcion, ReqMarcacion, Estado) VALUES ('$des', 0, 1)";
    }else{
      if(isset($_POST['hing']) && !empty($_POST['hing']) && isset($_POST['hsal']) && !empty($_POST['hsal'])){
        $hing=iseguro($cone,$_POST['hing']);
        $hsal=iseguro($cone,$_POST['hsal']);
        $hingr=empty(iseguro($cone,$_POST['hingr'])) ? "NULL" : "'".iseguro($cone,$_POST['hingr'])."'";
        $hsalr=empty(iseguro($cone,$_POST['hsalr'])) ? "NULL" : "'".iseguro($cone,$_POST['hsalr'])."'";
        $ssigd=iseguro($cone,$_POST['ssigd'])==1 ? 1 : 0;
        $esab=iseguro($cone,$_POST['esab'])==1 ? 1 : 0;
        $edom=iseguro($cone,$_POST['edom'])==1 ? 1 : 0;
        $rdlib=iseguro($cone,$_POST['rdlib'])==1 ? 1 : 0;
        $gu=true;
        $pq="(Descripcion, ReqMarcacion, Ingreso, SalidaRef, IngresoRef, Salida, SalSigDia, Estado, ExcSabado, ExcDomingo, RDLibre) VALUES ('$des', 1, '$hing', $hsalr, $hingr, '$hsal', $ssigd, 1, $esab, $edom, $rdlib)";
      }else{
        $r['m']=mensajewa("Cuando se requiere marcar, son campos obligatorios la <b>H. Ingreso</b> y la <b>H. Salida</b>.");
        $r['e']=false;
      }
    }
    if($gu){
      $q="INSERT INTO horario $pq;";
      if(mysqli_query($cone,$q)){
        $r['m']=mensajesu("Hecho, se guardo el horario.");
        $r['e']=true;
      }else{
        $r['m']=mensajewa("Error al guardar el horario, vuelva a intentarlo.");
        $r['e']=false;
      }
    }
  }else{
    $r['m']=mensajewa("El campo horario es obligatorio.");
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