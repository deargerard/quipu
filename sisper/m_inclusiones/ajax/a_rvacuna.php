<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
	if(isset($_POST['idp']) && !empty($_POST['idp'])){
		$idp=iseguro($cone, $_POST['idp']);
	
?>
				<div class="row">
                	<div class="col-md-12">
		                <div>
							<table style="width: 100%;">
		                		<tr>
		                			<td>
		                				<h4 class="box-title text-orange"><i class="fa fa-eyedropper"></i> Vacunas</h4>
		                			</td>
		                			<td align="right">
		                				<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
					                		<a href="#" class="btn btn-info btn-xs" onclick="vacuna('agrvac', <?php echo $idp ?>)"><i class="fa fa-eyedropper"></i> Vacuna</a>
					                	<?php } ?>
		                			</td>
		                		</tr>
		                	</table>

		                </div>
		            </div>
		        </div>
		        <div class="row">
                	<div class="col-md-12">
                	<?php
                	$cg=mysqli_query($cone, "SELECT * FROM vacuna WHERE idEmpleado=$idp ORDER BY fecha DESC;");
                	if(mysqli_num_rows($cg)>0){
					?>
						<table class="table table-hover table-bordered">
                			<tr>
								<th>#</th>
                				<th>Vacuna</th>
								<th>Laboratorio</th>
                				<th>Fecha</th>
								<th>Observaciones</th>
                				<td>Acciones</td>
                			</tr>
					<?php
						$n=0;
                		while($rg=mysqli_fetch_assoc($cg)){
							$n++;
                	?>
                			<tr>
                				<td><?php echo $n; ?></td>
                				<td><?php echo $rg['tipo']; ?></td>
								<td><?php echo $rg['laboratorio']; ?></td>
                				<td><?php echo fnormal($rg['fecha']); ?></td>
								<td><?php echo $rg['observaciones']; ?></td>
								<td>
									<button class="btn bg-yellow btn-xs" onclick="vacuna('edivac', <?php echo $rg['idvacuna']; ?>);"><i class="fa fa-edit"></i></button>
									<button class="btn bg-red btn-xs" onclick="vacuna('elivac', <?php echo $rg['idvacuna']; ?>);"><i class="fa fa-trash"></i></button>
								</td>
                			</tr>
                		
                	<?php
                		}
					?>
						</table>
					<?php
                	}else{
                		echo mensajewa("Sin registros de vacuna.");
                	}
                	mysqli_free_result($cg);
                	?>
                	</div>
                </div>
<?php
	}else{
		echo mensajewa("No envio datos.");
	}
}else{
  echo accrestringidoa();
}
?>