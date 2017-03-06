<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["idec"]) && !empty($_POST["idec"])){
    $idec=iseguro($cone,$_POST["idec"]);
    $cec=mysqli_query($cone,"SELECT * FROM estadoempcar WHERE idEmpleadoCargo=$idec ORDER BY idEstadoEmpCar DESC");
    if(mysqli_num_rows($cec)>0){
?>
<div class="row">
	<div class="col-md-12">
		
	</div>
	<div class="col-md-12">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>ESTADO</th>
					<th>INICIA</th>
					<th>FINALIZA</th>
					<th>N° RESOLUCIÓN</th>
					<th>N° DOCUMENTO</th>
					<th>MOTIVO</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($rec=mysqli_fetch_assoc($cec)){
					if ($rec['Estado']=='CESADO') {
						$est="<span class='text-maroon'>CESADO</span>";
					}else{
						$est="<span class='text-olive'>RESERVADO</span>";
					}
				?>
				<tr>
					<td><?php echo $est ?></td>
					<td><?php echo fnormal($rec['FechaIni']) ?></td>
					<td><?php echo fnormal($rec['FechaFin']) ?></td>
					<td><?php echo $rec['NumResolucion'] ?></td>
					<td><?php echo $rec['NumDocumento'] ?></td>
					<td><?php echo $rec['Motivo'] ?></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
		}else{
			echo "<h4 class='text-maroon'>El cargo, no tiene generado ningún estado adicional.</h4>";
		}
		mysqli_free_result($cec);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No eligió un cargo.</h4>";
	}
}
?>