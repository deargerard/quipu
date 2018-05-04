<?php
	include_once '../m_inclusiones/php/conexion_sp.php';
	include_once '../m_inclusiones/php/funciones.php';
	require __DIR__.'/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;

if(isset($_GET['mesanoc']) && !empty($_GET['mesanoc']) && isset($_GET['per']) && !empty($_GET['per']) && isset($_GET['car']) && !empty($_GET['car'])){


		ob_start();


		//require_once '../m_inclusiones/a_asistencia/pdfasistencia.php';
?>
<style type="text/css">
<!--
    table.page_header {width: 100%; border: none; padding: 2mm }
    table.page_footer {width: 100%; border: none; padding: 1mm; font-size: 10px;}
    table.tablep {width: 100%; border-collapse: collapse; font-size: 13px;}
    table.tablep th, table.tablep td {border: 1px solid #AAAAAA; padding: 2px; white-space: nowrap; word-break: break-all;}
    table.st {width: 100%; border-collapse: collapse; padding: 5px 0; font-size: 10px;}

-->
</style>
<page backtop="18mm" backbottom="5mm" backleft="2mm" backright="2mm" style="font-size: 9px;"> 
    <page_header> 
        <table class="page_header">
            <tr>
            	<td style="width: 20%;">
            		<img src="../m_images/logo.png" width="150">
            	</td>
                <td style="width: 60%; text-align: center;">
                    <span style="font-size: 16px;">ASISTENCIA</span><br>
                    <span style="font-size: 12px;">ADMINISTRACIÓN - DISTRITO FISCAL DE CAJAMARCA</span>

                </td>
                <td style="width: 20%;">
                	
                </td>
            </tr>
        </table>
    </page_header> 
    <page_footer> 
        <table class="page_footer">
            <tr>
                <td style="width: 100%; text-align: right">
                    Página [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>






<?php

    $emp=iseguro($cone,$_GET['per']);
    $car=iseguro($cone,$_GET['car']);
    $mesanoj=iseguro($cone,$_GET['mesanoc']);
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

    <table class="st">
    	<tr>
    		<td style="width: 50%; text-align: left;">NOMBRE: <b><?php echo nomempleado($cone,$emp); ?></b></td>
    		<td style="width: 50%; text-align: right;">MES: <b><?php echo strtoupper(nombremes($mesano[0])).' - '.$mesano[1]; ?></b></td>
    	</tr>
    </table>

<?php
      if(!$cm){
        echo "No le corresponde asistencia.";
      }else{
        //validamos si se selecciono el mes actual de modo que la fecha final sera en día actual.
        if(date('Y-m')==$fm){
          $ff=date('Y-m-d');
        }
?>
        <table class="tablep">
            <tr>
              <th style="width: 4%;" align="center"><small>Día</small></th>
              <th style="width: 8%;"><small>Ingreso</small></th>
              <th style="width: 8%;"><small>Sal. Ref.</small></th>
              <th style="width: 8%;"><small>Ing. Ref.</small></th>
              <th style="width: 8%;"><small>Salida</small></th>
              <th style="width: 30%;"><small>Justificación/Motivo</small></th>
              <th style="width: 8%" align="center"><small>Min. Tarde</small></th>
              <th style="width: 8%"><small>Incidente</small></th>
              <th style="width: 18%"><small>Horario</small></th>
            </tr>
<?php

      $nf=0;
      $lsg=0;
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
                $ccs=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE ('$fec' BETWEEN DATE_FORMAT(cs.FechaIni,'%Y-%m-%d') AND DATE_FORMAT(cs.FechaFin,'%Y-%m-%d')) AND cs.idEmpleado=$emp AND cs.Estado=1;");
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
                      $cper=mysqli_query($cone,"SELECT TipPermiso FROM permiso p INNER JOIN tippermiso tp ON p.idTipPermiso=tp.idTipPermiso WHERE FechaIni='$ftingref' AND p.idEmpleado=$emp AND p.Estado=1;");
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

?>

            <tr>
              <td align="center"><?php echo "<small>".date("d", strtotime($i))."</small>"; ?></td>
              <td><?php echo "<small class='text-red' style='font-size: 80%;'>".$mif."</small> ".($ti>0 ? "<small style='font-size: 70%;'> (".$ti.")</small>" : ""); ?></td>
              <td><?php echo "<small class='text-red' style='font-size: 80%;'>".$msrf."</small>"; ?></td>
              <td><?php echo "<small class='text-red' style='font-size: 80%;'>".$mirf."</small> ".($tir>0 ? "<small style='font-size: 70%;'> (".$tir.")</small>" : ""); ?></td>
              <td><?php echo "<small class='text-red' style='font-size: 80%;'>".$msf."</small>"; ?></td>
              <td><?php echo $nj; ?></td>
              <td align="center"><?php echo "<small style='font-size: 80%;'>".$tdia."</small>"; ?></td>
              <td><?php echo "<small style='font-size: 80%;'>".$incd."</small>"; ?></td>
              <td><?php echo "<small style='font-size: 80%;'>".wordwrap(html_entity_decode(nomhorario($cone, $idh)),28,"<br/>\n",true)."</small>"; ?></td>
            </tr>
<?php
      }
?>
            <tr>
              <th colspan="4"><small>Total Días de Licencias Sin Goce</small></th>
              <th><small><?php echo $lsg; ?></small></th>
              <th><small>Total Tardanza/Falta(s)</small></th>
              <th><small><?php echo $tmes; ?> Min.</small></th>
              <th colspan="2"><small><?php echo $nf; ?> Falta(s)</small></th>
            </tr>
        </table>
        <?php
        $cpp=mysqli_query($cone,"SELECT * FROM permiso WHERE idEmpleado=$emp AND DATE_FORMAT(FechaIni,'%Y-%m')='$fm' AND idTipPermiso=6 AND Estado=1;");
        if(mysqli_num_rows($cpp)>0){
        ?>
        <br>
        <table class="tablep">

          <tr>
            <th colspan="5" style="width: 100%;"><small>Permisos Particulares</small></th>
          </tr>
          <tr>
            <th><small>#</small></th>
            <th><small>Inicio</small></th>
            <th><small>Fin</small></th>
            <th><small>Aprobador</small></th>
            <th><small>Minutos</small></th>
          </tr>

        <?php
          $npsg=0;
          $ttmin=0;
          while($rpp=mysqli_fetch_assoc($cpp)){
            $npsg++;
            $tmin=floor((strtotime($rpp['FechaFin'])-strtotime($rpp['FechaIni']))/60);
            $ttmin=$ttmin+$tmin;
        ?>
          <tr>
            <td><small style='font-size: 80%;'><?php echo $npsg; ?></small></td>
            <td><small style='font-size: 80%;'><?php echo date('d/m/Y h:i A', strtotime($rpp['FechaIni'])); ?></small></td>
            <td><small style='font-size: 80%;'><?php echo date('d/m/Y h:i A', strtotime($rpp['FechaFin'])); ?></small></td>
            <td><small style='font-size: 80%;'><?php echo nomempleado($cone, $rpp['Aprobador']); ?></small></td>
            <td><small style='font-size: 80%;'><?php echo $tmin; ?></small></td>
          </tr>
        <?php
          }
        ?>
          <tr>
            <th colspan="4"><small>Total Minutos</small></th>
            <th><small><?php echo $ttmin; ?></small></th>
          </tr>
        </table>
        <br>
        <?php
        }
        mysqli_free_result($cpp);
        ?>
        <table class="tablasb">
          <?php
          $fo=$fm."-01";
          $cob=mysqli_query($cone,"SELECT Observacion FROM amobservacion WHERE idEmpleado=$emp AND Mes='$fo';");
          if($rob=mysqli_fetch_assoc($cob)){
            $obs="<b>Observaciones:</b> ".$rob['Observacion'];
          }else{
            $obs="";
          }
          ?>
          <tr>
            <td><?php echo "$obs"; ?></td>
          </tr>
        </table>


<?php
      }
    }else{
      echo "Error: El mes/año no es válido.";
    }

?>












</page> 
<?php
		$html=ob_get_clean();

		$html2pdf=new Html2Pdf('P','A4','es','true','UTF-8', array(5,5,5,1));
		$html2pdf->writeHTML($html);
		$html2pdf->output('asistencia.pdf');



}else{
	echo mensajeda("Error: No se enviaron los datos.");
}
mysqli_close($cone);
?>