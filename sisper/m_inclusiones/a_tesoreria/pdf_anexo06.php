<?php

include("../php/conexion_sp.php");
include("../php/funciones.php");
require '../../m_exportar/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

  if(isset($_GET['idcs']) && !empty($_GET['idcs'])){
    $idcs=iseguro($cone,$_GET['idcs']);   
    ob_start();    
?>
    
    <style type="text/css">
<!--
    table.page_header {width: 100%; border: none; padding: 2mm }
    table.page_footer {width: 100%; border: none; padding: 1mm; font-size: 10px;}
    table.tablep {width: 100%; border-collapse: collapse;}
    table.tablep th, table.tablep td {border: 1px solid #AAAAAA; padding: 2px; white-space: nowrap; word-break: break-all;}
    table.st {width: 100%; border-collapse: collapse; padding: 15px 0; font-size: 12px;}
    table.st th, table.st td {padding: 3px 0;}
    table.re {width: 100%; border-collapse: collapse; padding: 5px 0; font-size: 10px;}
    .de{text-align: right;}
    .ce{text-align: center;}

-->
</style>
<page backtop="34mm" backbottom="5mm" backleft="3mm" backright="3mm" style="font-size: 9px;">
    <page_header> 
      <table class="tablep">
         <tr>
           <td rowspan="2" style="width: 25%; height: 80px;"><img src="../../m_images/logompg.png" width="150"></td>
           <td colspan="2" style="text-align: center; font-size: 11px;">DIRECTIVA GENERAL</td>
           <td rowspan="2" style="width: 25%; font-size: 10px;">Código: 003-2018-MP-FN-CG<br>Versión: 1.0<br>Fecha:</td>
         </tr>
         <tr>
           <th colspan="2" style="text-align: center; font-size: 11px;">NORMAS PARA LA ENTREGA DE FONDOS POR<br>VIÁTICOS Y ASIGNACIONES PARA LA<br>REALIZACIÓN DE COMISIONES DE SERVICIOS</th>
         </tr>
         <tr>
           <td colspan="2" style="width: 50%; font-size: 11px; height: 15px">Generado por: Gerencia Central de Finanzas</td>
           <td colspan="2" style="width: 50%; font-size: 11px;">Aprobado por: Gerencia General</td>
         </tr>
         <tr>
           <td style="width: 25%; border-left: none; border-bottom: none; border-right: none;"></td>
           <td style="width: 25%; border-left: none; border-bottom: none; border-right: none;"></td>
           <td style="width: 25%; border-left: none; border-bottom: none; border-right: none;"></td>
           <td style="width: 25%; border-left: none; border-bottom: none; border-right: none;"></td>
         </tr>
      </table>
    </page_header> 
    <page_footer> 
      <table class="page_footer">
        <tr>
          <td style="width: 70%; text-align: left">
          </td>
          <td style="width: 30%; text-align: right">
              Página [[page_cu]]/[[page_nb]]
          </td>
        </tr>
      </table>
    </page_footer>      
<?php
    $c1=mysqli_query($cone,"SELECT cs.FechaIni, cs.FechaFin, cs.idEmpleado, cs.csivia, cs.destino, cs.numrecdev, e.NumeroDoc FROM comservicios cs INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado WHERE idComServicios=$idcs;");
      if($r1=mysqli_fetch_assoc($c1)){

              $ct=mysqli_query($cone,"SELECT SUM(monto) as tasignado FROM tedetplanillav where idComServicios=$idcs;");
              $cr=mysqli_query($cone,"SELECT SUM(totalcom) as trendido FROM tegasto where idComServicios=$idcs;");
              $tav=0;
              $trv=0;                         
              if ($rt=mysqli_fetch_assoc($ct)) {             
                $tav=$rt['tasignado'];
              }
              mysqli_free_result($ct);

              if ($rr=mysqli_fetch_assoc($cr)) {             
                $trv=$rr['trendido'];
              }
              mysqli_free_result($cr);

              $dev=n_2decimales($tav-$trv);
 ?>   
      <table class="re">
        <tr>
          <th style="text-align: center; font-size: 12px;">ANEXO 06</th>
        </tr>
        <tr>
          <th>&nbsp;</th>
        </tr>
        <tr>
          <th style="text-align: center; font-size: 12px;">ANALISIS DE RENDICION DE VIATICOS Y ASIGNACIONES POR COMISION DE SERVICIOS</th>
        </tr>
        <tr>
          <td style="width: 100%; text-align: right; font-size: 14px;">N° <?php echo $r1['csivia']; ?></td>
        </tr>
        <tr>
          <td style="width: 100%; text-align: right;">Cajamarca, <?php echo date('d'); ?> de <?php echo nombremes(date('m')); ?> de <?php echo date('Y'); ?></td>
        </tr>
      </table>
      <table class="st" style="font-size: 11px;">
        <tr>
          <th colspan="2">NOMBRES Y APELLIDOS:</th>
          <td colspan="5"><?php echo nomempleado_na($cone, $r1['idEmpleado']); ?></td>
        </tr>
        <tr>
          <th colspan="2">DEPENDENCIA:</th>
          <td colspan="5"><?php echo wordwrap(html_entity_decode(dependenciaxiecxfecha($cone, idecxidexfecha($cone, $r1['idEmpleado'], date('Y-m-d', strtotime($r1['FechaIni']))), date('Y-m-d', strtotime($r1['FechaIni'])))),60,"<br/>\n",true); ?></td>
        </tr>
        <tr>
          <th colspan="2">CARGO:</th>
          <td colspan="5"><?php echo cargoiec($cone, idecxidexfecha($cone, $r1['idEmpleado'], date('Y-m-d', strtotime($r1['FechaIni'])))) ?></td>
        </tr>
        <tr>
          <th colspan="2">GRADO Y SUB GRADO</th>
          <td colspan="5"></td>
        </tr>
        <tr>
          <th>LUGAR:</th>
          <td colspan="2"><?php echo $r1['destino']; ?></td>
          <th style="text-align: right;">DESDE:</th>
          <td><?php echo fnormal($r1['FechaIni']); ?></td>
          <th style="text-align: right;">HASTA:</th>
          <td><?php echo fnormal($r1['FechaFin']); ?></td>
        </tr>
        <tr>
          <th colspan="5" style="height: 18px;">1) OTORGAMIENTO DE VIATICOS</th>
          <th style="text-align: right;">OTORGADOS</th>
          <th style="text-align: right;">RECONOCIDOS</th>
        </tr>
        <tr>
          <th colspan="4">a) ALOJAMIENTO Y ALIMENTACION</th>
          <td style="text-align: right;">S/</td>
<?php
              $caao=mysqli_query($cone,"SELECT SUM(monto) as tasignado FROM tedetplanillav where idComServicios=$idcs AND (idteconceptov=1 OR idteconceptov=2);");
              $caar=mysqli_query($cone,"SELECT SUM(totalcom) as trendido FROM tegasto where idComServicios=$idcs AND (idteconceptov=9 OR idteconceptov=10 OR idteconceptov=11);");
              $taao=0;
              $taar=0;                         
              if ($raao=mysqli_fetch_assoc($caao)) {             
                $taao=$raao['tasignado'];
              }
              mysqli_free_result($caao);

              if ($raar=mysqli_fetch_assoc($caar)) {             
                $taar=$raar['trendido'];
              }
              mysqli_free_result($caar);
?>
          <td style="text-align: right;"><?php echo n_2decimales($taao); ?></td>
          <td style="text-align: right;"><?php echo n_2decimales($taar); ?></td>
        </tr>
        <tr>
          <th colspan="4">b) PASAJES TERRESTRES</th>
          <td style="text-align: right;">S/</td>
