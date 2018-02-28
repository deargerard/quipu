<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['idp']) && !empty($_POST['idp'])){
    $idp=iseguro($cone,$_POST['idp']);
    $cp=mysqli_query($cone, "SELECT idTipPermiso, idEmpleado, FechaIni, Estado FROM permiso WHERE idPermiso=$idp;");
    if($rp=mysqli_fetch_assoc($cp)){
      $pere=$rp['idEmpleado'];
      $mes=date("Y-m",strtotime($rp['FechaIni']));
      $cam=false;
      if($rp['Estado']==1){
        $cam=true;
      }else{
        if($rp['idTipPermiso']==7){
          $cntp=mysqli_query($cone, "SELECT idPermiso FROM permiso WHERE idEmpleado=$pere AND DATE_FORMAT(FechaIni, '%Y-%m')='$mes' AND idTipPermiso=7 AND idPermiso!=$idp AND Estado=1;");
          if(mysqli_num_rows($cntp)>=3){
            $r['m']=mensajewa("No se permite que existan más de tres permisos activos por REGISTRO FUERA DEL HORARIO ESTABLECIDO al mes");
            $cam=false;
          }else{
            $cam=true;
          }
          mysqli_free_result($cntp);
        }else{
          $cam=true;
        }
      }
      
      $est=$rp['Estado']==1 ? 0 : 1;

      if($cam){
        if(mysqli_query($cone, "UPDATE permiso SET Estado=$est WHERE idPermiso=$idp;")){
          $r['m']=mensajesu("Se cambio el estado del permiso.");
          $r['e']=true;
        }else{
          $r['m']=mensajewa("Error al cambiar el estado del permiso, vuelva a intentarlo.");
          $r['e']=false;
        }
      }else{
        $r['e']=false;
      }   

    }else{
      $r['m']=mensajewa("Los datos enviados no son válidos.");
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