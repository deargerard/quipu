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
		                	<h3 class="box-title text-orange"><i class="fa fa-graduation-cap"></i> Grados y Titulos</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrgrapersonal" onclick="agrgrapersonal(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
		                	<?php } ?>
		                </div>
		                <div>
		                	<?php
		                	$cgt=mysqli_query($cone,"SELECT idGradoTitulo, NivGraTit, Denominacion, Institucion, NumeroCol FROM gradotitulo AS gt INNER JOIN nivgratit AS ngt ON gt.idNivGraTit=ngt.idNivGraTit WHERE idEmpleado=$idp ORDER BY FechaExp DESC");
		                	if(mysqli_num_rows($cgt)>0){
		                	?>
		                	
		                	<table class="table table-striped table-bordered">
		                		<thead>
		                			<th>GRADO/TITULO</th>
		                			<th>DENOMINACIÓN</th>
		                			<th>INSTITUCIÓN</th>
		                			<th>NUM. COLEG.</th>
		                			<th>ACCIÓN</th>
		                		</thead>
		                		<tbody>
								<?php
								while($rgt=mysqli_fetch_assoc($cgt)){
								?>
									<tr>
			                			<td><?php echo $rgt['NivGraTit'] ?></td>
			                			<td><?php echo $rgt['Denominacion'] ?></td>
			                			<td><?php echo $rgt['Institucion'] ?></td>
			                			<td><?php echo $rgt['NumeroCol'] ?></td>
			                			<td>
		                					<div class="btn-group">
	                							<button class="btn bg-purple btn-xs dropdown-toggle" data-toggle="dropdown">
	                								<i class="fa fa-cog"></i>&nbsp;
	                								<span class="caret"></span>
	                								<span class="sr-only">Desplegar menú</span>
	                							</button>
	                							<ul class="dropdown-menu pull-right" role="menu">
	                								<li><a href="#" data-toggle="modal" data-target="#m_detgrapersonal" onclick="detgrapersonal(<?php echo $rgt['idGradoTitulo'] ?>)">Detalle</a></li>
	                								<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
	                								<li class="divider"></li>
	                								<li><a href="#" data-toggle="modal" data-target="#m_edigrapersonal" onclick="edigrapersonal(<?php echo $rgt['idGradoTitulo'] ?>)">Editar</a></li>
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
		                		<h4 class="text-maroon">No tiene registrado ningún grado o titulo.</h4>
		                	<?php
		                	}
		                	mysqli_free_result($cgt);
		                	?>
		                </div>
		            </div>
		        </div>
<?php
}else{
  echo accrestringidoa();
}
?>