<?php
              $cpo=mysqli_query($cone,"SELECT SUM(monto) as tasignado FROM tedetplanillav where idComServicios=$idcs AND idteconceptov=4;");
              $cpr=mysqli_query($cone,"SELECT SUM(totalcom) as trendido FROM tegasto where idComServicios=$idcs AND idteconceptov=8;");
              $tpo=0;
              $tpr=0;                         
              if ($rpo=mysqli_fetch_assoc($cpo)) {             
                $tpo=$rpo['tasignado'];
              }
              mysqli_free_result($cpo);

              if ($rpr=mysqli_fetch_assoc($cpr)) {             
                $tpr=$rpr['trendido'];
              }
              mysqli_free_result($cpr);
?>
          <td style="text-align: right;"><?php echo n_2decimales($tpo); ?></td>
          <td style="text-align: right;"><?php echo n_2decimales($tpr); ?></td>
        </tr>
        <tr>
          <th colspan="4">c) TUA CORPAC</th>
          <td style="text-align: right;">S/</td>
          <td style="text-align: right;">0.00</td>
          <td style="text-align: right;">0.00</td>
        </tr>
        <tr>
          <th colspan="4">d) PASAJES AEREOS</th>
          <td style="text-align: right;">S/</td>
          <td style="text-align: right;">0.00</td>
          <td style="text-align: right;">0.00</td>
        </tr>
        <tr>
          <th colspan="4">e) COMBUSTIBLE</th>
          <td style="text-align: right;">S/</td>
