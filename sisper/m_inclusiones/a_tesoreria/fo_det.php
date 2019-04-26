<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],16)){
	if(isset($_POST['ent']) && !empty($_POST['ent'])){
		$ent=iseguro($cone,$_POST['ent']);
			
		$cp=mysqli_query($cone, "SELECT e.motivo, de.tipo, de.numero, de.monto, de.fecha, de.tipmov, de.beneficiario FROM teentrega e INNER JOIN tedocentrega de ON e.idteentrega=de.idteentrega WHERE de.idteentrega=$ent;");
			if(mysqli_num_rows($cp)>0){
		$cp1=mysqli_query($cone, "SELECT motivo, empleado FROM teentrega WHERE idteentrega=$ent;");
			$rp=mysqli_fetch_assoc($cp1);				
?>
			<span class="text-purple"> <i class="fa fa-stack-overflow"></i> PAGOS POR <?php echo $rp['motivo']." REALIZADO POR ".nomempleado($cone, $rp['empleado']); ?> </span>
			<table class="table table-bordered table-hover">
				<thead>
				<tr>
					<th>FECHA</th>
					<th>TIPO</th>
					<th>NÚMERO</th>
					<th>MOVIMIENTO</th>
					<th>BENEFICIARIO</th>
					<th>MONTO</th>					
				</tr>
				</thead>
<?php			$tp=0;
				while($rpc=mysqli_fetch_assoc($cp)){

					if ($rpc['tipmov']==1) {
						$tp=$tp+$rpc['monto'];
					}else{
						$tp=$tp-$rpc['monto'];
						}					
?>
				<tr>
					<td><?php echo fnormal($rpc['fecha']); ?></td>					
					<td><?php echo $rpc['tipo']==2 ? "Recibo" : "Vale"; ?></td>
					<td><?php echo $rpc['numero']; ?></td>
					<td><?php echo $rpc['tipmov']==1 ? "Entrega" : "Recepción"; ?></td>
					<td><?php echo $rpc['beneficiario']; ?></td>
					<td><?php echo $rpc['monto']; ?></td>					
				</tr>
<?php
				}
?>				
			</table>

			<table class="table">
            	<tr>
	              <td class="text-orange">TOTAL PAGO POR <?php echo $rp['motivo']; ?></td>
	              <td class="text-orange"><strong><?php echo "S/  ".$tp; ?></strong></td>
            	</tr>
          	</table> 			
<?php
			}else{
				echo mensajewa("No se encontraron pagos para ese comprobante.");
			}
			mysqli_free_result($cp);
	}else{
		echo mensajewa("Error: Inique el documento.");
	}
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>
