<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  $idu=$_SESSION['identi'];
  $r=array();
  if(isset($_POST['est']) && !empty($_POST['est'])){
    $est=iseguro($cone,$_POST['est']);
    if ($est==3) {
      if (isset($_POST['usu']) && !empty($_POST['usu']) && isset($_POST['sol']) && !empty($_POST['sol']) && isset($_POST['pro']) && !empty($_POST['pro']) && isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['solu']) && !empty($_POST['solu'])) {
        $usu=iseguro($cone,$_POST['usu']);
        $sol=iseguro($cone,$_POST['sol']);
        $pro=iseguro($cone,$_POST['pro']);
        $des=iseguro($cone,$_POST['des']);
        $fec=ftmysql(iseguro($cone,$_POST['fec']));
        $solu=iseguro($cone,$_POST['solu']);
        $med=5;
        $fsol=date('Y-m-d H:i');
        $c="INSERT INTO maatencion (Fecha, idEmpleado, idSolucionador, idProducto, Descripcion, Estado, Registrador, Medio, Solucion, FecSolucion) VALUES ('$fec', $usu, $sol, $pro, '$des', $est, $idu, $med, '$solu', '$fsol');";
        if(mysqli_query($cone,$c)){
          $r['exito']=true;
          $r['mensaje']=mensajesu("Atencion registrada como cancelada.");
        }else{
          $r['exito']=false;
          $r['mensaje']=mensajeda("Error al registrar, intentalo nuevamente.");
        }

      }else{
        $r['exito']=false;
        $r['mensaje']=mensajeda("Todos los campos son obligatorios.");
      }
    }elseif ($est==1) {
      if (isset($_POST['usu']) && !empty($_POST['usu']) && isset($_POST['sol']) && !empty($_POST['sol']) && isset($_POST['pro']) && !empty($_POST['pro']) && isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['fec']) && !empty($_POST['fec']) && isset($_POST['solu']) && !empty($_POST['solu']) && isset($_POST['med']) && !empty($_POST['med'])) {
        $usu=iseguro($cone,$_POST['usu']);
        $sol=iseguro($cone,$_POST['sol']);
        $pro=iseguro($cone,$_POST['pro']);
        $des=iseguro($cone,$_POST['des']);
        $fec=ftmysql(iseguro($cone,$_POST['fec']));
        $solu=iseguro($cone,$_POST['solu']);
        $med=iseguro($cone,$_POST['med']);
        $fsol=date('Y-m-d H:i');
        $c="INSERT INTO maatencion (Fecha, idEmpleado, idSolucionador, idProducto, Descripcion, Estado, Registrador, Medio, Solucion, FecSolucion) VALUES ('$fec', $usu, $sol, $pro, '$des', $est, $idu, $med, '$solu', '$fsol');";
        if(mysqli_query($cone,$c)){
          $r['exito']=true;
          $r['mensaje']=mensajesu("Atencion registrada como resuelta.");
        }else{
          $r['exito']=false;
          $r['mensaje']=mensajeda("Error al registrar, intentalo nuevamente.");
        }

      }else{
        $r['exito']=false;
        $r['mensaje']=mensajeda("Todos los campos son obligatorios.");
      }
    }elseif ($est==2) {
      if (isset($_POST['usu']) && !empty($_POST['usu']) && isset($_POST['sol']) && !empty($_POST['sol']) && isset($_POST['pro']) && !empty($_POST['pro']) && isset($_POST['des']) && !empty($_POST['des']) && isset($_POST['fec']) && !empty($_POST['fec'])) {
        $usu=iseguro($cone,$_POST['usu']);
        $sol=iseguro($cone,$_POST['sol']);
        $pro=iseguro($cone,$_POST['pro']);
        $des=iseguro($cone,$_POST['des']);
        $fec=ftmysql(iseguro($cone,$_POST['fec']));
        $c="INSERT INTO maatencion (Fecha, idEmpleado, idSolucionador, idProducto, Descripcion, Estado, Registrador) VALUES ('$fec', $usu, $sol, $pro, '$des', $est, $idu);";
        if(mysqli_query($cone,$c)){
          $r['exito']=true;
          $r['mensaje']=mensajesu("Atencion registrada como pendiente.");
        }else{
          $r['exito']=false;
          $r['mensaje']=mensajeda("Error al registrar, intentalo nuevamente.");
        }
      }else{
        $r['exito']=false;
        $r['mensaje']=mensajeda("Todos los campos son obligatorios.");
      }
    }else{
      $r['exito']=false;
      $r['mensaje']=mensajeda("No enviaste un estado válido.");
    }

  }else{
    $r['exito']=false;
    $r['mensaje']=mensajeda("Elija un estado.");
  }

  header('Content-type: application/json; charset=utf-8');
  echo json_encode($r);
  exit();
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
