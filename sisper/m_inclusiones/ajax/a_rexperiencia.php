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
		                	<h3 class="box-title text-orange"><i class="fa fa-industry"></i> Experiencia Laboral</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
		                	<a href="#" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrexppersonal" onclick="agrexppersonal(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
		                	<?php } ?>
		                </div>
		                <div>
		                	<?php
		                	$cel=mysqli_query($cone,"SELECT idExpLaboral, Institucion, Cargo, FechaIni, FechaFin FROM explaboral WHERE idEmpleado=$idp ORDER BY FechaIni DESC");
		                	if(mysqli_num_rows($cel)>0){
		                	?>
		                	
		                	<table class="table table-hover table-bordered">
		                		<thead>
		                			<th>INSTITUCIÓN</th>
		                			<th>CARGO</th>
		                			<th>TIEMPO</th>
		                			<th>ACCIÓN</th>
		                		</thead>
		                		<tbody>
								<?php
								while($rel=mysqli_fetch_assoc($cel)){
									if($rel['FechaFin']=='1970-01-01'){
										$f1=@date("y-m-d");
									}else{
										$f1=$rel['FechaFin'];
									}
									$f1=@date_create($f1);
									$f2=@date_create($rel['FechaIni']);
									$tie=date_diff($f1, $f2);
								?>
									<tr>
			                			<td><?php echo $rel['Institucion'] ?></td>
			                			<td><?php echo $rel['Cargo'] ?></td>
			                			<td><?php echo $tie->format('%y año(s), %m mes(es)') ?></td>
			                			<td>
		                					<div class="btn-group">
	                							<button class="btn bg-purple btn-xs dropdown-toggle" data-toggle="dropdown">
	                								<i class="fa fa-cog"></i>&nbsp;
	                								<span class="caret"></span>
	                								<span class="sr-only">Desplegar menú</span>
	                							</button>
	                							<ul class="dropdown-menu pull-right" role="menu">
	                								<li><a href="#" data-toggle="modal" data-target="#m_detexppersonal" onclick="detexppersonal(<?php echo $rel['idExpLaboral'] ?>)">Detalle</a></li>
	                								<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
	                								<li class="divider"></li>
	                								<li><a href="#" data-toggle="modal" data-target="#m_ediexppersonal" onclick="ediexppersonal(<?php echo $rel['idExpLaboral'] ?>)">Editar</a></li>
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
		                		<h4 class="text-maroon">No tiene registrada ninguna experiencia laboral.</h4>
		                	<?php
		                	}
		                	mysqli_free_result($cel);
		                	?>
		                </div>
		            </div>
		        </div>
<?php
}else{
  echo accrestringidoa();
}
?>