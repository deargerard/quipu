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
		      header("Content-Disposition: attachment; filename=Formato15_$fecha.xls");
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
              <th colspan="2"></th>
              <th colspan="7" style="font-size: 16px;">FORMATO N&deg; 15</th>
              <th></th>
              <th style="text-align: center;">N&deg;</th>
              <th style="text-align: center;"><?php echo $rr['codigo']; ?></th>
            </tr>
            <tr>
              <td colspan="12"></td>
            </tr>
            <tr>
              <th colspan="2"></th>
              <th colspan="7">RENDICI&Oacute;N DE FONDO PARA PAGOS EN EFECTIVO N&deg; <?php echo $rr['codigo']." ".$rr['fondo']."-".$rr['meta']; ?> | DISTRITO FISCAL DE CAJAMARCA</th>
              <td style="text-align: center;">DIA</td>
              <td style="text-align: center;">MES</td>
              <td style="text-align: center;">A&Ntilde;O</td>
            </tr>
			      <tr>
			        <th colspan="2"></th>
              <th colspan="7"><?php echo strtoupper(nombremes($rr['mes']))." DE ".$rr['anio']; ?></th>
              <td style="text-align: center;">&nbsp;<?php echo date('d'); ?></td>
              <td style="text-align: center;">&nbsp;<?php echo date('m'); ?></td>
              <td style="text-align: center;">&nbsp;<?php echo date('Y'); ?></td>
            </tr>
            <tr>
              <td colspan="12"></td>
            </tr>
          </table>
          <table border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="width: 100%; padding: 0;" class="formato">
            <tr style="background-color: #DDDDDD;" style="vertical-align: middle; text-align: center;">
              <td rowspan="2">N&deg;</td>
              <td colspan="3">Documento</td>
              <td rowspan="2">Proveedor</td>
              <td rowspan="2">RUC</td>
              <td rowspan="2">Detalle Gasto</td>
              <td rowspan="2" colspan="2">Especifica de gasto</td>
              <td colspan="2"><?php echo substr($rr['fondo'], 0, 4)."/".substr($rr['meta'], 0, 4); ?></td>
              <td rowspan="2">TOTAL</td>
            </tr>
            <tr style="background-color: #DDDDDD;" style="vertical-align: middle; text-align: center;">
              <td>Fecha</td>
              <td>Clase</td>
              <td>N&deg;</td>
              <td colspan="2"><?php echo $rr['mnemonico']; ?></td>
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
			<tr style="background-color: #EEEEEE;" style="vertical-align: middle;">
        <td colspan="6"></td>
				<td style="text-align: right;"><?php echo $re['codigo']; ?></td>
				<td colspan="4"><?php echo $re['nombre']; ?></td>
				<th style="mso-number-format:'0.00'; text-align: right;"><?php echo $re['tot']; ?></th>
			</tr>
