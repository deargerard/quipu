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
      .formato{
          font-family: Arial;
          font-size: 16px;
      }
		</style>
          <table cellpadding="0" cellspacing="0" style="width: 100%; padding: 0;" class="formato">
            <tr>
              <th colspan="12">ANEXO N&deg; 11</th>
            </tr>
            <tr>
              <th colspan="12">RENDICI&Oacute;N N&deg; <?php echo $rr['codigo']." ".$rr['fondo']."-".$rr['meta']; ?> | DISTRITO FISCAL DE CAJAMARCA | <?php echo strtoupper(nombremes($rr['mes']))." DE ".$rr['anio']; ?></th>
            </tr>
			      <tr>
              <th colspan="12">(Energ&iacute;a el&eacute;ctrica, agua, desague y arbitrios)</th>
            </tr>
          </table>
          <table border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="width: 100%; padding: 0;" class="formato">
            <tr style="background-color: #DDDDDD;" style="vertical-align: middle; text-align: center;">
              <td>N&deg;</td>
              <td>DEPENDENCIA</td>
              <td>N&deg; RECIBO</td>
              <td>N&deg; SUMINISTRO</td>
              <td>EMPRESA</td>
              <td>SITUACI&Oacute;N INMUEBLE</td>
              <td>% ACUERDO CONTRATO</td>
              <td>MES CONSUMO</td>
              <td colspan="2">ESPECIFICA DEL GASTO</td>
              <td>IMPORTE</td>
              <td>N&deg; RENDICI&Oacute;N</td>
            </tr>
<?php
				$cc=mysqli_query($cone,"SELECT DISTINCT g.numerocom, g.codservicio, g.totalcom, p.razsocial, e.nombre, e.codigo, d.Denominacion, l.Alias, cl.CondicionLocal FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN teproveedor p ON g.idteproveedor=p.idteproveedor INNER JOIN teespecifica e ON g.idteespecifica=e.idteespecifica INNER JOIN dependencia d ON g.idDependencia=d.idDependencia LEFT JOIN local l ON g.idLocal=l.idLocal LEFT JOIN condicionloc cl ON l.idCondicionLoc=cl.idCondicionLoc WHERE g.idterendicion=$ren AND (e.idteespecifica=38 OR e.idteespecifica=39) ORDER BY e.codigo ASC;");
				if(mysqli_num_rows($cc)>0){
					$n=0;
					$t=0;
					while($rc=mysqli_fetch_assoc($cc)){
						$n++;
?>
            <tr>
              <td style="vertical-align: middle;"><?php echo $n; ?></td>
              <td style="vertical-align: middle;"><?php echo $rc['Denominacion']." - ".$rc['Alias']; ?></td>
              <td style="vertical-align: middle;"><?php echo '&nbsp;'.$rc['numerocom']; ?></td>
              <td style="vertical-align: middle;"><?php echo '&nbsp;'.$rc['codservicio']; ?></td>
              <td style="vertical-align: middle;"><?php echo $rc['razsocial']; ?></td>
              <td style="vertical-align: middle;"><?php echo $rc['CondicionLocal']; ?></td>
              <td style="vertical-align: middle;">100%</td>
              <td style="vertical-align: middle;"></td>
              <td style="vertical-align: middle;"><?php echo $rc['codigo']; ?></td>
              <td style="vertical-align: middle;"><?php echo $rc['nombre']; ?></td>
              <td style="mso-number-format:'0.00'; vertical-align: middle;"><?php echo $rc['totalcom']; ?></td>
              <td style="vertical-align: middle;">R-<?php echo $rr['codigo']."-".$rr['anio']."-".substr($rr['fondo'],0,4)."-".substr($rr['meta'],0,4); ?></td>
            </tr>
            <?php
            			$t=$t+$rc['totalcom'];
            		}
            	}
            	mysqli_free_result($cc);
            ?>
            <tr style="background-color: #DDDDDD;">
            	<td colspan="10" style="text-align: right;">TOTAL RENDIDO</td>
            	<td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
            	<td></td>
            </tr>
          </table>
          <table cellpadding="0" cellspacing="0" style="width: 100%; padding: 0;" class="formato">
          	<tr>
          		<td colspan="12">&nbsp;</td>
          	</tr>
          	<tr>
          		<td colspan="12">&nbsp;</td>
          	</tr>
          	<tr style="text-align: center;">
          		<td colspan="5">________________________________</td>
              <td></td>
          		<td colspan="6">________________________________</td>
          	</tr>
          	<tr style="text-align: center;">
          		<td colspan="5">Gerencia de Tesorer&iacute;a/Administrador</td>
              <td></td>
          		<td colspan="6">Encargado &Uacute;nico del manejo del FPPE</td>
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