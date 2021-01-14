<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){
  if(isset($_POST['idl']) && !empty($_POST['idl']) && isset($_POST['docapr']) && !empty($_POST['docapr']) ){
    $idl=iseguro($cone,$_POST['idl']);
    $dap=iseguro($cone,$_POST['docapr']);
    $c=mysqli_query($cone,"SELECT FechaIni, FechaFin, TipoLic, MotivoLic, l.Estado FROM licencia l INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic WHERE idLicencia=$idl;");
    if($r=mysqli_fetch_assoc($c)){
      $e=$r['Estado']==0 ? 1 : 0;
      $m=$r['Estado']==0 ? "activó" : "canceló";
      if (mysqli_query($cone,"UPDATE licencia SET Estado=$e WHERE idLicencia=$idl;")) {
        mysqli_query($cone, "INSERT INTO aprlicencia (idLicencia, Aprobado, idDoc) VALUES ($idl, $e, $dap)");
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
