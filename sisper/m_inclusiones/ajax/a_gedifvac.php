<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
$r=array();
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["fvac"]) && !empty($_POST["fvac"]) && isset($_POST["idec"]) && !empty($_POST["idec"])){
    $idec=iseguro($cone,$_POST["idec"]);
    $fvac=fmysql(iseguro($cone,$_POST["fvac"]));

    if(mysqli_query($cone,"UPDATE empleadocargo SET FechaVac='$fvac' WHERE idEmpleadoCargo=$idec;")){
      $r['e']=true;
      $r['m']=mensajesu("Fecha de vacaciones editada correctamente");
    }else{
      $r['e']=false;
      $r['m']=mensajewa("Error al editar, vuelva a intentarlo");
    }
    mysqli_close($cone);
  }else{
    $r['e']=false;
    $r['m']=mensajewa("Error: No se envio datos");
  }
}else{
  $r['e']=false;
  $r['m']=mensajewa("Acceso restringido");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
?>