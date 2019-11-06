<?php
//Inicio de cálculo de fechas de restricción de vacaciones.
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
  $fii1=date($fii);
  $das=(caldiant($cone, $rin['idEmpleadoCargo'])%365)+1;
  $das1=$das-1;
  $fii=strtotime('+'.$das.' day',strtotime($fii1));
  $nf=strtotime('+'.$das1.' day',strtotime($fii1));
  $fii= date('j-m-Y',$fii); //Fecha Mínima de inicio de vacaciones.
  $f=date($fii);
  $f1=strtotime('+12 month',strtotime($f));
  $ffi=date('j-m-Y',$f1); //Fecha máxima de inicio de vacaciones.
  $fff= $ffi; //Fecha máxima de fin de vacaciones.
  $hoy = date("j-m-Y");
  $fii = strtotime($fii)<=strtotime($hoy) ? date("d-m-Y",strtotime('+15 day',strtotime($hoy))) : $fii; // Valida que la fecha inicial sea 15 días mayor que la fecha actual.
//fin de cálculo de fechas de restricción de vacaciones.

  $anot= substr($rpv['PeriodoVacacional'], -11,-6);
  $anov= substr($rpv['PeriodoVacacional'], -4);
  $alta= substr($rin['FechaVac'], -10, -6);
  $asume= substr($rin['FechaVac'], -10, -6);
  $d= substr($rin['FechaVac'],-2);
  $m= substr($rin['FechaVac'],-5, -3);
  $aa=$d."-".$m."-".$anot;
  $av=$d."-".$m."-".$anov;
  $av=date($av);
  $ab=date($aa);
  $ls=intervalo($hoy,$ab);
  if ($ls<365) { //Calcula el valor del estado
    $st=4;
  }else {
    $st=0;
  } //fin
  $l=intervalo($hoy, $rin['FechaVac']);
  $mpp=date('m');
  //$ffi=$das;
?>
