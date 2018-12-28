<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
	if(isset($_POST['acc']) && !empty($_POST['acc']) && isset($_POST['v1']) && !empty($_POST['v1'])){
		$acc=iseguro($cone,$_POST['acc']);
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);

		if($acc=="verpla"){
			if(accesocon($cone,$_SESSION['identi'],16)){
				$cc=mysqli_query($cone, "SELECT FechaIni, FechaFin, idEmpleado, idDistrito, aneplanilla, estadoren FROM comservicios WHERE idComServicios=$v1;");
				if($rc=mysqli_fetch_assoc($cc)){
?>
		<table class="table table-bordered table-hover">
			<tr>
				<td><i class="fa fa-user text-orange"></i> <?php echo nomempleado($cone, $rc['idEmpleado']); ?></td>
				<td><?php echo erviaticos($rc['estadoren']); ?></td>
				<td align="right">
<?php if(accesoadm($cone, $_SESSION['identi'], 16) && $rc['estadoren']!=4){ ?>
					<button type="button" class="btn btn-info btn-sm" title="Tipo Anexo" onclick="fo_viaticos1('tipane', <?php echo $v1; ?>, 0);"><i class="fa fa-folder-open"></i> Tipo Anexo</button>
<?php } ?>
<?php if(!is_null($rc['aneplanilla'])){ ?>
<?php if(accesoadm($cone, $_SESSION['identi'], 16) && $rc['estadoren']!=4){ ?>
					<button type="button" class="btn btn-info btn-sm" title="Agregar Concepto" onclick="fo_viaticos1('agrcon', <?php echo $v1.", ".$rc['aneplanilla']; ?>);"><i class="fa fa-plus"></i> Concepto</button>
<?php } ?>
					<a href="m_inclusiones/a_tesoreria/pdf_anexo0<?php echo $rc['aneplanilla']; ?>.php?idcs=<?php echo $v1; ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-cloud-download"></i> A <?php echo $rc['aneplanilla']; ?></a>
<?php } ?>
					
				</td>
			</tr>
			<tr>
				<td><i class="fa fa-map-marker text-orange"></i> <?php echo disprodep($cone, $rc['idDistrito']); ?></td>
				<td><?php echo ftnormal($rc['FechaIni']); ?></td>
				<td><?php echo ftnormal($rc['FechaFin']); ?></td>
			</tr>
		</table>
<?php
					if(!is_null($rc['aneplanilla'])){
						$cd=mysqli_query($cone, "SELECT c.conceptov, d.idtedetplanillav, d.dia, d.monto FROM tedetplanillav d INNER JOIN teconceptov c ON d.idteconceptov=c.idteconceptov WHERE idComServicios=$v1 ORDER BY d.dia, c.conceptov ASC;");
						if(mysqli_num_rows($cd)>0){
	
?>
		<table class="table table-bordered table-hover">
			<thead>
			<tr>
				<th>#</th>
				<th>DÍA</th>
				<th>CONCEPTO</th>
				<th>MONTO</th>
<?php if(accesoadm($cone, $_SESSION['identi'], 16) && $rc['estadoren']!=4){ ?>
				<th>ACCIÓN</th>
<?php } ?>
			</tr>
			</thead>
<?php
							$n=0;
							while($rd=mysqli_fetch_assoc($cd)){
								$n++;
?>
			<tr>
				<td><?php echo $n; ?></td>
				<td><?php echo $rd['dia']; ?></td>
				<td><?php echo $rd['conceptov']; ?></td>
				<td><?php echo $rd['monto']; ?></td>
<?php if(accesoadm($cone, $_SESSION['identi'], 16) && $rc['estadoren']!=4){ ?>
				<td>
					<button type="button" class="btn btn-default btn-xs" title="Editar" onclick="fo_viaticos1('edicon', <?php echo $rd['idtedetplanillav'].", ".$rc['aneplanilla']; ?>);"><i class="fa fa-pencil"></i></button>
					<button type="button" class="btn btn-default btn-xs" title="Eliminar" onclick="fo_viaticos1('elicon', <?php echo $rd['idtedetplanillav']; ?>, 0);"><i class="fa fa-trash"></i></button>
				</td>
<?php } ?>
			</tr>
<?php
							}
?>
		</table>	
<?php
						}else{
							echo mensajewa("No se encontró ningún registro.");
						}
						mysqli_free_result($cd);
					}else{
						echo mensajewa("Aún no registró el tipo de anexo.");
					}
				}else{
					echo mensajewa("Datos inválidos.");
				}
				mysqli_free_result($cc);
			}else{
				echo mensajewa("Acceso restringido.");
			}
		}elseif($acc=="agrcon"){
			if(accesoadm($cone,$_SESSION['identi'],16)){
?>
		  <div class="row">
		  	<div class="col-sm-12">
		    	<div class="form-group">
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="idcs" value="<?php echo $v1; ?>">
			      <label for="con">Concepto<small class="text-red">*</small></label>
			      <select class="form-control" name="con" id="con">
			      	<option value="">CONCEPTO</option>
<?php 
				$cc=mysqli_query($cone, "SELECT idteconceptov, conceptov FROM teconceptov WHERE nanexo=$v2;");
				if(mysqli_num_rows($cc)>0){
					while($rc=mysqli_fetch_assoc($cc)){
?>
					<option value="<?php echo $rc['idteconceptov']; ?>"><?php echo $rc['conceptov']; ?></option>
<?php
					}
				}
				mysqli_free_result($cc);
?>
		      	  </select>
		      	</div>
		    </div>
		  </div>
		  <div class="row">
		  	<div class="col-sm-6 <?php echo $v2==7 ? "hidden" : ""; ?>">
		    	<div class="form-group">
			      <label for="dia">Día<small class="text-red">*</small></label>
			      <select class="form-control" name="dia" id="dia">
			      	<option value="">Día</option>
					<option value="1" <?php echo $v2==7 ? "selected" : ""; ?>>1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
		      	  </select>
		      	</div>
		    </div>
		    <div class="col-sm-6">
		    	<div class="form-group">
			      <label for="mon">Monto<small class="text-red">*</small></label>
			      <input type="number" name="mon" id="mon" class="form-control" step=".01">
		      	</div>
		    </div>
		    <div class="clearfix"></div>
		    <div id="d1_frespuesta">
		  	</div>
		  </div>
<?php
			}else{
				echo mensajewa("Acceso restringido");
			}
		}elseif($acc=="edicon"){
			if(accesoadm($cone,$_SESSION['identi'],16)){
				$cco=mysqli_query($cone, "SELECT dia, monto, idteconceptov, idComServicios FROM tedetplanillav WHERE idtedetplanillav=$v1");
				if($rco=mysqli_fetch_assoc($cco)){
?>
		  <div class="row">
		  	<div class="col-sm-12">
		    	<div class="form-group">
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="idcs" value="<?php echo $rco['idComServicios']; ?>">
			      <input type="hidden" name="iddp" value="<?php echo $v1; ?>">
			      <label for="con">Concepto<small class="text-red">*</small></label>
			      <select class="form-control" name="con" id="con">
			      	<option value="">CONCEPTO</option>
<?php 
				$cc=mysqli_query($cone, "SELECT idteconceptov, conceptov FROM teconceptov WHERE nanexo=$v2;");
				if(mysqli_num_rows($cc)>0){
					while($rc=mysqli_fetch_assoc($cc)){
?>
					<option value="<?php echo $rc['idteconceptov']; ?>" <?php echo $rc['idteconceptov']==$rco['idteconceptov'] ? "selected" : ""; ?>><?php echo $rc['conceptov']; ?></option>
<?php
					}
				}
				mysqli_free_result($cc);
?>
		      	  </select>
		      	</div>
		    </div>
		  </div>
		  <div class="row">
		  	<div class="col-sm-6 <?php echo $v2==7 ? "hidden" : ""; ?>">
		    	<div class="form-group">
			      <label for="dia">Día<small class="text-red">*</small></label>
			      <select class="form-control" name="dia" id="dia">
			      	<option value="">Día</option>
					<option value="1" <?php echo $rco['dia']==1 ? "selected" : ""; ?>>1</option>
					<option value="2" <?php echo $rco['dia']==2 ? "selected" : ""; ?>>2</option>
					<option value="3" <?php echo $rco['dia']==3 ? "selected" : ""; ?>>3</option>
					<option value="4" <?php echo $rco['dia']==4 ? "selected" : ""; ?>>4</option>
					<option value="5" <?php echo $rco['dia']==5 ? "selected" : ""; ?>>5</option>
					<option value="6" <?php echo $rco['dia']==6 ? "selected" : ""; ?>>6</option>
		      	  </select>
		      	</div>
		    </div>
		    <div class="col-sm-6">
		    	<div class="form-group">
			      <label for="mon">Monto<small class="text-red">*</small></label>
			      <input type="number" name="mon" id="mon" class="form-control" value="<?php echo $rco['monto']; ?>" step=".01">
		      	</div>
		    </div>
		    <div id="d1_frespuesta">
		  	</div>
		  </div>
<?php
				}else{
					echo mensajewa("Datos inválidos");
				}
				mysqli_free_result($cco);
			}else{
				echo mensajewa("Acceso restringido");
			}
		}elseif($acc=="tipane"){
			$c2=mysqli_query($cone,"SELECT aneplanilla FROM comservicios WHERE idcomservicios=$v1;");
			if($r2=mysqli_fetch_assoc($c2)){
?>
		  <div class="row">
		    <div class="col-sm-12">
		    	<div class="form-group">
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="idcs" value="<?php echo $v1; ?>">
			      <label for="ane">Anexo<small class="text-red">*</small></label>
			      <select class="form-control" name="ane" id="ane">
			      	<option value="">Anexo</option>
					<option value="1" <?php echo $r2['aneplanilla']==1 ? "selected" : ""; ?>>1</option>
					<option value="7" <?php echo $r2['aneplanilla']==7 ? "selected" : ""; ?>>7</option>
		      	  </select>
		      	</div>
		    </div>
		  </div>
		  <div id="d1_frespuesta">
		  	
		  </div>
<?php
			}else{
				echo mensajewa("Datos inválidos");
			}
			mysqli_free_result($c2);
		}elseif($acc=="elicon"){
			$cg=mysqli_query($cone, "SELECT dp.dia, dp.monto, dp.idComServicios, c.conceptov FROM tedetplanillav dp INNER JOIN teconceptov c ON dp.idteconceptov=c.idteconceptov WHERE idtedetplanillav=$v1;");
			if($rg=mysqli_fetch_assoc($cg)){
?>
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="idcs" value="<?php echo $rg['idComServicios']; ?>">
			      <input type="hidden" name="v1" value="<?php echo $v1; ?>">
				<table class="table table-bordered">
					<tr>
						<td align="center">
							<i class="fa fa-warning text-red"></i> <b>Eliminará el concepto por:</b>
						</td>
					</tr>
					<tr>
						<td align="center">
							<?php echo "Día ".$rg['dia']." | ".$rg['conceptov']." | S/ ".$rg['monto']; ?>
						</td>
					</tr>
				</table>
				<div id="d1_frespuesta">
				  	
				</div>
<?php
			}else{
				echo mensajewa("Error, datos inválidos.");
			}
			mysqli_free_result($cg);
		}//acafin
	}else{
		echo mensajewa("Error: Faltan datos.");
	}

mysqli_close($cone);
?>