<?php
              $cco=mysqli_query($cone,"SELECT SUM(monto) as tasignado FROM tedetplanillav where idComServicios=$idcs AND idteconceptov=5;");
              $ccr=mysqli_query($cone,"SELECT SUM(totalcom) as trendido FROM tegasto where idComServicios=$idcs AND idteconceptov=12;");
              $tco=0;
              $tcr=0;                         
              if ($rco=mysqli_fetch_assoc($cco)) {             
                $tco=$rco['tasignado'];
              }
              mysqli_free_result($cco);

              if ($rcr=mysqli_fetch_assoc($ccr)) {             
                $tcr=$rcr['trendido'];
              }
              mysqli_free_result($ccr);
?>
          <td style="text-align: right;"><?php echo n_2decimales($tco); ?></td>
          <td style="text-align: right;"><?php echo n_2decimales($tcr); ?></td>
        </tr>
        <tr>
          <th colspan="4">f) PEAJE</th>
          <td style="text-align: right;">S/</td>
<?php
              $cpeo=mysqli_query($cone,"SELECT SUM(monto) as tasignado FROM tedetplanillav where idComServicios=$idcs AND idteconceptov=6;");
              $cper=mysqli_query($cone,"SELECT SUM(totalcom) as trendido FROM tegasto where idComServicios=$idcs AND idteconceptov=21;");
              $tpeo=0;
              $tper=0;                         
              if ($rpeo=mysqli_fetch_assoc($cpeo)) {    
                $tpeo=$rpeo['tasignado'];
              }
              mysqli_free_result($cpeo);

              if ($rper=mysqli_fetch_assoc($cper)) {
                $tper=$rper['trendido'];
              }
              mysqli_free_result($cper);
?>
          <td style="text-align: right;"><?php echo n_2decimales($tpeo); ?></td>
          <td style="text-align: right;"><?php echo n_2decimales($tper); ?></td>
        </tr>
        <tr>
          <th colspan="4">g) OTROS</th>
          <td style="text-align: right;">S/</td>
<?php
              $coo=mysqli_query($cone,"SELECT SUM(monto) as tasignado FROM tedetplanillav where idComServicios=$idcs AND idteconceptov=7;");
              $cor=mysqli_query($cone,"SELECT SUM(totalcom) as trendido FROM tegasto where idComServicios=$idcs AND idteconceptov=14;");
              $too=0;
              $tor=0;                         
              if ($roo=mysqli_fetch_assoc($coo)) {    
                $too=$roo['tasignado'];
              }
              mysqli_free_result($coo);

              if ($ror=mysqli_fetch_assoc($cor)) {
                $tor=$ror['trendido'];
              }
              mysqli_free_result($cor);
?>
          <td style="text-align: right;"><?php echo n_2decimales($too); ?></td>
          <td style="text-align: right;"><?php echo n_2decimales($tor); ?></td>
        </tr>
        <tr>
          <th colspan="4" style="text-align: center;">TOTAL</th>
          <th style="text-align: right;">S/</th>
          <th style="text-align: right;"><?php echo n_2decimales($taao+$tpo+$tco+$tpeo+$too); ?></th>
          <th style="text-align: right;"><?php echo n_2decimales($taar+$tpr+$tcr+$tper+$tor); ?></th>
        </tr>
        <tr>
          <th colspan="7" style="height: 18px;">2) RENDICION DE GASTOS POR COMISION DE SERVICIOS</th>
        </tr>
        <tr>
          <th colspan="4">a) Rendición documentada de gastos</th>
          <td style="text-align: right;">S/</td>
