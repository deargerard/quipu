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

		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrcarpersonal" onclick="agrcarpersonal(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
		                	<?php
		                		}
		                		mysqli_free_result($cca);
		                	}
		                	?>
		                </div>
		                <?php
		                	$cc=mysqli_query($cone,"SELECT idEmpleadoCargo, c.Denominacion as Cargo, ec.idCondicionCar, ec.idModAcceso, idEstadoCar AS Est, ec.FechaAsu, cl.Tipo FROM empleadocargo AS ec INNER JOIN cargo AS c ON ec.idCargo=c.idCargo INNER JOIN condicionlab AS cl ON ec.idCondicionLab=cl.idCondicionLab WHERE idEmpleado=$idp ORDER BY FechaAsu DESC");
		                	if(mysqli_num_rows($cc)>0){
		                		while($rc=mysqli_fetch_assoc($cc)){
		                			if($rc['Est']==1){
            							$estado="<span class='label label-success'>ACTIVO</span>";
            						}elseif($rc['Est']==2){
            							$estado="<span class='label label-warning'>RESERVADO</span>";
            						}elseif ($rc['Est']==3){
            							$estado="<span class='label label-danger'>CESADO</span>";
            						}
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
		                ?>
		                <!--<div class="table-responsive">-->
		                <hr style="border: 1px dotted #CCCCCC; height: 0;">
		                	<table class="table table-striped table-bordered">
		                		<thead>
		                			<tr>
		                				<th>CARGO</th>
		                				<th>MOD.</th>
		                				<th>COND. LABORAL</th>
		                				<th>FEC. ASUME</th>
		                				<th>ACCIÓN</th>
		                			</tr>
		                		</thead>
		                		<tbody>
	                				<tr>
	                					<td><?php echo $caremp ?></td>
	                					<td><?php echo $mod ?></td>
	                					<td><?php echo $rc['Tipo'] ?></td>
	                					<td><?php echo fnormal($rc['FechaAsu']) ?></td>
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
	                									if($rc['Est']!=3){
	                								?>
	                								<li class="divider"></li>
	                								<li><a href="#" data-toggle="modal" data-target="#m_edicarpersonal" onclick="edicarpersonal(<?php echo $rc['idEmpleadoCargo'] ?>)">Editar</a></li>
	                								<?php
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
			                	<div class="col-md-8">
			                	  <div class="box-header">
			                		<h4 class="box-title text-orange"><i class="fa fa-angle-right"></i> Desplazamientos</h4>
			                		<?php
			                		if(accesoadm($cone,$_SESSION['identi'],1)){ 
			                		if($rc['Est']==1){
			                		?>
			                		<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_nuedesplazamiento" onclick="nuedesplazamiento(<?php echo $idec ?>)"><i class="fa fa-plus"></i> Nuevo</a>
			                		<?php
			                		}
			                		}
			                		?>
			                	  </div>
			                		<?php
			                		$cde=mysqli_query($cone,"SELECT idCarDependencia, Denominacion, TipoDesplaza, cd.Estado FROM cardependencia AS cd INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia INNER JOIN tipodesplaza AS tde ON cd.idTipoDesplaza=tde.idTipoDesplaza WHERE cd.idEmpleadoCargo=$idec ORDER BY FecInicio DESC");
			                		if(mysqli_num_rows($cde)>0){
			                		?>
			                		<table class="table table-striped table-bordered">
				                		<thead>
				                			<tr>
				                				<th>DEPENDENCIA</th>
				                				<th>TP. DESPLAZ.</th>
				                				<th>ACCIÓN</th>
				                			</tr>
				                		</thead>
				                		<tbody>
				                		<?php
				                		while($rde=mysqli_fetch_assoc($cde)){
				                		?>
				                			<tr>
				                				<td><?php echo $rde['Denominacion'] ?></td>
				                				<td><?php echo $rde['TipoDesplaza'] ?></td>
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
			                									if($rc['Est']!=3){
			                										if($rde['Estado']==5){
			                								?>
			                								<li class="divider"></li>
			                								<li><a href="#" data-toggle="modal" data-target="#m_edidesplazamiento" onclick="edidesplazamiento(<?php echo $rde['idCarDependencia'] ?>)">Editar</a></li>
			                								<?php
			                										}
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
			                	<div class="col-md-4">
			                	  <div class="box-header">
			                		<h4 class="box-title text-orange"><i class="fa fa-angle-right"></i> Estados</h4>
			                		<?php
			                		if(accesoadm($cone,$_SESSION['identi'],1)){
		                			if($rc['Est']!=3){
			                		?>
			                		<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_nueestcargo" onclick="nueestcargo(<?php echo $idec ?>)"><i class="fa fa-plus"></i> Nuevo</a>
			                		<?php
			                		}
			                		}
			                		?>
			                	  </div>
			                		<?php
			                		$ces=mysqli_query($cone,"SELECT idEstadoCargo, EstadoCar, FechaIni, ec.Estado FROM estadocargo AS ec INNER JOIN estadocar AS e ON ec.idEstadoCar=e.idEstadoCar WHERE idEmpleadoCargo=$idec ORDER BY FechaIni DESC");
			                		if(mysqli_num_rows($ces)>0){
			                		?>
			                		<table class="table table-striped table-bordered">
			                			<thead>
			                				<tr>
			                					<th>ESTADO</th>
			                					<th>DESDE</th>
			                					<th>ACCIÓN</th>
			                				</tr>
			                			</thead>
			                			<tbody>
			                		<?php
			                		while($res=mysqli_fetch_assoc($ces)){
			                			if($res['EstadoCar']=='ACTIVO'){
	            							$estado="<span class='label label-success'>ACTIVO</span>";
	            						}elseif($res['EstadoCar']=='RESERVADO'){
	            							$estado="<span class='label label-warning'>RESERVADO</span>";
	            						}elseif ($res['EstadoCar']=='CESADO'){
	            							$estado="<span class='label label-danger'>CESADO</span>";
	            						}
			                		?>
			                				<tr>
			                					<td><?php echo $estado ?></td>
			                					<td><?php echo fnormal($res['FechaIni']) ?></td>
			                					<td>
			                						<div class="btn-group">
			                							<button class="btn bg-purple btn-xs dropdown-toggle" data-toggle="dropdown">
			                								<i class="fa fa-cog"></i>&nbsp;
			                								<span class="caret"></span>
			                								<span class="sr-only">Desplegar menú</span>
			                							</button>
			                							<ul class="dropdown-menu pull-right" role="menu">
			                								<li><a href="#" data-toggle="modal" data-target="#m_detestcargo" onclick="detestcargo(<?php echo $res['idEstadoCargo'] ?>)">Detalle</a></li>
			                								<?php
			                								if(accesoadm($cone,$_SESSION['identi'],1)){
			                									if($rc['Est']!=3){
			                										if($res['Estado']==5){
			                								?>
			                								<li class="divider"></li>
			                								<li><a href="#" data-toggle="modal" data-target="#m_ediestcargo" onclick="ediestcargo(<?php echo $res['idEstadoCargo'] ?>)">Editar</a></li>
			                								<?php
			                										}
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
			                			<h4 class="text-maroon">No registra ningún estado adicional.</h4>
			                		<?php
			                		}
			                		mysqli_free_result($ces);
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