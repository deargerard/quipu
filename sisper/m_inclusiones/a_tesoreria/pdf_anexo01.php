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
<page backtop="20mm" backbottom="5mm" backleft="2mm" backright="2mm" style="font-size: 9px;">
<?php
$v1=iseguro($cone, $_GET['idcs']);
$cc=mysqli_query($cone, "SELECT cs.*, d.Numero, d.Ano, d.Siglas, e.ApellidoPat, e.ApellidoMat, e.Nombres, e.NumeroDoc, td.TipoDoc FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado INNER JOIN tipodoc td ON d.idTipoDoc=d.idTipoDoc WHERE idComServicios=$v1;");
  if($rc=mysqli_fetch_assoc($cc)){
    $idec=idecxidexfecha($cone, $rc['idEmpleado'], date('Y-m-d', strtotime($rc['FechaIni'])));
    //calculamos el numerde horas
    $d1=new DateTime($rc['FechaIni']);
    $d2=new DateTime($rc['FechaFin']);
    $dif=$d1->diff($d2);
    $ho=($dif->days)*60+$dif->h;
?>
    <page_header> 
        <table class="page_header">
            <tr>
              <td style="width: 20%;">
                <img src="../../m_images/logo.png" width="150">
              </td>
                <th style="width: 60%; text-align: center;">
                    <span style="font-size: 14px;">ANEXO 01</span><br>
                    <span style="font-size: 11px;">PLANILLA DE VIÁTICOS Y ASIGNACIONES POR COMISIÓN DE SERVICIOS</span>

                </th>
                <td style="width: 20%;">
                  <table class="tablec" align="center">
                    <tr>
                      <td style="width: 40%;" align="center">N°</td>
                      <td style="width: 50%;" align="center"><?php echo $rc['csivia']; ?></td>
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

  <table class="tablec">
    <tr>
      <th style="width: 18%;" bgcolor="#EAF1DD">Apellidos y Nombres</th>
      <td colspan="8" align="center" style="font-size: 12px;"><?php echo $rc['ApellidoPat']." ".$rc['ApellidoMat']." ".$rc['Nombres']; ?></td>
    </tr>
    <tr>
      <th bgcolor="#EAF1DD">Dependencia</th>
      <td colspan="3" align="center"><?php echo substr(html_entity_decode(dependenciaxiecxfecha($cone, $idec, date('Y-m-d', strtotime($rc['FechaIni'])))),0,60); ?></td>
      <th colspan="2" bgcolor="#EAF1DD">D.N.I.</th>
      <td colspan="3" align="center"><?php echo $rc['NumeroDoc']; ?></td>
    </tr>
    <tr>
      <th bgcolor="#EAF1DD">Cargo</th>
      <td colspan="3" align="center"><?php echo cargoiec($cone, idecxidexfecha($cone, $rc['idEmpleado'], date('Y-m-d', strtotime($rc['FechaIni'])))); ?></td>
      <th colspan="2" bgcolor="#EAF1DD">Régimen</th>
      <td colspan="3" align="center"><?php echo condicionlabxiec($cone, $idec); ?></td>
    </tr>
    <tr>
      <th bgcolor="#EAF1DD">Mnemonico</th>
      <td align="center"><?php echo $rc['mnemonico']; ?></td>
      <th colspan="2" bgcolor="#EAF1DD">N° de Cuenta</th>
      <td colspan="5" align="center"></td>
    </tr>
    <tr>
      <th bgcolor="#EAF1DD">Lugar de la comisión</th>
      <td style="width: 33%;" align="center"><?php echo $rc['destino']; ?></td>
      <th colspan="2" bgcolor="#EAF1DD">Doc. Autoriza</th>
      <td colspan="5" align="center"><?php echo substr($rc['TipoDoc'],0,3).". ".$rc['Numero']."-".$rc['Ano']."-".$rc['Siglas']; ?></td>
    </tr>
    <tr>
      <th bgcolor="#EAF1DD">Motivo de la comisión</th>
      <td colspan="9" align="center"></td>
    </tr>
    <tr>
      <th bgcolor="#EAF1DD">Fecha salida</th>
      <td align="center"><?php echo date('d/m/Y', strtotime($rc['FechaIni'])); ?></td>
      <th colspan="2" bgcolor="#EAF1DD">Fecha retorno</th>
      <td colspan="3" align="center"><?php echo date('d/m/Y', strtotime($rc['FechaFin'])); ?></td>
      <th colspan="2" align="center" bgcolor="#EAF1DD">TOTAL HORAS</th>
    </tr>
    <tr>
      <th bgcolor="#EAF1DD">Hora salida</th>
      <td align="center"><?php echo date('H:i', strtotime($rc['FechaIni'])); ?> Horas</td>
      <th colspan="2" bgcolor="#EAF1DD">Hora retorno</th>
      <td colspan="3" align="center"><?php echo date('H:i', strtotime($rc['FechaFin'])); ?> Horas</td>
      <td colspan="2" align="center"><?php echo $ho; ?></td>
    </tr>
    <tr>
      <td colspan="9" style="border-left: none; border-right: none;"></td>
    </tr>
    <tr>
      <th colspan="2" align="center" bgcolor="#D7E4BC">CONCEPTO</th>
      <th colspan="6" align="center" bgcolor="#D7E4BC">DÍAS</th>
      <th rowspan="2" style="width: 7%;" align="center" bgcolor="#D7E4BC">TOTAL</th>
    </tr>
    <tr>
      <th colspan="2">Viáticos</th>
      <th style="width: 7%;" align="center">
        <?php
        if(date('G',strtotime($rc['FechaIni']))>18){
          $feci=sumdias($rc['FechaIni'],1);
          echo date('d', strtotime($feci));
        }else{
          $feci=date('Y-m-d', strtotime($rc['FechaIni']));
          echo date('d', strtotime($feci));
        }
        ?>
      </th>
      <th style="width: 7%;" align="center">
        <?php
          if(date('Y-m-d', strtotime($rc['FechaFin']))>=sumdias($feci, 1)){
            echo date('d', strtotime(sumdias($feci, 1)));
          }else{
            echo 2;
          }
        ?>
      </th>
      <th style="width: 7%;" align="center">
        <?php
          if(date('Y-m-d', strtotime($rc['FechaFin']))>=sumdias($feci, 2)){
            echo date('d', strtotime(sumdias($feci, 2)));
          }else{
            echo 3;
          }
        ?>
      </th>
      <th style="width: 7%;" align="center">
        <?php
          if(date('Y-m-d', strtotime($rc['FechaFin']))>=sumdias($feci, 3)){
            echo date('d', strtotime(sumdias($feci, 3)));
          }else{
            echo 4;
          }
        ?>
      </th>
      <th style="width: 7%;" align="center">
        <?php
          if(date('Y-m-d', strtotime($rc['FechaFin']))>=sumdias($feci, 4)){
            echo date('d', strtotime(sumdias($feci, 4)));
          }else{
            echo 5;
          }
        ?>
      </th>
      <th style="width: 7%;" align="center">
        <?php
          if(date('Y-m-d', strtotime($rc['FechaFin']))>=sumdias($feci, 5)){
            echo date('d', strtotime(sumdias($feci, 5)));
          }else{
            echo 6;
          }
        ?>
      </th>
    </tr>
<?php
    $cco=mysqli_query($cone, "SELECT idteconceptov, conceptov FROM teconceptov WHERE nanexo=1 AND tipo=1;");
    if(mysqli_num_rows($cco)>0){
      $sv1=array();
      while($rco=mysqli_fetch_assoc($cco)){
        $idco=$rco['idteconceptov'];
?>
    <tr>
      <td colspan="2"><?php echo $rco['conceptov']; ?></td>
<?php
        $sh1=0;
        for ($i=1; $i < 7; $i++) {
          $cc1=mysqli_query($cone, "SELECT monto FROM tedetplanillav WHERE idComServicios=$v1 AND idteconceptov=$idco AND dia=$i;");
          if($rc1=mysqli_fetch_assoc($cc1)){
            $mc1=$rc1['monto'];
          }else{
            $mc1=0;
          }
          mysqli_free_result($cc1);
          $sh1=$sh1+$mc1;
          $sv1[$i]=$sv1[$i]+$mc1;
?>
      <td align="right"><?php echo ($mc1!=0 ? n_2decimales($mc1) : ""); ?></td>
<?php
        }
        
?>
      <td align="right"><?php echo n_2decimales($sh1); ?></td>
    </tr>
<?php
      }
    }
    mysqli_free_result($cco);
?>
    <tr bgcolor="#D7E4BC">
      <th colspan="2" align="right">SUB TOTAL</th>
      <th align="right"><?php echo n_2decimales($sv1[1]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[2]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[3]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[4]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[5]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[6]); ?></th>
      <th align="right"><?php echo n_2decimales(array_sum($sv1)); ?></th>
    </tr>
<?php
    $coc=mysqli_query($cone, "SELECT idteconceptov, conceptov FROM teconceptov WHERE nanexo=1 AND tipo=2;");
    if(mysqli_num_rows($coc)>0){
      $nf=mysqli_num_rows($coc);
      $ti=true;
      $sv2=array();
      while ($roc=mysqli_fetch_assoc($coc)){
        $idoco=$roc['idteconceptov'];
?>
    <tr>
      <?php
      if($ti){ 
      ?>
      <th rowspan="<?php echo $nf; ?>" bgcolor="#EAF1DD">Otras Asignaciones-<?php echo $v1; ?></th>
      <?php
      }
?>
      <td><?php echo $roc['conceptov']; ?></td>
<?php
      $sh2=0;
      for ($j=1; $j < 7; $j++) { 
          $cc2=mysqli_query($cone, "SELECT monto FROM tedetplanillav WHERE idComServicios=$v1 AND idteconceptov=$idoco AND dia=$j;");
          if($rc2=mysqli_fetch_assoc($cc2)){
            $mc2=$rc2['monto'];
          }else{
            $mc2=0;
          }
          mysqli_free_result($cc2);
          $sh2=$sh2+$mc2;
          $sv2[$j]=$sv2[$j]+$mc2;
?>
      <td align="right"><?php echo ($mc2!=0 ? n_2decimales($mc2) : ""); ?></td>
<?php
      }
      ?>
      <td align="right"><?php echo n_2decimales($sh2); ?></td>
    </tr>
<?php
        $ti=false;
      }
    }
?>
    <tr bgcolor="#D7E4BC">
      <th colspan="2" align="right">TOTAL</th>
      <th align="right"><?php echo n_2decimales($sv1[1]+$sv2[1]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[2]+$sv2[2]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[3]+$sv2[3]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[4]+$sv2[4]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[5]+$sv2[5]); ?></th>
      <th align="right"><?php echo n_2decimales($sv1[6]+$sv2[6]); ?></th>
      <th align="right"><?php echo n_2decimales(array_sum($sv1)+array_sum($sv2)); ?></th>
    </tr>
    <tr>
      <td colspan="9">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" height="100"></td>
      <td colspan="7" height="100"></td>
    </tr>
    <tr>
      <th colspan="2" align="center">Firma del comisionado</th>
      <th colspan="7" align="center">Sello de Pagado y Firma del Encargado Único del FPPE</th>
    </tr>
    <tr>
      <td colspan="9" style="border-left: none; border-right: none;"></td>
    </tr>
    <tr>
      <td colspan="9">
        <b>NOTA:</b><br>
        <p>a) La Rendición de Cuentas deberá ser presentada dentro de los 05 días calendario después de culminada la comisión. Y cuando dicha Comisión sea en el exterior el plazo máximo para presentar la rendición es de 10 días calendario. Art. 68.3 de la Directiva de Tesorería N° 001-2007-EF/77.15, aprobado con Resolución Directoral N° 002-2007-EF/77.15. <b>En caso de incumplimiento autorizo se me establezca responsabilidad económica y se descuente de mis remuneraciones y/o Honorarios Profesionales (CAS) en caso de no justificar el importe recibido y/o ser sancionado conforme al Reglamento Interno de Trabajo</b>.</p>
        <p>b) Por razones de cierre del Ejercicio Presupuestal del año en curso, la atención de viáticos se efectuará solo hasta el 16 de diciembre.</p>
        <p>c) De existir saldo, el comisionado debe devolver el dinero dentro de los cinco (05) días calendario contados desde la culminación de la comisión, a la dependencia que le asigno los fondos, recibiendo a cambio el "Recibo de Caja" correspondiente.</p>
        <p>d) La Declaración Jurada solo será aplicable por concepto de movilidad Local y movilidad de embarque, utilizando para ello el formato de "Declaración Jurada de Viáticos y Asignaciones por Comisión de Servicios en el Territorio Nacional" - Anexo 02.</p>
        <p>e) Los Gastos de Alojamiento y Alimentación, así como cualquier otra asignación adicional, deberán ser sustentados con documentos reconocidos por SUNAT (Factura, Boletas de Ventas, Tickets electrónicos, etc.). Emitidos a nombre del Ministerio Público, Utilizando el Formato de Rendición documentaria (Anexo 04), en caso la comisión de servicios tenga el carácter de reservado o por motivos de seguridad del comisionado, podrán ser emitidos a nombre del comisionado.</p>
        <p>f) En caso de existir comisionados que tengan viáticos pendientes de rendición, no se le otorgaran más fondos hasta que rinda lo adeudado.</p>
        <p>g) El Gasto en Alojamiento es obligatorio, caso contrario procederá a devolver el equivalente a 100 soles por día no sustentado.</p>
      </td>
    </tr>
  </table>
<?php
  }
  mysqli_free_result($cc);
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