<?php
				$cc=mysqli_query($cone,"SELECT g.fechacom, g.numerocom, g.glosacom, g.totalcom, tc.tipo, p.razsocial, p.ruc FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN teproveedor p ON g.idteproveedor=p.idteproveedor WHERE g.idterendicion=$ren AND g.idteespecifica=$ide ORDER BY g.fechacom, g.numerocom ASC;");
				if(mysqli_num_rows($cc)>0){
					while($rc=mysqli_fetch_assoc($cc)){
						$n++;
            $nc=explode('-', $rc['numerocom']);
            if($nc[0]=='S'){
              $nnc=$nc['1'];
            }else{
              $nnc=$rc['numerocom'];
            }
?>
            <tr>
              <td><?php echo $n; ?></td>
              <td><?php echo fnormal($rc['fechacom']); ?></td>
              <td><?php echo $rc['tipo']; ?></td>
              <td><?php echo '&nbsp;'.$nnc; ?></td>
              <td><?php echo $rc['razsocial']; ?></td>
              <td><?php echo '&nbsp;'.$rc['ruc']; ?></td>
              <td colspan="3"><?php echo $rc['glosacom']; ?></td>
              <td colspan="2" style="mso-number-format:'0.00';"><?php echo $rc['totalcom']; ?></td>
              <td style="mso-number-format:'0.00'; text-align: right;"><?php echo $rc['totalcom']; ?></td>
            </tr>
            <?php
            		}
            	}
            	mysqli_free_result($cc);
              }
            }
            mysqli_free_result($ce);
            ?>
            <tr style="background-color: #DDDDDD;">
            	<th colspan="11" style="text-align: right;">TOTAL</th>
            	<th style="mso-number-format:'0.00'; text-align: right;"><?php echo $t; ?></th>
            </tr>
          </table>
          <table cellpadding="0" cellspacing="0" style="width: 100%; padding: 0;" class="formato">
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

		}elseif($ti==2){

        $cr=mysqli_query($cone, "SELECT r.codigo, r.mes, r.anio, m.nombre AS meta, f.nombre AS fondo, m.mnemonico FROM terendicion r INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE r.idterendicion=$ren;");
        if($rr=mysqli_fetch_assoc($cr)){

          header("Content-Type: application/vnd.ms-excel; charset=utf-8");
          header("Content-Disposition: attachment; filename=Formato15_$fecha.xls");
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
          <table cellpadding="0" cellspacing="0" style="width: 100%; padding: 0;">
            <tr>
              <th colspan="2"></th>
              <th colspan="4">FORMATO N&deg; 15</th>
              <th colspan="2"></th>
            </tr>
            <tr>
              <th colspan="2"></th>
              <th colspan="4">RENDICI&Oacute;N DE FONDO PARA PAGOS EN EFECTIVO N&deg; <?php echo $rr['codigo']."-".$rr['anio']."-".$rr['fondo']."-".$rr['meta']; ?> <br>DISTRITO FISCAL DE CAJAMARCA<br> <?php echo strtoupper(nombremes($rr['mes']))." DE ".$rr['anio']; ?></th>
              <th colspan="2" align="center"></th>
            </tr>
          </table>
          <table border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="width: 100%; padding: 0;" class="tabla">
            <tr style="background-color: #CCCCCC;" style="vertical-align: middle; text-align: center;">
              <td rowspan="2">N&deg;</td>
              <td colspan="3">DOCUMENTO</td>
              <td rowspan="2">ESPECIFICA DE GASTO</td>
              <td colspan="2"><?php echo substr($rr['fondo'], 0, 4)."/".substr($rr['meta'], 0, 4); ?></td>
              <td rowspan="2">TOTAL</td>
            </tr>
            <tr style="background-color: #CCCCCC;" style="vertical-align: middle; text-align: center;">
              <td>FECHA</td>
              <td>CLASE</td>
              <td>N&deg;</td>
              <td>NM</td>
              <td>S/</td>
            </tr>
<?php
          $cct=mysqli_query($cone, "SELECT SUM(g.totalcom) tot, cs.idEmpleado, cs.csivia, cs.idComServicios FROM comservicios cs INNER JOIN tegasto g ON cs.idComServicios=g.idComServicios WHERE cs.idterendicion=$ren GROUP BY g.idComServicios ORDER BY cs.orden ASC;");
          if(mysqli_num_rows($cct)>0){
            $n=0;
            $st=0;
            $se=array();
            while($rct=mysqli_fetch_assoc($cct)){
              $st=$st+$rct['tot'];
              $n++;
              $idcs=$rct['idComServicios'];
?>
            <tr style="background-color: #DDDDDD; vertical-align: middle;">
              <td colspan="7"><b><?php echo $n.".- ".nomempleado($cone, $rct['idEmpleado'])." - ".$rct['csivia']; ?></b></td>
              <td style="mso-number-format:'0.00';"><b><?php echo n_2decimales($rct['tot']); ?></b></td>
            </tr>
<?php
              $cte=mysqli_query($cone, "SELECT SUM(g.totalcom) totesp, e.nombre, e.codigo, g.idteespecifica FROM teespecifica e INNER JOIN tegasto g ON e.idteespecifica=g.idteespecifica WHERE g.idComServicios=$idcs GROUP BY g.idteespecifica ORDER BY e.codigo ASC;");
              if(mysqli_num_rows($cte)>0){
                while($rte=mysqli_fetch_assoc($cte)){
                  $ide=$rte['idteespecifica'];
                  $se[$ide]=$se[$ide]+$rte['totesp'];
?>
            <tr style="background-color: #EEEEEE;">
              <td colspan="4"></td>
              <td><b><?php echo $rte['codigo']." ".$rte['nombre']; ?></b></td>
              <td></td>
              <td style="mso-number-format:'0.00';"><b><?php echo $rte['totesp']; ?></b></td>
              <td></td>
            </tr>
<?php
                  $cga=mysqli_query($cone, "SELECT g.fechacom, tc.tipo, g.numerocom, g.glosacom, g.totalcom FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom WHERE g.idComServicios=$idcs AND g.idteespecifica=$ide ORDER BY g.fechacom ASC;");
                  if(mysqli_num_rows($cga)>0){
                    while($rga=mysqli_fetch_assoc($cga)){
?>
            <tr>
              <td></td>
              <td><?php echo fnormal($rga['fechacom']); ?></td>
              <td><?php echo $rga['tipo']; ?></td>
              <td><?php echo is_null($rga['numerocom']) ? "&nbsp;S/N" : "&nbsp;".$rga['numerocom']; ?></td>
              <td><?php echo $rga['glosacom']; ?></td>
              <td><?php echo $rr['mnemonico']; ?></td>
              <td style="mso-number-format:'0.00';"><?php echo $rga['totalcom']; ?></td>
              <td style="mso-number-format:'0.00';"><?php echo $rga['totalcom']; ?></td>
            </tr>
<?php
                    }
                  }
                  mysqli_free_result($cga);
                }
              }
              mysqli_free_result($cte);
            }
?>
            <tr>
              <td colspan="7" style="text-align: center;"><b>TOTAL</b></td>
              <td style="mso-number-format:'0.00';"><b><?php echo $st; ?></b></td>
            </tr>
<?php
          }else{
?>
            <tr>
              <td colspan="8">Aún sin registros</td>
            </tr>
<?php
          }
          mysqli_free_result($cct);
?>

          </table>
          <table cellpadding="0" cellspacing="0" style="width: 100%; padding: 0;">
            <tr>
              <td colspan="8"></td>
            </tr>
          </table>
          <table border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" style="width: 100%; padding: 0;" class="tabla">
            <tr style="background-color: #CCCCCC;" style="vertical-align: middle; text-align: center;">
              <td colspan="6" rowspan="2">ESPECIFICA DE GASTO</td>
              <td colspan="2">MNEMONICO</td>
            </tr>
            <tr style="background-color: #CCCCCC;" style="vertical-align: middle; text-align: center;">
              <td colspan="2"><?php echo $rr['mnemonico']; ?></td>
            </tr>
<?php
          ksort($se);
          foreach ($se as $key => $value) {
            $ces=mysqli_query($cone, "SELECT nombre, codigo FROM teespecifica WHERE idteespecifica=$key;");
            if($res=mysqli_fetch_assoc($ces)){
?>
            <tr>
              <td colspan="6"><?php echo $res['codigo']." ".$res['nombre']; ?></td>
              <td colspan="2" style="mso-number-format:'0.00';"><?php echo $value; ?></td>
            </tr>
<?php
            }
            mysqli_free_result($ces);
          }
?>
            <tr>
              <td colspan="6" style="text-align: center;"><b>TOTAL</b></td>
              <td colspan="2" style="mso-number-format:'0.00';"><b><?php echo $st; ?></b></td>
            </tr>
          </table>
<?php
      }else{
        echo "Datos incorrectos";
      }
      mysqli_free_result($cr);




		}
	}else{
		echo "Faltan datos";
	}
}else{
      echo "Restringido";
}
mysqli_close($cone);
?>