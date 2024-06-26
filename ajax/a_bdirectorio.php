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
		<div class="col-sm-2">
			<img src="<?php echo $fot; ?>" class="img-thumbnail img-fluid">
		</div>
		<div class="col-sm-9">
			<h4 class="text-info">
				<br>
				<b><?php echo nomempleado($cone,$id); ?></b><br>
				<small class="text-primary"><b><?php echo cargoe($cone,$id); ?></b></small><br>
				<small class="text-muted"><?php echo dependenciae($cone,$id); ?></small>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
<?php
    		$c2=mysqli_query($cone, "SELECT CorreoIns, CorreoPer FROM empleado WHERE idEmpleado=$id;");
    		$r2=mysqli_fetch_assoc($c2);
?>

				<h6 class="text-center text-muted"><i class="fa fa-phone-square text-info"></i> CORREO</h6>
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
	<h4 class="text-info text-center"><strong><?php echo nomdependencia($cone,$id); ?></strong></h4>
			<h6 class="text-muted text-center"><i class="fa fa-phone-square text-info"></i> TELÉFONOS</h6>
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
					$c5=mysqli_query($cone,"SELECT Oficina, Piso, tl.Tipo, tt.TipoTelefono, Numero, EquipoTra FROM dependencialocal dl INNER JOIN telefonodep td ON dl.idDependenciaLocal=td.idDependenciaLocal INNER JOIN tipotelefono tt ON td.idTipoTelefono=tt.idTipoTelefono INNER JOIN piso p ON dl.idPiso=p.idPiso INNER JOIN tipolocal tl ON dl.idTipoLocal=tl.idTipoLocal WHERE idLocal=$idloc AND idDependencia=$id ORDER BY EquipoTra ASC, Numero ASC;");
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
						<td class="text-center">Sin local asignado</td>
					</tr>
				</tbody>
			</table>
<?php
			}		
			
    	}

	}
	mysqli_close($cone);
?>