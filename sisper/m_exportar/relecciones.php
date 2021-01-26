<?php
	include_once '../m_inclusiones/php/conexion_sp.php';
	include_once '../m_inclusiones/php/funciones.php';
	require __DIR__.'/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;

if(isset($_GET['eleccion']) && !empty($_GET['eleccion'])){
	$v1=iseguro($cone,$_GET['eleccion']);
	$ce=mysqli_query($cone, "SELECT * FROM elecciones WHERE id=$v1");
	if($re=mysqli_fetch_assoc($ce)){
		ob_start();
?>
<style type="text/css">
<!--
    table.page_header {width: 100%; border: none; padding: 2mm }
    table.page_footer {width: 100%; border: none; padding: 1mm; font-size: 11px;}
    table.tablep {width: 100%; border-collapse: collapse; font-size: 10.3px;}
    table.tablep th, table.tablep td {border: 1px solid #AAAAAA; padding: 2px; white-space: nowrap; word-break: break-all;}
    table.st {width: 100%; border-collapse: collapse; padding: 5px 0; font-size: 11px;}

-->
</style>
<page backtop="22mm" backbottom="6mm" backleft="2mm" backright="2mm" style="font-size: 9px;">
    <page_header> 
        <table class="page_header">
            <tr>
            	<td style="width: 20%;">
            		<img src="../m_images/logompg.png" width="150">
            	</td>
                <td style="width: 60%; text-align: center;">
                    <span style="font-size: 16px;">DISTRITO FISCAL DE CAJAMARCA</span><br>
                    <span style="font-size: 18px;"><?php echo $re['nombre']; ?></span>
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
            		Ministerio Público | Distrito Fiscal de Cajamarca
            	</td>
                <td style="width: 30%; text-align: right">
                    Página [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
    <table class="st">
    	<tr>
    		<td style="width: 12%;">Del</td>
    		<td style="width: 12%;"><b><?php echo ftnormal($re['inicio']); ?></b></td>
    		<td style="width: 12%;">Al</td>
    		<td style="width: 12%;"><b><?php echo ftnormal($re['fin']); ?></b></td>
    	</tr>
    </table>
    <h4>Resumen elección</h4>
	<table class="tablep">
<?php
		$cr=mysqli_query($cone, "SELECT l.nombre, COUNT(l.id) AS votos FROM listas l INNER JOIN eleccione_empleado ee ON l.id=ee.lista_id WHERE ee.eleccione_id=$v1 GROUP BY l.id;");
        if(mysqli_num_rows($cr)>0){
?>
		<tr>
			<th style="width: 6%;" align="center" valign="middle">N°</th>
			<th style="width: 15%;" align="center" valign="middle">LISTA</th>
			<th style="width: 15%;" align="center" valign="middle">VOTOS</th>
		</tr>
<?php
			$n=0;
			$nv=0;
			while($rr=mysqli_fetch_assoc($cr)){
				$n++; $nv=$nv+$rr['votos'];
?>
		<tr>
			<td align="center"><?php echo $n; ?></td>
			<td align="center"><?php echo $rr['nombre']; ?></td>
			<td align="center"><?php echo $rr['votos']; ?></td>
		</tr>
<?php
			}
?>
	</table>
	<br>
	<table class="tablep">
		<tr>
			<th align="center" style="width: 21%;">TOTAL VOTOS</th>
			<td style="width: 15%;" align="center"><?php echo $nv; ?></td>
		</tr>
		<tr>
			<th align="center">TOTAL OMISOS</th>
			<td align="center"><?php echo $re['numvotantes']-$nv; ?></td>
		</tr>
		<tr>
			<th align="center">TOTAL ELECTORES</th>
			<td align="center"><?php echo $re['numvotantes']; ?></td>
		</tr>
	</table>
	<h4>Personal que emitió su voto</h4>
	<table class="tablep">
<?php
		}
		mysqli_free_result($cr);
		$cv=mysqli_query($cone, "SELECT empleado_id FROM eleccione_empleado WHERE eleccione_id=$v1;");
		if(mysqli_num_rows($cv)>0){
?>
		<tr>
			<th style="width: 4%;" align="center" valign="middle">N°</th>
			<th style="width: 10%;" align="center" valign="middle">DNI</th>
			<th style="width: 25%;" align="center" valign="middle">NOMBRE</th>
			<th style="width: 25%;" align="center" valign="middle">CARGO</th>
			<th style="width: 36%;" align="center" valign="middle">DEPENDENCIA</th>
		</tr>
<?php
			$n=0;
			while($rv=mysqli_fetch_assoc($cv)){
				$n++;
?>
		<tr>
			<td align="center" style="font-size: 9.5px;"><?php echo $n; ?></td>
			<td align="center" style="font-size: 10px;"><?php echo docidentidad($cone, $rv['empleado_id']); ?></td>
			<td><?php echo wordwrap(html_entity_decode(nomempleado($cone, $rv['empleado_id'])),40,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(cargoe($cone, $rv['empleado_id'])),40,"<br/>\n",true); ?></td>
			<td><?php echo wordwrap(html_entity_decode(dependenciae($cone, $rv['empleado_id'])),55,"<br/>\n",true); ?></td>
		</tr>
<?php
			}
		}
		mysqli_free_result($cv);
?>
	</table>

</page> 
<?php
		$html=ob_get_clean();

		$html2pdf=new Html2Pdf('L','A4','es','true','UTF-8', array(5,5,5,3));
		$html2pdf->writeHTML($html);
		$html2pdf->output('Resultados_elecciones.pdf');
	}else{
		echo mensajeda("Datos invalidos.");
	}
	mysqli_free_result($ce);
}else{
	echo mensajeda("Error: No se enviaron los datos.");
}
mysqli_close($cone);
?>