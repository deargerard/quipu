<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],14)){
  if (isset($_POST["doc"]) && !empty($_POST["doc"])) {
    $doc=iseguro($cone, $_POST["doc"]);
    $cva=mysqli_query($cone, "SELECT pv.idProVacaciones, pv.idEmpleadoCargo, pev.PeriodoVacacional FROM provacaciones pv INNER JOIN periodovacacional pev ON pv.idPeriodoVacacional=pev.idPeriodoVacacional WHERE pv.Estado=7;");
    if (mysqli_num_rows($cva)>0) {
      $m=true;
      while ($rva=mysqli_fetch_assoc($cva)) {
        $idv=$rva["idProVacaciones"];
        $idec=$rva["idEmpleadoCargo"];
        $ano = substr($rva['PeriodoVacacional'], -4);
        $in= mysqli_query($cone, "INSERT INTO aprvacaciones (idProVacaciones, Aprobado, idDoc) VALUES ($idv, 1, $doc);");
        if ($in) {
          $cfv=mysqli_query($cone, "SELECT FechaVac FROM empleadocargo WHERE idEmpleadoCargo=$idec;");
          if ($rfv=mysqli_fetch_assoc($cfv)) {
              $fv=explode("-", $rfv["FechaVac"]);
              $fec=$ano."-".$fv[1]."-".$fv[2];
              if ($fec>date("Y-m-d")) {
                mysqli_query($cone, "UPDATE provacaciones SET Estado=4 WHERE idProVacaciones=$idv;");
              }else {
                mysqli_query($cone, "UPDATE provacaciones SET Estado=1 WHERE idProVacaciones=$idv;");
              }
          }
        }else {
          echo mensajewa("No se aprobó las vacaciones con Id $idv.");
          $m=false;
        }
      }
      if ($m) {
        echo mensajesu("¡Vacaciones Aprobadas!");
      }else {
        echo mensajewa("Solo algunas vacaciones se aprobaron");
      }

    }else {
      echo mensajewa("No existen vacaciones aceptadas");
    }
  }else {
    echo mensajewa("No se envío datos");
  }

    mysqli_close($cone);

}else{
  echo accrestringidoa();
}
?>
