<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],1) || accesocon($cone,$_SESSION['identi'],9)){
	$idex=iseguro($cone,$_POST["idex"]);
	if(isset($idex) && !empty($idex)){
		$cel=mysqli_query($cone,"SELECT * FROM explaboral AS el INNER JOIN conconexp AS cce ON el.idConConExp=cce.idConConExp WHERE idExplaboral=$idex");
		if($rel=mysqli_fetch_assoc($cel)){
			if($rel['FechaFin']=='1970-01-01'){
				$f1=@date("y-m-d");
			}else{
				$f1=$rel['FechaFin'];
			}
			$f1=@date_create($f1);
			$f2=@date_create($rel['FechaIni']);
			$tie=date_diff($f1, $f2);
	?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th colspan="2">Cargo</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" class="text-fuchsia"><?php echo $rel['Cargo'] ?></td>
				</tr>
				<tr>
					<th>Institución</th>
					<td><?php echo $rel['Institucion'] ?></td>
				</tr>
				<tr>
					<th>Fecha Inicio</th>
					<td><?php echo fnormal($rel['FechaIni']) ?></td>
				</tr>
				<tr>
					<th>Fecha Fin</th>
					<td><?php echo fnormal($rel['FechaFin']) ?></td>
				</tr>
				<tr>
					<th>Tiempo</th>
					<td><?php echo $tie->format('%y año(s), %m mes(es)') ?></td>
				</tr>
				<tr>
					<th>Condición</th>
					<td><?php echo $rel['ConConExp'] ?></td>
				</tr>
				<tr>
					<th>Motivo Cese</th>
					<td><?php echo $rel['MotivoCese'] ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
		}else{
			echo "<h4 class='text-maroon'>Error: No se seleccionó una experiencia laboral válida.</h4>";
		}
		mysqli_free_result($cel);
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ninga experiencia laboral.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>