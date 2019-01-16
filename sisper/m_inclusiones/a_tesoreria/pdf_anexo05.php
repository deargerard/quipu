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
    table.tablep {width: 95%; border-collapse: collapse;}
    table.tablep th, table.tablep td {border: 1px solid #AAAAAA; padding: 2px; white-space: nowrap; word-break: break-all;}
    table.st {width: 95%; border-collapse: collapse; padding: 30px 0; font-size: 10px;}
    table.re {width: 100%; border-collapse: collapse; padding: 5px 0; font-size: 10px;}
    .de{text-align: right;}
    .ce{text-align: center;}

-->
</style>
<page backtop="10mm" backbottom="5mm" backleft="2mm" backright="2mm" style="font-size: 9px;">
    <page_header> 

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
    $c1=mysqli_query($cone,"SELECT cs.FechaIni, cs.FechaFin, cs.idEmpleado, cs.origen, cs.destino, cs.numrecdev, e.NumeroDoc FROM comservicios cs INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado WHERE idComServicios=$idcs;");
      if($r1=mysqli_fetch_assoc($c1)){

              //numero de recibo de devolucion
              if(is_null($r1['numrecdev'])){
                $fr=date('Y', strtotime($r1['FechaIni']));
                $cnr=mysqli_query($cone, "SELECT MAX(numrecdev) numrec FROM comservicios WHERE DATE_FORMAT(FechaIni, '%Y')='$fr';");
                if($rnr=mysqli_fetch_assoc($cnr)){
                  $nrec=$rnr['numrec']+1;
                }else{
                  $nrec=1;
                }
                if(!mysqli_query($cone, "UPDATE comservicios SET numrecdev=$nrec WHERE idComServicios=$idcs;")){
                  $nrec="S/N";
                }
              }else{
                $nrec=$r1['numrecdev'];
              }



              $ct=mysqli_query($cone,"SELECT SUM(monto) as tasignado FROM tedetplanillav where idComServicios=$idcs;");
              $cr=mysqli_query($cone,"SELECT SUM(totalcom) as trendido FROM tegasto where idComServicios=$idcs;");
              $tav="";
              $trv="";                         
              if ($rt=mysqli_fetch_assoc($ct)) {             
                $tav=$rt['tasignado'];
              }else{
                $tav=0;
              }
              mysqli_free_result($ct);

              if ($rr=mysqli_fetch_assoc($cr)) {             
                $trv=$rr['trendido'];
              }else{
                $trv=0;
              }
              mysqli_free_result($cr);
              $dev=n_2decimales($tav-$trv);
              $ndev=explode('.', $dev);
 ?>   
<table style="width: 100%; border-collapse: collapse; text-align: center;" align="center">
  <tr>
    <td style="border: 2px solid #777777; padding: 20px 0 20px 30px; border-radius: 15px;">
      <table style="width: 95%; border-collapse: collapse;">
        <tr>
          <td style="width: 32%; text-align: left;"><img src="../../m_images/logompg.png" width="150"></td>
          <th style="width: 32%; text-align: center; font-size: 16px;">ANEXO 05<br>RECIBO DE CAJA</th>
          <td style="width: 32%; font-size: 16px; text-align: right;">N° <?php echo str_pad($nrec, 6, "0", STR_PAD_LEFT); ?></td>
        </tr>
      </table>

      <table style="width: 95%; border-collapse: collapse;">
        <tr>
          <td style="width: 70%;"></td>
          <td style="width: 25%; text-align: right; font-size: 14px;">Fecha: <?php echo date('d/m/Y'); ?></td>
        </tr>
        <tr>
          <td colspan="2" style="height: 15px;"></td>
        </tr>    
        <tr>              
          <td colspan="2" style="text-align: center;">
            <span style="font-size: 14px;">Recibí del Comisionado de la Sede Central y/o <b>Distrito Fiscal de Cajamarca</b><br> la cantidad de <b>S/ <?php echo $dev; ?></b>, (<?php echo convertir($ndev['0'])." con ".$ndev['1']."/100"; ?>)</span> 
          </td>
        </tr>
      </table>
      <br><br>
      <table class="tablep" style="font-size: 13px;">
        <tr>
          <td colspan="3" style="width: 100%; text-align: center; height: 50px;">Por concepto de: Devolución de víaticos <?php echo $r1['origen']." - ".$r1['destino']." - ".$r1['origen']; ?><br>del <?php echo fnormal($r1['FechaIni'])." al ".fnormal($r1['FechaFin']); ?></td>
        </tr>
        <tr>
          <td style="width: 12%; height: 30px;">Apellidos y Nombres:</td>
          <td colspan="2"><?php echo nomempleado($cone, $r1['idEmpleado']); ?></td>
        </tr>
        <tr>
          <td style="height: 30px;">Cargo:</td>
          <td style="width: 43%; font-size: 13px;"><?php echo cargoiec($cone, idecxidexfecha($cone, $r1['idEmpleado'], date('Y-m-d', strtotime($r1['FechaIni'])))) ?></td>
          <td rowspan="2" style="width: 45%"></td>
        </tr>
        <tr>
          <td style="height: 30px;">DNI:</td>
          <td><?php echo $r1['NumeroDoc']; ?></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td style="height: 30px; text-align: center;"><b>Encargado Único del FPPE</b></td>
        </tr>
      </table>


    </td>
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
    $html2pdf=new Html2Pdf('P','A4','es','true','UTF-8', array(5,5,5,3));
    $html2pdf->writeHTML($html);
    $html2pdf->output('Anexo02_Declaracion_Jurada.pdf');

  }else{
    echo "Faltan datos";
  }
mysqli_close($cone);
?>