<?php
  include_once '../php/conexion_sp.php';
  include_once '../php/funciones.php';
  require '../../m_exportar/vendor/autoload.php';
  use Spipu\Html2Pdf\Html2Pdf;

if(isset($_GET['idcs']) && !empty($_GET['idcs'])){
    ob_start();
?>
<style type="text/css">
<!--
    table.page_header {width: 100%; border: none; padding: 2mm }
    table.page_footer {width: 100%; border: none; padding: 1mm; font-size: 10px;}
    table.tablep {width: 100%; border-collapse: collapse; font-size: 13px;}
    table.tablep th, table.tablep td {border: 1px solid #AAAAAA; padding: 2px; white-space: nowrap; word-break: break-all;}
    table.st {width: 100%; border-collapse: collapse; padding: 5px 0; font-size: 10px;}
    table.tablec {width: 100%; border-collapse: collapse; font-size: 10px;}
    table.tablec th, table.tablec td {border: 1px solid #AAAAAA; padding: 2px; white-space: nowrap; word-break: break-all;}

-->
</style>
<page backtop="18mm" backbottom="5mm" backleft="2mm" backright="2mm" style="font-size: 9px;"> 
    <page_header> 
        <table class="page_header">
            <tr>
              <td style="width: 20%;">
                <img src="../../m_images/logo.png" width="150">
              </td>
                <td style="width: 60%; text-align: center;">
                    <span style="font-size: 14px;">ANEXO 07</span><br>
                    <span style="font-size: 11px;">PLANILLA DE COMISIÓN DE SERVICIOS QUE NO IMPLICA VIÁTICOS</span>

                </td>
                <td style="width: 20%;">
                  <table class="tablec" align="center">
                    <tr>
                      <td style="width: 40%;" align="center">N°</td>
                      <td style="width: 50%;"></td>
                    </tr>
                  </table>
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
$v1=iseguro($cone, $_GET['idcs']);
$cc=mysqli_query($cone, "SELECT cs.*, d.Numero, d.Ano, d.Siglas, e.ApellidoPat, e.ApellidoMat, e.Nombres, e.NumeroDoc, td.TipoDoc FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado INNER JOIN tipodoc td ON d.idTipoDoc=d.idTipoDoc WHERE idComServicios=$v1;");
  if($rc=mysqli_fetch_assoc($cc)){
    $idec=idecxidexfecha($cone, $rc['idEmpleado'], date('Y-m-d', strtotime($rc['FechaIni'])));
    //calculamos el numerde horas
    $d1=new DateTime($rc['FechaIni']);
    $d2=new DateTime($rc['FechaFin']);
    $dif=$d1->diff($d2);
    $ho=(($dif->days)*60)+$dif->h;
?>
  <table class="tablec">
    
    <tr>
      <th>APELLIDOS</th>
      <td colspan="3" align="center"><?php echo $rc['ApellidoPat']." ".$rc['ApellidoMat']; ?></td>
      <th>NOMBRES</th>
      <td align="center"><?php echo $rc['Nombres']; ?></td>
    </tr>
    <tr>
      <th>DEPENDENCIA</th>
      <td colspan="3" align="center"><?php echo substr(html_entity_decode(dependenciaxiecxfecha($cone, $idec, date('Y-m-d', strtotime($rc['FechaIni'])))),0,60); ?></td>
      <th>REGIMEN</th>
      <td align="center"><?php echo condicionlabxiec($cone, $idec); ?></td>
    </tr>
    <tr>
      <th>MNEMÓNICO</th>
      <td align="center"><?php echo $rc['mnemonico']; ?></td>
      <th>CARGO</th>
      <td colspan="3" align="center"><?php echo cargoiec($cone, idecxidexfecha($cone, $rc['idEmpleado'], date('Y-m-d', strtotime($rc['FechaIni'])))); ?></td>
    </tr>
    <tr>
      <th>DOC. DE AUTORIZACIÓN</th>
      <td colspan="5" align="center"><?php echo substr($rc['TipoDoc'],0,3).". ".$rc['Numero']."-".$rc['Ano']."-".$rc['Siglas']; ?></td>
    </tr>
    <tr>
      <th>MOTIVO DE LA COMISIÓN</th>
      <td colspan="5" align="center"></td>
    </tr>
    <tr>
      <th>LUGAR DE LA COMISIÓN</th>
      <td colspan="5" align="center"><?php echo disprodep($cone, $rc['idDistrito']); ?></td>
    </tr>
    <tr>
      <td colspan="6"></td>
    </tr>
    <tr>
      <td colspan="2"><b>FECHA SALIDA:</b> <?php echo date('d/m/Y', strtotime($rc['FechaIni'])); ?> <b>Hora:</b> <?php echo date('H:i', strtotime($rc['FechaIni'])); ?> Horas</td>
      <td colspan="3"><b>FECHA DE REGRESO:</b> <?php echo date('d/m/Y', strtotime($rc['FechaFin'])); ?> <b>Hora:</b> <?php echo date('H:i', strtotime($rc['FechaFin'])); ?> Horas</td>
      <td align="center"><b>Total Horas:</b> <?php echo $ho; ?></td>
    </tr>
    <tr>
      <th colspan="5" align="center">CONCEPTO</th>
      <th align="center">TOTAL (S/)</th>
    </tr>
<?php
  $cco=mysqli_query($cone, "SELECT idteconceptov, conceptov FROM teconceptov WHERE nanexo=7 AND estado=1;");
  if(mysqli_num_rows($cco)>0){
    $su=0;
    while($rco=mysqli_fetch_assoc($cco)){
      $idco=$rco['idteconceptov'];
?>
    <tr>
      <td colspan="5"><?php echo $rco['conceptov']; ?></td>
<?php
      $cdp=mysqli_query($cone, "SELECT monto FROM tedetplanillav WHERE idComServicios=$v1 AND idteconceptov=$idco AND dia=1;");
      if($rdp=mysqli_fetch_assoc($cdp)){
        $m=$rdp['monto'];
      }else{
        $m=0;
      }
      $su=$su+$m;
?>
      <td align="right"><?php echo $m!=0 ? $m : ""; ?></td>
    </tr>
<?php
    }
  }
?>
    <tr>
      <th colspan="5" align="center">TOTAL</th>
      <th align="right"><?php echo n_2decimales($su); ?></th>
    </tr>
    <tr>
      <td colspan="6"></td>
    </tr>
    <tr>
      <td colspan="3" height="100"></td>
      <td colspan="3" height="100"></td>
    </tr>
    <tr>
      <th colspan="3" align="center">FIRMA DEL COMISIONADO</th>
      <th colspan="3" align="center">ENCARGADO ÚNICO DEL MANEJO DEL FPPE</th>
    </tr>


    <tr>
      <td style="width: 19%;"></td>
      <td style="width: 21%;"></td>
      <td style="width: 15%;"></td>
      <td style="width: 10%;"></td>
      <td style="width: 15%;"></td>
      <td style="width: 20%;"></td>
    </tr>
  </table>
<?php
  }
?>
















</page> 
<?php
    $html=ob_get_clean();

    $html2pdf=new Html2Pdf('P','A4','es','true','UTF-8', array(7,7,7,3));
    $html2pdf->writeHTML($html);
    $html2pdf->output('Anexo01.pdf');



}else{
  echo mensajeda("Error: No se enviaron los datos.");
}
mysqli_close($cone);
?>