<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],2)){
  if(isset($_POST['mesanoi']) && !empty($_POST['mesanoi']) && isset($_POST['loc']) && !empty($_POST['loc'])){
    $loc=iseguro($cone,$_POST['loc']);
    $mesanoj=iseguro($cone,$_POST['mesanoi']);
    $mesano=explode("/", $mesanoj);
    if(strlen($mesano[0])==2 && strlen($mesano[1])==4){
      $inim="01/".$mesanoj;
      $inimm=fmysql($inim);
?>
<br>
<div class="row">
  <div class="col-md-7">
    <h4><i class='fa fa-building-o text-gray'></i> <span class="text-orange"><?php echo dirlocal($cone,$loc); ?></span></h4>
  </div>
  <div class="col-md-5">
    <h4 class="text-right"><i class='fa fa-calendar text-gray'></i> <span class="text-orange"><?php echo strtoupper(nombremes($mesano[0])).' - '.$mesano[1]; ?></span></h4>
  </div>
</div>
<?php
      $q="SELECT ec.idEmpleadoCargo, ec.idEmpleado FROM dependencialocal dl INNER JOIN dependencia d ON dl.idDependencia=d.idDependencia INNER JOIN cardependencia cd ON d.idDependencia=cd.idDependencia INNER JOIN empleadocargo ec ON cd.idEmpleadoCargo=ec.idEmpleadoCargo INNER JOIN cargo c ON ec.idCargo=c.idCargo INNER JOIN sistemalab sl ON c.idSistemaLab=sl.idSistemaLab WHERE dl.idLocal=$loc AND (('$inimm' BETWEEN cd.FecInicio AND cd.FecFin) OR ('$inimm'>=cd.FecInicio AND cd.FecFin IS NULL)) AND (sl.idSistemaLab=2 OR sl.idSistemaLab=3) GROUP BY ec.idEmpleadoCargo;";
      $ca=mysqli_query($cone,$q);
      if(mysqli_num_rows($ca)>0){
?>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>NOMBRE</th>
            <th>CARGO</th>
            <th>TARDANZA (Min)</th>
            <th>Faltas (Días)</th>
            <th>LIC. SG (Días)</th>
            <th>P. PART. (Min)</th>
          </tr>
        </thead>
        <tbody>
<?php
        while($ra=mysqli_fetch_assoc($ca)){
          $emp=$ra['idEmpleado'];
          $car=$ra['idEmpleadoCargo'];











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

                      if(!$cm){
                      }else{
                          //validamos si se selecciono el mes actual de modo que la fecha final sera en día actual.
                          if(date('Y-m')==$fm){
                            $ff=date('Y-m-d');
                          }

                        $nf=0;
                        $lsg=0;
                        $tmes=0;
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
                            $rdlib=$rdh['RDLibre'];
                            if($ssd){
                              $fec=strtotime('+1 day', strtotime($fec));
                            }
                            $fsal=$fec." ".$sal;
                          }
                          mysqli_free_result($cdh);


                          if($rm){
                            //Consultamos vacaciones
                            $cv=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas FROM empleadocargo ec INNER JOIN provacaciones pv ON ec.idEmpleadoCargo=pv.idEmpleadoCargo INNER JOIN aprvacaciones av ON pv.idProVacaciones=av.idProVacaciones INNER JOIN doc d ON av.idDoc=d.idDoc WHERE ('$fec' BETWEEN pv.FechaIni AND pv.FechaFin) AND ec.idEmpleado=$emp AND pv.estado!=2;");
                            if($rv=mysqli_fetch_assoc($cv)){
                              $dj=true;
                              $nj="<small style='font-size:70%;'>Vacaciones<br>".$rv['Numero']."-".$rv['Ano']."-".$rv['Siglas']."</small><br>";
                            }else{
                              //validamos si el turno excluye sabado o domingo
                              if($nomdia=="Sábado" && $esab==1){
                                $dj=true;
                                $nj="<small style='font-size:70%;'>Descanso</small><br>";
                              }elseif($nomdia=="Domingo" && $edom==1){
                                $dj=true;
                                $nj="<small style='font-size:70%;'>Descanso</small><br>";
                              }else{
                                //Colsultamos licencia
                                $cl=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas, tl.MotivoLic, tl.TipoLic FROM empleadocargo ec INNER JOIN licencia l ON ec.idEmpleadoCargo=l.idEmpleadoCargo INNER JOIN aprlicencia al ON l.idLicencia=al.idLicencia INNER JOIN doc d ON al.idDoc=d.idDoc INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic WHERE ('$fec' BETWEEN l.FechaIni AND l.FechaFin) AND ec.idEmpleado=$emp AND l.Estado=1;");
                                if($rl=mysqli_fetch_assoc($cl)){
                                  $dj=true;
                                  $nj="<small style='font-size:70%;'>(L) ".$rl['MotivoLic']."<br>".$rl['Numero']."-".$rl['Ano']."-".$rl['Siglas']."</small><br>";
                                  if($rl['TipoLic']=="Sin goce"){
                                    $lsg++;
                                  }
                                }else{
                                  //Consultamos Comisión de servicio
                                  $ccs=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE ('$fsal' BETWEEN cs.FechaIni AND cs.FechaFin) AND cs.idEmpleado=$emp AND cs.Estado=1;");
                                  if($rcs=mysqli_fetch_assoc($ccs)){
                                    $dj=true;
                                    $nj="<small style='font-size:70%;'>Com. Servicios<br>".$rcs['Numero']."-".$rcs['Ano']."-".$rcs['Siglas']."</small><br>";
                                  }else{
                                    //consultamos si el día esta considerado como día libre
                                    $cdl=mysqli_query($cone, "SELECT * FROM dialibre WHERE Fecha='$fec' AND Estado=1;");
                                    if(($rdl=mysqli_fetch_assoc($cdl)) && $rdlib){
                                      $dj=true;
                                      $nj="<small style='font-size:70%;'>".$rdl['Descripcion']."</small><br>";
                                    }else{
                                      //Consultamos permiso por onomastico
                                      $cpe=mysqli_query($cone, "SELECT idTipPermiso FROM permiso WHERE DATE_FORMAT(FechaIni,'%Y-%m-%d')='$fec' AND idEmpleado=$emp AND idTipPermiso=5");
                                      if($rpe=mysqli_fetch_assoc($cpe)){
                                        $dj=true;
                                        $nj="<small style='font-size:70%;'> (P) Onomástico</small><br>";
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
                            $nj="<small style='font-size:70%;'></small><br>";
                          }
                          
                          //validamos si su día tiene justificación
                          if(!$dj){

                                  //buscamos la marcación de ingreso
                                  $fting=$fec." ".$ing;
                                  $ing1=date('Y-m-d H:i:s',strtotime('-75 minute', strtotime($fting)));
                                  $ing2=date('Y-m-d H:i:s',strtotime('+60 minute', strtotime($fting)));
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
                                        $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small><br>";
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
                                        $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small><br>";
                                      }else{
                                        $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small><br>";
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
                                              $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small><br>";                        
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
                                            $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small><br>";                        
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
                                        $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small><br>";
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
                                              $nj.="<small style='font-size:70%;'> (P) ".$rper1['TipPermiso']."</small><br>";                        
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
                                  $sal2=date('Y-m-d H:i:s',strtotime('+75 minute', strtotime($ftsal)));
                                  if($ssd){
                                    $ftsal=date('Y-m-d H:i:s',strtotime('+1 day', strtotime($ftsal)));
                                    $sal2=date('Y-m-d H:i:s',strtotime('+1 day', strtotime($sal2)));
                                  }
                                  $cms=mysqli_query($cone, "SELECT Marcacion FROM marcacion WHERE idEmpleado=$emp AND (Marcacion BETWEEN '$ftsal' AND '$sal2');");
                                  if($rms=mysqli_fetch_assoc($cms)){
                                    $ms=$rms['Marcacion'];
                                    $msf=date('h:i A', strtotime($ms));

                                  }else{
                                    //Buscar si tiene permiso
                                    $cper=mysqli_query($cone,"SELECT TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE FechaFin='$ftsal' AND p.idEmpleado=$emp AND p.Estado=1;;");
                                    if($rper=mysqli_fetch_assoc($cper)){
                                        $nj.="<small style='font-size:70%;'> (P) ".$rper['TipPermiso']."</small><br>";                    
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
                        }
                          $ttmin=0;
                          $cpp=mysqli_query($cone,"SELECT * FROM permiso WHERE idEmpleado=$emp AND DATE_FORMAT(FechaIni,'%Y-%m')='$fm' AND idTipPermiso=6 AND Estado=1;");
                          if(mysqli_num_rows($cpp)>0){
                            while($rpp=mysqli_fetch_assoc($cpp)){
                              $tmin=floor((strtotime($rpp['FechaFin'])-strtotime($rpp['FechaIni']))/60);
                              $ttmin=$ttmin+$tmin;
                            }
                          }
                          mysqli_free_result($cpp);
                      















    



?>
          <tr>
            <td><?php echo nomempleado($cone,$ra['idEmpleado']); ?></td>
            <td><?php echo cargoiec($cone,$ra['idEmpleadoCargo']); ?></td>
            <td><?php echo $tmes; ?></td>
            <td><?php echo $nf; ?></td>
            <td><?php echo $lsg; ?></td>
            <td><?php echo $ttmin; ?></td>
          </tr>
<?php
        }
        }
?>
        </tbody>
      </table>
<?php
      }else{
        echo mensajewa("No se hallaron resultados.");
      }

    }else{
      echo mensajewa("Error: El mes/año no es válido.");
    }
  }else{
    echo mensajeda("Error: Faltan datos.");
  }
}else{
  echo accrestringidoa();
}
?>