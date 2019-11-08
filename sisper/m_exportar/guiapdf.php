<?php
	include_once '../m_inclusiones/php/conexion_sp.php';
	include_once '../m_inclusiones/php/funciones.php';
	require __DIR__.'/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;

if(isset($_GET['guia']) && !empty($_GET['guia'])){
	$guia=iseguro($cone,$_GET['guia']);
	$cg=mysqli_query($cone, "SELECT * FROM tdguia WHERE idtdguia=$guia;");
	if($rg=mysqli_fetch_assoc($cg)){
		ob_start();
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
            		<img src="../m_images/logompg.png" width="150">
            	</td>
                <td style="width: 60%; text-align: center;">
                    <span style="font-size: 16px;">GUÍA DE REMISIÓN DE DOCUMENTOS</span><br>
                    <span style="font-size: 12px;"><?php echo nommpartes($cone, $rg['idtdmesapartesg']); ?> - DISTRITO FISCAL DE CAJAMARCA</span>
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
            		Ministerio Público | Distrito Fiscal de Cajamarca | (076)-365577
            	</td>
                <td style="width: 30%; text-align: right">
                    Página [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
    <table class="st">
    	<tr>
    		<td style="width: 45%; text-align: left;">DESTINO: <b><?php echo nommpartes($cone, $rg['idtdmesapartesd']); ?></b></td>
    		<td style="width: 10%; text-align: center;">GUÍA: <b><?php echo $rg['numero']."-".$rg['anio']; ?></b></td>
    		<td style="width: 45%; text-align: right;">F. ENVIO: <b><?php echo date("d/m/Y", strtotime($rg['fecenvio'])); ?></b></td>
    	</tr>
    </table>
	<table class="tablep">
<?php
		$cdg=mysqli_query($cone,"SELECT d.*, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE ed.idtdguia=$guia AND d.cargo=0;");
		if(mysqli_num_rows($cdg)>0){
?>
		<tr>
			<th colspan="10" style="width: 100%; text-align: center; background-color: #AAAAAA; color: #FFFFFF;">PARA DELIGENCIAMIENTO</th>
		</tr>
		<tr>
			<th style="width: 2%;" align="center" valign="middle">N°</th>
			<th style="width: 3%;" align="center" valign="middle">DOC</th>
			<th style="width: 7%;" align="center" valign="middle">TIPO DOC.</th>
			<th style="width: 11%;" align="center" valign="middle">DOCUM. N°</th>
			<th style="width: 16%;" valign="middle">DEPENDENCIA ORIGEN</th>
			<th style="width: 16%;" valign="middle">NOMBRE REMITENTE</th>
			<th style="width: 16%;" valign="middle">LUG. O DEPENDENCIA DESTINO</th>
			<th style="width: 16%;" valign="middle">NOMBRE DESTINATARIO</th>
		</tr>
<?php
			$n=0;
			while($rdg=mysqli_fetch_assoc($cdg)){
				$n++;
?>
		<tr>
			<td align="center"><?php echo ' <small>'.$n.'</small>'; ?></td>
			<td align="center"><?php echo ' <small>'.$rdg['numdoc'].'</small>'; ?></td>
			<td align="center"><?php echo wordwrap(html_entity_decode($rdg['TipoDoc']),16,"<br/>\n",true); ?></td>
			<td align="center"><?php echo wordwrap(html_entity_decode($rdg['Numero'].'-'.$rdg['Ano'].'-'.$rdg['Siglas']),22,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(!is_null($rdg['deporigenint']) ? abrdependencia($cone, $rdg['deporigenint']) : $rdg['deporigenext']),38,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(!is_null($rdg['remitenteint']) ? nomempleado($cone, $rdg['remitenteint']) : $rdg['remitenteext']),38,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(!is_null($rdg['depdestinoint']) ? abrdependencia($cone, $rdg['depdestinoint']) : $rdg['depdestinoext']),38,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(!is_null($rdg['destinatarioint']) ? nomempleado($cone, $rdg['destinatarioint']) : $rdg['destinatarioext']),38,"<br/>\n",true); ?></td>
		</tr>
<?php
			}
		}
		mysqli_free_result($cdg);
		$cdg1=mysqli_query($cone,"SELECT d.*, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc INNER JOIN tdestadodoc ed ON d.idDoc=ed.idDoc WHERE ed.idtdguia=$guia AND d.cargo=1;");
		if(mysqli_num_rows($cdg1)>0){
?>
		<tr>
			<th colspan="10" style="width: 100%; text-align: center; background-color: #AAAAAA; color: #FFFFFF;">PARA DEVOLVER CARGOS DELIGENCIADOS</th>
		</tr>
		<tr>
			<th style="width: 2%;" align="center" valign="middle">N°</th>
			<th style="width: 3%;" align="center" valign="middle">DOC</th>
			<th style="width: 7%;" align="center" valign="middle">TIPO DOC.</th>
			<th style="width: 11%;" align="center" valign="middle">DOCUM. N°</th>
			<th style="width: 16%;" valign="middle">DEPENDENCIA ORIGEN</th>
			<th style="width: 16%;" valign="middle">NOMBRE REMITENTE</th>
			<th style="width: 16%;" valign="middle">LUG. O DEPENDENCIA DESTINO</th>
			<th style="width: 16%;" valign="middle">NOMBRE DESTINATARIO</th>
		</tr>
<?php
			$n=0;
			while($rdg1=mysqli_fetch_assoc($cdg1)){
				$n++;
?>
		<tr>
			<td align="center"><?php echo $n; ?></td>
			<td align="center"><?php echo ' <small>'.$rdg1['numdoc'].'</small>'; ?></td>
			<td align="center"><?php echo wordwrap(html_entity_decode($rdg1['TipoDoc']),16,"<br/>\n",true); ?></td>
			<td align="center"><?php echo wordwrap(html_entity_decode((!is_null($rdg1['Numero']) ? $rdg1['Numero'].'-' : '').$rdg1['Ano'].(!is_null($rdg1['Siglas']) ? '-'.$rdg1['Siglas'] : '')),22,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(!is_null($rdg1['deporigenint']) ? abrdependencia($cone, $rdg1['deporigenint']) : $rdg1['deporigenext']),36,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(!is_null($rdg1['remitenteint']) ? nomempleado($cone, $rdg1['remitenteint']) : $rdg1['remitenteext']),36,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(!is_null($rdg1['depdestinoint']) ? abrdependencia($cone, $rdg1['depdestinoint']) : $rdg1['depdestinoext']),36,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(!is_null($rdg1['destinatarioint']) ? nomempleado($cone, $rdg1['destinatarioint']) : $rdg1['destinatarioext']),36,"<br/>\n",true); ?></td>
		</tr>
<?php
			}
		}
		mysqli_free_result($cdg1);
?>
	</table>
	<span>DEVOLVER CARGO EXTERNO CON COURIER</span>

</page> 
<?php
		$html=ob_get_clean();

		$html2pdf=new Html2Pdf('L','A4','es','true','UTF-8', array(5,5,5,3));
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