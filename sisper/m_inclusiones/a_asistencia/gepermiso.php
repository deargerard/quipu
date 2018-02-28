<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['pere']) && !empty($_POST['pere']) && isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['mote']) && !empty($_POST['mote']) && isset($_POST['fhinie']) && !empty($_POST['fhinie']) && isset($_POST['fhfine']) && !empty($_POST['fhfine']) && isset($_POST['apre']) && !empty($_POST['apre']) && isset($_POST['obse']) && !empty($_POST['obse'])){
    $pere=iseguro($cone,$_POST['pere']);
    $idp=iseguro($cone,$_POST['idp']);
    $mote=iseguro($cone,$_POST['mote']);
    $fhinie=ftmysql(iseguro($cone,$_POST['fhinie']));
    $fhfine=ftmysql(iseguro($cone,$_POST['fhfine']));
    $apre=iseguro($cone,$_POST['apre']);
    $obse=iseguro($cone,$_POST['obse']);
    $mes=date("Y-m", strtotime($fhinie));
    $seg=(strtotime($fhfine)-strtotime($fhinie));
    if($seg<86400){
      $cntp=mysqli_query($cone, "SELECT idPermiso FROM permiso WHERE idEmpleado=$pere AND DATE_FORMAT(FechaIni, '%Y-%m')='$mes' AND idTipPermiso=7 AND idPermiso!=$idp AND Estado=1;");
      $mt=false;
      if(mysqli_num_rows($cntp)>=3){
        $mt=true;
      }
      mysqli_free_result($cntp);
      if($mote==7 && $mt){
        $r['m']=mensajewa("Sólo se permite tres permisos por REGISTRO FUERA DEL HORARIO ESTABLECIDO al mes.");
        $r['e']=false;
      }else{
        if(mysqli_query($cone, "UPDATE permiso SET idTipPermiso=$mote, FechaIni='$fhinie', FechaFin='$fhfine', Aprobador=$apre, Observacion='$obse' WHERE idPermiso=$idp;")){
          $r['m']=mensajesu("Permiso editado.");
          $r['e']=true;
        }else{
          $r['m']=mensajewa("Error al editar permiso, vuelva a intentarlo.");
          $r['e']=false;
        }
      }

    }else{
      $r['m']=mensajewa("El permiso se otorga sólo por horas.");
      $r['e']=false;
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