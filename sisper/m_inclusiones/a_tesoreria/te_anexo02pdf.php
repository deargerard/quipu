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
    table.st {width: 100%; border-collapse: collapse; padding: 30px 0; font-size: 10px;}
    table.re {width: 100%; border-collapse: collapse; padding: 5px 0; font-size: 10px;}
    .de{text-align: right;}
    .ce{text-align: center;}

-->
</style>
<page backtop="35mm" backbottom="6mm" backleft="6mm" backright="5mm" style="font-size: 10px;"> 
    <page_header> 
      <table class="page_header">
          <tr>
            <td style="width: 20%;">
              <img src="../../m_images/logompg.png" width="150">
            </td>
            <th style="width: 60%; text-align: center;">                
            </th>
            <td style="width: 20%;">                
            </td>
          </tr>
          <tr>
            <th colspan="3" style="text-align: center;">
                <span style="font-size: 14px;">ANEXO 02</span><br>
                <br>
                <span style="font-size: 16px;">DECLARACIÓN JURADA DE VIÁTICOS / NO VIÁTICOS Y ASIGNACIONES<br> POR COMISIÓN DE SERVICIOS EN EL TERRITORIO NACIONAL</span><br>
                <br>
                <span style="font-size: 12px;"></span>
            </th>
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
    $c1=mysqli_query($cone,"SELECT cs.FechaIni, cs.FechaFin, cs.idEmpleado, cs.origen, cs.destino, e.NumeroDoc FROM comservicios cs INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado WHERE idComServicios=$idcs;");
      if($r1=mysqli_fetch_assoc($c1)){
 ?>   
 
 <?php 
        $c2=mysqli_query($cone,"SELECT idtegasto, idteconceptov, idtetipocom, totalcom, fechacom FROM tegasto WHERE idtetipocom=2 AND idComServicios=$idcs;");           
        if (mysqli_num_rows($c2)>0) {             
          while ($r2=mysqli_fetch_assoc($c2)) {
            $tdj=$tdj+$r2['totalcom'];                
              switch ($r2['idteconceptov']) {                
                case 9 :
                  $tah=$tah+$r2['totalcom'];
                  $fah=$r2['fechacom'];
                  break;
                case 10 :
                  $tah=$tah+$r2['totalcom'];
                  $fah=$r2['fechacom'];
                  break;                   
                case 11:
                  $tml=$tml+$r2['totalcom'];
                  $fml=$r2['fechacom'];
                  break;
                case 20:
                  $tme=$tme+$r2['totalcom'];
                  $fme=$r2['fechacom'];
                  break;
                case 8:
                  $tpt=$tpt+$r2['totalcom'];
                  $fpt=$r2['fechacom'];
                  break;                   
              }                
          }
        mysqli_free_result($c2);
        }
      
        $texto="Yo, <b>".nomempleado($cone, $r1['idEmpleado'])."</b> identificado con DNI N° <b>".$r1['NumeroDoc']."</b> en el cargo de <b>".cargoe($cone, $r1['idEmpleado'])."</b> del Ministerio Público, DECLARO BAJO JURAMENTO, haber efectuado la comisión de servicios a la ciudad de <b>".$r1['destino']."</b> los días del <b>".fnormal($r1['FechaIni'])."</b> al <b>".fnormal($r1['FechaFin'])."</b>, en cumplimiento del numeral 71.3 del articulo 71° de la Directiva N° 001-2007-EF/77.15, modificada por Resolución directoral N° 017-2007-EF/77.15, por el siguiente importe: <b>".($tdj=="" ? "" : n_2decimales($tdj))."</b>";
  ?>
        <table class="st" style="margin-bottom: 200px;">      
          <tr>                 
            <td style="width: 98%; text-align: justify; font-size: 13px;">
              <div><?php echo wordwrap($texto, 80, "\n", false); ?></div>
            </td>
          </tr>
        </table>
      
        <table class="st">
          <tr>
            <td style="width: 50%;">
              <span>Ciudad de <?php echo $r1['origen'] ?>, <?php echo date('d')." de ".nombremes(date('m'))." de ".date('Y')."."; ?></span>
            </td>
          </tr>
          <tr>
            <td style="width: 50%">
              
            </td>
          </tr>
        </table>

        <table class="st">
          <tr> 
            <td style="width: 50%">
              
            </td>
            <td style="width: 50%">
              <table class="re" style="font-size: 13px;">             
                <tr>
                  <td colspan="2">_________________________________________</td>                                  
                </tr>
                <tr>
                  <td colspan="2">Firma del Comisionado (Manuscrita o digital)</td>                
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>                        
                <tr>
                  <td style="width: 15%;">Nombre:</td>
                  <td style="width: 85%;"><?php echo nomempleado($cone, $r1['idEmpleado']);?></td>               
                </tr>
                <tr>
                  <td style="width: 15%;">DNI N°:</td>
                  <td><?php echo $r1['NumeroDoc']; ?></td>               
                </tr>             
              </table>
            </td>
          </tr>
          <tr>
            <td style="height: 50px;">
            </td>
          </tr>
          <tr>
            <td colspan="2" style="font-size: 12px; text-align: justify;">
            Nota: El documento que se suscribe para sustentar los gastos solo es usado cuando no es posible obtener comprobantes de pago reconocidos y emitidos de conformidad con lo dispuesto por la Superintendencia Nacional de Aduanas y de Administración Tributaria - SUNAT, en el lugar de la comisión de servicio donde no existen restaurantes, hoteles o empresas de transportes formales que otorguen los citados comprobantes. Dicha Declaración Jurada será presentada sólo hasta el 30% del monto total asignado por concepto de viáticos (alimentación, hospedaje y movilidad hacia y desde el lugar de embarque), según lo establecido por el Decreto Supremo N° 007-2013-EF.
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