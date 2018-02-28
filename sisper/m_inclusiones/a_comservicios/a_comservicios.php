<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],15)){
	$per=iseguro($cone,$_POST["per"]);
	if(isset($per) && !empty($per)){
	//$cec=mysqli_query($cone,"SELECT ec.idEmpleadoCargo FROM empleado e INNER JOIN empleadocargo ec ON e.idEmpleado=ec.idEmpleado WHERE e.idEmpleado=$per;");
	//$rec=mysqli_fetch_assoc($cec);
?>
<div class="row">
  <div class="col-sm-2"> <!--Botón Nuevo-->
		<button id="b_nuecomser" class="btn btn-info" data-toggle="modal" data-target="#m_ncomservicios" onclick="nuecomser(<?php echo $per?>)">Nueva Comisión de Servicios</button>
	</div>
  <div class="col-sm-7"> <!--Nombre-->
		<h4 class="text-aqua text-center"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$per); ?> </strong>| <small><i class="fa fa-black-tie"></i> <?php echo cargoe($cone, $per); ?></small></h4>
	</div>
</div>
<br>
<?php
	$ccs=mysqli_query($cone,"SELECT cs.idComServicios, concat(d.Numero,'-',d.Ano,'-',d.Siglas) AS Resolucion, d.FechaDoc, cs.FechaIni, cs.FechaFin, cs.Estado, cs.Vehiculo, SUBSTRING(cs.Descripcion, 1, 100) as Descripcion FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc WHERE cs.idEmpleado=$per;");

	if(mysqli_num_rows($ccs)>0){
	?>
		<table id="dtcomser" class="table table-bordered table-hover"> <!--Tabla que Lista las vacaciones-->
			<thead>
				<tr>
					<th>DESCRIPCIÓN</th>
					<th>INICIA</th>
	        <th>TERMINA</th>
					<th>NÚMERO DE RESOLUCIÓN</th>
					<th>FECHA RES.</th>
					<!-- <th>DÍAS</th> -->
	        <th>ESTADO</th>
					<th>ACCIÓN</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$est="";
				$cap="";
				while($rcs=mysqli_fetch_assoc($ccs)){

					if ($rcs['Estado']==1) {
						$est="success";
						$cap="Activa";
					}elseif ($rcs['Estado']==2){
						$est="danger";
						$cap="Cancelada";
					}

					// $dt=intervalo ($rcs['FechaFin'], $rcs['FechaIni']);
			?>
					<tr> <!--Fila de vacaciones-->
						<td><?php echo $rcs['Descripcion']?></td> <!--columna DESCRIPCIÓN-->
						<td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaIni']))?></td> <!--columna INICIO-->
						<td><?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin']))?></td> <!--columna FIN-->
						<td><?php echo $rcs['Resolucion']?></td> <!--columna NÚMERO DE RESOLUCIÓN-->
						<td><?php echo fnormal($rcs['FechaDoc'])?></td> <!--columna FECHA DOCUMENTO-->
						<!-- <td><?php //echo $dt ?></td> columna CAMTIDAD DE DIAS-->
						<td><span class='label label-<?php echo $est?>'><?php echo $cap?></span></td> <!--columna ESTADO-->
	          <td> <!--columna ACCIÓN-->
							<div class="btn-group">  <!--menu desplegable-->
		              <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
		                <i class="fa fa-cog"></i>&nbsp;
		                <span class="caret"></span>
		                <span class="sr-only">Desplegar menú</span>
		              </button>
		              <ul class="dropdown-menu pull-right" role="menu">
										<li><a href="#" data-toggle="modal" data-target="#m_dcomservicios" onclick="detcomser(<?php echo $rcs['idComServicios'] ?>)">Detalle</a></li>
										<?php
										if ($rcs['Estado']!='2'){
										?>
											<li><a href="#" data-toggle="modal" data-target="#m_ecomservicios" onclick="edicomser(<?php echo $rcs['idComServicios'] ?>)">Editar</a></li>
											<!-- <li><a href="#" data-toggle="modal" data-target="#m_nencargatura" onclick="nueenca(<?php //echo $rcs['idComServicios'] ?>)">Encargatura</a></li> -->
											<li><a href="#" data-toggle="modal" data-target="#m_ccomservicios" onclick="cancomser(<?php echo $rcs['idComServicios']?>)">Cancelar</a></li>
										<?php
										}
										?>
		              </ul>
		            </div>
	          </td> <!--/columna ACCIÓN-->
					</tr>
				<?php
				}
		}else{
			?>
			<tr>
				<?php
			 	echo mensajewa("El trabajador no tiene Comisiones de Servicios para mostrar");
				?>
			</tr>
				<?php
		}
			mysqli_free_result($ccs);
				?>
			</tbody>
		</table>
	<script>
	$('#dtcomser').DataTable({
		"order": [[2,"desc"]]
	});
	</script>
	<?php
	mysqli_close($cone);
	}else{
		echo mensajewa("Atención: Debe seleccionar el trabajador");
	}
}else{
  echo accrestringidoa();
}
?>
