<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
$idp=$_SESSION['idperper'];
?>
            	<div>
              		<strong class="text-orange"><i class="fa fa-phone-square margin-r-5"></i> Teléfonos</strong>
              		<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
              		<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrtelefono" onclick="agrtelefono(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
              		<?php } ?>
				</div>
				<div class="clearfix"></div>
				<div class="table-responsive">
					<br>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>Tipo</th>
								<th>Número</th>
								<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
								<th>Acción</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
						<?php
							if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){
							$cte=mysqli_query($cone,"SELECT idTelefonoEmp, TipoTelefono, Numero, te.Estado FROM telefonoemp as te RIGHT JOIN tipotelefono AS tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE idEmpleado=$idp");
							}else{
							$cte=mysqli_query($cone,"SELECT TipoTelefono, Numero FROM telefonoemp as te RIGHT JOIN tipotelefono AS tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE idEmpleado=$idp AND te.Estado=1");
							}
							while($rte=mysqli_fetch_assoc($cte)){
						?>
							<tr>
								<td><?php echo $rte["TipoTelefono"] ?></td>
								<td><?php echo $rte["Numero"] ?></td>
								<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
								<td>
									<a href="" class="text-purple" title="Editar" data-toggle="modal" data-target="#m_editelefono" onclick="editelefono(<?php echo $rte["idTelefonoEmp"] ?>)"><i class="fa fa-pencil-square"></i></a>
									<?php if($rte["Estado"]==1){ ?>
									<a href="" class="text-red" title="Desactivar" data-toggle="modal" data-target="#m_destelefono" onclick="destelefono(<?php echo $rte["idTelefonoEmp"] ?>)"><i class="fa fa-minus-square"></i></a>
									<?php } ?>
									<?php if($rte["Estado"]==0){ ?>
									<a href="" class="text-olive" title="Activar" data-toggle="modal" data-target="#m_acttelefono" onclick="acttelefono(<?php echo $rte["idTelefonoEmp"] ?>)"><i class="fa fa-check-square"></i></a>
									<?php } ?>
								</td>
								<?php } ?>
							</tr>
						<?php
							}
							mysqli_free_result($cte);
						?>
						</tbody>
					</table>
				</div>
<?php
}else{
  echo accrestringidoa();
}
?>