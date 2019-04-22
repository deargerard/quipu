<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
	$mesini=iseguro($cone, $_POST["mesini"]);
	$mesfin=iseguro($cone, $_POST["mesfin"]);
	$soluc=iseguro($cone,$_POST["soluc"]);

	if(isset($mesini) && !empty($mesini) && isset($mesfin) && !empty($mesfin) && isset($soluc) && !empty($soluc)){
		$mesini=fmysql($mesini);
		$mesfin=fmysql($mesfin);
		if ($soluc==t) {
			$wsol="";
		}else {
			$wsol="AND ms.idSolucionador=$soluc";
		}
			$cp=mysqli_query($cone, "SELECT ma.idAtencion, ma.Fecha, ma.idEmpleado, ma.FecSolucion, ma.Estado, mp.Producto, ma.Registrador, mt.Tipo, msc.SubCategoria, mc.Categoria, ms.idSolucionador, ms.idEmpleado as Solucionador FROM maatencion ma INNER JOIN maproducto mp ON ma.idProducto=mp.idProducto INNER JOIN matipo mt ON mp.idTipo=mt.idTipo INNER JOIN masubcategoria msc ON mt.idSubCategoria=msc.idSubCategoria INNER JOIN macategoria mc ON msc.idCategoria=mc.idCategoria INNER JOIN masolucionador ms ON ma.idSolucionador=ms.idSolucionador WHERE (DATE_FORMAT(ma.FecSolucion, '%Y-%m-%d') BETWEEN '$mesini' AND '$mesfin') $wsol ORDER BY ma.Fecha DESC;");
?>
			<hr>
			<table id="dtatenciones" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>FECHA REPORTE</th>
					<th>FECHA SOLUCIÓN</th>
					<th>TIEMPO</th>
					<th>USUARIO</th>
					<th>CATEGORIA</th>
					<th>ASIGNADA A</th>
					<th>ASIGNADA POR</th>
					<th>ESTADO</th>
					<th>ACCIÓN</th>
				</tr>
			</thead>
			<tbody>
	<?php

				while($rp=mysqli_fetch_assoc($cp)){

					$reg=explode(" ", nomempleado($cone,$rp["Registrador"]));
					$sol=explode(" ", nomempleado($cone,$rp["Solucionador"]));

					if ($rp['Estado']==2) {
						$ffin=date('Y-m-d H:i');
					}else {
						$ffin=$rp['FecSolucion'];
					}

	?>
					<tr>
					<td style="font-size: 11px;"><span class="hidden"><?php echo $rp["Fecha"] ?></span><?php echo ftnormal($rp["Fecha"]) ?></td>
					<td style="font-size: 11px;"><?php echo ftnormal($rp["FecSolucion"]) ?></td>
					<td><?php echo diftiempo($rp['Fecha'], $ffin) ?></td>
					<td><?php echo nomempleado($cone,$rp["idEmpleado"]) ?></td>
					<td><?php echo $rp['Categoria']." - ".$rp['SubCategoria']." - ".$rp['Tipo']." - ".$rp['Producto'] ?></td>
					<td><?php echo $sol[2]." ".$sol[0] ?></td>
					<td><?php echo $reg[2]." ".$reg[0] ?></td>
					<td><?php echo ateestado($rp['Estado']); ?></td>
					<td><button type="button" class="btn btn-info btn-xs" onclick="iatencion(<?php echo $rp['idAtencion']; ?>)" data-toggle="modal" data-target="#m_iatencion"><i class="fa fa-info-circle"></i> Info</button></td>

				</tr>
	<?php
			}
			mysqli_free_result($cp);
	?>
			</tbody>
		</table>
			<script>
			$('#dtatenciones').DataTable({
				"order": [[0,"desc"]]
			});
			</script>
		<?php
	//}else {
			//echo mensajewa("No se encontraron resultados");
		//}
		mysqli_close($cone);
}else{
		echo mensajewa("Debe seleccionar un rango de fechas");
	}

}else{
  echo accrestringidoa();
}
?>
