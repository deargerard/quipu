<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
if(accesocon($cone,$_SESSION['identi'],1) || accesocon($cone,$_SESSION['identi'],9)){
	if(isset($_GET['idp']) && !empty($_GET['idp'])){
		$_SESSION['idperper']=iseguro($cone,$_GET['idp']);
		$_SESSION['mo']=false;
	}else{
		$_SESSION['idperper']=$_SESSION['identi'];
		$_SESSION['mo']=true;
	}
	$idp=$_SESSION['idperper'];
	$ce=mysqli_query($cone,"SELECT * FROM empleado WHERE idEmpleado=$idp");
	if($re=mysqli_fetch_assoc($ce)){
		$numdoc=$re['NumeroDoc'];

//$cce=mysqli_query($cone,"SELECT * FROM empleado AS e LEFT JOIN empleadocargo AS ec ON e.idEmpleado=ec.idEmpleado WHERE idEmpleado=$idp");
//$rce=mysqli_fetch_assoc($cce);

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ficha Personal
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Personal</li>
        <li class="active">Perfil</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary" id="nomcare">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo mfotop($re['NumeroDoc']) ?>" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo $re['ApellidoPat']." ".$re['ApellidoMat'].", ".$re['Nombres'] ?></h3>

              <p class="text-muted text-center"><strong><?php echo cargoe($cone,$idp) ?></strong></p>
              <p class="text-muted text-center"><small><?php echo dependenciae($cone,$idp) ?></small></p>
              <?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
              <button class="btn btn-info btn-block btn-xs" data-toggle="modal" data-target="#m_camfoto" onclick="camfoto(<?php echo "'$numdoc'" ?>)">Cambiar foto</button>
              <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Datos de Contacto</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="dcontacto">
            	<div>
              		<strong class="text-orange"><i class="fa fa-phone-square margin-r-5"></i> Teléfonos</strong>
              		<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
              		<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrtelefono" onclick="agrtelefono(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
              		<?php } ?>
				</div>
				<div class="clearfix"></div>
				<div class="table-responsive">
					<br>
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Tipo</th>
								<th>Número</th>
								<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
								<th>Acción</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
						<?php
							if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
							$cte=mysqli_query($cone,"SELECT idTelefonoEmp, TipoTelefono, Numero, te.Estado FROM telefonoemp as te RIGHT JOIN tipotelefono AS tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE idEmpleado=$idp");
							}else{
							$cte=mysqli_query($cone,"SELECT TipoTelefono, Numero FROM telefonoemp as te RIGHT JOIN tipotelefono AS tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE idEmpleado=$idp AND te.Estado=1");
							}
							while($rte=mysqli_fetch_assoc($cte)){
						?>
							<tr>
								<td><?php echo $rte["TipoTelefono"] ?></td>
								<td><?php echo $rte["Numero"] ?></td>
								<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
								<td>
									<a href="" class="text-purple" title="Editar" data-toggle="modal" data-target="#m_editelefono" onclick="editelefono(<?php echo $rte["idTelefonoEmp"] ?>)"><i class="fa fa-pencil"></i></a>&nbsp;
									<a href="" class="text-red" title="Eliminar" data-toggle="modal" data-target="#m_elitelefono" onclick="elitelefonop(<?php echo $rte["idTelefonoEmp"] ?>)"><i class="fa fa-trash"></i></a>
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
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#datose" data-toggle="tab">Datos</a></li>
              <?php if(accesocon($cone,$_SESSION['identi'],1)){ ?>
              <li><a href="#cargoe" data-toggle="tab">Cargos</a></li>
              <?php } ?>
              <li><a href="#parientese" data-toggle="tab">Parientes</a></li>
              <li><a href="#gradose" data-toggle="tab">Grados/Titulos</a></li>
              <li><a href="#capacitacionese" data-toggle="tab">Capacitaciones</a></li>
              <li><a href="#experienciae" data-toggle="tab">Experiencia</a></li>
              <li><a href="#discapacidade" data-toggle="tab">Discapacidad</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="datose">

                <!-- Tabla -->
                <div class="row">
                	<?php
	              		$cemp=mysqli_query($cone,"SELECT * FROM empleado WHERE idEmpleado=$idp");
	              		$remp=mysqli_fetch_assoc($cemp);
	              	?>
                	<div class="col-md-6">
                		<div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-user"></i> Datos Personales</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_edidatpersonales" onclick="edidatpersonales(<?php echo $idp ?>)"><i class="fa fa-pencil"></i> Editar</a>
		                	<?php } ?>
		                </div>
		                <div class="table-responsive">
		                	<table class="table table-hover">
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
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_edigrainstruccion" onclick="edigrainstruccion(<?php echo $idp ?>)"><i class="fa fa-pencil"></i> Editar</a>
		                	<?php } ?>
		                </div>
		                <div class="table-responsive">
		                	<table class="table table-hover">
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
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_edisispension" onclick="edisispension(<?php echo $idp ?>)"><i class="fa fa-pencil"></i> Editar</a>
		                	<?php } ?>
		                </div>
		                <div class="table-responsive">
		                	<table class="table table-hover">
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
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_edidomicilio" onclick="edidomicilio(<?php echo $idp ?>)"><i class="fa fa-pencil"></i> Editar</a>
		                	<?php } ?>
		                </div>
		                <div class="table-responsive">
		                	<?php
		                		$cdom=mysqli_query($cone,"SELECT * FROM domicilio WHERE idEmpleado=$idp");
		                		$rdom=mysqli_fetch_assoc($cdom);
		                	?>
		                	<table class="table table-hover">
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
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="cargoe">
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
            								$mod='-';
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
		                				<th>REEMPLAZA A</th>
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
			                		$cde=mysqli_query($cone,"SELECT idCarDependencia, Denominacion, FecInicio, FecFin, Oficial, cd.Estado, tde.TipoDesplaza, tde.idTipoDesplaza FROM cardependencia AS cd INNER JOIN dependencia AS d ON cd.idDependencia=d.idDependencia INNER JOIN tipodesplaza AS tde ON cd.idTipoDesplaza=tde.idTipoDesplaza WHERE cd.idEmpleadoCargo=$idec ORDER BY FecInicio DESC");
			                		if(mysqli_num_rows($cde)>0){
			                		?>
			                		<table class="table table-hover table-bordered">
				                		<thead>
				                			<tr>
				                				<th>DEPENDENCIA</th>
				                				<th>T. DESPLAZ.</th>
				                				<th>OFICIAL</th>
				                				<th>F. INICIO</th>
				                				<th>F. FIN</th>
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
				                				<td><?php echo fnormal($rde['FecFin']) ?></td>
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
			                								?>
			                								<li class="divider"></li>
			                								<li><a href="#" data-toggle="modal" data-target="#m_edidesplazamiento" onclick="edidesplazamiento(<?php echo $rde['idCarDependencia'].", 'edat'" ?>)">Editar Datos</a></li>
			                								<?php if($rde['Oficial']!=1){ ?>
			                								<li><a href="#" data-toggle="modal" data-target="#m_edidesplazamiento" onclick="edidesplazamiento(<?php echo $rde['idCarDependencia'].", 'eofi'" ?>)">Oficializar</a></li>
			                								<?php } ?>
			                								<?php if($rde['idTipoDesplaza']!=1){ ?>
			                								<li><a href="#" data-toggle="modal" data-target="#m_edidesplazamiento" onclick="edidesplazamiento(<?php echo $rde['idCarDependencia'].", 'efin'" ?>)">Editar Fecha Inicio</a></li>
			                								<?php } ?>
			                								<?php if($rde['Estado']!=1){ ?>
			                								<li><a href="#" data-toggle="modal" data-target="#m_edidesplazamiento" onclick="edidesplazamiento(<?php echo $rde['idCarDependencia'].", 'effi'" ?>)">Editar Fecha Fin</a></li>
			                								<?php } ?>
			                								<?php
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
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="parientese">
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
							<div class="table-responsive">
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
	                								<?php if(accesoadm($cone,$_SESSION['identi'],1)  || accesoadm($cone,$_SESSION['identi'],9)){ ?>
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
		                	</div>
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
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="gradose">
                <div class="row">
                	<div class="col-md-12">
                		<div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-graduation-cap"></i> Grados y Titulos</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
		                	<a href="" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrgrapersonal" onclick="agrgrapersonal(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
		                	<?php } ?>
		                </div>
		                <div>
		                	<?php
		                	$cgt=mysqli_query($cone,"SELECT idGradoTitulo, NivGraTit, Denominacion, Institucion, NumeroCol FROM gradotitulo AS gt INNER JOIN nivgratit AS ngt ON gt.idNivGraTit=ngt.idNivGraTit WHERE idEmpleado=$idp ORDER BY FechaExp DESC");
		                	if(mysqli_num_rows($cgt)>0){
		                	?>
							<div class="table-responsive">
		                	<table class="table table-hover table-bordered">
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
	                								<?php if(accesoadm($cone,$_SESSION['identi'],1)  || accesoadm($cone,$_SESSION['identi'],9)){ ?>
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
		                	</div>
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
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="capacitacionese">
                <div class="row">
                	<div class="col-md-12">
                		<div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-file-text-o"></i> Capacitaciones</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
		                	<a href="#" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrcappersonal" onclick="agrcappersonal(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
		                	<?php } ?>
		                </div>
		                <div>
		                	<?php
		                	$cca=mysqli_query($cone,"SELECT idCapacitacion, Denominacion, TipCap, Duracion FROM capacitacion AS c INNER JOIN tipcap AS tc ON c.idTipCap=tc.idTipCap WHERE idEmpleado=$idp ORDER BY FechaIni DESC");
		                	if(mysqli_num_rows($cca)>0){
		                	?>
							<div class="table-responsive">
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
	                								<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
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
		                	</div>
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
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="experienciae">
                <div class="row">
                	<div class="col-md-12">
                		<div class="box-header">
		                	<h3 class="box-title text-orange"><i class="fa fa-industry"></i> Experiencia Laboral</h3>
		                	<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
		                	<a href="#" class="btn btn-info pull-right btn-xs" data-toggle="modal" data-target="#m_agrexppersonal" onclick="agrexppersonal(<?php echo $idp ?>)"><i class="fa fa-plus"></i> Agregar</a>
		                	<?php } ?>
		                </div>
		                <div>
		                	<?php
		                	$cel=mysqli_query($cone,"SELECT idExpLaboral, Institucion, Cargo, FechaIni, FechaFin FROM explaboral WHERE idEmpleado=$idp ORDER BY FechaIni DESC");
		                	if(mysqli_num_rows($cel)>0){
		                	?>
							
							<div class="table-responsive">
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
	                								<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
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
		                	</div>
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
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="discapacidade">

              </div>
              <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
<!--Modal Detalle Cargo-->
<div class="modal fade" id="m_detcargo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CARGO</h4>
      </div>
      <div class="modal-body" id="r_detcargo">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle Cargo-->
<!--Modal Detalle Desplazamiento-->
<div class="modal fade" id="m_detdesplazamiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Desplazamiento</h4>
      </div>
      <div class="modal-body" id="r_detdesplazamiento">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle Desplazamiento-->
<!--Modal Detalle Estado Cargo-->
<div class="modal fade" id="m_detestcargo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Estado de cargo</h4>
      </div>
      <div class="modal-body" id="r_detestcargo">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle Estado Cargo-->
<!--Modal Detalle Pariente-->
<div class="modal fade" id="m_detparpersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Pariente</h4>
      </div>
      <div class="modal-body" id="r_detparpersonal">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle Pariente-->
<!--Modal Detalle grado titulo-->
<div class="modal fade" id="m_detgrapersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Grado y/o Titulo</h4>
      </div>
      <div class="modal-body" id="r_detgrapersonal">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle grado titulo-->
<!--Modal Detalle capacitación-->
<div class="modal fade" id="m_detcappersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Capacitación</h4>
      </div>
      <div class="modal-body" id="r_detcappersonal">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle capacitación-->
<!--Modal Detalle experiencia laboral-->
<div class="modal fade" id="m_detexppersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle Experiencia Laboral</h4>
      </div>
      <div class="modal-body" id="r_detexppersonal">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Detalle experiencia laboral-->
<?php if(accesoadm($cone,$_SESSION['identi'],1) || $_SESSION['mo']){ ?>
<!--Modal Cambiar Foto-->
<div class="modal fade" id="m_camfoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_camfoto" action="javascript:void(0);" class="form-horizontal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cambiar Foto</h4>
      </div>
      <div class="modal-body" id="r_camfoto">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gcamfoto">Subir foto</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Cambiar Foto-->
<!--Modal Agregar Teléfono-->
<div class="modal fade" id="m_agrtelefono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_agrtelefono" action="" class="form-horizontal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Teléfono</h4>
      </div>
      <div class="modal-body" id="r_agrtelefono">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gagrtelefono">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar teléfono-->
<!--Modal Editar Teléfono-->
<div class="modal fade" id="m_editelefono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_editelefono" action="" class="form-horizontal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Teléfono</h4>
      </div>
      <div class="modal-body" id="r_editelefono">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_geditelefono">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar teléfono-->
<!--Modal Eliminar Teléfono-->
<div class="modal fade" id="m_elitelefono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_elitelefonop" action="" class="form-horizontal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Eliminar Teléfono</h4>
      </div>
      <div class="modal-body" id="r_elitelefono">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="b_gelitelefono">Sí</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal eliminar teléfono-->
<!--Modal Editar Datos Personales-->
<div class="modal fade" id="m_edidatpersonales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edidatpersonales" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Datos Personales</h4>
      </div>
      <div class="modal-body" id="r_edidatpersonales">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedidatpersonales">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Datos Personales-->
<!--Modal Editar Grado de Instrucción-->
<div class="modal fade" id="m_edigrainstruccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edigrainstruccion" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Grado Instrucción</h4>
      </div>
      <div class="modal-body" id="r_edigrainstruccion">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedigrainstruccion">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Grado de Instrucción-->
<!--Modal Editar Sistema pension-->
<div class="modal fade" id="m_edisispension" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edisispension" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Sistema de Pensión</h4>
      </div>
      <div class="modal-body" id="r_edisispension">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedisispension">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Sistema pension-->
<!--Modal Editar Domicilio-->
<div class="modal fade" id="m_edidomicilio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edidomicilio" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Domicilio</h4>
      </div>
      <div class="modal-body" id="r_edidomicilio">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedidomicilio">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Domicilio-->
<!--Modal Agregar Cargo-->
<div class="modal fade" id="m_agrcarpersonal" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_agrcarpersonal" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Cargo</h4>
      </div>
      <div class="modal-body" id="r_agrcarpersonal">

      </div>
      <div class="modal-footer">
      	<div id="l_agrcarpersonal"></div>
        <button type="submit" class="btn bg-teal" id="b_gagrcarpersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar Cargo-->
<!--Modal Editar Cargo-->
<div class="modal fade" id="m_edicarpersonal" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edicarpersonal" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Cargo</h4>
      </div>
      <div class="modal-body" id="r_edicarpersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedicarpersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Cargo-->
<!--Modal Reservar Cargo-->
<div class="modal fade" id="m_rescarpersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_rescarpersonal" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reservar Cargo</h4>
      </div>
      <div class="modal-body" id="r_rescarpersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_grescarpersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Reservar Cargo-->
<!--Modal Cesar Cargo-->
<div class="modal fade" id="m_cescarpersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_cescarpersonal" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cesar Cargo</h4>
      </div>
      <div class="modal-body" id="r_cescarpersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gcescarpersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Cesar Cargo-->
<!--Modal Estados Cargo-->
<div class="modal fade" id="m_estcarpersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Estados Cargo</h4>
      </div>
      <div class="modal-body" id="r_estcarpersonal">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Estados Cargo-->
<!--Modal Agregar Desplazamiento-->
<div class="modal fade" id="m_nuedesplazamiento" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_nuedesplazamiento" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Desplazamiento</h4>
      </div>
      <div class="modal-body" id="r_nuedesplazamiento">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnuedesplazamiento">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar Desplazamiento-->
<!--Modal Agregar Desplazamiento-->
<div class="modal fade" id="m_edidesplazamiento" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edidesplazamiento" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog modal-lg" id="m_edesplazamiento" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title t_edesplazamiento" id="myModalLabel">Editar Desplazamiento</h4>
      </div>
      <div class="modal-body" id="r_edidesplazamiento">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedidesplazamiento">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar Desplazamiento-->
<!--Modal Agregar Estado Cargo-->
<div class="modal fade" id="m_nueestcargo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_nueestcargo" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Estado Cargo</h4>
      </div>
      <div class="modal-body" id="r_nueestcargo">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gnueestcargo">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar Estado Cargo-->
<!--Modal Agregar Estado Cargo-->
<div class="modal fade" id="m_ediestcargo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_ediestcargo" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title teecargo" id="myModalLabel">Editar Estado Cargo</h4>
      </div>
      <div class="modal-body" id="r_ediestcargo">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gediestcargo">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar Estado Cargo-->
<!--Modal Editar -->
<div class="modal fade" id="m_edimovpersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edimovpersonal" action="" class="form-horizontal" accept-charset="UTF-8">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Movimiento de Dependencia</h4>
      </div>
      <div class="modal-body" id="r_edimovpersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedimovpersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Movimiento-->
<!--Modal Agregar Pariente Personal-->
<div class="modal fade" id="m_agrparpersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_agrparpersonal" action="" class="form-horizontal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Pariente</h4>
      </div>
      <div class="modal-body" id="r_agrparpersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gagrparpersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar Pariente Personal-->
<!--Modal Editar Pariente Personal-->
<div class="modal fade" id="m_ediparpersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_ediparpersonal" action="" class="form-horizontal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Pariente</h4>
      </div>
      <div class="modal-body" id="r_ediparpersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gediparpersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Pariente Personal-->
<!--Modal Agregar grados y titulos Personal-->
<div class="modal fade" id="m_agrgrapersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_agrgrapersonal" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Grado o Titulo</h4>
      </div>
      <div class="modal-body" id="r_agrgrapersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gagrgrapersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar grados y titulos Personal-->
<!--Modal Editar grados y titulos Personal-->
<div class="modal fade" id="m_edigrapersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edigrapersonal" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Grado y/o Título</h4>
      </div>
      <div class="modal-body" id="r_edigrapersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedigrapersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar grados y titulos Personal-->
<!--Modal Agregar Capacitación Personal-->
<div class="modal fade" id="m_agrcappersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_agrcappersonal" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Capacitación</h4>
      </div>
      <div class="modal-body" id="r_agrcappersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gagrcappersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar Capacitación Personal-->
<!--Modal Editar Capacitación Personal-->
<div class="modal fade" id="m_edicappersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_edicappersonal" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Capacitación</h4>
      </div>
      <div class="modal-body" id="r_edicappersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gedicappersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Capacitación Personal-->
<!--Modal Agregar Experiencia Personal-->
<div class="modal fade" id="m_agrexppersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_agrexppersonal" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Experiencia Laboral</h4>
      </div>
      <div class="modal-body" id="r_agrexppersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gagrexppersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Agregar Experiencia Personal-->
<!--Modal Editar Experiencia Personal-->
<div class="modal fade" id="m_ediexppersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_ediexppersonal" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Experiencia Laboral</h4>
      </div>
      <div class="modal-body" id="r_ediexppersonal">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gediexppersonal">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Editar Experiencia Personal-->
<!-- Modal editar fecha de vacaciones-->
<div class="modal fade" id="m_fvac" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Fecha Vacaciones</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="f_efvac">
        	
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="b_gefvac">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal discapacidad-->
<div class="modal fade" id="m_dis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title tmodal" id="myModalLabel"><i class="fa fa-wheelchair text-orange"></i> Discapacidad</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="f_dis">
        	
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="b_gdis">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<?php }
		mysqli_free_result($cemp);
	}else{
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-maroon text-center"><i class="fa fa-warning"></i>Error: No se eligió un personal válido.</h4>
    </div>
  </div>
</section>
<?php
	}
}else{
	echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
