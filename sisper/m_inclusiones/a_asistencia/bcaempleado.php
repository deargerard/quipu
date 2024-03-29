<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],2)){
  if(isset($_POST['mesanoc']) && !empty($_POST['mesanoc']) && isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['car']) && !empty($_POST['car'])){
    $emp=iseguro($cone,$_POST['per']);
    $car=iseguro($cone,$_POST['car']);
    $mesanoj=iseguro($cone,$_POST['mesanoc']);
    $mesano=explode("/", $mesanoj);
    //validamos que el mes seleccionado, sea una fecha correcta
    if(strlen($mesano[0])==2 && strlen($mesano[1])==4){
      //calculamos el numero de días del mes seleccionado
      $ndias=cal_days_in_month(CAL_GREGORIAN, $mesano[0], $mesano[1]);
      //calculamos primer inicio y final del mes y la fecha mes
      $fm=$mesano[1]."-".$mesano[0];
      $fi=$mesano[1]."-".$mesano[0]."-01";
      $ff=$mesano[1]."-".$mesano[0]."-".$ndias;
      //Consultamos si le corresponde marcación
      $q1="SELECT idEstadoCar, FechaIni FROM estadocargo WHERE idEmpleadoCargo=$car AND DATE_FORMAT(FechaIni,'%Y-%m')='$fm' ORDER BY FechaIni DESC LIMIT 1;";
      $q2="SELECT idEstadoCar FROM estadocargo WHERE idEmpleadoCargo=$car AND DATE_FORMAT(FechaIni,'%Y-%m')<'$fm' ORDER BY FechaIni DESC LIMIT 1;";
      $ccm1=mysqli_query($cone,$q1);
      $ccm2=mysqli_query($cone,$q2);
      $cm=false;
      if($rcm1=mysqli_fetch_assoc($ccm1)){
        $cm=true;
        //Como el mes comprende a un inicio o final del cargo calculamos la fecha de inicio o final que se usara para su marcación
        if($rcm1['idEstadoCar']==1){
          $fi=$rcm1['FechaIni'];
        }else{
          $ff=$rcm1['FechaIni'];
        }
      }elseif($rcm2=mysqli_fetch_assoc($ccm2)){
        if($rcm2['idEstadoCar']==1){
          $cm=true;
        }
      }
      mysqli_free_result($ccm1);
      mysqli_free_result($ccm2);


?>
<br>
<div class="row">
  <div class="col-md-5">
    <h4><i class='fa fa-user text-gray'></i> <span class="text-orange"><?php echo nomempleado($cone,$emp); ?></span></h4>
  </div>
  <div class="col-md-3">
    <h4><i class='fa fa-calendar text-gray'></i> <span class="text-orange"><?php echo strtoupper(nombremes($mesano[0])).' - '.$mesano[1]; ?></span></h4>
  </div>
  <div class="col-md-4 text-right">
    <?php if(accesoadm($cone,$_SESSION['identi'],2) && $cm){ ?>
    <a href="#" class="btn btn-sm bg-aqua" onclick="hormen(<?php echo "'".$fm."', ".$ndias.", ".$emp; ?>);" data-toggle="modal" data-target="#m_hmensual"><i class="fa fa-calendar-check-o"></i> Horario mensual</a>
    <?php } ?>
    <a href="m_exportar/e_casistencia.php?mesanoc=<?php echo $mesanoj; ?>&per=<?php echo $emp; ?>&car=<?php echo $car; ?>" class="btn btn-sm bg-teal" target="_blank"><i class="fa fa-file-pdf-o"></i> Exportar</a>
    <a href="#" class="btn btn-sm bg-orange" onclick="acasistencia(<?php echo "'".$mesanoj."', ".$emp.", ".$car; ?>);"><i class="fa fa-refresh"></i> Actualizar</a>
  </div>
</div>
<?php
      if(!$cm){
        echo mensajewa("No le corresponde asistencia.");
      }else{
        //validamos si se selecciono el mes actual de modo que la fecha final sera en día actual.
        //if(date('Y-m')==$fm){
          //$ff=date('Y-m-d');
        //}
?>
        <input type="hidden" name="mesanoa" id="mesanoa" value="<?php echo $mesanoj; ?>">
        <table class="table table-bordered table-hover" id="catable">
          <thead>
            <tr>
              <th>Día</th>
              <th>Ingreso</th>
              <th>Sal. Ref.</th>
              <th>Ing. Ref.</th>
              <th>Salida</th>
              <th>Justificación/Motivo</th>
              <th>Min. Tarde</th>
              <th>Incidente</th>
              <th>Horario</th>
            </tr>
          </thead>
          <tbody>
<?php

      $nf=0;
      $lsg=0;
      $nhe=0;
      $nht=0;
      for ($i=$fi; $i <= $ff; $i=date("Y-m-d", strtotime("+1 day", strtotime($i)))) {
        $fec=$i;
        $nomdia=nombredia($fec);

        //variables
        $mif="";//marcación ingreso
        $msrf="";//marcación salida a refrigerio
        $mirf="";//marcación ingreso de refrigerio
        $msf="";//marcación salida
        $ti=0;//tardanza ingreso
        $tir=0;//tardanza ingreso de refrigerio
        $incd="";//incidente
        //consultamos si el día tiene justificación para no asistir
        //variables dias justificados
        $dj=false;
        $nj="";

        //consultamos el horario para el día
        $ceh=mysqli_query($cone,"SELECT idHorario FROM empleadohorario WHERE idEmpleado=$emp AND Fecha='$fec' AND Estado=1;");
        if($reh=mysqli_fetch_assoc($ceh)){
          $idh=$reh['idHorario'];
        }else{
          //Si no tiene asignado ningún horario le asignamos el normal por defecto
          $idh=1;
        }
        mysqli_free_result($ceh);
        //consultamos datos del horario
        $cdh=mysqli_query($cone, "SELECT * FROM horario WHERE idHorario=$idh;");
        if($rdh=mysqli_fetch_assoc($cdh)){
          $rm=$rdh['ReqMarcacion'];
          $ing=$rdh['Ingreso'];
          $salref=$rdh['SalidaRef'];
          $ingref=$rdh['IngresoRef'];
          $sal=$rdh['Salida'];
          $ssd=$rdh['SalSigDia'];
          $esab=$rdh['ExcSabado'];
          $edom=$rdh['ExcDomingo'];
          $elun=$rdh['ExcLunes'];
          $emar=$rdh['ExcMartes'];
          $emie=$rdh['ExcMiercoles'];
          $ejue=$rdh['ExcJueves'];
          $evie=$rdh['ExcViernes'];
          $rdlib=$rdh['RDLibre'];
          $ht=$rdh['NumHoras'];
          if($ssd){
            $fsal=date('Y-m-d',strtotime('+1 day', strtotime($fec)))." ".$sal;
          }else{
            $fsal=$fec." ".$sal;
          }
        }
        mysqli_free_result($cdh);


        if($rm){
          //Consultamos vacaciones
          $cv=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas FROM empleadocargo ec INNER JOIN provacaciones pv ON ec.idEmpleadoCargo=pv.idEmpleadoCargo INNER JOIN aprvacaciones av ON pv.idProVacaciones=av.idProVacaciones INNER JOIN doc d ON av.idDoc=d.idDoc WHERE ('$fec' BETWEEN pv.FechaIni AND pv.FechaFin) AND ec.idEmpleado=$emp AND pv.estado!=2;");
          if($rv=mysqli_fetch_assoc($cv)){
            $dj=true;
            $nj="<small style='font-size:70%;'>Vacaciones<br>".$rv['Numero']."-".$rv['Ano']."-".$rv['Siglas']."</small>";
          }else{
            //validamos si el turno excluye sabado o domingo
            if($nomdia=="Sábado" && $esab==1){
              $dj=true;
              $nj="<small style='font-size:70%;'>-</small>";
            }elseif($nomdia=="Domingo" && $edom==1){
              $dj=true;
              $nj="<small style='font-size:70%;'>-</small>";
            }elseif($nomdia=="Lunes" && $elun==1){
              $dj=true;
              $nj="<small style='font-size:70%;'>-</small>";
            }elseif($nomdia=="Martes" && $emar==1){
              $dj=true;
              $nj="<small style='font-size:70%;'>-</small>";
            }elseif($nomdia=="Miércoles" && $emie==1){
              $dj=true;
              $nj="<small style='font-size:70%;'>-</small>";
            }elseif($nomdia=="Jueves" && $ejue==1){
              $dj=true;
              $nj="<small style='font-size:70%;'>-</small>";
            }elseif($nomdia=="Viernes" && $evie==1){
              $dj=true;
              $nj="<small style='font-size:70%;'>-</small>";
            }else{
              //Colsultamos licencia
              $cl=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas, tl.MotivoLic, tl.TipoLic FROM empleadocargo ec INNER JOIN licencia l ON ec.idEmpleadoCargo=l.idEmpleadoCargo INNER JOIN aprlicencia al ON l.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic WHERE ('$fec' BETWEEN l.FechaIni AND l.FechaFin) AND ec.idEmpleado=$emp AND l.Estado=1;");
              if($rl=mysqli_fetch_assoc($cl)){
                $dj=true;
                $nj="<small style='font-size:70%;'>(L) ".$rl['MotivoLic']."<br>".$rl['Numero']."-".$rl['Ano']."-".$rl['Siglas']."</small>";
                if($rl['TipoLic']=="Sin goce"){
                  $lsg++;
                }
              }else{
                //Consultamos Comisión de servicio
                $ccs=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE ('$fsal' BETWEEN cs.FechaIni AND cs.FechaFin) AND cs.idEmpleado=$emp AND cs.Estado=1;");
                if($rcs=mysqli_fetch_assoc($ccs)){
                  $dj=true;
                  $nj="<small style='font-size:70%;'>Com. Servicios<br>".$rcs['Numero']."-".$rcs['Ano']."-".$rcs['Siglas']."</small>";
                  //agregamos 8 horas trabajadas por comisión de servicios
                  $nht=$nht+8;
                }else{
                  //consultamos si el día esta considerado como día libre
                  $cdl=mysqli_query($cone, "SELECT * FROM dialibre WHERE Fecha='$fec' AND Estado=1;");
                  if(($rdl=mysqli_fetch_assoc($cdl)) && $rdlib){
                    $dj=true;
                    $nj="<small style='font-size:70%;'>".$rdl['Descripcion']."</small>";
                  }else{
                    //Consultamos permiso por onomastico
                    $cpe=mysqli_query($cone, "SELECT idTipPermiso FROM permiso WHERE DATE_FORMAT(FechaIni,'%Y-%m-%d')='$fec' AND idEmpleado=$emp AND idTipPermiso=5");
                    if($rpe=mysqli_fetch_assoc($cpe)){
                      $dj=true;
                      $nj="<small style='font-size:70%;'> (P) Onomástico</small>";
                    }
                    mysqli_free_result($cpe);
                  }
                  mysqli_free_result($cdl);
                }
                mysqli_free_result($ccs);
              }
              mysqli_free_result($cl);
            }
          }
          mysqli_free_result($cv);
        }else{
          $dj=true;
          $nj="<small style='font-size:70%;'></small>";
        }
        
        //validamos si su día tiene justificación
        if(!$dj){

                //buscamos la marcación de ingreso
                $fting=$fec." ".$ing;
                $ing1=date('Y-m-d H:i:s',strtotime('-75 minute', strtotime($fting)));
                $ing2=date('Y-m-d H:i:s',strtotime('+61 minute', strtotime($fting)));
                $ingt=date('Y-m-d H:i:s',strtotime('+6 minute', strtotime($fting)));
                $ingf=date('Y-m-d H:i:s',strtotime('+11 minute', strtotime($fting)));

                $cmi=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$ing1' AND '$ing2');");

                if($rmi=mysqli_fetch_assoc($cmi)){
                  $mi=$rmi['Marcacion'];
                  $mif=date('h:i A', strtotime($mi));
                  //calcular tardanza
                  if($mi>=$ingt && $mi<$ingf){
                    $ti=floor(((strtotime($mi)-strtotime($fting))/60));
                  }elseif($mi>=$ingf){
                    //Buscamos si tiene permiso por marcación fuera de horario
                    $cper=mysqli_query($cone,"SELECT TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE FechaIni='$fting' AND p.idTipPermiso=7 AND p.idEmpleado=$emp AND p.Estado=1;");
                    if($rper=mysqli_fetch_assoc($cper)){
                      $ti=60;
                      $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small>";
                    }else{
                      $incd="En Falta";
                    }
                    mysqli_free_result($cper);
                  }

                }else{
                  //no encontro marcación de ingreso
                  //buscamos si tiene algún tipo de permiso
                  $cper=mysqli_query($cone,"SELECT TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE FechaIni='$fting' AND p.idEmpleado=$emp AND p.Estado=1;");
                  if($rper=mysqli_fetch_assoc($cper)){
                    if($rper['idTipPermiso']==7){
                      $ti=60;
                      $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small>";
                    }else{
                      $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small>";
                    }
                    
                  }else{
                    $incd="En Falta";
                  }
                  mysqli_free_result($cper);
                }
                mysqli_free_result($cmi);
                //buscamos la marcación salida a refrigerio
                if(!is_null($salref)){
                  $ftsalref=$fec." ".$salref;
                  $salr2=date('Y-m-d H:i:s',strtotime('+29 minute', strtotime($ftsalref)));
                  $cmsr=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$ftsalref' AND '$salr2');");
                  if($rmsr=mysqli_fetch_assoc($cmsr)){
                    $msr=$rmsr['Marcacion'];
                    $msrf=date('h:i A', strtotime($msr));
                    //buscamos la marcación de ingreso de refrigerio
                    $ftingref=$fec." ".$ingref;
                    $ingr1=date('Y-m-d H:i:s',strtotime('-30 minute', strtotime($ftingref)));
                    $ingr2=date('Y-m-d H:i:s',strtotime('+75 minute', strtotime($ftingref)));
                    $ingrt=date('Y-m-d H:i:s',strtotime('+6 minute', strtotime($ftingref)));
                    $cmir=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$ingr1' AND '$ingr2');");
                    if($rmir=mysqli_fetch_assoc($cmir)){
                      $mir=$rmir['Marcacion'];
                      $mirf=date('h:i A', strtotime($mir));
                      //calculamos la tardanza
                      if($mir>=$ingrt){
                        //buscamos si tiene algún tipo de permiso
                        $cper=mysqli_query($cone,"SELECT TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE FechaIni='$ftingref' AND p.idEmpleado=$emp AND p.Estado=1;");
                        if($rper=mysqli_fetch_assoc($cper)){
                            $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small>";                        
                        }else{
                          $tir=floor((strtotime($mir)-strtotime($ftingref))/60);
                        }
                        mysqli_free_result($cper);
                      }
                    }else{
                      //acciones cuando no marco el ingreso de refrigerio
                      //buscamos si tiene algún tipo de permiso
                      $cper=mysqli_query($cone,"SELECT TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE ('$ftingref' BETWEEN FechaIni AND FechaFin) AND p.idEmpleado=$emp AND p.Estado=1;");
                      if($rper=mysqli_fetch_assoc($cper)){
                          $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small>";                        
                      }else{
                        $incd="En Falta";
                      }
                      mysqli_free_result($cper);
                    }
                    mysqli_free_result($cmir);
                  }else{
                    //Como no marcó buscamos algun tipo de permiso
                    $cper=mysqli_query($cone,"SELECT TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE FechaFin='$ftsalref' AND p.idEmpleado=$emp AND p.Estado=1;;");
                    if($rper=mysqli_fetch_assoc($cper)){
                      $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small>";
                      //buscamos la marcación de ingreso de refrigerio
                      $ftingref=$fec." ".$ingref;
                      $ingr1=date('Y-m-d H:i:s',strtotime('-30 minute', strtotime($ftingref)));
                      $ingr2=date('Y-m-d H:i:s',strtotime('+75 minute', strtotime($ftingref)));
                      $ingrt=date('Y-m-d H:i:s',strtotime('+6 minute', strtotime($ftingref)));
                      $cmir=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$ingr1' AND '$ingr2');");
                      if($rmir=mysqli_fetch_assoc($cmir)){
                        $mir=$rmir['Marcacion'];
                        $mirf=date('h:i A', strtotime($mir));
                        //calculamos la tardanza
                        if($mir>=$ingrt){
                          $tir=floor((strtotime($mir)-strtotime($ftingref))/60);
                        }
                      }else{
                        //acciones cuando no marco el ingreso de refrigerio
                        //buscamos si tiene algún tipo de permiso
                        $cper1=mysqli_query($cone,"SELECT TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE FechaIni='$ftingref' AND p.idEmpleado=$emp AND p.Estado=1;");
                        if($rper1=mysqli_fetch_assoc($cper1)){
                            $nj.="<small style='font-size:70%;'> (P) ".$rper1['TipPermiso']."</small>";                        
                        }else{
                          $incd="En Falta";
                        }
                        mysqli_free_result($cper1);
                      }
                    }
                    mysqli_free_result($cper);
                  }
                  mysqli_free_result($cmsr);
                }else{
                //acciones para cuando no necesita marcar salida a refrigerio
                }
                //buscamos la marcación de salida
                $ftsal=$fec." ".$sal;
                $sal2=date('Y-m-d H:i:s',strtotime('+59 minute', strtotime($ftsal)));
                if($ssd){
                  $ftsal=date('Y-m-d H:i:s',strtotime('+1 day', strtotime($ftsal)));
                  $sal2=date('Y-m-d H:i:s',strtotime('+1 day', strtotime($sal2)));
                }
                $cms=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$ftsal' AND '$sal2');");
                if($rms=mysqli_fetch_assoc($cms)){
                  $ms=$rms['Marcacion'];
                  $msf=date('h:i A', strtotime($ms));

                  //calculamos horas extra
                  $he=date('H', strtotime($ms))-date('H', strtotime($ftsal));
                  if($he>=1){
                    $nhe=$nhe+$he;
                  }
                  //calculamos las horas trabajadas
                  if($incd!="En Falta"){
                    $nht=$nht+$ht;
                  }
                }else{
                  //Buscar si tiene permiso
                  $cper=mysqli_query($cone,"SELECT TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE FechaFin='$ftsal' AND p.idEmpleado=$emp AND p.Estado=1;;");
                  if($rper=mysqli_fetch_assoc($cper)){
                      $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small>";
                      //calculamos las horas trabajadas
                      if($incd!="En Falta"){
                        $nht=$nht+$ht;
                      }                 
                  }else{
                    $incd="En Falta";
                  }
                  mysqli_free_result($cper);
                }
                mysqli_free_result($cms);
              

        //fin validación si tiene justificacion
        }

        if($incd=="En Falta"){
          $nf++;
          $tdia=0;
        }else{
          $tdia=$ti+$tir;
        }
        $tmes=$tmes+$tdia;

?>

            <tr id="<?php echo "fila_".$i; ?>">
              <td><?php echo "<small style='font-size: 70%;'>".$nomdia."</small><br><b>".date("d", strtotime($i))."</b>"; ?></td>
              <td><?php echo $mif."<br>".($ti>0 ? "<small class='text-red' style='font-size: 70%;'> (".$ti.")</small>" : ""); ?></td>
              <td><?php echo $msrf; ?></td>
              <td><?php echo $mirf."<br>".($tir>0 ? "<small class='text-red' style='font-size: 70%;'> (".$tir.")</small>" : ""); ?></td>
              <td><?php echo $msf; ?></td>
              <td><?php echo $nj; ?></td>
              <td><?php echo $tdia; ?></td>
              <td><?php echo "<small>".$incd."</small>"; ?></td>
              <?php if(accesoadm($cone,$_SESSION['identi'],2)){ ?>
              <td width="125">
                <select class="form-control" style="width: 120px;" onchange="ghorario(this,<?php echo "'".$fec."', ".$emp; ?>);">
                <?php
                  $ch=mysqli_query($cone, "SELECT idHorario, Descripcion FROM horario WHERE Estado=1 ORDER BY Descripcion ASC;");
                  if(mysqli_num_rows($ch)>0){
                    while($rh=mysqli_fetch_assoc($ch)){
                ?>
                  <option value="<?php echo $rh['idHorario']; ?>" <?php echo $rh['idHorario']==$idh ? "selected" : ""; ?>><?php echo $rh['Descripcion']; ?></option>
                <?php
                    }
                  }
                  mysqli_free_result($ch);
                ?>
                </select>
              </td>
              <?php }else{ ?>
              <td><?php echo nomhorario($cone, $idh); ?></td>
              <?php } ?>
            </tr>
<?php
      }
?>
            <tr>
              <th colspan="4">Total Días de Licencias Sin Goce</th>
              <th><?php echo $lsg; ?></th>
              <th>Total Tardanza/Falta(s)</th>
              <th><?php echo $tmes; ?> Min.</th>
              <th><?php echo $nf; ?> Falta(s)</th>
              <th></th>
            </tr>
          </tbody>
        </table>
        <?php
        $npsg=0;
        $ttmin=0;
        $cpp=mysqli_query($cone,"SELECT * FROM permiso WHERE idEmpleado=$emp AND DATE_FORMAT(FechaIni,'%Y-%m')='$fm' AND idTipPermiso=6 AND Estado=1;");
        if(mysqli_num_rows($cpp)>0){
        ?>
        <table class="table table-bordered table-hover">
          <thead>
          <tr>
            <th colspan="5">Permisos Particulares</th>
          </tr>
          <tr>
            <th>#</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Aprobador</th>
            <th>Minutos</th>
          </tr>
          </thead>
        <?php
          while($rpp=mysqli_fetch_assoc($cpp)){
            $npsg++;
            $tmin=floor((strtotime($rpp['FechaFin'])-strtotime($rpp['FechaIni']))/60);
            $ttmin=$ttmin+$tmin;
        ?>
          <tr>
            <td><?php echo $npsg; ?></td>
            <td><?php echo date('d/m/Y h:i A', strtotime($rpp['FechaIni'])); ?></td>
            <td><?php echo date('d/m/Y h:i A', strtotime($rpp['FechaFin'])); ?></td>
            <td><?php echo nomempleado($cone, $rpp['Aprobador']); ?></td>
            <td><?php echo $tmin; ?></td>
          </tr>
        <?php
          }
        ?>
          <tr>
            <th colspan="4">Total Minutos</th>
            <th><?php echo $ttmin; ?></th>
          </tr>
        </table>
        <?php
        }
        mysqli_free_result($cpp);
        ?>
        <table class="table table-bordered table-hover">
          <tr>
              <th>Horas trabajadas</th>
              <th><?php echo round(($nht+$nhe-($ttmin/60)-($tmes/60)), 2); ?></th>
              <th>Horas extra</th>
              <th><?php echo $nhe; ?></th>
            </tr>
        </table>
        <br>
        <form class="form-horizontal" id="f_observaciones">
          <?php
          $fo=$fm."-01";
          $cob=mysqli_query($cone,"SELECT Observacion FROM amobservacion WHERE idEmpleado=$emp AND Mes='$fo';");
          if($rob=mysqli_fetch_assoc($cob)){
            $obs=$rob['Observacion'];
          }else{
            $obs="";
          }
          ?>
          <div class="form-group">
            <div class="col-sm-10">
              <input type="hidden" name="idp" value="<?php echo $emp; ?>">
              <input type="hidden" name="mes" value="<?php echo $fo; ?>">
              <textarea class="form-control" name="obs" id="obs" placeholder="Observaciones" maxlength="250"><?php echo "$obs"; ?></textarea>
            </div>
            <div class="col-sm-2">
              <button type="button" class="btn bg-aqua" id="b_gobservacion"><i class="fa fa-floppy-o"></i> Guardar</button>
              <div id="r_observaciones"></div>
            </div>
          </div>
        </form>
<script>
$("#b_gobservacion").click(function(){
  var datos = $("#f_observaciones").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gobservaciones.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#r_observaciones").html("<i class='fa fa-spinner fa-spin'></i>");
     },
     success: function(d){
        $("#r_observaciones").html(d.m);
        $("#r_observaciones").slideDown();
     }
  });
});
</script>

<?php
      }
    }else{
      echo mensajewa("Error: El mes/año no es válido.");
    }
  }else{
    echo mensajeda("Error: No se enviaron los datos.");
  }
}else{
  echo accrestringidoa();
}
                  ?>