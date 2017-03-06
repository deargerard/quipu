<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1) || accesocon($cone,$_SESSION['identi'],9)){
	$idpa=iseguro($cone,$_POST["idpa"]);
	if(isset($idpa) && !empty($idpa)){
		$cpa=mysqli_query($cone,"SELECT * FROM pariente WHERE idPariente=$idpa");
		$rpa=mysqli_fetch_assoc($cpa);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2">Nombre</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" class="text-fuchsia"><?php echo $rpa['ApellidoPat']." ".$rpa['ApellidoMat'].", ".$rpa['Nombres'] ?></td>
				</tr>
				<tr>
					<th>Parentezco</th>
					<?php
					$idtp=$rpa['idTipoPariente'];
					$ctp=mysqli_query($cone,"SELECT TipoPariente FROM tipopariente WHERE idTipoPariente=$idtp");
					$rtp=mysqli_fetch_assoc($ctp);
					?>
					<td><?php echo $rtp['TipoPariente'] ?></td>
					<?php
					mysqli_free_result($ctp)
					?>
				</tr>
				<tr>
					<th>Sexo</th>
					<?php 
					if($rpa['Sexo']=='M'){
						$sex='MASCULINO';
					}elseif($rpa['Sexo']=='F'){
						$sex='FEMENINO';
					}
					?>
					<td><?php echo $sex ?></td>
				</tr>
				<tr>
					<th>Estado Civil</th>
					<?php
					$idec=$rpa['idEstadoCivil'];
					$cec=mysqli_query($cone,"SELECT EstadoCivil FROM estadocivil WHERE idEstadoCivil=$idec");
					$rec=mysqli_fetch_assoc($cec);
					?>
					<td><?php echo $rec['EstadoCivil'] ?></td>
					<?php
					mysqli_free_result($cec);
					?>
				</tr>
				<tr>
					<th>Fecha Nacimiento</th>
					<td><?php echo fnormal($rpa['FechaNac']) ?></td>
				</tr>
				<tr>
					<th><?php echo $rpa['TipoDoc'] ?></th>
					<td><?php echo $rpa['NumeroDoc'] ?></td>
				</tr>
				<tr>
					<th>Ocupación</th>
					<td><?php echo $rpa['Ocupacion'] ?></td>
				</tr>
				<tr>
					<th>Entidad laboral</th>
					<td><?php echo $rpa['EntidadLab'] ?></td>
				</tr>
				<?php
				if(!empty($rpa['TelefonoFij'])){
				?>
				<tr>
					<th>Teléfono Fijo</th>
					<td><?php echo $rpa['TelefonoFij'] ?></td>
				</tr>
				<?php
				}
				if(!empty($rpa['TelefonoMov'])){
				?>
				<tr>
					<th>Teléfono Móvil</th>
					<td><?php echo $rpa['TelefonoMov'] ?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<th>Contácto Emergencia</th>
					<?php
					if($rpa['ContactoEme']==1){
						$ce='Sí';
					}else{
						$ce='No';
					}
					?>
					<td><?php echo $ce ?></td>
				</tr>
				<tr>
					<th>Vive</th>
					<?php
					if($rpa['Vive']==1){
						$vi='Sí';
					}else{
						$vi='No';
					}
					?>
					<td><?php echo $vi ?></td>
				</tr>
				<?php
				if(!empty($rpa['Correo'])){
				?>
				<tr>
					<th>Correo</th>
					<td><?php echo $rpa['Correo'] ?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<?php
					$gi=$rpa['idGradoInstruccion'];
					$cgi=mysqli_query($cone,"SELECT * FROM gradoinstruccion WHERE idGradoInstruccion=$gi");
					$rgi=mysqli_fetch_assoc($cgi);
					?>
					<th>Grado Instrucción</th>
					<td><?php echo $rgi['GradoInstruccion'] ?></td>
				</tr>
				<tr>
					<th>Nivel Instrucción</th>
					<td><?php echo $rgi['Nivel'] ?></td>
					<?php
					mysqli_free_result($cgi);
					?>
				</tr>
				<tr>
					<th>Especialidad</th>
					<td><?php echo $rpa['Especialidad'] ?></td>
				</tr>
				<tr>
					<th>Institución</th>
					<td><?php echo $rpa['Institucion'] ?></td>
				</tr>
				<tr>
					<th>Fec. Reg./Act.</th>
					<td><?php echo $rpa['FecRegistro'] ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
		mysqli_free_result($cpa);
		mysqli_close($cone);
	}else{
		echo "<h3 class='text-maroon'>Error: No se seleccionó ningún movimiento.</h3>";
	}
}else{
  echo accrestringidoa();
}
?>