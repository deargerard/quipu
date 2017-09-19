<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1)){
$idp=$_SESSION['idperper'];
?>
                <div class="row">
                	<div class="col-md-12">
                		<div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-black-tie"></i> Cargos</h3>
		                	<?php
		                	if(accesoadm($cone,$_SESSION['identi'],1)){
		                		$cca=mysqli_query($cone,"SELECT idEmpleadoCargo FROM empleadocargo WHERE idEmpleado=$idp AND (idEstadoCar=1)");
		                		if(!($rca=mysqli_fetch_assoc($cca))){
		                	?>

		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrcarpersonal" onclick="agrcarpersonal(<?php echo $idp ?>)"><i class="fa fa-briefcase"></i> Agregar Cargo</a>
		                	<?php
		                		}
		                		mysqli_free_result($cca);
		                	}
		                	?>
		                </div>
		                <?php
		                	$act="DESACTIVO";
		                	$cc=mysqli_query($cone,"SELECT ec.idEmpleadoCargo, ec.Reemplazado, c.Denominacion as Cargo, ec.idCondicionCar, ec.idModAcceso, ec.FechaAsu, cl.Tipo, escar.EstadoCar, esca.idEstadoCargo, esca.FechaIni FROM empleadocargo AS ec INNER JOIN cargo AS c ON ec.idCargo=c.idCargo INNER JOIN condicionlab AS cl ON ec.idCondicionLab=cl.idCondicionLab INNER JOIN estadocargo AS esca ON ec.idEmpleadoCargo=esca.idEmpleadoCargo INNER JOIN estadocar AS escar ON esca.idEstadoCar=escar.idEstadoCar WHERE idEmpleado=$idp AND esca.Estado=1 ORDER BY ec.idEstadoCar ASC,  ec.idEmpleadoCargo DESC");
		                	if(mysqli_num_rows($cc)>0){
		                		while($rc=mysqli_fetch_assoc($cc)){
            						$idec=$rc['idEmpleadoCargo'];
            						switch ($rc['idCondicionCar']) {
            							case 1:
            								$caremp=$rc['Cargo'];
            								break;
            							case 2:
            								$caremp=$rc['Cargo'].' (T)';
            								break;
            							case 3:
            								$caremp=$rc['Cargo'].' (P)';
            								break;
            						}
            						switch ($rc['idModAcceso']) {
            							case 6:
            								$mod='SUPLENCIA';
            								break;
            							
            							default:
            								$mod='--';
            								break;
            						}
            						if($rc['EstadoCar']=="ACTIVO"){
            							$act="ACTIVO";
            						}
		                ?>
		                <!--<div class="table-responsive">-->
		                <hr style="border: 1px dotted #FF851B;">
		                	<table class="table table-hover table-bordered">
		                		<thead>
		                			<tr>
		                				<th colspan="<?php echo $rc['EstadoCar']=="ACTIVO" ? 6 : 7; ?>"><h4 class="<?php echo $rc['EstadoCar']=="ACTIVO" ? "text-primary" : "text-gray"; ?>"><strong><?php echo $caremp ?></strong></h4></th>
		                			</tr>
		                			<tr>
		                				<th>COND. LAB.</th>
		                				<th>MOD.</th>
		                				<th>REEMPAZA A</th>
		                				<th>F. ASUME</th>
		                				<th>ESTADO</th>
		                			<?php if($rc['EstadoCar']!="ACTIVO"){ ?>
		                				<th><?php echo $rc['EstadoCar']; ?> EL</th>
		                			<?php } ?>
		                				<th>ACCIÓN</th>
		                			</tr>
		                		</thead>
		                		<tbody>
	                				<tr>
	                					<td><?php echo $rc['Tipo'] ?></td>
	                					<td><?php echo $mod ?></td>
	                					<td><?php echo nomempleado($cone,$rc['Reemplazado']) ?></td>
	                					<td><?php echo fnormal($rc['FechaAsu']) ?></td>
	                					<td><?php echo estadocar($rc['EstadoCar']); ?></td>
	                				<?php if($rc['EstadoCar']!="ACTIVO"){ ?>
	                					<td><?php echo fnormal($rc['FechaIni']); ?></td>
	                				<?php } ?>
	                					<td>
	                						<div class="btn-group">
	                							<button class="btn bg-purple btn-xs dropdown-toggle" data-toggle="dropdown">
	                								<i class="fa fa-cog"></i>&nbsp;
	                								<span class="caret"></span>
	                								<span class="sr-only">Desplegar menú</span>
	                							</button>
	                							<ul class="dropdown-menu pull-right" role="menu">
	                								<li><a href="#" data-toggle="modal" data-target="#m_detcargo" onclick="detcargo(<?php echo $rc['idEmpleadoCargo'] ?>)">Detalle</a></li>
	                								<?php
	                								if(accesoadm($cone,$_SESSION['identi'],1)){
	                									if($rc['EstadoCar']!="CESADO"){
	                								?>
	                								<li class="divider"></li>
	                								<li><a href="#" data-toggle="modal" data-target="#m_edicarpersonal" onclick="edicarpersonal(<?php echo $rc['idEmpleadoCargo'] ?>)">Editar Cargo</a></li>
	                								<li><a href="#" data-toggle="modal" data-target="#m_nueestcargo" onclick="nueestcargo(<?php echo $rc['idEmpleadoCargo'] ?>)">Cambiar Estado</a></li>
	                								<?php 
	                										if ($rc['FechaIni']!=$rc['FechaAsu']) {

	                								?>
	                								<li><a href="#" data-toggle="modal" data-target="#m_ediestcargo" onclick="ediestcargo(<?php echo $rc['idEstadoCargo'] ?>)">Editar Estado</a></li>
	                								<?php
	                										}
	                									}
	                								}
	                								?>
	                							</ul>
	                						</div>
	                					</td>
	                				</tr>
		                		</tbody>
		                	</table>
		                <!--</div>-->
		                	<div class="row">
			                	<div class="col-md-12">
			                	  <div class="box-header">
			                		<h4 class="box-title text-orange"><i class="fa fa-bus"></i> Desplazamientos</h4>
			                		<?php
			                		if(accesoadm($cone,$_SESSION['identi'],1)){ 
			                		if($rc['EstadoCar']=="ACTIVO"){
			                		?>
			                		<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_nuedesplazamiento" onclick="nuedesplazamiento(<?php echo $idec ?>)"><i class="fa fa-plane"></i> Desplazar</a>
			                		<?php
			                		}
			                		}
			                		?>
			                	  </div>
			                		<?php
			                		$cde=mysqli_query($cone,"SELECT idCarDependencia, Denominacion, FecInicio, Oficial, cd.Estado, tde.TipoDesplaza FROM cardependencia AS cd INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia INNER JOIN tipodesplaza AS tde ON cd.idTipoDesplaza=tde.idTipoDesplaza WHERE cd.idEmpleadoCargo=$idec ORDER BY FecInicio DESC");
			                		if(mysqli_num_rows($cde)>0){
			                		?>
			                		<table class="table table-hover table-bordered">
				                		<thead>
				                			<tr>
				                				<th>DEPENDENCIA</th>
				                				<th>T. DESPLAZ.</th>
				                				<th>OFICIAL</th>
				                				<th>DESDE</th>
				                				<th>ACCIÓN</th>
				                			</tr>
				                		</thead>
				                		<tbody>
				                		<?php
				                		while($rde=mysqli_fetch_assoc($cde)){
				                		?>
				                			<tr>
				                				<td><?php echo $rde['Denominacion']; ?></td>
				                				<td><?php echo $rde['TipoDesplaza'] ?></td>
				                				<td><?php echo $rde['Oficial']==1 ? "<span class='label label-success'>Sí</span>" : "<span class='label label-default'>No</span>" ?></td>
				                				<td><?php echo fnormal($rde['FecInicio']) ?></td>
				                				<td>
				                					<div class="btn-group">
			                							<button class="btn bg-purple btn-xs dropdown-toggle" data-toggle="dropdown">
			                								<i class="fa fa-cog"></i>&nbsp;
			                								<span class="caret"></span>
			                								<span class="sr-only">Desplegar menú</span>
			                							</button>
			                							<ul class="dropdown-menu pull-right" role="menu">
			                								<li><a href="#" data-toggle="modal" data-target="#m_detdesplazamiento" onclick="detdesplazamiento(<?php echo $rde['idCarDependencia'] ?>)">Detalle</a></li>
			                								<?php
			                								if(accesoadm($cone,$_SESSION['identi'],1)){
			                									if(($rc['EstadoCar']=='ACTIVO') AND $rde['Oficial']==1){
			                								?>
			                								<li class="divider"></li>
			                								<li><a href="#" data-toggle="modal" data-target="#m_edidesplazamiento" onclick="edidesplazamiento(<?php echo $rde['idCarDependencia'] ?>)">Editar</a></li>
			                								<?php
			                									}
			                								}
			                								?>
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
			                			<h4 class="text-maroon">No registra ningún desplazamiento.</h4>
			                		<?php
			                		}
			                		mysqli_free_result($cde);
			                		?>
			                	</div>
			                	<div class="col-md-12">
			                	</div>
		                	</div>
		                <?php
		                		}
		                	}else{
		                ?>
		                	<h4 class="text-maroon">Aún no tiene asignado ningún cargo.</h4>
		                <?php
		                	}
		                	mysqli_free_result($cc);
		                ?>
		            </div>
                </div>
<?php
}else{
  echo accrestringidoa();
}
?>