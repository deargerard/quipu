<?php
	include 'cone.php';
	include 'func.php';
	include '../const.php';
	require __DIR__.'/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;

if(isset($_GET['guia']) && !empty($_GET['guia'])){
	$guia=iseguro($cone,$_GET['guia']);
	$cg=mysqli_query($cone, "SELECT g.*, d.Destino FROM guia g INNER JOIN destino d ON d.idDestino=g.idDestino WHERE idGuia=$guia;");
	if($rg=mysqli_fetch_assoc($cg)){
		ob_start();
		//require_once '../m_inclusiones/a_asistencia/pdfasistencia.php';
?>
<style type="text/css">
<!--
    table.page_header {width: 100%; border: none; padding: 2mm }
    table.page_footer {width: 100%; border: none; padding: 1mm; font-size: 10px;}
    table.tablep {width: 100%; border-collapse: collapse;}
    table.tablep th, table.tablep td {border: 1px solid #AAAAAA; padding: 2px; white-space: nowrap; word-break: break-all;}
    table.st {width: 100%; border-collapse: collapse; padding: 5px 0; font-size: 10px;}

-->
</style>
<page backtop="18mm" backbottom="5mm" backleft="2mm" backright="2mm" style="font-size: 9px;"> 
    <page_header> 
        <table class="page_header">
            <tr>
            	<td style="width: 20%;">
            		<img src="../img/logompg.png" width="150">
            	</td>
                <td style="width: 60%; text-align: center;">
                    <span style="font-size: 16px;">GUÍA DE REMISIÓN DE DOCUMENTOS</span><br>
                    <span style="font-size: 12px;">OFICINA CENTRAL DE NOTIFICACIONES - DISTRITO FISCAL DE CAJAMARCA</span>

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
    <table class="st">
    	<tr>
    		<td style="width: 50%; text-align: left;">DESTINO: <?php echo $rg['Destino']; ?></td>
    		<td style="width: 50%; text-align: right;">GUÍA: <?php echo $guia."-".date("Y",strtotime($rg['Fecha'])); ?></td>
    	</tr>
    </table>
	<table class="tablep">
<?php
		$cdg=mysqli_query($cone,"SELECT d.*, td.Tipo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE idGuia=$guia AND Cargo=0;");
		if(mysqli_num_rows($cdg)>0){
?>
		<tr>
			<th colspan="9" style="width: 100%; text-align: center; background-color: #AAAAAA; color: #FFFFFF;">PARA DELIGENCIAMIENTO</th>
		</tr>
		<tr>
			<th style="width: 3%;" align="center" valign="middle">N°</th>
			<th style="width: 3%;" align="center" valign="middle">GUIA N°</th>
			<th style="width: 8%;" align="center" valign="middle">TIPO DOC.</th>
			<th style="width: 8%;" align="center" valign="middle">DOCUM. N°</th>
			<th style="width: 15%;" valign="middle">DEPENDENCIA ORIGEN</th>
			<th style="width: 15%;" valign="middle">NOMBRE REMITENTE</th>
			<th style="width: 15%;" valign="middle">LUG. O DEPENDENCIA DESTINO</th>
			<th style="width: 15%;" valign="middle">NOMBRE DESTINATARIO</th>
			<th style="width: 5%;" align="center" valign="middle">F. ENVIO</th>
		</tr>
<?php
			$n=0;
			while($rdg=mysqli_fetch_assoc($cdg)){
				$n++;
?>
		<tr>
			<td align="center"><?php echo $n; ?></td>
			<td align="center"><?php echo $guia; ?></td>
			<td align="center"><?php echo wordwrap(html_entity_decode($rdg['Tipo']),16,"<br/>\n",true); ?></td>
			<td align="center"><?php echo wordwrap(html_entity_decode($rdg['Numero']),16,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode($rdg['Origen']),36,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap($rdg['Remitente'],36,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap($rdg['Destino'],36,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap($rdg['Destinatario'],36,"<br/>\n",true); ?></td>
			<td align="center"><?php echo date("d/m/Y", strtotime($rg['Fecha'])); ?></td>
		</tr>
<?php
			}
		}
		mysqli_free_result($cdg);
		$cdg1=mysqli_query($cone,"SELECT d.*, td.Tipo FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE idGuia=$guia AND Cargo=1;");
		if(mysqli_num_rows($cdg1)>0){
?>
		<tr>
			<th colspan="9" style="width: 100%; text-align: center; background-color: #AAAAAA; color: #FFFFFF;">PARA DEVOLVER CARGOS DELIGENCIADOS</th>
		</tr>
		<tr>
			<th style="width: 3%;" align="center" valign="middle">N°</th>
			<th style="width: 3%;" align="center" valign="middle">GUIA N°</th>
			<th style="width: 8%;" align="center" valign="middle">TIPO DOC.</th>
			<th style="width: 8%;" align="center" valign="middle">DOCUM. N°</th>
			<th style="width: 15%;" valign="middle">DEPENDENCIA ORIGEN</th>
			<th style="width: 15%;" valign="middle">NOMBRE REMITENTE</th>
			<th style="width: 15%;" valign="middle">LUG. O DEPENDENCIA DESTINO</th>
			<th style="width: 15%;" valign="middle">NOMBRE DESTINATARIO</th>
			<th style="width: 5%;" align="center" valign="middle">F. ENVIO</th>
		</tr>
<?php
			$n=0;
			while($rdg1=mysqli_fetch_assoc($cdg1)){
				$n++;
?>
		<tr>
			<td align="center"><?php echo $n; ?></td>
			<td align="center"><?php echo $guia; ?></td>
			<td align="center"><?php echo wordwrap(html_entity_decode($rdg1['Tipo']),16,"<br/>\n",true); ?></td>
			<td align="center"><?php echo wordwrap(html_entity_decode($rdg1['Numero']),16,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode($rdg1['Origen']),36,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode($rdg1['Remitente']),36,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode($rdg1['Destino']),36,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode($rdg1['Destinatario']),36,"<br/>\n",true); ?></td>
			<td align="center"><?php echo date("d/m/Y", strtotime($rg['Fecha'])); ?></td>
		</tr>
<?php
			}
		}
		mysqli_free_result($cdg1);
?>
	</table>
	<p>DEVOLVER CARGO EXTERNO CON CURIER</p>

</page> 
<?php
		$html=ob_get_clean();

		$html2pdf=new Html2Pdf('L','A4','es','true','UTF-8', array(5,5,5,2));
		$html2pdf->writeHTML($html);
		$html2pdf->output('guia.pdf');
	}else{
		echo mensajeda("Datos invalidos.");
	}
	mysqli_free_result($cg);
}else{
	echo mensajeda("Error: No se enviaron los datos.");
}
mysqli_close($cone);
?>
