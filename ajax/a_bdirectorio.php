<?php
    include ("../sisper/m_inclusiones/php/conexion_sp.php");
    include ("../sisper/m_inclusiones/php/funciones.php");

    if(isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST['tip']) && !empty($_POST['tip'])){
    	$id=iseguro($cone,$_POST["id"]);
    	$tip=iseguro($cone,$_POST['tip']);

    	if($tip==1){
?>
		<h4 class="text-aqua text-center">
			<strong><?php echo nomempleado($cone,$id); ?></strong><br>
			<small><strong><?php echo cargoe($cone,$id); ?></strong></small><br>
			<small><?php echo dependenciae($cone,$id); ?></small>
		</h4>

				<h4 class="text-orange text-center"><i class="fa fa-phone-square"></i> TELÉFONOS</h4>
<?php
    		$c1=mysqli_query($cone, "SELECT TipoTelefono, Numero FROM telefonoemp te INNER JOIN tipotelefono tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE idEmpleado=$id AND te.idTipoTelefono=17 AND te.Estado=1 ORDER BY TipoTelefono ASC;");
    		if(mysqli_num_rows($c1)>0){
?>
				<table class="table table-hover">
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
    			echo "<h5 class='text-maroon text-center'>No cuenta con ningún teléfono institucional.</h5>";
    		}
    		mysqli_free_result($c1);
    		$c2=mysqli_query($cone, "SELECT CorreoIns, CorreoPer FROM empleado WHERE idEmpleado=$id;");
    		$r2=mysqli_fetch_assoc($c2);
?>
				<h4 class="text-orange text-center"><i class="fa fa-envelope-square"></i> CORREO</h4>
				<table class="table table-hover">
					<tbody>
						<tr>
							<th>Institucional</th>
							<td><?php echo $r2['CorreoIns']=="" ? "Sin Correo" : $r2['CorreoIns']; ?></td>
						</tr>
					</tbody>
				</table>
<?php
			mysqli_free_result($c2);
    	}elseif($tip==2){
?>
	<h4 class="text-aqua text-center"><strong><?php echo nomdependencia($cone,$id); ?></strong></h4>
<?php
			$c4=mysqli_query($cone, "SELECT Telefono FROM dependencialocal dl INNER JOIN local l ON dl.idLocal=l.idLocal WHERE idDependencia=$id;");
			if($r4=mysqli_fetch_assoc($c4)){
?>
			<h5 class="text-center"><strong>Central: </strong><?php echo $r4['Telefono']; ?></h5>
<?php
			}else{
?>
			<h5 class="text-center"><strong>Central: </strong>--</h5>
<?php
			}
?>
			
			<h4 class="text-orange text-center"><i class="fa fa-phone-square"></i> TELÉFONOS</h4>
<?php
			$c3=mysqli_query($cone,"SELECT Tipotelefono, Numero, idDistrito, Direccion, dl.Oficina, tl.Tipo, p.Piso FROM telefonodep td INNER JOIN tipotelefono tt ON td.idTipoTelefono=tt.idTipoTelefono INNER JOIN dependencialocal dl ON td.idDependenciaLocal=dl.idDependenciaLocal INNER JOIN piso p ON dl.idPiso=p.idPiso INNER JOIN tipolocal tl ON dl.idTipoLocal=tl.idTipoLocal INNER JOIN local l ON dl.idLocal=l.idLocal WHERE dl.idDependencia=$id AND td.Estado=1;");
			if(mysqli_num_rows($c3)>0){
?>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>TIPO</th>
						<th>NÚMERO</th>
						<th>AMBIENTE</th>
						<th>DISTRITO</th>
					</tr>
				</thead>
				<tbody>
<?php
				while ($r3=mysqli_fetch_assoc($c3)) {
?>
					<tr>
						<td><?php echo $r3['Tipotelefono']; ?></td>
						<td><?php echo $r3['Numero']; ?></td>
						<td><?php echo $r3['Tipo']." (".$r3['Oficina']." - ".$r3['Piso']." - ".$r3['Direccion'].")"; ?></td>
						<td><?php echo nomdistrito($cone,$r3['idDistrito']); ?></td>
					</tr>
<?php
				}
?>
				</tbody>
			</table>
<?php
			}else{

				echo "<h5 class='text-maroon text-center'>Sin teléfono en la oficina.</h5>";	

			}
			mysqli_free_result($c3);
    	}
?>


<?php

	}
	mysqli_close($cone);
?>