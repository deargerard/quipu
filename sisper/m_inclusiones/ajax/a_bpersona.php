<?php 
	session_start();
	include("../php/conexion_sp.php");
	include("../php/funciones.php");
	if(accesocon($cone,$_SESSION['identi'],10)){
	$ib_persona=iseguro($cone,$_POST["ib_persona"]);
	if(isset($ib_persona) && !empty($ib_persona)){
		$que=mysqli_query($cone,"SELECT * FROM enombre WHERE NumeroDoc='$ib_persona'");
		if($res=mysqli_fetch_assoc($que)){
			$ide=$res["idEmpleado"];
			$quet=mysqli_query($cone,"SELECT TipoTelefono, Numero FROM telefonoemp AS te LEFT JOIN tipotelefono AS tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE te.Estado=1 AND te.idEmpleado=$ide");
?>
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-4">
					<img src="<?php echo mfotom($ib_persona) ?>" alt="Foto" class="img-responsive img-thumbnail">
				</div>
				<div class="col-md-9 col-sm-9 col-xs-8">
					<h4 class='text-aqua'><strong><?php echo $res["NombreCom"] ?></strong><br>
					<small><strong><?php echo cargoe($cone, $ide) ?></strong></small><br>
					<small><?php echo dependenciae($cone, $ide) ?></small>
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
				<h4 class="text-orange"><i class="fa fa-phone-square"></i> Teléfono</h4>
<?php
			if(mysqli_num_rows($quet)>0){
?>
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Tipo</th>
									<th>Número</th>
								</tr>
							</thead>
							<tbody>
<?php
				while($rest=mysqli_fetch_assoc($quet)){
?>
								<tr>
									<td><?php echo $rest["TipoTelefono"] ?></td>
									<td><?php echo $rest["Numero"] ?></td>
								</tr>						
<?php
				}
?>
							</tbody>
						</table>
					</div>		
<?php
			}else{
				echo "<h4 class='text-maroon'>No tiene registrado ningún teléfono</h4>";
			}
?>
				</div>
				<div class="col-md-6">
					<h4 class="text-orange"><i class="fa fa-envelope-square"></i> Correo</h4>
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Correo</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if(!empty($res["CorreoIns"])){
								?>
									<tr>
										<td><?php echo $res["CorreoIns"] ?></td>
									</tr>
								<?php
									}
									if(!empty($res["CorreoPer"])){
								?>
									<tr>
										<td><?php echo $res["CorreoPer"] ?></td>
									</tr>
								<?php
									}
								?>						
								</tbody>
							</table>
						</div>		
				</div>
			</div>
			<div class="row">
			<?php
			$cpa=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres, TelefonoFij, TelefonoMov, TipoPariente FROM pariente AS pa INNER JOIN tipopariente AS tp ON pa.idTipoPariente=tp.idTipoPariente WHERE idEmpleado=$ide AND ContactoEme=1 AND Vive=1");
			if(mysqli_num_rows($cpa)>0){
			?>
			<div class="col-md-12">
				<h4 class="text-orange"><i class="fa fa-ambulance"></i> Contacto Emergencia</h4>
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Parentesco</th>
									<th>Número</th>
								</tr>
							</thead>
							<tbody>
							<?php
								while($rpa=mysqli_fetch_assoc($cpa)){
							?>
								<tr>
									<td><?php echo $rpa["ApellidoPat"]." ".$rpa["ApellidoMat"].", ".$rpa["Nombres"] ?></td>
									<td><?php echo $rpa["TipoPariente"] ?></td>
									<?php
									if(!empty($rpa["TelefonoFij"]) AND !empty($rpa["TelefonoMov"])){
									?>
									<td><?php echo $rpa["TelefonoFij"]."/".$rpa["TelefonoMov"] ?></td>
									<?php
									}elseif(empty($rpa["TelefonoFij"]) AND !empty($rpa["TelefonoMov"])){
									?>
									<td><?php echo $rpa["TelefonoMov"] ?></td>
									<?php
									}elseif(!empty($rpa["TelefonoFij"]) AND empty($rpa["TelefonoMov"])){
									?>
									<td><?php echo $rpa["TelefonoFij"] ?></td>
									<?php
									}elseif (empty($rpa["TelefonoFij"]) AND empty($rpa["TelefonoMov"])) {
									?>
									<td><?php echo 'SIN TELÉFONO' ?></td>
									<?php
									}
									?>
								</tr>
							<?php
								}
							?>						
							</tbody>
						</table>
					</div>		
			</div>
			<?php
			}
			mysqli_free_result($cpa);
			?>
		</div>
<?php
		}else{
			echo "<h4 class='text-maroon'>Error: No se encontraron resultados.</h4>";
		}
		mysqli_free_result($que);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: Ingrese un número de documento válido.</h4>";
	}
	}else{
		echo accrestringidoa();
	}
?>