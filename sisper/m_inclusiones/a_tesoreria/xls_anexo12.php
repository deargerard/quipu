<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
	if(isset($_GET['ren']) && !empty($_GET['ren'])){
		$ren=iseguro($cone,$_GET['ren']);

	    $fecha = @date("dmYHis");

	    	$cr=mysqli_query($cone, "SELECT r.codigo, r.mes, r.anio, m.nombre AS meta, f.nombre AS fondo, m.mnemonico FROM terendicion r INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE r.idterendicion=$ren;");
	    	if($rr=mysqli_fetch_assoc($cr)){

		      header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		      header("Content-Disposition: attachment; filename=Anexo11_$fecha.xls");
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
              <th colspan="8">ANEXO N&deg; 12</th>
            </tr>
            <tr>
              <th colspan="8">RENDICI&Oacute;N N&deg; <?php echo $rr['codigo']." ".$rr['fondo']."-".$rr['meta']; ?> | DISTRITO FISCAL DE CAJAMARCA | <?php echo strtoupper(nombremes($rr['mes']))." DE ".$rr['anio']; ?></th>
            </tr>
			<tr>
			  <th colspan="1"></th>
              <th colspan="6">(Telefon&iacute;a Fija, Internet, Cable)</th>
              <td colspan="1"><?php echo date('d/m/Y'); ?></td>
            </tr>
          </table>
          <table border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="font-size:8px; width: 100%; padding: 0;" class="tabla">
            <tr style="background-color: #DDDDDD;" style="font-size: 10px; vertical-align: middle; text-align: center;">
              <td>N&deg;</td>
              <td>N&deg; RECIBO</td>
              <td>N&deg; SUMINISTRO</td>
              <td>MES CONSUMO</td>
              <td>DEPENDENCIA</td>
              <td colspan="2">ESPECIFICA DEL GASTO</td>
              <td>IMPORTE</td>
            </tr>
<?php
				$cc=mysqli_query($cone,"SELECT g.numerocom, g.codservicio, g.totalcom, e.nombre, e.codigo, d.Denominacion FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN teespecifica e ON g.idteespecifica=e.idteespecifica INNER JOIN dependencia d ON g.idDependencia=d.idDependencia WHERE g.idterendicion=$ren AND (e.idteespecifica=42 OR e.idteespecifica=43) ORDER BY e.codigo ASC;");
				if(mysqli_num_rows($cc)>0){
					$n=0;
					$t=0;
					while($rc=mysqli_fetch_assoc($cc)){
						$n++;
?>
            <tr>
              <td><?php echo $n; ?></td>
              <td><?php echo $rc['numerocom']; ?></td>
              <td style="text-align: center;"><?php echo $rc['codservicio']; ?></td>
              <td></td>
              <td><?php echo $rc['Denominacion']; ?></td>
              <td><?php echo $rc['codigo']; ?></td>
              <td><?php echo $rc['nombre']; ?></td>
              <td style="mso-number-format:'0.00';"><?php echo $rc['totalcom']; ?></td>
            </tr>
            <?php
            			$t=$t+$rc['totalcom'];
            		}
            	}
            	mysqli_free_result($cc);
            ?>
            <tr style="background-color: #DDDDDD;" style="font-size: 10px;">
            	<td colspan="7" style="text-align: right;">TOTAL GENERAL</td>
            	<td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
            </tr>
          </table>
          <table cellpadding="0" cellspacing="0" style="font-size:8px; width: 100%; padding: 0;">
          	<tr>
          		<td colspan="8">&nbsp;</td>
          	</tr>
          	<tr>
          		<th colspan="8">MOVIMIENTO DEL DINERO EN EFECTIVO</th>
          	</tr>
          	<tr>
          		<td colspan="6">Saldo Anterior</td>
          		<td colspan="2" style="text-align: right;">S/ _______________</td>
          	</tr>
          	<tr>
          		<td colspan="6">C/P N&deg; _______________</td>
          		<td colspan="2"></td>
          	</tr>
          	<tr>
          		<td colspan="6">C/P N&deg; _______________</td>
          		<td colspan="2"></td>
          	</tr>
          	<tr>
          		<td colspan="6">Importe de la presente rendici&oacute;n</td>
          		<td colspan="2" style="text-align: right;">S/ <?php echo $t; ?></td>
          	</tr>
          	<tr>
          		<td colspan="6">SALDO ACTUAL</td>
          		<td colspan="2" style="text-align: right;">S/ _______________</td>
          	</tr>
          	<tr>
          		<td colspan="8">&nbsp;</td>
          	</tr>
          	<tr style="text-align: center;">
          		<td colspan="4">________________________________</td>
          		<td></td>
          		<td colspan="3">________________________________</td>
          	</tr>
          	<tr style="text-align: center;">
          		<td colspan="4">Administrador</td>
          		<td></td>
          		<td colspan="3">Encargado &Uacute;nico del manejo del FPPE</td>
          	</tr>
          </table>
<?php
			}else{
				echo "Datos incorrectos";
			}
			mysqli_free_result($cr);
	}else{
		echo "Faltan datos";
	}
}else{
      echo "Restringido";
}
mysqli_close($cone);
?>