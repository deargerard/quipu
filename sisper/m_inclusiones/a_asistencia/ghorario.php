<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['tur']) && !empty($_POST['tur']) && isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['emp']) && !empty($_POST['emp'])){
    $tur=iseguro($cone,$_POST['tur']);
    $fec=iseguro($cone,$_POST['fec']);
    $emp=iseguro($cone,$_POST['emp']);
    $ch=mysqli_query($cone,"SELECT idEmpleadoHorario FROM empleadohorario WHERE Fecha='$fec' AND idEmpleado=$emp;");
    if($rh=mysqli_fetch_assoc($ch)){
      $ideh=$rh['idEmpleadoHorario'];
      $q="UPDATE empleadohorario SET idHorario=$tur WHERE idEmpleadoHorario=$ideh;";
      if(mysqli_query($cone,$q)){
        $r['m']="Horario cambiado!. (Si ya no realizará mas cambios, favor actualice.)";
        $r['e']=true;
      }else{
        $r['m']="Error al cambiar el horario, vuelva a intentarlo";
        $r['e']=false;
      }
    }else{
      $q="INSERT INTO empleadohorario (idEmpleado, idHorario, Fecha, Estado) VALUES ($emp, $tur, '$fec', 1)";
      if(mysqli_query($cone,$q)){
        $r['m']="Horario cambiado!. (Si ya no realizará mas cambios, favor actualice.)";
        $r['e']=true;
      }else{
        $r['m']="Error al cambiar el horario, vuelva a intentarlo";
        $r['e']=false;
      }
    }

  }else{
    $r['m']="Faltan Datos";
    $r['e']=false;
  }
  header('Content-type: application/json; charset=utf-8');
  echo json_encode($r);
  exit();
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
                  ?>