<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],16)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		
		if($acc=="agrent"){
		$tra= iseguro($cone,$_POST['v1']);					
?>	 
			<div class="form-group">
				<input type="hidden" name="acc" value="<?php echo $acc; ?>">
				<input type="hidden" name="tra" value="<?php echo $tra; ?>">	
  				<label for="mot" class="col-sm-12">Motivo de Adelanto de dinero:</label>
  				<div class="col-sm-12">
  					<textarea name="mot" id="mot" rows="3" class="form-control" ></textarea>
  				</div> 				
			</div>		
			<div id="d_frespuesta">
		  	
			</div>		  
<?php
		}elseif($acc=="edient"){
			$tra= iseguro($cone,$_POST['v1']);			
			$ide=iseguro($cone,$_POST['v2']);
			$c2=mysqli_query($cone,"SELECT * FROM teentrega WHERE idteentrega=$ide;");
			if($r2=mysqli_fetch_assoc($c2)){
?>  
				<div class="form-group">
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
					<input type="hidden" name="tra" value="<?php echo $tra; ?>">
					<input type="hidden" name="ide" value="<?php echo $ide; ?>">	
  					<label for="mot" class="col-sm-12">Motivo de Adelanto de dinero:</label>
  					<div class="col-sm-12">
  						<textarea name="mot" id="mot" rows="3" class="form-control" > <?php echo $r2['motivo']; ?></textarea>
  					</div> 				
				</div>				
				<div id="d_frespuesta">
				  	
				</div>		  
<?php
					}else{
						echo mensajewa("Datos inválidos");
					}
					mysqli_free_result($c2);
		}elseif($acc=="elient"){
			$tra= iseguro($cone,$_POST['v1']);
			$ide=iseguro($cone,$_POST['v2']);
			$c3=mysqli_query($cone,"SELECT * FROM tedocentrega WHERE idteentrega=$ide;");
			if(mysqli_num_rows($c3)<=0){
?>
				<div class="form-group">	
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
					<input type="hidden" name="tra" value="<?php echo $tra; ?>">
					<input type="hidden" name="ide" value="<?php echo $ide; ?>">					
			        <h4 class="text-maroon text-center">¿Está seguro que desea eliminar el Adelanto de dinero?</h4>
			    </div>
<?php 

			}else{
				echo mensajewa("No se puede eliminar el Adelanto debido a que tiene documentos registrados");
?>
<script>
	$('#b_guardar').addClass('hidden');
</script>
<?php 
			}
			mysqli_free_result($c3);
		}elseif($acc=="agrdent"){
		$ide= iseguro($cone,$_POST['v1']);		
?>		  
		<div class="form-group">
			<div class="col-sm-6">
				<label for="tip">Tipo<small class="text-red">*</small></label>
				<input type="hidden" name="acc" id="acc" value="<?php echo $acc;?>">	
				<input type="hidden" name="ide" id="ide" value="<?php echo $ide;?>">    
				<select class="form-control" name="tip" id="tip">
					<option value="">TIPO</option>
					<option value="1">VALE</option>
					<option value="2">RECIBO</option>
					<option value="3">GIRO</option>
					<option value="4">DEPOSITO</option>
				</select>
			</div>
			<div class="col-sm-6">
				<label for="num">Número<small class="text-red">*</small></label>		
				<input type="text" name="num" id="num" class="form-control">											
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-6">
				<label for="mov">Movimiento<small class="text-red">*</small></label>	    
				<select class="form-control" name="mov" id="mov">
					<option value="1">ADELANTO</option>
					<option value="2">DEVOLUCIÓN</option>					
				</select>
			</div>
			<div class="col-sm-6">
				<label for="mon">Monto<small class="text-red">*</small></label>
				<div class="input-group">
					<span class="input-group-addon">S/</span>
					<input type="text" name="mon" id="mon" class="form-control">			
				</div>				
			</div>		
		</div>
		<div class="form-group">
		    <div class="col-sm-6">
		  		<label for="fecc">Fecha<small class="text-red">*</small></label>
		    	<div class="input-group">
		    		<input type="text" id="fecc" name="fecc" class="form-control" value="<?php echo fnormal($rvac['FechaIni'])?>" placeholder="dd/mm/aaaa" autocomplete="off">
		        	<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		    	</div>		    	
		    </div>
		    <div class="col-sm-6">
				<label for="ben">Beneficiario</label>		
				<input type="text" name="ben" id="ben" class="form-control">										
			</div>
		</div>
		<div class="form-group" id="d_frespuesta">		  	
		</div>		  
<?php
		}elseif($acc=="edident"){
			$ide= iseguro($cone,$_POST['v1']);		
			$idce= iseguro($cone,$_POST['v2']);			
			$c2=mysqli_query($cone,"SELECT * FROM tedocentrega WHERE idtedocentrega=$idce;");
			if($r2=mysqli_fetch_assoc($c2)){
?>  
				<div class="form-group">
					<div class="col-sm-6">
						<label for="tip">Tipo<small class="text-red">*</small></label>
						<input type="hidden" name="acc" id="acc" value="<?php echo $acc; ?>">
						<input type="hidden" name="ide" id="ide" value="<?php echo $ide;?>">
						<input type="hidden" name="idce" id="idce" value="<?php echo $idce; ?>">    
						<select class="form-control" name="tip" id="tip">
							<option value="">TIPO</option>
							<option value="1" <?php echo $r2['tipo']==1 ? "selected" : ""; ?>>VALE</option>
							<option value="2" <?php echo $r2['tipo']==2 ? "selected" : ""; ?>>RECIBO</option>
							<option value="3" <?php echo $r2['tipo']==3 ? "selected" : ""; ?>>GIRO</option>
							<option value="4" <?php echo $r2['tipo']==4 ? "selected" : ""; ?>>DEPOSITO</option>			
						</select>
					</div>
					<div class="col-sm-6">
						<label for="num">Número<small class="text-red">*</small></label>			
						<input type="text" name="num" id="num" class="form-control" value="<?php echo $r2['numero'] ?>">				
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-6">
						<label for="mov">Movimiento<small class="text-red">*</small></label>	    
						<select class="form-control" name="mov" id="mov">
							<option value="1" <?php echo $r2['tipmov']==1 ? "selected" : ""; ?>>ADELANTO</option>
							<option value="2" <?php echo $r2['tipmov']==2 ? "selected" : ""; ?>>DEVOLUCIÓN</option>	
						</select>
					</div>
					<div class="col-sm-6">
						<label for="mon">Monto<small class="text-red">*</small></label>
						<div class="input-group">
							<span class="input-group-addon">S/</span>
							<input type="text" name="mon" id="mon" class="form-control" value="<?php echo $r2['monto']; ?>">			
						</div>				
					</div>
				</div>
				<div class="form-group">
				    <div class="col-sm-6">
				    	<label for="fecc">Fecha<small class="text-red">*</small></label>
				    	<div class="input-group">
				    		<input type="text" id="fecc" name="fecc" class="form-control" value="<?php echo fnormal($r2['fecha'])?>" placeholder="dd/mm/aaaa" autocomplete="off">
				        	<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				    	</div>		    	
				    </div>
				    <div class="col-sm-6">
						<label for="ben">Beneficiario</label>		
						<input type="text" name="ben" id="ben" class="form-control" value="<?php echo $r2['beneficiario']; ?>">										
					</div>
				</div>
				<div class="form-group" id="d_frespuesta">
				  	
				</div>		  
<?php
					}else{
						echo mensajewa("Datos inválidos");
					}
					mysqli_free_result($c2);
		}elseif($acc=="elident"){
			$ide= iseguro($cone,$_POST['v1']);
			$idce= iseguro($cone,$_POST['v2']);				
			$c3=mysqli_query($cone,"SELECT * FROM tedocentrega WHERE idtedocentrega=$idce;");
			if($r3=mysqli_fetch_assoc($c3)){												
?>
				<div class="form-group">	
					<input type="hidden" name="acc" id="acc" value="<?php echo $acc; ?>">
					<input type="hidden" name="ide" id="ide" value="<?php echo $ide;?>">
					<input type="hidden" name="idce" id="idce" value="<?php echo $idce; ?>">
					<table class="table">
			          <thead>
			            <tr>
			              <td><h4 class="text-maroon text-center"> ¿Está seguro que desea eliminar el <?php echo $r3['tipo']== 1 ? "VALE" : "RECIBO";?> de <?php echo $r3['tipmov']== 1 ? "ADELANTO" : "DEVOLUCIÓN";?> por S/ <?php echo $r3['monto']?>?</h4></td></th>
			            </tr>
			          </thead>			          
	        		</table>
	        	</div>
<?php 
			}else{
				echo mensajewa("Datos inválidos");
			}
			mysqli_free_result($c3);
		}elseif($acc=="agrcomp"){
			$ide=iseguro($cone,$_POST['v1']);
			$cg=mysqli_query($cone, "SELECT * FROM tegasto WHERE ISNULL(idteentrega) AND ISNULL(idComServicios);");
			if(mysqli_num_rows($cg)>0){
?>
			<span class="text-purple"> <i class="fa fa-stack-overflow"></i> Comprobantes</span>
			<table class="table table-bordered table-hover" id="dt_comprobantes">
				<thead>
				<tr>
					<th>#</th>
					<th>GLOSA</th>
					<th>NÚMERO</th>
					<th>FECHA</th>
					<th>IMPORTE</th>
					<th>ACCIÓN</th>
				</tr>
				</thead>
<?php
				$n=0;
				while($rg=mysqli_fetch_assoc($cg)){
					$n++;
?>
				<tr>
					<td><?php echo $n; ?></td>
					<td><?php echo $rg['glosacom']; ?></td>
					<td><?php echo $rg['numerocom']; ?></td>
					<td><?php echo fnormal($rg['fechacom']); ?></td>
					<td><?php echo $rg['totalcom']; ?></td>
					<td>
						<button class="btn bg-yellow btn-xs" onclick="comaent(<?php echo $rg['idtegasto'].", ".$ide; ?>);" title="Agregar a entrega"><i class="fa fa-plus"></i></button><i class='fa fa-spinner fa-spin hidden' id="var<?php echo $rg['idtegasto']; ?>"></i>
					</td>
				</tr>
<?php
				}
?>
			</table>
			<script>
				$("#dt_comprobantes").dataTable();
			</script>
<?php
			}else{
				echo mensajewa("No se encontró comprobantes libres.");
			}
			mysqli_free_result($cg);
		}elseif($acc=="agrviat"){
			$ide=iseguro($cone,$_POST['v1']);

			$cg=mysqli_query($cone, "SELECT cs.idComServicios, cs.idEmpleado, cs.FechaIni, cs.FechaFin, cs.destino, d.Numero, d.Ano, d.Siglas, cs.estadoren, r.codigo, r.anio FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc LEFT JOIN terendicion r ON cs.idterendicion=r.idterendicion WHERE FechaIni>='2018-12-01' AND ISNULL(idteentrega) AND cs.Estado=1;");
			if(mysqli_num_rows($cg)>0){
?>
			<span class="text-purple"> <i class="fa fa-stack-overflow"></i> Viáticos</span>
			<table class="table table-bordered table-hover" id="dt_viaticos">
				<thead>
				<tr>
					<th>#</th>
					<th>NOMBRE</th>
					<th>DESTINO</th>
					<th>FECHAS</th>
					<th>DOCUMENTO</th>
					<th>NUM. REND.</th>
					<th>T. REND.</th>
					<th>ESTADO</th>
					<th>ACCIÓN</th>
				</tr>
				</thead>
<?php
				$n=0;
				while($rg=mysqli_fetch_assoc($cg)){
					$n++;
					$idcs=$rg['idComServicios'];
					$mv=0;
					$cm=mysqli_query($cone, "SELECT SUM(totalcom) movi FROM tegasto WHERE idComServicios=$idcs;");
					if($rm=mysqli_fetch_assoc($cm)){
						$mv=$rm['movi'];
					}
					mysqli_free_result($cm);
?>
				<tr>
					<td><?php echo $n; ?></td>
					<td style="font-size: 11px;"><?php echo nomempleado($cone, $rg['idEmpleado']); ?></td>
					<td style="font-size: 10px;"><?php echo $rg['destino']; ?></td>
					<td style="font-size: 11px;"><?php echo fnormal($rg['FechaIni'])."<br>".fnormal($rg['FechaFin']); ?></td>
					<td style="font-size: 10px;"><?php echo $rg['Numero']."-".$rg['Ano']."<br>".$rg['Siglas']; ?></td>
					<td style="font-size: 10px;"><?php echo $rg['codigo']."-".$rg['anio']; ?></td>
					<td style="font-size: 10px;"><?php echo $mv; ?></td>
					<td><?php echo erviaticos($rg['estadoren']); ?></td>
					<td>
						<button class="btn bg-yellow btn-xs" onclick="viaaent(<?php echo $rg['idComServicios'].", ".$ide; ?>);" title="Agregar a entrega"><i class="fa fa-plus"></i></button><i class='fa fa-spinner fa-spin hidden' id="var<?php echo $rg['idComServicios']; ?>"></i>
					</td>
				</tr>
<?php
				}
?>
			</table>
			<script>
				$("#dt_viaticos").dataTable();
			</script>
<?php
			}else{
				echo mensajewa("No se encontró viáticos libres.");
			}
			mysqli_free_result($cg);
		}elseif($acc=="libcomp"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
		  	$v1=iseguro($cone, $_POST['v1']);
		  	$v2=iseguro($cone, $_POST['v2']);
			$cv=mysqli_query($cone, "SELECT fechacom, numerocom, totalcom, glosacom FROM tegasto WHERE idtegasto=$v2;");
			if($rv=mysqli_fetch_assoc($cv)){
?>
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="v1" value="<?php echo $v1; ?>">
			      <input type="hidden" name="v2" value="<?php echo $v2; ?>">
				<table class="table table-bordered">
					<tr>
						<td align="center">
							<i class="fa fa-warning text-red"></i> <b>Liberará el comprobante:</b>
						</td>
					</tr>
					<tr>
						<td align="center">
							<?php echo "<span class='text-orange'>".$rv['numerocom']." [".$rv['glosacom']."]</span><br> Del: ".fnormal($rv['fechacom'])." | Por: ".n_2decimales($rv['totalcom']); ?>
						</td>
					</tr>
				</table>
				<div id="d_frespuesta">
				  	
				</div>
<?php
			}else{
				echo mensajewa("Error, datos inválidos.");
			}
			mysqli_free_result($cv);
		  }else{
		  	echo accrestringidoa();
		  }
		}elseif($acc=="libviat"){
		  if(accesoadm($cone,$_SESSION['identi'],16)){
		  	$v1=iseguro($cone, $_POST['v1']);
		  	$v2=iseguro($cone, $_POST['v2']);
			$cv=mysqli_query($cone, "SELECT idEmpleado, FechaIni, FechaFin, destino, idterendicion FROM comservicios WHERE idComServicios=$v2;");
			if($rv=mysqli_fetch_assoc($cv)){
?>
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="v1" value="<?php echo $v1; ?>">
			      <input type="hidden" name="v2" value="<?php echo $v2; ?>">
				<table class="table table-bordered">
					<tr>
						<td align="center">
							<i class="fa fa-warning text-red"></i> <b>Liberará el víatico:</b>
						</td>
					</tr>
					<tr>
						<td align="center">
							<?php echo "<span class='text-orange'>".nomempleado($cone, $rv['idEmpleado'])."</span><br>".$rv['destino']." | ".fnormal($rv['FechaIni'])." al ".fnormal($rv['FechaFin']); ?>
						</td>
					</tr>
				</table>
				<div id="d_frespuesta">
				  	
				</div>
<?php
			}else{
				echo mensajewa("Error, datos inválidos.");
			}
			mysqli_free_result($cv);
		  }else{
		  	echo accrestringidoa();
		  }
		}//acafin
	}else{
		echo mensajewa("Error: Faltan datos.");
	}
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>
<script>
$(' #fecc').datepicker({
  format: "dd/mm/yyyy",
  language: "es",
  autoclose: true,
  todayHighlight: true,
})
</script>