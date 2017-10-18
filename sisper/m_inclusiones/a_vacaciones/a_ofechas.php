<?php
$fii="";
$ffi="";
$fff="";
$cin=mysqli_query($cone,"SELECT ec.idEmpleadoCargo, FechaVac, FechaAsu, Denominacion, ec.idEstadoCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo WHERE ec.idEmpleadoCargo=$idec");
$cpv=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE idPeriodoVacacional=$pervac");
$rin=mysqli_fetch_assoc($cin);
$rpv=mysqli_fetch_assoc($cpv);
  $diai = substr($rin['FechaVac'], -2);
  $mesi = substr($rin['FechaVac'], -5, -3);
  $anoi = substr($rpv['PeriodoVacacional'], -4);
  $fii= $diai."-".$mesi."-".$anoi;
  $fii=date($fii);
  $fii=strtotime('+1 day',strtotime($fii));
  $fii= date('j-m-Y',$fii);
  $f=date($fii);
  $f=strtotime('+11 month',strtotime($f));
  $ffi=date('j-m-Y',$f);
  $fff= strtotime('+29 day',strtotime($ffi));
  $fff= date('j-m-Y',$fff);
  $hoy = date("j-m-Y");
  $fii = strtotime($fii)<=strtotime($hoy) ? date("d-m-Y",strtotime('+15 day',strtotime($hoy))) : $fii; // Valida que la fecha inicial sea 15 días mayor que la fecha actual.
  $anot= substr($rpv['PeriodoVacacional'], -11,-6);
  $alta= substr($rin['FechaVac'], -10, -6);
  $asume= substr($rin['FechaAsu'], -10, -6);
  $d= substr($rin['FechaVac'],-2);
  $m= substr($rin['FechaVac'],-5, -3);
  $aa=$d."-".$m."-".$anot;
  $ab=date($aa);
  $ls=intervalo($hoy,$ab);
  if ($ls<365) { //Calcula el valor del estado
    $st=4;
  }else {
    $st=0;
  } //fin
  $l=intervalo($hoy, $rin['FechaVac']);
?>
