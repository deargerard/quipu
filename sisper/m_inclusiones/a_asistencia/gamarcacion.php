<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['marc']) && !empty($_POST['marc']) && isset($_POST['vig']) && !empty($_POST['vig']) && isset($_POST['per']) && !empty($_POST['per'])){
    $per=iseguro($cone,$_POST['per']);
    $marc=ftmysql(iseguro($cone,$_POST['marc']));
    $vig=iseguro($cone,$_POST['vig']);
    if(mysqli_query($cone, "INSERT INTO marcacion (idEmpleado, idVigilante, Marcacion) VALUES ($per, $vig, '$marc');")){
      $r['m']=mensajesu("Marcación agregada.");
      $r['e']=true;
    }else{
      $r['m']=mensajewa("Error al registrar la marcación, vuelva a intentarlo.");
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