<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  $r=array();
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $c=mysqli_query($cone,"SELECT Estado FROM vigilante WHERE idVigilante=$id;");
    if($r=mysqli_fetch_assoc($c)){
        $e=$r["Estado"]==1 ? 0 : 1;
        $es=$r["Estado"]==1 ? "desactivó" : "activó";
        $q="UPDATE vigilante SET Estado=$e WHERE idVigilante=$id";
        if(mysqli_query($cone,$q)){
          $r["mensaje"]=mensajesu("Listo: Se <b>$es</b> al vigilante.");
          $r["exito"]=true;
        }else{
          $r["mensaje"]=mensajeda("Error: No se $es al vigilante, vuelva a intentarlo.");
          $r["exito"]=false;
        }
    }else{
      $r["mensaje"]=mensajeda("Error: Datos inválidos.");
      $r["exito"]=false;
    }
  }else{
    $r["mensaje"]=mensajeda("Error: No se enviaron datos.");
    $r["exito"]=false;
  }
  header('Content-type: application/json; charset=utf-8');
  echo json_encode($r);
  exit();
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>