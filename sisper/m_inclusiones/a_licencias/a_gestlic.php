<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){
  if(isset($_POST['idl']) && !empty($_POST['idl'])){
    $idl=iseguro($cone,$_POST['idl']);
    $c=mysqli_query($cone,"SELECT FechaIni, FechaFin, TipoLic, MotivoLic, l.Estado FROM licencia l INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic WHERE idLicencia=$idl;");
    if($r=mysqli_fetch_assoc($c)){
      $e=$r['Estado']==0 ? 1 : 0;
      $m=$r['Estado']==0 ? "activo" : "cancelo";
      if (mysqli_query($cone,"UPDATE licencia SET Estado=$e WHERE idLicencia=$idl;")) {
        echo mensajesu("Listo: Se $m la Licencia.");
      }else{
        echo mensajewa("Error: No se pudo $m la licencia.");
      }
    }else{
      echo mensajewa("Error: No se enviaron datos válidos.");
    }
  }else{
    echo mensajewa("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>
