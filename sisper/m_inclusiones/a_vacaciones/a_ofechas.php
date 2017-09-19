<?php
$cin=mysqli_query($cone,"SELECT ec.idEmpleadoCargo, FechaVac, FechaAsu, Denominacion, ec.idEstadoCar FROM empleadocargo ec INNER JOIN cargo c ON ec.idCargo=c.idCargo WHERE ec.idEmpleadoCargo=$idec");
$cpv=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE idPeriodoVacacional=$pervac");
$rin=mysqli_fetch_assoc($cin);
//$idec=$rin['idEmpleadoCargo'];
$rpv=mysqli_fetch_assoc($cpv);
  $mesi = substr($rin['FechaVac'], -5, -3)==12 ? 1 : substr($rin['FechaVac'], -5, -3) + 1;
  $anoi= $mesi==1 ? substr($rpv['PeriodoVacacional'], -4)+1 : substr($rpv['PeriodoVacacional'], -4);
  $fii="01-".$mesi."-".$anoi;
  $f=date($fii);
  $f=strtotime('+10 month',strtotime($f));
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
//echo "Hoy ".$hoy." Fecha de resta ". $ab." F-Asume: ".$l." estado: ".$st;
//Fin Obtener  idEmpleadoCargo, fechas para cálculo de vacaciones
//echo "F-Asume: ".$rin['FechaAsu']." F-para vacaciones: ".$rin['FechaVac']." F-inicial de inicio vacaciones: ".$fii ." F-final de inicio vacaciones:  ".$ffi."   F-final de fin vacaciones:   ".$fff .  "  Hoy  ".$hoy."  dias  ".$l."  año trabajado  ".$anot."  año alta  ".$alta."  intervalo  ". intervalo($fff,$hoy);
//echo $anot."<br>";
//echo $can;
?>
