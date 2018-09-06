<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
$idp=$_SESSION['idperper'];
?>
				<div class="row">
                	<div class="col-md-12">
                		<div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-file-text-o"></i> Capacitaciones</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
		                	<a href="#" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrcappersonal" onclick="agrcappersonal(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
		                	<?php } ?>
		                </div>
		                <div>
		                	<?php
		                	$cca=mysqli_query($cone,"SELECT idCapacitacion, Denominacion, TipCap, Duracion FROM capacitacion AS c INNER JOIN tipcap AS tc ON c.idTipCap=tc.idTipCap WHERE idEmpleado=$idp ORDER BY FechaIni DESC");
		                	if(mysqli_num_rows($cca)>0){
		                	?>
		                	
		                	<table class="table table-hover table-bordered">
		                		<thead>
		                			<th>DENOMINACIÓN</th>
		                			<th>TIPO</th>
		                			<th>DURACIÓN</th>
		                			<th>ACCIÓN</th>
		                		</thead>
		                		<tbody>
								<?php
								while($rca=mysqli_fetch_assoc($cca)){
								?>
									<tr>
			                			<td><?php echo $rca['Denominacion'] ?></td>
			                			<td><?php echo $rca['TipCap'] ?></td>
			                			<td><?php echo $rca['Duracion']." Horas" ?></td>
			                			<td>
		                					<div class="btn-group">
	                							<button class="btn bg-purple btn-xs dropdown-toggle" data-toggle="dropdown">
	                								<i class="fa fa-cog"></i>&nbsp;
	                								<span class="caret"></span>
	                								<span class="sr-only">Desplegar menú</span>
	                							</button>
	                							<ul class="dropdown-menu pull-right" role="menu">
	                								<li><a href="#" data-toggle="modal" data-target="#m_detcappersonal" onclick="detcappersonal(<?php echo $rca['idCapacitacion'] ?>)">Detalle</a></li>
	                								<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
	                								<li class="divider"></li>
	                								<li><a href="#" data-toggle="modal" data-target="#m_edicappersonal" onclick="edicappersonal(<?php echo $rca['idCapacitacion'] ?>)">Editar</a></li>
	                								<?php } ?>
	                							</ul>
	                						</div>
			                			</td>
			                		</tr>
		                		<?php
		                		}
		                		?>
		                		</tbody>
		                	</table>
		                	<?php
		                	}else{
		                	?>
		                		<h4 class="text-maroon">No tiene registrado ninguna capacitación.</h4>
		                	<?php
		                	}
		                	mysqli_free_result($cca);
		                	?>
		                </div>
		            </div>
		        </div>
<?php
}else{
  echo accrestringidoa();
}
?>