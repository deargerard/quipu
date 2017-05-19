<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],3)){
	$per=iseguro($cone,$_POST["per"]);
	$estvac=iseguro($cone,$_POST["estvac"]);
	$convac=iseguro($cone,$_POST["convac"]);
	if(isset($per) && !empty($per) && isset($estvac) && !empty($estvac) && isset($convac)&& !empty($convac)){
    // Obtener  idEmpleadoCargo, fechas para cálculo de vacaciones
		$cin=mysqli_query($cone,"SELECT idEmpleadoCargo, FechaVac, FechaAsu FROM empleadocargo WHERE idEmpleado=$per AND idEstadoCar=1");
		$rin=mysqli_fetch_assoc($cin);
?>
<div class="row">
  <div class="col-sm-2"> <!--Botón Nuevo-->
		boton
  </div>
  <div class="col-sm-7"> <!--Nombre-->
		<h4 class="text-aqua text-center"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$per); ?> </strong>| <small><i class="fa fa-black-tie"></i> <?php echo cargoe($cone,$per); ?></small></h4>
	</div>
	<div class="col-sm-3"> <!--Nombre-->
     fecha
	</div>
</div>
<br>

<table id="dtdir" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
			  <thead>
					<tr>
						<th>PERÍODO</th>
						<th>NÚMERO DE RESOLUCIÓN</th>
						<th>FECHA</th>
						<th>PROGRAMACIÓN</th>
						<th>DÍAS</th>
						<th>INICIA</th>
	          <th>TERMINA</th>
	          <th>ESTADO</th>
						<th>ACCIÓN</th>
					</tr>
				</thead>
		<tbody>

				<tr> <!--Fila de vacaciones-->
					<td><?php echo "a"//$rvac['PeriodoVacacional']?></td> <!--columna PERÍODO-->
					<td><?php echo "b"//$rvac['Resolucion']?></td> <!--columna NÚMERO DE RESOLUCIÓN-->
					<td><?php echo "b"//fnormal($rvac['FechaDoc'])?></td> <!--columna FECHA DOCUMENTO-->
					<td><?php echo "b"//$con ?></td> <!--columna CONDICIÓN-->
					<td><?php echo "b"//$dt ?></td> <!--columna CAMTIDAD DE DIAS-->
					<td><?php echo "b"//fnormal($rvac['FechaIni'])?></td> <!--columna INICIO-->
					<td><?php echo "b"//fnormal($rvac['FechaFin'])?></td> <!--columna FIN-->
					<td><span class='label label-<?php //echo $est?>'><?php //echo $cap?></span></td> <!--columna ESTADO-->
          <td> <!--columna ACCIÓN-->
					</td> <!--/columna ACCIÓN-->
				</tr>

		</tbody>

	</table>

<?php
		mysqli_close($cone);

	}else{
		echo mensajeda("Error: No se seleccionó ningún trabajador");
	}

}else{
  echo accrestringidoa();
}
?>
