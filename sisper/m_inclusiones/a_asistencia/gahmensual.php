<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['hor']) && !empty($_POST['hor']) && isset($_POST['mes']) && !empty($_POST['mes']) && isset($_POST['ndias']) && !empty($_POST['ndias']) && isset($_POST['idp']) && !empty($_POST['idp'])){
    $hor=iseguro($cone,$_POST['hor']);
    $mes=iseguro($cone,$_POST['mes']);
    $ndias=iseguro($cone,$_POST['ndias']);
    $idp=iseguro($cone,$_POST['idp']);
    $fi=$mes."-01";
    $ff=$mes."-".$ndias;
    $m="";
    for ($i=$fi; $i <= $ff; $i=date("Y-m-d", strtotime("+1 day", strtotime($i)))) {
        $ch=mysqli_query($cone,"SELECT idEmpleadoHorario FROM empleadohorario WHERE Fecha='$i' AND idEmpleado=$idp;");
        if($rh=mysqli_fetch_assoc($ch)){
          $ideh=$rh['idEmpleadoHorario'];
          $q="UPDATE empleadohorario SET idHorario=$hor WHERE idEmpleadoHorario=$ideh;";
          if(mysqli_query($cone,$q)){
            $m.=fnormal($i)." - Horario actualizado.<br>";
          }else{
            $m.=fnormal($i)." - Error al actualizar.<br>";
          }
        }else{
          $q="INSERT INTO empleadohorario (idEmpleado, idHorario, Fecha, Estado) VALUES ($idp, $hor, '$i', 1)";
          if(mysqli_query($cone,$q)){
            $m.=fnormal($i)." - Horario registrado<br>";
          }else{
            $m.=fnormal($i)." - Error al registrar<br>";
          }
        }
    }
    $r['m']=mensajesu("Hecho<br>".$m);
    $r['e']=true;
  }else{
    $r['m']=mensajewa("Faltan Datos");
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