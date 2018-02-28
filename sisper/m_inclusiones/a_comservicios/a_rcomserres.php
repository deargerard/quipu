<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],15)){
	$doc=iseguro($cone, $_POST["doc"]);
	if(isset($doc) && !empty($doc)){

			$c="SELECT e.idEmpleado, e.NumeroDoc, cs.FechaIni, cs.FechaFin, SUBSTRING(cs.Descripcion, 1, 100) as Descripcion, cs.Estado from comservicios cs INNER JOIN empleado e ON e.idEmpleado=cs.idEmpleado INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleadoCargo  INNER JOIN cardependencia cd ON ec.idEmpleadoCargo=cd.idEmpleadoCargo INNER JOIN doc d ON cs.idDoc=d.idDoc where cs.idDoc=$doc;";
			//echo $c;
			$ccs=mysqli_query($cone,$c);
			if (mysqli_num_rows($ccs)>0) {
		?>
		<hr>
		<table id="dtcomserres" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
					  <thead>
							<tr>
								<!-- <th style="font-size:12px;">DNI</th> -->
								<th style="font-size:12px;">EMPLEADO</th>
								<th style="font-size:12px;">CARGO</th>
								<th style="font-size:12px;">DESCRIPCIÓN</th>
			          <th style="font-size:12px;">INICIA</th>
								<th style="font-size:12px;">TERMINA</th>
			          <th style="font-size:12px;">ESTADO</th>

							</tr>
						</thead>
				<tbody>
					<?php
					while($rcs=mysqli_fetch_assoc($ccs)){
						if ($rcs['Estado']==1) {
							$est="success";
							$cap="Activa";
						}elseif ($rcs['Estado']==2){
							$est="danger";
							$cap="Cancelada";
						}
					?>
						<tr> <!--Fila de vacaciones-->
							<!-- <td><?php //echo $rcs['NumeroDoc']?></td> --> <!--columna DNI-->
							<td><?php echo nomempleado($cone, $rcs['idEmpleado'])?></td> <!--columna APELLIDOS Y NOMBRES-->
							<td style="font-size:12px;"><?php echo cargoe($cone, $rcs['idEmpleado'])?></td> <!--columna CARGO-->
							<td><?php echo $rcs['Descripcion']?></td> <!--columna DESCRIPCIÓN-->
							<td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaIni']))?></td> <!--columna INICIO-->
							<td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin']))?></td> <!--columna FIN-->
							<td><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->
						</tr>
						<?php
							}
						 ?>
				</tbody>
			</table>
			<script>
			$('#dtcomserres').DataTable({
				"order": [[4,"asc"]]
			});
			</script>
		<?php
	}else {
			echo mensajewa("No se encontraron resultados");
		}
		mysqli_close($cone);
}else{
		echo mensajeda("Error: Debe seleccionar al menos un valor en cada campo");
	}

}else{
  echo accrestringidoa();
}
?>
