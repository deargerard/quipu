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
		                	<h3 class="box-title text-orange"><i class="fa fa-child"></i> Parientes</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrparpersonal" onclick="agrparpersonal(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
		                	<?php } ?>
		                </div>
		                <div>
		                	<?php
		                	$cp=mysqli_query($cone,"SELECT idPariente, TipoPariente, ApellidoPat, ApellidoMat, Nombres, TipoDoc, NumeroDoc, ContactoEme FROM pariente AS p INNER JOIN tipopariente AS tp ON p.idTipoPariente=tp.idTipoPariente WHERE idEmpleado=$idp ORDER BY FechaNac ASC");
		                	if(mysqli_num_rows($cp)>0){
		                	?>
		                	
		                	<table class="table table-hover table-bordered">
		                		<thead>
		                			<th>PARENTESCO</th>
		                			<th>NOMBRE</th>
		                			<th>T. DOC.</th>
		                			<th>N° DOC.</th>
		                			<th>CONT. EMERG.</th>
		                			<th>ACCIÓN</th>
		                		</thead>
		                		<tbody>
								<?php
								while($rp=mysqli_fetch_assoc($cp)){
									if($rp['ContactoEme']==1)
										$ce="SI";
									else
										$ce="NO";
								?>
									<tr>
			                			<td><?php echo $rp['TipoPariente'] ?></td>
			                			<td><?php echo $rp['ApellidoPat']." ".$rp['ApellidoMat'].", ".$rp['Nombres'] ?></td>
			                			<td><?php echo $rp['TipoDoc'] ?></td>
			                			<td><?php echo $rp['NumeroDoc'] ?></td>
			                			<td><?php echo $ce ?></td>
			                			<td>
		                					<div class="btn-group">
	                							<button class="btn bg-purple btn-xs dropdown-toggle" data-toggle="dropdown">
	                								<i class="fa fa-cog"></i>&nbsp;
	                								<span class="caret"></span>
	                								<span class="sr-only">Desplegar menú</span>
	                							</button>
	                							<ul class="dropdown-menu pull-right" role="menu">
	                								<li><a href="#" data-toggle="modal" data-target="#m_detparpersonal" onclick="detparpersonal(<?php echo $rp['idPariente'] ?>)">Detalle</a></li>
	                								<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
	                								<li class="divider"></li>
	                								<li><a href="#" data-toggle="modal" data-target="#m_ediparpersonal" onclick="ediparpersonal(<?php echo $rp['idPariente'] ?>)">Editar</a></li>
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
		                		<h4 class="text-maroon">No tiene registrado ningún pariente.</h4>
		                	<?php
		                	}
		                	mysqli_free_result($cp);
		                	?>
		                </div>
		            </div>
		        </div>
<?php
}else{
  echo accrestringidoa();
}
?>