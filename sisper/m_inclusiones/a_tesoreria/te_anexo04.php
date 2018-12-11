<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

if(accesoadm($cone,$_SESSION['identi'],9)){
	if(isset($_GET['idcs']) && !empty($_GET['idcs'])){
		$idcs=iseguro($cone,$_GET['idcs']);		

	    $fecha = @date("dmYHis");

    //if($ti==1){
	    $c1=mysqli_query($cone,"SELECT cs.FechaIni, cs.FechaFin, cs.idEmpleado, e.NumeroDoc, d.NombreDis FROM comservicios cs INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado INNER JOIN distrito d ON cs.idDistrito=d.idDistrito WHERE idComServicios=$idcs;");
	    if($r1=mysqli_fetch_assoc($c1)){

		      header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		      header("Content-Disposition: attachment; filename=Anexo04_$fecha.xls");
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
          .tsb{
              border: none;
          }
          		</style>
                    <table border="1" cellpadding="0" cellspacing="0" style="font-size:10px; width: 100%; padding: 0; border-collapse:collapse;border-color:#fff;">
                      <tr>
                        <th class="tsb" colspan="12">ANEXO N&deg; 04</th>
                      </tr>
                      <tr >
                        <th class="tsb" colspan="12">RENDICI&Oacute;N DOCUMENTARIA DE VI&Aacute;TICOS Y ASIGNACIONES POR COMISIÓN DE SERVICIOS </th>
                      </tr>
          			      <tr>
                        <th class="tsb" colspan="12">DISTRITO FISCAL DE CAJAMARCA</th>
                      </tr>
                      <tr class="tsb"> 

                      </tr>
                      <tr>
                        <th class="tsb" colspan="12" style="font-size: 12px; vertical-align: middle;">Yo <?php echo nomempleado($cone, $r1['idEmpleado']); ?> identificado con DNI N° <?php echo $r1['NumeroDoc']; ?> en el cargo de <?php echo cargoe($cone, $r1['idEmpleado']); ?>  manifiesto haber efectuado todos los gastos en la comisión de servicios, <br> llevada a cabo a la ciudad de <?php echo $r1['NombreDis']; ?> del <?php echo fnormal($r1['FechaIni']); ?> al <?php echo fnormal($r1['FechaFin']); ?> que a continuación se detallan y sustentan con la documentación que se adjunta al presente.</th>
                      </tr>
                      <tr class="tsb">
                        
                      </tr>
                      <tr >
                        <th colspan="3" class="tsb"></th>
                        <th rowspan="2">Recursos</th>
                        <th rowspan="1">Monto Otorgado</th>
                        <th rowspan="1">Monto Rendido</th>
                        <th rowspan="1">Devolución</th>
                        <th rowspan="1">Saldo</th>
                      </tr>
                        <th colspan="3" class="tsb"></th>                        
                        <th rowspan="1"></th>
                        <th rowspan="1"></th>
                        <th rowspan="1"></th>
                        <th rowspan="1"></th>
                      <tr>
                        
                      </tr>

                    </table>
                    <table border="1" cellpadding="0" cellspacing="0" bordercolor="#151515" style="font-size:8px; width: 100%; padding: 0;" class="tabla">
                      <tr style="background-color: #DDDDDD;" style="font-size: 10px; vertical-align: middle;">
                        <td rowspan="2">N&deg;</td>
                        <td rowspan="2">Fecha</td>
                        <td rowspan="2">Concepto</td>
                        <td rowspan="2">N&deg; de Comprobante de pago</td>
                        <td colspan="3" align="center">Vi&aacute;ticos</td> 
                        <td colspan="4" align="center">Otras Asignaciones</td>                       
                        <td rowspan="2" align="center">TOTAL</td>
                      </tr>
                      <tr style="background-color: #DDDDDD;" style="font-size: 10px; vertical-align: middle;">
                        <td>Hospedaje</td>
                        <td>Alimentación</td>
                        <td>Movilidad</td>
                        <td>Pasajes Terrestre</td>
                        <td>Combustible</td>
                        <td>TUUA</td>
                        <td>Otros</td>
                      </tr>
          <?php 
          				$cc=mysqli_query($cone,"SELECT g.idtegasto, g.fechacom, tc.abreviatura, cv.conceptov, g.numerocom, g.totalcom FROM tegasto g INNER JOIN tetipocom tc ON tc.idtetipocom=g.idtetipocom INNER JOIN teconceptov cv ON g.idteconceptov=cv.idteconceptov WHERE g.idComServicios=$idcs;");
          				if(mysqli_num_rows($cc)>0){
          					$n=0;
          					$t=0;
          					while($rc=mysqli_fetch_assoc($cc)){
          						$n++;
          						$t=$t+$rc['totalcom'];
          ?>
                      <tr>
                        <td><?php echo $n; ?></td>
                        <td><?php echo fnormal($rc['fechacom']); ?></td>
                        <td><?php echo $rc['tipo']; ?></td>
                        <td><?php echo $rc['numerocom']; ?></td>
                        <td><?php echo $rc['razsocial']; ?></td>
                        <td><?php echo $rc['ruc']; ?></td>
                        <td><?php echo $rc['glosacom']; ?></td>
                        <td><?php echo $rc['codigo']; ?></td>
                        <td><?php echo $rc['nombre']; ?></td>
                        <td><?php echo $rr['mnemonico']; ?></td>
                        <td style="mso-number-format:'0.00';"><?php echo $rc['totalcom']; ?></td>
                        <td style="mso-number-format:'0.00';"><?php echo $rc['totalcom']; ?></td>
                      </tr>
                      <?php
                      		}
                      	}
                      	mysqli_free_result($cc);
                      ?>
                      <tr style="background-color: #DDDDDD;" style="font-size: 10px;">
                      	<td colspan="4">SUB TOTAL RENDICI&Oacute;N DE GASTOS</td>
                      	<td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
                      	<td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
                        <td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
                        <td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
                        <td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
                        <td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
                        <td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
                        <td style="mso-number-format:'0.00';"><?php echo $t; ?></td>
                      </tr>
                      <tr style="background-color: #DDDDDD;" style="font-size: 10px;">
                        <td colspan="4">MONTO ASIGNADO</td>
                        <td colspan="7"></td>
                        <td style="mso-number-format:'0.00';"><?php echo $t; ?></td>                        
                      </tr>
                      <tr style="background-color: #DDDDDD;" style="font-size: 10px;">
                        <td colspan="4">SALDO</td>
                        <td colspan="7"></td>
                        <td style="mso-number-format:'0.00';"><?php echo $t; ?></td>                        
                      </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0" style="font-size:8px; width: 100%; padding: 0;">
                    	<tr>
                    		<td colspan="12">&nbsp;</td>
                    	</tr>
                    	<tr>
                    		
                    	</tr>
                      <tr style="text-align: center;">
                        <td colspan="6">________________________</td>
                        
                      </tr>
                      <tr style="text-align: center;">
                        <td colspan="6">Firma del Comisionado</td>
                        
                      </tr>
                    	<tr>
                    		<td colspan="2">Nombre</td>
                        <td colspan="2">-------</td>
                        <td colspan="5"></td>
                        <td colspan="2">Monto Recibido</td>
                    		<td colspan="1">S/ ______</td>
                    	</tr>
                    	<tr>
                    		<td colspan="2">DNI N°</td>
                        <td colspan="2">-------</td>
                        <td colspan="5"></td>
                        <td colspan="2">Monto Rendido</td>
                        <td colspan="1">S/ ______</td>
                    	</tr>
                    	<tr>
                    		<td colspan="4">Ciudad de Cajamarca -----</td>
                        
                        <td colspan="5"></td>
                        <td colspan="2">Devoluci&oacute;n</td>
                        <td colspan="1">S/ ______</td>
                    	</tr>
                    	<tr>
                    		<td colspan="9"></td>
                        <td colspan="2">Total</td>
                        <td colspan="1">S/ ______</td>
                    	</tr>
                    	
                    	<tr>
                    		<td colspan="12">&nbsp;</td>
                    	</tr>
                    	
                    	
                    </table>
          <?php
			}else{
        echo mensajewa("No se han registrado comprobantes de gasto.");
      }
			mysqli_free_result($c1);
		//}else{
			//echo "Víaticos";
		//}
	}else{
		echo "Faltan datos";
	}
}else{
      echo "Restringido";
}
mysqli_close($cone);
?>