<?php
              $crd=mysqli_query($cone,"SELECT SUM(totalcom) as trendido FROM tegasto where idComServicios=$idcs AND idtetipocom!=2;");
              $trd=0;
              if ($rrd=mysqli_fetch_assoc($crd)) {
                $trd=$rrd['trendido'];
              }
              mysqli_free_result($crd);
?>
          <td style="text-align: right;"><?php echo n_2decimales($trd); ?></td>
          <td></td>
        </tr>
        <tr>
          <th colspan="4">b) Declaración Jurada de gastos</th>
          <td style="text-align: right;">S/</td>
<?php
              $cdj=mysqli_query($cone,"SELECT SUM(totalcom) as trendido FROM tegasto where idComServicios=$idcs AND idtetipocom=2;");
              $tdj=0;
              if ($rdj=mysqli_fetch_assoc($cdj)) {
                $tdj=$rdj['trendido'];
              }
              mysqli_free_result($cdj);
?>
          <td style="text-align: right;"><?php echo n_2decimales($tdj); ?></td>
          <td></td>
        </tr>
        <tr>
          <th colspan="4"></th>
          <th style="text-align: right;">S/</th>
          <th style="text-align: right;"><?php echo n_2decimales($trd+$tdj); ?></th>
          <td></td>
        </tr>
        <tr>
          <th colspan="7" style="height: 18px;">3) RESUMEN</th>
        </tr>
        <tr>
          <th colspan="4">a) Víaticos otorgados</th>
          <td style="text-align: right;">S/</td>
          <td style="text-align: right;"><?php echo n_2decimales($tav); ?></td>
          <td></td>
        </tr>
        <tr>
          <th colspan="4">b) Gastos reconocidos</th>
          <td style="text-align: right;">S/</td>
          <td style="text-align: right;"><?php echo n_2decimales($trv); ?></td>
          <td></td>
        </tr>
        <tr>
          <th colspan="4" style="text-align: right;">Devolución</th>
          <th style="text-align: right;">S/</th>
          <th style="text-align: right;"><?php echo n_2decimales($dev); ?></th>
          <td></td>
        </tr>
        <tr>
          <th colspan="7" style="height: 18px;">4) Devolución</th>
        </tr>
        <tr>
          <td></td>
          <th>R. CAJA: <?php echo str_pad($r1['numrecdev'], 6, "0", STR_PAD_LEFT); ?></th>
          <td>S/ <?php echo $dev; ?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <th>MEMO N°</th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <th style="text-align: center; border: 1px solid #BBBBBB;">TOTAL</th>
          <th style="text-align: center; border: 1px solid #BBBBBB;">S/ <?php echo n_2decimales($tav); ?></th>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td style="width: 7%;"></td>
          <td style="width: 18%;"></td>
          <td style="width: 18%;"></td>
          <td style="width: 12%;"></td>
          <td style="width: 15%;"></td>
          <td style="width: 15%;"></td>
          <td style="width: 15%;"></td>
        </tr>
      </table>
      <table class="st">
        <tr>
          <td style="width: 100%; height: 40px;" colspan="2"></td>
        </tr>
        <tr>
          <td style="width: 60%"></td>
          <td style="text-align: center; width: 40%;">____________________________</td>
        </tr>
        <tr>
          <td></td>
          <th style="text-align: center;">ENCARGADO DE LA REVISIÓN</th>
        </tr>
      </table>
<?php
  }else{
  echo "No se han registrado comprobantes de gasto.";
  }
  mysqli_free_result($c1);
?>
</page>   

<?php
		$html=ob_get_clean();
    $html2pdf=new Html2Pdf('P','A4','es','true','UTF-8', array(8,8,8,5));
    $html2pdf->writeHTML($html);
    $html2pdf->output('Anexo02_Declaracion_Jurada.pdf');

  }else{
    echo "Faltan datos";
  }
mysqli_close($cone);
?>