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
<page backtop="18mm" backbottom="5mm" backleft="2mm" backright="2mm" style="font-size: 9px;"> 
    <page_header> 
      <table class="page_header">
          <tr>
            <td style="width: 20%;">
              <img src="../../m_images/logompg.png" width="150">
            </td>
            <td style="width: 60%; text-align: center;">
                <span style="font-size: 16px;">ANEXO 04</span><br>
                <br>
                <span style="font-size: 12px;">RENDICION DOCUMENTARIA DE VIATICOS / NO VIÁTICOS Y ASIGNACIONES POR COMISION DE SERVICIOS</span><br>
                <br>
                <span style="font-size: 12px;">DISTRITO FISCAL DE CAJAMARCA</span>
                <br><br>
            </td>
            <td style="width: 20%;">                
            </td>
          </tr>          
      </table>
    </page_header> 
    <page_footer> 
      <table class="page_footer">
        <tr>
          <td style="width: 70%; text-align: left">
            (076)-365577 Anexo 1085 | Anexo IP 2410 | Jr. Sor Manuela Gil S/N Urb. La Alameda | Cajamarca-Perú
          </td>
          <td style="width: 30%; text-align: right">
              Página [[page_cu]]/[[page_nb]]
          </td>
        </tr>
      </table>
    </page_footer>      
