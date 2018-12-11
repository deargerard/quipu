<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
	if(isset($_GET['ren']) && !empty($_GET['ren']) && isset($_GET['ti']) && !empty($_GET['ti'])){
		$ren=iseguro($cone,$_GET['ren']);
		$ti=iseguro($cone,$_GET['ti']);

	    $fecha = @date("dmYHis");

	    if($ti==1){
	    	$cr=mysqli_query($cone, "SELECT r.codigo, r.mes, r.anio, m.nombre AS meta, f.nombre AS fondo, m.mnemonico FROM terendicion r INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE r.idterendicion=$ren;");
	    	if($rr=mysqli_fetch_assoc($cr)){

		      header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		      header("Content-Disposition: attachment; filename=Anexo16_$fecha.xls");
		      header("Pragma: no-cache");
		      header("Expires: 0");

	   			
?>
		<style type="text/css">
.tabla {
    border-collapse: collapse;
}

.tabla>th>td {
    border: 1px solid black;
}
		</style>
          <table cellpadding="0" cellspacing="0" style="font-size:10px; width: 100%; padding: 0;">
            <tr>
              <th colspan="2"></th>
              <th colspan="7">ANEXO N&deg; 16</th>
              <th colspan="2"></th>
            </tr>
            <tr>
              <th colspan="2"></th>
              <th colspan="7">RENDICI&Oacute;N N&deg; <?php echo $rr['codigo']." ".$rr['fondo']."-".$rr['meta']; ?> | DISTRITO FISCAL DE CAJAMARCA</th>
              <th colspan="2" align="center"></th>
            </tr>
			<tr>
			  <th colspan="2"></th>
              <th colspan="7"><?php echo strtoupper(nombremes($rr['mes']))." DE ".$rr['anio']; ?></th>
              <td colspan="2" align="center"><?php echo date('m/d/Y'); ?></td>
            </tr>
          </table>
          <table border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="font-size:8px; width: 100%; padding: 0;" class="tabla">
            <tr style="background-color: #DDDDDD;" style="font-size: 10px; vertical-align: middle; text-align: center;">
              <td rowspan="2">N&deg;</td>
              <td colspan="3">Documento</td>
              <td rowspan="2">Proveedor</td>
              <td rowspan="2">RUC</td>
              <td rowspan="2">Detalle Gasto</td>
              <td rowspan="2" colspan="2">Especifica de gasto</td>
              <td><?php echo substr($rr['fondo'], 0, 4)."/".substr($rr['meta'], 0, 4); ?></td>
              <td rowspan="2">TOTAL</td>
            </tr>
            <tr style="background-color: #DDDDDD;" style="font-size: 10px; vertical-align: middle; text-align: center;">
              <td>Fecha</td>
              <td>Clase</td>
              <td>N&deg;</td>
              <td><?php echo $rr['mnemonico']; ?></td>
            </tr>
<?php
			$ce=mysqli_query($cone, "SELECT e.idteespecifica, e.nombre, e.codigo, sum(g.totalcom) AS tot FROM tegasto g INNER JOIN teespecifica e ON g.idteespecifica=e.idteespecifica WHERE g.idterendicion=$ren GROUP BY g.idteespecifica ORDER BY e.codigo ASC;");
			if(mysqli_num_rows($ce)>0){
				$t=0;
				$n=0;
			  while($re=mysqli_fetch_assoc($ce)){
			  	$ide=$re['idteespecifica'];
			  	$t=$t+$re['tot'];
?>
			<tr style="background-color: #EEEEEE;" style="font-size: 9px; vertical-align: middle;">
				<td colspan="2"><?php echo $re['codigo']; ?></td>
				<td colspan="8"><?php echo $re['nombre']; ?></td>
				<td style="mso-number-format:'0.00';"><?php echo $re['tot']; ?></td>
			</tr>
<?php
				$cc=mysqli_query($cone,"SELECT g.fechacom, g.numerocom, g.glosacom, g.totalcom, tc.tipo, p.razsocial, p.ruc FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN teproveedor p ON g.idteproveedor=p.idteproveedor WHERE g.idterendicion=$ren AND g.idteespecifica=$ide ORDER BY g.fechacom ASC;");
				if(mysqli_num_rows($cc)>0){
					while($rc=mysqli_fetch_assoc($cc)){
						$n++;
?>
            <tr>
              <td><?php echo $n; ?></td>
              <td><?php echo fnormal($rc['fechacom']); ?></td>
              <td><?php echo $rc['tipo']; ?></td>
              <td><?php echo $rc['numerocom']; ?></td>
              <td><?php echo $rc['razsocial']; ?></td>
              <td><?php echo $rc['ruc']; ?></td>
              <td><?php echo $rc['glosacom']; ?></td>
              <td><?php echo $re['codigo']; ?></td>
              <td><?php echo $re['nombre']; ?></td>
              <td style="mso-number-format:'0.00';"><?php echo $rc['totalcom']; ?></td>
              <td style="mso-number-format:'0.00';"><?php echo $rc['totalcom']; ?></td>
            </tr>
            <?php
            		}
            	}
            	mysqli_free_result($cc);
              }
            }
            mysqli_free_result($ce);
            ?>
            <tr style="background-color: #DDDDDD;" style="font-size: 10px;">
            	<td colspan="10" style="text-align: right;">TOTAL</td>
            	<td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
            </tr>
          </table>
          <table cellpadding="0" cellspacing="0" style="font-size:8px; width: 100%; padding: 0;">
          	<tr>
          		<td colspan="11">&nbsp;</td>
          	</tr>
          	<tr>
          		<td colspan="11" style="text-align: center;"><b>MOVIMIENTO DE EFECTIVO</b></td>
          	</tr>
          	<tr>
          		<td colspan="7">Saldo Anterior</td>
          		<td colspan="4" style="text-align: right;">S/ ________________</td>
          	</tr>
          	<tr>
          		<td colspan="7">C/P N&deg; _______________</td>
          		<td colspan="4">&nbsp;</td>
          	</tr>
          	<tr>
          		<td colspan="7">CH N&deg;&nbsp;&nbsp; _______________</td>
          		<td colspan="4">&nbsp;</td>
          	</tr>
          	<tr>
          		<td colspan="7">Importe de la presente Rendici&oacute;n</td>
          		<td colspan="4" style="text-align: right;">S/ ________________</td>
          	</tr>
          	<tr>
          		<td colspan="7">SALDO ACTUAL</td>
          		<td colspan="4" style="text-align: right;">S/ ________________</td>
          	</tr>
          	<tr>
          		<td colspan="11">&nbsp;</td>
          	</tr>
          	<tr style="text-align: center;">
          		<td colspan="6">________________________________</td>
              <td></td>
          		<td colspan="4">________________________________</td>
          	</tr>
          	<tr style="text-align: center;">
          		<td colspan="6">Gerencia de Tesorer&iacute;a/Administrador</td>
              <td></td>
          		<td colspan="4">Encargado &Uacute;nico del manejo del FPPE</td>
          	</tr>
          </table>
<?php
			}else{
				echo "Datos incorrectos";
			}
			mysqli_free_result($cr);
		}else{
			echo "Víaticos";
		}
	}else{
		echo "Faltan datos";
	}
}else{
      echo "Restringido";
}
mysqli_close($cone);
?>