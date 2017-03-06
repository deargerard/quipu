<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
$idp=$_SESSION['idperper'];
?>
				<div class="row">
                	<?php 
	              		$cemp=mysqli_query($cone,"SELECT * FROM empleado WHERE idEmpleado=$idp");
	              		$remp=mysqli_fetch_assoc($cemp);
	              	?>
                	<div class="col-md-6">
                		<div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-user"></i> Datos Personales</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_edidatpersonales" onclick="edidatpersonales(<?php echo $idp ?>)"><i class="fa fa-pencil"></i> Editar</a>
		                	<?php } ?>
		                </div>
		                <div class="table-responsive">
		                	<table class="table table-striped table-bordered">
		                		<tbody>
		                			<tr>
		                				<th><?php echo $remp["TipoDoc"] ?></th>
		                				<td><?php echo $remp["NumeroDoc"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Sexo</th>
		                				<td><?php echo sexo($remp["Sexo"]) ?></td>
		                			</tr>
		                			<tr>
		                				<th>Fecha Nac.</th>
		                				<td><?php echo fnormal($remp["FechaNac"]) ?></td>
		                			</tr>
		                			<tr>
		                				<th>Nacionalidad</th>
		                				<td><?php echo $remp["Nacionalidad"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Lugar Nac.</th>
		                				<td><?php echo disprodep($cone, $remp["idDistrito"]) ?></td>
		                			</tr>
		                			<tr>
		                				<th>Estado Civil</th>
		                				<td><?php echo estciv($cone, $remp["idEstadoCivil"]) ?></td>
		                			</tr>
		                			<tr>
		                				<th>Libreta Mil.</th>
		                				<td><?php echo $remp["LibretaMil"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>ESSALUD</th>
		                				<td><?php echo $remp["Autogenerado"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>RUC</th>
		                				<td><?php echo $remp["RUC"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Correo Pers.</th>
		                				<td><?php echo $remp["CorreoPer"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Correo Inst.</th>
		                				<td><?php echo $remp["CorreoIns"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Cuenta BN</th>
		                				<td><?php echo $remp["NumeroCuenta"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Entidad CTS</th>
		                				<td><?php echo $remp["EntidadCts"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Grupo Sang.</th>
		                				<td><?php echo $remp["GrupoSan"] ?></td>
		                			</tr>
		                		</tbody>
		                	</table>
		                </div>
		                <!--Nueva Tabla-->
		                
		            </div>
					<!--Siguiente Columna-->
		            <div class="col-md-6">
                		<div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-graduation-cap"></i> Grado Instrucción</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_edigrainstruccion" onclick="edigrainstruccion(<?php echo $idp ?>)"><i class="fa fa-pencil"></i> Editar</a>
		                	<?php } ?>
		                </div>
		                <div class="table-responsive">
		                	<table class="table table-striped table-bordered">
		                		<tbody>
		                			<tr>
		                				<th>Grado</th>
		                				<td><?php echo gradoi($cone, $idp) ?></td>
		                			</tr>
		                			<tr>
		                				<th>Nivel</th>
		                				<td><?php echo niveli($cone, $idp) ?></td>
		                			</tr>
		                			<tr>
		                				<th>Especialidad</th>
		                				<td><?php echo $remp["Especialidad"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Institución</th>
		                				<td><?php echo $remp["Institucion"] ?></td>
		                			</tr>
		                		</tbody>
		                	</table>
		                </div>
		                <!--Nueva Tabla-->
		                <div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-hospital-o"></i> Sistema Pensión</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_edisispension" onclick="edisispension(<?php echo $idp ?>)"><i class="fa fa-pencil"></i> Editar</a>
		                	<?php } ?>
		                </div>
		                <div class="table-responsive">
		                	<table class="table table-striped table-bordered">
		                		<?php
		                		$cpe=mysqli_query($cone,"SELECT CUSPP, FecAfiliacion FROM pensionempleado WHERE idEmpleado=$idp");
		                		$rpe=mysqli_fetch_assoc($cpe);
		                		?>
		                		<tbody>
		                			<tr>
		                				<th>Institución</th>
		                				<td><?php echo pensioni($cone, $idp) ?></td>
		                			</tr>
		                			<tr>
		                				<th>CUPS</th>
		                				<td><?php echo $rpe['CUSPP'] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Fecha Afiliación</th>
		                				<td><?php echo fnormal($rpe['FecAfiliacion']) ?></td>
		                			</tr>
		                		</tbody>
		                		<?php
		                		mysqli_free_result($cpe);
		                		?>
		                	</table>
		                </div>
		                <!--Nueva Tabla-->
		                <div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-building-o"></i> Domicilio</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_edidomicilio" onclick="edidomicilio(<?php echo $idp ?>)"><i class="fa fa-pencil"></i> Editar</a>
		                	<?php } ?>
		                </div>
		                <div class="table-responsive table-bordered">
		                	<?php 
		                		$cdom=mysqli_query($cone,"SELECT * FROM domicilio WHERE idEmpleado=$idp");
		                		$rdom=mysqli_fetch_assoc($cdom);
		                	?>
		                	<table class="table table-striped">
		                		<tbody>
		                			<tr>
		                				<th>Condición</th>
		                				<td><?php echo $rdom["Condicion"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Dirección</th>
		                				<td><?php echo $rdom["Direccion"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Urbanización</th>
		                				<td><?php echo $rdom["Urbanizacion"] ?></td>
		                			</tr>
		                			<tr>
		                				<th>Ubicación</th>
		                				<td><?php echo disprodep($cone, $rdom["idDistrito"]) ?></td>
		                			</tr>
		                		</tbody>
		                	</table>
		                	<?php
		                		mysqli_free_result($cdom);
		                	?>
		                </div>
		                <!--Nueva tabla-->
		            </div>
                </div>
<?php
}else{
  echo accrestringidoa();
}
?>