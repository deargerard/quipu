<?php

include("../php/conexion_sp.php");
include("../php/funciones.php");
require '../../m_exportar/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;


  if(isset($_GET['idcs']) && !empty($_GET['idcs'])){
    $idcs=iseguro($cone,$_GET['idcs']);   
ob_start();
      $fecha = @date("dmYHis");
		  

?>
        <style type="text/css">
          .tabla {
              border-collapse: collapse;
          }

          .tabla>th>td {
              border: 1px solid black;
          }
          .tsb{
              border: none;
          }
        </style>

        <page backtop="18mm" backbottom="5mm" backleft="2mm" backright="2mm" style="font-size: 9px;"> 
            <page_header> 
                <table class="page_header">
                    <tr>
                    	<td style="width: 20%;">
                    		<img src="../../m_images/logo.png" width="150">
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




<?php       echo $idcs."--".$fecha;
 ?>











        </page> 
<?php
		$html=ob_get_clean();
		$html2pdf=new Html2Pdf('P','A4','es','true','UTF-8', array(5,5,5,1));
		$html2pdf->writeHTML($html);
		$html2pdf->output('formato04.pdf');


  }else{
    echo "Faltan datos";
  }

mysqli_close($cone);
?>