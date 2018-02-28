<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['mot']) && !empty($_POST['mot']) && isset($_POST['fhini']) && !empty($_POST['fhini']) && isset($_POST['fhfin']) && !empty($_POST['fhfin']) && isset($_POST['apr']) && !empty($_POST['apr']) && isset($_POST['obs']) && !empty($_POST['obs'])){
    $per=iseguro($cone,$_POST['per']);
    $mot=iseguro($cone,$_POST['mot']);
    $fhini=ftmysql(iseguro($cone,$_POST['fhini']));
    $fhfin=ftmysql(iseguro($cone,$_POST['fhfin']));
    $apr=iseguro($cone,$_POST['apr']);
    $obs=iseguro($cone,$_POST['obs']);
    $mes=date("Y-m", strtotime($fhini));
    $seg=(strtotime($fhfin)-strtotime($fhini));
    if($seg<86400){
      $cntp=mysqli_query($cone, "SELECT idPermiso FROM permiso WHERE idEmpleado=$per AND DATE_FORMAT(FechaIni, '%Y-%m')='$mes' AND idTipPermiso=7 AND Estado=1;");
      $mt=false;
      if(mysqli_num_rows($cntp)>=3){
        $mt=true;
      }
      mysqli_free_result($cntp);
      if($mot==7 && $mt){
        $r['m']=mensajewa("Sólo se permite tres permisos por REGISTRO FUERA DEL HORARIO ESTABLECIDO al mes.");
        $r['e']=false;
      }else{
        if(mysqli_query($cone, "INSERT INTO permiso (idEmpleado, idTipPermiso, FechaIni, FechaFin, Aprobador, Observacion, Estado) VALUES ($per, $mot, '$fhini', '$fhfin', $apr, '$obs', 1);")){
          $r['m']=mensajesu("Permiso agregado.");
          $r['e']=true;
        }else{
          $r['m']=mensajewa("Error al registrar el permiso, vuelva a intentarlo.");
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