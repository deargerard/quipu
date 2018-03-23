<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['obs']) && !empty($_POST['obs']) && isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['mes']) && !empty($_POST['mes'])){
    $obs=iseguro($cone,$_POST['obs']);
    $idp=iseguro($cone,$_POST['idp']);
    $mes=iseguro($cone,$_POST['mes']);
    $cob=mysqli_query($cone, "SELECT idAMObservacion FROM amobservacion WHERE Mes='$mes' AND idEmpleado=$idp;");
    if($rob=mysqli_fetch_assoc($cob)){
      $ido=$rob['idAMObservacion'];
      if(mysqli_query($cone,"UPDATE amobservacion SET Observacion='$obs' WHERE idAMObservacion=$ido;")){
        $r['m']="<small class='text-success'>Observación actualizada</small>";
        $r['e']=true;
      }else{
        $r['m']="<small class='text-danger'>Error al actualizar</small>";
        $r['e']=false;
      }
    }else{
      if(mysqli_query($cone, "INSERT INTO amobservacion (Observacion, Mes, idEmpleado) VALUES ('$obs', '$mes', $idp);")){
        $r['m']="<small class='text-success'>Observación guardada</small>";
        $r['e']=true;
      }else{
        $r['m']="<small class='text-danger'>Error al guardar</small>";
        $r['e']=false;
      }
    }
    mysqli_free_result($cob);
  }else{
    $r['m']="<small class='text-danger'>Faltan Datos</small>";
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