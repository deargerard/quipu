<?php
    include ("../sisper/m_inclusiones/php/conexion_sp.php");
    include ("../sisper/m_inclusiones/php/funciones.php");

    if(isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST['tip']) && !empty($_POST['tip'])){
    	$id=iseguro($cone,$_POST["id"]);
    	$tip=iseguro($cone,$_POST['tip']);

    	if($tip==1){
    		$fot = "../sisper/m_fotos/".docidentidad($cone,$id).".jpg";
    		$fot1 = "sisper/m_fotos/".docidentidad($cone,$id).".jpg";
    		$fot = file_exists($fot) ? $fot1 : "/sisper/m_fotos/sinfoto.jpg";
?>
	<div class="row">
		<div class="col-sm-3">
			<img src="<?php echo $fot; ?>" class="img-thumbnail img-responsive">
		</div>
		<div class="col-sm-9">
			<h4 class="text-aqua">
				<br>
				<strong><?php echo nomempleado($cone,$id); ?></strong><br>
				<small><strong><?php echo cargoe($cone,$id); ?></strong></small><br>
				<small><?php echo dependenciae($cone,$id); ?></small>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
				<h4 class="text-orange text-center"><i class="fa fa-phone-square"></i> TELÉFONOS</h4>
<?php
    		$c1=mysqli_query($cone, "SELECT TipoTelefono, Numero FROM telefonoemp te INNER JOIN tipotelefono tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE idEmpleado=$id AND te.idTipoTelefono=17 AND te.Estado=1 ORDER BY TipoTelefono ASC;");
    		if(mysqli_num_rows($c1)>0){
?>

				<table class="table table-hover table-bordered">
					<tbody>
				
<?php
    			while ($r1=mysqli_fetch_assoc($c1)) {
?>
						<tr>
							<th><?php echo $r1['TipoTelefono']; ?></th>
							<td><?php echo $r1['Numero']; ?></td>
						</tr>
<?php
    			}
?>
					</tbody>
				</table>
<?php
    		}else{
?>
				<table class="table table-hover table-bordered">
					<tbody>
						<tr>
							<td class="text-center">Sin teléfono institucional.</td>
						</tr>
					</tbody>
				</table>
<?php
    		}
    		mysqli_free_result($c1);
?>
		</div>
		<div class="col-sm-6">
<?php
    		$c2=mysqli_query($cone, "SELECT CorreoIns, CorreoPer FROM empleado WHERE idEmpleado=$id;");
    		$r2=mysqli_fetch_assoc($c2);
?>

				<h4 class="text-orange text-center"><i class="fa fa-envelope-square"></i> CORREO</h4>
				<table class="table table-hover table-bordered">
					<tbody>
						<tr>
							<td class="text-center"><?php echo $r2['CorreoIns']=="" ? "Sin Correo" : $r2['CorreoIns']; ?></td>
						</tr>
					</tbody>
				</table>
		</div>
	</div>
<?php
			mysqli_free_result($c2);
    	}elseif($tip==2){
?>
	<h4 class="text-aqua text-center"><strong><?php echo nomdependencia($cone,$id); ?></strong></h4>
			<h4 class="text-orange text-center"><i class="fa fa-phone-square"></i> TELÉFONOS</h4>
<?php
			$c4=mysqli_query($cone, "SELECT DISTINCT l.idLocal, Telefono, Direccion, idDistrito FROM dependencialocal dl INNER JOIN local l ON dl.idLocal=l.idLocal WHERE idDependencia=$id;");
			if(mysqli_num_rows($c4)>0){
?>
			<table class="table table-bordered table-hover">
				<tbody>
<?php
				while($r4=mysqli_fetch_assoc($c4)){
					$idloc=$r4['idLocal'];
?>
					<tr class="text-red">
						<th colspan="2">Central Telefónica</th>
						<th colspan="2">Local</th>
					</tr>
					<tr>
						<td colspan="2"><?php echo $r4['Telefono']=="" ? "Sin teléfono" : $r4['Telefono']; ?></td>
						<td colspan="2"><?php echo $r4['Direccion']." - ".nomdistrito($cone,$r4['idDistrito']); ?></td>
					</tr>
<?php
					$c5=mysqli_query($cone,"SELECT Oficina, Piso, tl.Tipo, tt.TipoTelefono, Numero, EquipoTra FROM dependencialocal dl INNER JOIN telefonodep td ON dl.idDependenciaLocal=td.idDependenciaLocal INNER JOIN tipotelefono tt ON td.idTipoTelefono=tt.idTipoTelefono INNER JOIN piso p ON dl.idPiso=p.idPiso INNER JOIN tipolocal tl ON dl.idTipoLocal=tl.idTipoLocal WHERE idLocal=$idloc AND idDependencia=$id;");
					if(mysqli_num_rows($c5)>0){
?>
					<tr class="text-blue">
						<th>Tipo</th>
						<th>Número</th>
						<th>Equipo</th>
						<th>Ambiente</th>
					</tr>
<?php
						while($r5=mysqli_fetch_assoc($c5)){
?>
					<tr>
						<td><?php echo $r5['TipoTelefono']; ?></td>
						<td><?php echo $r5['Numero']; ?></td>
						<td><?php echo $r5['EquipoTra']; ?></td>
						<td><?php echo $r5['Tipo']." (".$r5['Oficina']." - ".$r5['Piso'].")"; ?></td>
					</tr>
<?php
						}
					}
				}
?>
				</tbody>
			</table>
<?php
			}else{
?>
			<table class="table table-bordered table-hover">
				<tbody>
					<tr>
						<td class="text-center">Sin local asiganado</td>
					</tr>
				</tbody>
			</table>
<?php
			}		
			
    	}

	}
	mysqli_close($cone);
?>