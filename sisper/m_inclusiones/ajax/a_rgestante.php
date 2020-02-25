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
		                				<h4 class="box-title text-orange"><i class="fa fa-user-md"></i> Gestante</h4>
		                			</td>
		                			<td align="right">
		                				<?php if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){ ?>
					                	<a href="#" class="btn btn-info btn-xs" onclick="gestante('agrges', <?php echo $idp ?>)"><i class="fa fa-user-md"></i> Gestante</a>
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
                	$cg=mysqli_query($cone, "SELECT * FROM gestante WHERE idEmpleado=$idp AND b_ac!='eli' ORDER BY fpp DESC;");
                	if(mysqli_num_rows($cg)>0){
                		while($rg=mysqli_fetch_assoc($cg)){
                	?>
                		<table class="table table-hover table-bordered">
                			<tr>
                				<th>GESTANTE</th>
                				<th colspan="2" class="text-purple"><?php echo is_null($rg['idPariente']) ? nomempleado($cone, $idp) : nompariente($cone, $rg['idPariente']); ?></th>
                				<td>
                					<button class="btn bg-yellow btn-xs" onclick="gestante('ediges', <?php echo $rg['idgestante']; ?>);"><i class="fa fa-edit"></i></button>
                					<button class="btn bg-red btn-xs" onclick="gestante('eliges', <?php echo $rg['idgestante']; ?>);"><i class="fa fa-trash"></i></button>
                				</td>
                			</tr>
                			<tr>
                				<th>FECHA ÚLTIMA REGLA</th>
                				<td><?php echo fnormal($rg['fur']); ?></td>
                				<th>FECHA PROBABLE DE PARTO</th>
                				<td><?php echo fnormal($rg['fpp']); ?></td>
                			</tr>
                			<tr>
                				<th>ESTABLECIMIENTO DE SALUD</th>
                				<td colspan="3"><?php echo $rg['estsalud']; ?></td>
                			</tr>
                			<tr>
                				<th>OBSERVACIONES</th>
                				<td colspan="3"><?php echo $rg['observaciones']; ?></td>
                			</tr>
                		</table>
                	<?php
                		}
                	}else{
                		echo mensajewa("Sin registros de gestante.");
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