<?php 
    $c1=mysqli_query($cone,"SELECT cs.FechaIni, cs.FechaFin, cs.idEmpleado, e.NumeroDoc, d.NombreDis FROM comservicios cs INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado INNER JOIN distrito d ON cs.idDistrito=d.idDistrito WHERE idComServicios=$idcs;");
      if($r1=mysqli_fetch_assoc($c1)){
 ?>   
      <table class="st">      
        <tr>
        <td style="width: 5%;"></td>                    
          <td style="width: 90%; text-align: center;">
            <span style="font-size: 12px;">Yo <?php echo nomempleado($cone, $r1['idEmpleado']); ?> identificado con DNI N° <?php echo $r1['NumeroDoc']; ?> en el cargo de <?php echo cargoe($cone, $r1['idEmpleado']); ?>  manifiesto haber efectuado todos los gastos en la comisión de servicios, llevada a cabo a la ciudad de <?php echo $r1['NombreDis']; ?> del <?php echo fnormal($r1['FechaIni']); ?> al <?php echo fnormal($r1['FechaFin']); ?> que a continuación se detallan y sustentan con la documentación que se adjunta al presente.</span> 
          </td>
          <td style="width: 5%;"></td>
        </tr>
      </table>
      <table class="re">
        <tr>
          <td style="width: 50%">            
          </td>
          <td style="width: 50%">
            <table class="tablep">
              <tr>                
                <td rowspan="2" class="ce" style="width: 20%;">Recursos</td>
                <td class="ce" style="width: 20%;">Monto Otorgado</td>
                <td class="ce" style="width: 20%;">Monto Rendido</td>
                <td class="ce" style="width: 20%;">Devolución</td>
                <td class="ce" style="width: 20%;">Saldo</td>
              </tr>
              <tr>                        
                <td>S/</td>
                <td>S/</td>
                <td>S/</td>
                <td>S/</td>
              </tr>       
            </table>
          </td>
        </tr>        
      </table>

      <table class="tablep">
        <tr>
          <td class="ce" rowspan="2" style="width: 2%;">N&deg;</td>
          <td class="ce" rowspan="2" style="width: 7%;">Fecha</td>
          <td class="ce" rowspan="2" style="width: 35%;">Concepto</td>
          <td class="ce" rowspan="2" style="width: 6%;">N&deg; de Comprobante</td>
          <td class="ce" colspan="3" align="center" style="width: 18%;">Vi&aacute;ticos</td> 
          <td class="ce" colspan="4" align="center" style="width: 24%;">Otras Asignaciones</td>                       
          <td class="ce" rowspan="2" align="center" style="width: 8%;">TOTAL</td>
        </tr>
        <tr>
          <td class="ce" style="width: 6%;">Hospedaje</td>
          <td class="ce" style="width: 6%;">Alimentación</td>
          <td class="ce" style="width: 6%;">Movilidad</td>
          <td class="ce" style="width: 8%;">Pasajes Terrestre</td>
          <td class="ce" style="width: 6%;">Combustible</td>
          <td class="ce" style="width: 5%;">TUUA</td>
          <td class="ce" style="width: 5%;">Otros</td>
        </tr>
  <?php 
          $cc=mysqli_query($cone,"SELECT cv.idteconceptov, g.idtegasto, g.fechacom, g.glosacom, tc.abreviatura, cv.conceptov, g.numerocom, g.totalcom FROM tegasto g INNER JOIN tetipocom tc ON tc.idtetipocom=g.idtetipocom INNER JOIN teconceptov cv ON g.idteconceptov=cv.idteconceptov WHERE g.idComServicios=$idcs;");
          if(mysqli_num_rows($cc)>0){
            $n=0;
            $t=0;
            $th=0;
            $ta=0;
            $tm=0;
            $tp=0;
            $tc=0;
            $tt=0;
            $to=0;
            while($rc=mysqli_fetch_assoc($cc)){
              $n++;
              $t=$t+$rc['totalcom'];
              switch ($rc['idteconceptov']) {
                case 10:
                  $th=$th+$rc['totalcom'];
                  break;                
                case 9:
                  $ta=$ta+$rc['totalcom'];
                  break;
                case 11:
                  $tm=$tm+$rc['totalcom'];
                  break;
                case 8:
                  $tp=$tp+$rc['totalcom'];
                  break;
                case 12:
                  $tc=$tc+$rc['totalcom'];
                  break;
                case 13:
                  $tt=$tt+$rc['totalcom'];
                  break;
                case 14:
                  $to=$to+$rc['totalcom'];
                  break;
              }
  ?>
          <tr>
            <td class="ce"><?php echo $n; ?></td>
            <td><?php echo fnormal($rc['fechacom']); ?></td>
            <td><?php echo $rc['conceptov']; ?></td>
            <td class="de"><?php echo $rc['numerocom']; ?></td>
            <td class="de"><?php echo $rc['idteconceptov']==10 ? $rc['totalcom'] : "";?></td>
            <td class="de"><?php echo $rc['idteconceptov']==9  ? $rc['totalcom'] : ""; ?></td>
            <td class="de"><?php echo $rc['idteconceptov']==11 ? $rc['totalcom'] : ""; ?></td>
            <td class="de"><?php echo $rc['idteconceptov']==8  ? $rc['totalcom'] : ""; ?></td>
            <td class="de"><?php echo $rc['idteconceptov']==12 ? $rc['totalcom'] : ""; ?></td>
            <td class="de"><?php echo $rc['idteconceptov']==13 ? $rc['totalcom'] : ""; ?></td>
            <td class="de"><?php echo $rc['idteconceptov']==14 ? $rc['totalcom'] : ""; ?></td>            
            <td class="de" style="mso-number-format:'0.00';"><?php echo $rc['totalcom']; ?></td>
          </tr>
          <?php
              }
            }
            mysqli_free_result($cc);
          ?>
          <tr>
            <td colspan="4">SUB TOTAL RENDICI&Oacute;N DE GASTOS</td>
            <td class="de" style="mso-number-format:'0.00';"><?php echo $th;?></td>
            <td class="de" style="mso-number-format:'0.00';"><?php echo $ta;?></td>
            <td class="de" style="mso-number-format:'0.00';"><?php echo $tm;?></td>
            <td class="de" style="mso-number-format:'0.00';"><?php echo $tp;?></td>
            <td class="de" style="mso-number-format:'0.00';"><?php echo $tc;?></td>
            <td class="de" style="mso-number-format:'0.00';"><?php echo $tt;?></td>
            <td class="de" style="mso-number-format:'0.00';"><?php echo $to;?></td>
            <td class="de" style="mso-number-format:'0.00';"><?php echo $t;?></td>
          </tr>
          <tr>
            <td colspan="4">MONTO ASIGNADO</td>
            <td colspan="7"></td>
            <td class="de" style="mso-number-format:'0.00';"></td>                        
          </tr>
          <tr>
            <td colspan="4">SALDO</td>
            <td colspan="7"></td>
            <td class="de" style="mso-number-format:'0.00';"></td>                        
          </tr>
        </table>
        
        <table class="st">
        <tr> 
          <td style="width: 84%">
            <table class="st">             
              <tr class="ce">
                <td style="width: 10%;">              
                </td>
                <td colspan="2" style="width: 90%;">________________________
                </td>
                                              
              </tr>
              <tr style="text-align: center;">
                <td>                  
                </td>
                <td>Firma del Comisionado</td>
                
              </tr>
              
              <tr>
                <td style="width: 10%;">Nombre:</td>
                <td style="width: 30%;"><?php echo nomempleado($cone, $r1['idEmpleado']); ?></td>    
                
              </tr>
              <tr>
                <td style="width: 10%;">DNI N°:</td>
                <td><?php echo $r1['NumeroDoc']; ?></td>              
                
              </tr>
              <tr>
                <td colspan="2">Ciudad de Cajamarca <?php echo date('d')." de ".nombremes(date('m'))." de ".date('Y')."."; ?></td>      
  
              </tr>                  
              
            </table>

          </td>
          <td style="width: 16%">
            <table class="tablep">
              <tr>
                <td style="width: 50%">Monto Recibido</td>
                <td style="width: 50%">S/</td>
              </tr>
              <tr>
                <td >Monto Rendido</td>
                <td >S/</td>
              </tr>
              <tr>
                <td >Devoluci&oacute;n</td>
                <td >S/</td>
              </tr>
              <tr>
                <td >Total</td>
                <td >S/</td>
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
    $html2pdf=new Html2Pdf('L','A4','es','true','UTF-8', array(5,5,5,3));
    $html2pdf->writeHTML($html);
    $html2pdf->output('Anexo04_Rendicion.pdf');

  }else{
    echo "Faltan datos";
  }
mysqli_close($cone);
?>