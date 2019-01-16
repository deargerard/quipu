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
                <span style="font-size: 16px;">ANEXO 02</span><br>
                <br>
                <span style="font-size: 12px;">DECLARACIÓN JURADA DE VIÁTICOS Y ASIGNACIONES <br> POR COMISION DE SERVICIOS EN EL TERRITORIO NACIONAL</span><br>
                <br>
                <span style="font-size: 12px;"></span>
                
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
          </td>
          <td style="width: 30%; text-align: right">
              Página [[page_cu]]/[[page_nb]]
          </td>
        </tr>
      </table>
    </page_footer>      
<?php 
    $c1=mysqli_query($cone,"SELECT cs.FechaIni, cs.FechaFin, cs.idEmpleado, cs.destino, e.NumeroDoc FROM comservicios cs INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado WHERE idComServicios=$idcs;");
      if($r1=mysqli_fetch_assoc($c1)){
 ?>   
      <table class="st">      
        <tr>
        <td style="width: 5%;"></td>                    
          <td style="width: 90%; text-align: center;">
            <span style="font-size: 12px;">Yo <b><?php echo nomempleado($cone, $r1['idEmpleado']); ?></b> identificado con DNI N° <?php echo $r1['NumeroDoc']; ?> en el cargo de <?php echo cargoe($cone, $r1['idEmpleado']); ?>  del Ministerio Público, DECLARO BAJO JURAMENTO, haber efectuado la comisión de servicios, llevada a cabo a la ciudad de <b><?php echo $r1['destino']; ?></b> del <?php echo fnormal($r1['FechaIni']); ?> al <?php echo fnormal($r1['FechaFin']); ?> en cumplimiento del numeral 71.3 del articulo 71° de la Directiva N° 001-2017-EF/77.15 modificada por Resolución directoral N° 017-2017-EF/77.15, por los siguientes conceptos:</span> 
          </td>
          <td style="width: 5%;"></td>
        </tr>
      </table>
      
      <table class="tablep">
        <tr>
          <td class="ce" rowspan="1" style="width: 2%;">N&deg;</td>
          <td class="ce" rowspan="1" style="width: 10%;">FECHA</td>
          <td class="ce" rowspan="1" style="width: 35%;">DETALLE</td>
          <td class="ce" rowspan="1" style="width: 15%;">IMPORTE</td>
          <td class="ce" rowspan="1" style="width: 38%;">OBSERVACIONES(*)</td>         
        </tr>        
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
  ?>
          <tr>
            <td class="ce">1</td>
            <td><?php echo fnormal($fah); ?></td>
            <td>Alojamiento y Alimentación (*)</td>
            <td class="de"><?php echo $tah==""? "" : n_2decimales($tah);?></td>
            <td rowspan="5" class="de" style="text-align: center;">Estos conceptos solo son aplicables en<br>lugares donde no se emitan comprobantes <br> de pago autorizados por SUNAT.</td>            
          </tr>
          <tr>
            <td class="ce">2</td>
            <td><?php echo fnormal($fml); ?></td>
            <td>Movilidad local</td>
            <td class="de"><?php echo $tml=="" ? "" : n_2decimales($tml); ?></td>
                        
          </tr>
          <tr>
            <td class="ce">3</td>
            <td><?php echo fnormal($fme); ?></td>
            <td>Movilidad de embarque</td>
            <td class="de"><?php echo $tme=="" ? "" : n_2decimales($tme); ?></td>
                       
          </tr>
          <tr>
            <td class="ce">4</td>
            <td><?php echo fnormal($fpt); ?></td>
            <td>Pasaje Terrestre (*)</td>
            <td class="de"><?php echo $tpt=="" ? "" : n_2decimales($tpt); ?></td>
                        
          </tr>

          <tr>
            <td colspan="3">TOTAL S/</td>
            <td class="de"><?php echo $tdj=="" ? "" : n_2decimales($tdj);?></td>            
          </tr>          
        </table>
        <table class="st">
          <tr>
            <td style="width: 50%">
              <span>EN FE DE LO CUAL FIRMO LA PRESENTE DECLARACION</span>
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
            <span>Ciudad de Cajamarca <?php echo date('d')." de ".nombremes(date('m'))." de ".date('Y')."."; ?></span>
          </td>
          <td style="width: 50%">
            <table class="re">             
              <tr>
                <td colspan="2">_________________________________________</td>                                  
              </tr>
              <tr>
                <td colspan="2">Firma del Comisionado  </td>                
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