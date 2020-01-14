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

    if($acc=='agrges'){
      if(isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['fur']) && !empty($_POST['fur']) && isset($_POST['fpp']) && !empty($_POST['fpp'])){

        $idp=iseguro($cone,$_POST['idp']);
        $ges=vacio(iseguro($cone,$_POST['ges']));
        $fur=fmysql(iseguro($cone,$_POST['fur']));
        $fpp=fmysql(iseguro($cone,$_POST['fpp']));
        $esa=vacio(iseguro($cone,$_POST['esa']));
        $obs=vacio(iseguro($cone,$_POST['obs']));

        if(mysqli_query($cone, "INSERT INTO gestante (idEmpleado, idPariente, fur, fpp, estsalud, observaciones, b_ac, b_fe, b_po) VALUES ($idp, $ges, '$fur', '$fpp', $esa, $obs, 'ins', NOW(), $yo);")){
          $r['e']=true;
          $r['m']=mensajesu("Listo, gestante registrada.");
          $r['d']=$idp;
        }else{
          $r['m']=mensajewa("Error, no se pudo registrar, vuelva a intentarlo.");
        }

      }else{
        $r['m']=mensajewa("Los campos marcados con <b>*</b> son obligatorios.");
      }
    }elseif($acc=='ediges'){
      if(isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['fur']) && !empty($_POST['fur']) && isset($_POST['fpp']) && !empty($_POST['fpp'])){

        $idp=iseguro($cone,$_POST['idp']);
        $ges=vacio(iseguro($cone,$_POST['ges']));
        $fur=fmysql(iseguro($cone,$_POST['fur']));
        $fpp=fmysql(iseguro($cone,$_POST['fpp']));
        $esa=vacio(iseguro($cone,$_POST['esa']));
        $obs=vacio(iseguro($cone,$_POST['obs']));
        $ide=iseguro($cone,$_POST['ide']);

        if(mysqli_query($cone, "UPDATE gestante SET idPariente=$ges, fur='$fur', fpp='$fpp', estsalud=$esa, observaciones=$obs, b_ac='edi', b_fe=NOW(), b_po=$yo WHERE idgestante=$idp;")){
          $r['e']=true;
          $r['m']=mensajesu("Listo, gestante editada.");
          $r['d']=$ide;
        }else{
          $r['m']=mensajewa("Error, no se pudo registrar, vuelva a intentarlo.");
        }

      }else{
        $r['m']=mensajewa("Los campos marcados con <b>*</b> son obligatorios.");
      }
    }elseif($acc='eliges'){
      if(isset($_POST['idp']) && !empty($_POST['idp'])){
        $idp=iseguro($cone, $_POST['idp']);
        $ide=iseguro($cone, $_POST['ide']);
        if(mysqli_query($cone, "UPDATE gestante SET b_ac='eli', b_fe=NOW(), b_po=$yo WHERE idgestante=$idp;")){
          $r['e']=true;
          $r['m']=mensajesu("¡Listo! Registro de gestante eliminado");
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
        