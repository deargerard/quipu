<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  $yo=$_SESSION['identi'];

  if(isset($_POST['acc']) && !empty($_POST['acc'])){
    $acc=iseguro($cone, $_POST['acc']);

    if($acc=='agrvac'){
      if(isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['tvac']) && !empty($_POST['tvac']) && isset($_POST['lab']) && !empty($_POST['lab']) && isset($_POST['fvac']) && !empty($_POST['fvac'])){

        $idp=iseguro($cone,$_POST['idp']);
        $tvac=iseguro($cone,$_POST['tvac']);
        $lab=iseguro($cone,$_POST['lab']);
        $fvac=fmysql(iseguro($cone,$_POST['fvac']));
        $obs=vacio(iseguro($cone,$_POST['obs']));

        $cv=mysqli_query($cone, "SELECT idvacuna FROM vacuna WHERE tipo='$tvac';");
        if(mysqli_num_rows($cv)>0){
            $r['m']=mensajewa("Ya tiene registrada una vacuna del mismo tipo");
        }else{
            if(mysqli_query($cone, "INSERT INTO vacuna (idEmpleado, tipo, laboratorio, fecha, observaciones) VALUES ($idp, '$tvac', '$lab', '$fvac', $obs);")){
            $r['e']=true;
            $r['m']=mensajesu("Listo, vacuna registrada.");
            $r['d']=$idp;
            }else{
            $r['m']=mensajewa("Error, no se pudo registrar, vuelva a intentarlo.");
            }
        }
      }else{
        $r['m']=mensajewa("Los campos marcados con <b>*</b> son obligatorios.");
      }
    }elseif($acc=='edivac'){
      if(isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['ide']) && !empty($_POST['ide'])){

        $idp=iseguro($cone,$_POST['idp']);
        $ide=iseguro($cone, $_POST['ide']);
        $tvac=iseguro($cone,$_POST['tvac']);
        $lab=iseguro($cone,$_POST['lab']);
        $fvac=fmysql(iseguro($cone,$_POST['fvac']));
        $obs=vacio(iseguro($cone,$_POST['obs']));

        if(mysqli_query($cone, "UPDATE vacuna SET tipo='$tvac', laboratorio='$lab', fecha='$fvac', observaciones=$obs WHERE idvacuna=$idp;")){
          $r['e']=true;
          $r['m']=mensajesu("Listo, vacuna editada.");
          $r['d']=$ide;
        }else{
          $r['m']=mensajewa("Error, no se pudo editar, vuelva a intentarlo.");
        }

      }else{
        $r['m']=mensajewa("Los campos marcados con <b>*</b> son obligatorios.");
      }
    }elseif($acc='elivac'){
      if(isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['ide']) && !empty($_POST['ide'])){
        $idp=iseguro($cone, $_POST['idp']);
        $ide=iseguro($cone, $_POST['ide']);
        if(mysqli_query($cone, "DELETE FROM vacuna WHERE idvacuna=$idp")){
          $r['e']=true;
          $r['m']=mensajesu("¡Listo! Registro de vacuna eliminado");
          $r['d']=$ide;
        }else{
          $r['m']=mensajeda("¡Error! No se pudo eliminar, vuelva a intentarlo.");
        }
      }else{
        $r['m']=mensajeda("Faltan datos.");
      }
    }
  }else{
    $r['m']=mensajeda("No envio la acción");
  }
}else{
  $r['m']=mensajeda("Acceso restringido.");
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($r);
mysqli_close($cone);
?>
        