<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
$r=array();
$r['e']=false;
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){

  if(isset($_POST['acc']) && !empty($_POST['acc'])){
    $acc=iseguro($cone, $_POST['acc']);

    if($acc=='agrdis'){
      if(isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['tdis']) && !empty($_POST['tdis']) && isset($_POST['tayu']) && !empty($_POST['tayu']) && isset($_POST['tseg']) && !empty($_POST['tseg']) && isset($_POST['tlim']) && !empty($_POST['tlim']) && isset($_POST['glim']) && !empty($_POST['glim']) && isset($_POST['olim']) && !empty($_POST['olim']) && isset($_POST['cdis']) && !empty($_POST['cdis']) && isset($_POST['icon']) && !empty($_POST['icon'])){

        $idp=iseguro($cone,$_POST['idp']);
        $re=iseguro($cone,$_POST['re']);
        $tdis=iseguro($cone,$_POST['tdis']);
        $dmed=vacio(iseguro($cone,$_POST['dmed']));
        $tayu=iseguro($cone,$_POST['tayu']);
        $otr=vacio(iseguro($cone,$_POST['otr']));
        $tseg=iseguro($cone,$_POST['tseg']);
        $tlim=iseguro($cone,$_POST['tlim']);
        $glim=iseguro($cone,$_POST['glim']);
        $olim=iseguro($cone,$_POST['olim']);
        $cdis=iseguro($cone,$_POST['cdis']);
        $fcer=vacio(fmysql(iseguro($cone,$_POST['fcer'])));
        $icon=iseguro($cone,$_POST['icon']);
        $fins=vacio(fmysql(iseguro($cone,$_POST['fins'])));

        if($re=='e'){
          if(mysqli_query($cone, "UPDATE discapacidad SET idtipdiscapacidad=$tdis, diamedico=$dmed, idtipayubio=$tayu, otipayubio=$otr, idtipseg=$tseg, idtiplimper=$tlim, idgralim=$glim, idorilim=$olim, cerdis=$cdis, feccerdis=$fcer, conadis=$icon, fecconadis=$fins WHERE idEmpleado=$idp;")){
            $r['e']=true;
            $r['m']=mensajesu("¡Listo! Discapacidad editada.");
            $r['d']=$idp;
          }else{
            $r['m']=mensajeda("¡Error! No se pudo editar, vuelva a intentarlo.");
          }
        }elseif($re=='n'){
          if(mysqli_query($cone, "INSERT INTO discapacidad (idtipdiscapacidad, diamedico, idtipayubio, otipayubio, idtipseg, idtiplimper, idgralim, idorilim, cerdis, feccerdis, conadis, fecconadis, idEmpleado) VALUES ($tdis, $dmed, $tayu, $otr, $tseg, $tlim, $glim, $olim, $cdis, $fcer, $icon, $fins, $idp);")){
            $r['e']=true;
            $r['m']=mensajesu("¡Listo! Discapacidad registrada.");
            $r['d']=$idp;
          }else{
            $r['m']=mensajeda("¡Error! No se pudo registrar, vuelva a intentarlo.");
          }
        }


      }else{
        $r['m']=mensajeda("Los campos marcados con <b>*</b> son obligatorios.");
      }
    }elseif($acc='elidis'){
      if(isset($_POST['idp']) && !empty($_POST['idp'])){
        $idp=iseguro($cone, $_POST['idp']);
        if(mysqli_query($cone, "DELETE FROM discapacidad WHERE idEmpleado=$idp;")){
          $r['e']=true;
          $r['m']=mensajesu("¡Listo! Discapacidad eliminada.");
          $r['d']=$idp;
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
        