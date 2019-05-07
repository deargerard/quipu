<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  $idu=$_SESSION['identi'];
  $r=array();
  if(isset($_POST['ida']) && !empty($_POST['ida']) && isset($_POST['usu']) && !empty($_POST['usu']) && isset($_POST['pro']) && !empty($_POST['pro']) && isset($_POST['des']) && !empty($_POST['des'])){
    $ida=iseguro($cone,$_POST['ida']);
    $usu=iseguro($cone,$_POST['usu']);
    $pro=iseguro($cone,$_POST['pro']);
    $des=imseguro($cone,$_POST['des']);
    $c="UPDATE maatencion SET idEmpleado=$usu, idProducto=$pro, Descripcion='$des' WHERE idAtencion=$ida";
    if(mysqli_query($cone,$c)){
      $r['exito']=true;
      $r['mensaje']=mensajesu("Atención actualizada.");
    }else{
      $r['exito']=false;
      $r['mensaje']=mensajeda("Error al actualizar, vuelva a intentarlo.");
    }
  }else{
    $r['exito']=false;
    $r['mensaje']=mensajeda("Todos los campos son obligatorios.");
  }

  header('Content-type: application/json; charset=utf-8');
  echo json_encode($r);
  exit();
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
