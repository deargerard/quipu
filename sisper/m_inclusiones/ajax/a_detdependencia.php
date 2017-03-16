<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],6)){
	$idd=iseguro($cone,$_POST["idd"]);
	if(isset($idd) && !empty($idd)){
		$cmandet=mysqli_query($cone,"SELECT idDependencia, idDependenciaPadre, idDistritoFiscal, Denominacion, Siglas, d.Estado, concat(e.ApellidoPat, ' ', e.ApellidoMat, ', ', e.Nombres) as nombre FROM dependencia d LEFT JOIN empleado e ON e.idEmpleado=d.jefe WHERE idDependencia=$idd");
		$rmandet=mysqli_fetch_assoc($cmandet);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2" class="text-center" ><h4 class="text-aqua"><?php echo $rmandet['Denominacion'] ?></h4></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>Pertenece a</th>
					<td><?php echo nomdependencia($cone, $rmandet['idDependenciaPadre']) ?></td>
				</tr>
				<tr>
					<th>Siglas</th>
					<td><?php echo $rmandet['Siglas'] ?></td>
				</tr>
				<tr>
					<th>Responsable</th>
					<td><?php echo $rmandet['nombre'] ?></td>
				</tr>
				<tr>
					<th>Distrito Fiscal</th>
					<td><?php echo nomdisfiscal($cone,$rmandet['idDistritoFiscal']) ?></td>
				</tr>
				<?php if(!empty($rmandet['Observacion'])){ ?>
				<tr>
					<th>Observación</th>
					<td><?php $rmandet['Observacion'] ?></td>
				</tr>
				<?php } ?>
				<tr>
				<?php
					if($rmandet['Estado']==1)
						$est='<span class="label label-success">Activo</span>';
					else
						$est='<span class="label label-danger">Inactivo</span>';
				?>
					<th>Estado</th>
					<td><?php echo $est ?></td>
				</tr>
				<tr>
					<th colspan="2" class="text-center">AMBIENTES CON LOS QUE CUENTA LA DEPENDENCIA</th>
							<table id="dtamb" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>TIPO</th>
										<th>AMBIENTE</th>
										<th>LOCAL</th>
										<th>PISO</th>
									</tr>
								</thead>
								<tbody>
									<?php
											$camb=mysqli_query($cone,"SELECT dl.idDependenciaLocal, dl.Estado, t.Tipo, dl.Oficina, l.Direccion, p.Piso FROM dependencialocal as dl INNER JOIN local AS l ON dl.idLocal=l.idLocal INNER JOIN tipolocal AS t ON dl.idTipoLocal= t.idTipoLocal INNER JOIN piso AS p ON dl.idPiso=p.idPiso WHERE dl.idDependencia=$idd and dl.Estado=1");

											while($ramb=mysqli_fetch_assoc($camb)){
									?>
									<tr>
										<td><?php echo $ramb['Tipo'] ?></td>
										<td><?php echo $ramb['Oficina'] ?></td>
										<td><?php echo $ramb['Direccion']?></td>
										<td><?php echo $ramb['Piso'] ?></td>
										</tr>
									<?php
										}
										mysqli_free_result($camb);
									?>
								</tbody>
								</table>
					</tr>
			</tbody>
		</table>
	</div>
	<?php
		mysqli_free_result($cmandet);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ninguna dependencia.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>
