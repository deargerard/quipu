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
			<input type="hidden" name="acc" id="acc" value="<?php echo $acc;?>">	
			<input type="hidden" name="ide" id="ide" value="<?php echo $ide;?>">				
			<label for="tip" class="col-sm-2 control-label">Tipo</label>
			<div class="col-sm-4">		    
				<select class="form-control" name="tip" id="tip">
					<option value="2">RECIBO</option>
					<option value="1">VALE</option>					
				</select>
			</div>
			<label for="num" class="col-sm-2 control-label">Número</label>
			<div class="col-sm-4">				
				<input type="text" name="num" id="num" class="form-control">											
			</div>
			
		</div>

		<div class="form-group">
			<label for="mov" class="col-sm-2 control-label">Movimiento</label>
			<div class="col-sm-4">		    
				<select class="form-control" name="mov" id="mov">
					<option value="1">ADELANTO</option>
					<option value="2">DEVOLUCIÓN</option>					
				</select>
			</div>
			<label for="mon" class="col-sm-2 control-label">Monto</label>
			<div class="col-sm-4">
				<div class="input-group">
					<span class="input-group-addon">S/</span>
					<input type="text" name="mon" id="mon" class="form-control">			
				</div>				
			</div>		
		</div>
		<div class="form-group">
			<label for="fecc" class="col-sm-2 control-label">Fecha</label>
		    <div class="col-sm-4">
		    	<div class="input-group">
		    		<input type="text" id="fecc" name="fecc" class="form-control" value="<?php echo fnormal($rvac['FechaIni'])?>" placeholder="dd/mm/aaaa" autocomplete="off">
		        	<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		    	</div>		    	
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
					<input type="hidden" name="acc" id="acc" value="<?php echo $acc; ?>">
					<input type="hidden" name="ide" id="ide" value="<?php echo $ide;?>">
					<input type="hidden" name="idce" id="idce" value="<?php echo $idce; ?>">
													
					<label for="tip" class="col-sm-2 control-label">Tipo</label>
					<div class="col-sm-4">		    
						<select class="form-control" name="tip" id="tip">
							<option value="2" <?php echo $r2['tipo']==2 ? "selected" : ""; ?>>RECIBO</option>
							<option value="1" <?php echo $r2['tipo']==1 ? "selected" : ""; ?>>VALE</option>					
						</select>
					</div>
					<label for="num" class="col-sm-2 control-label">Número</label>
					<div class="col-sm-4">				
						<input type="text" name="num" id="num" class="form-control" value="<?php echo $r2['numero'] ?>">				
					</div>
				</div>

				<div class="form-group">
					<label for="mov" class="col-sm-2 control-label">Movimiento</label>
					<div class="col-sm-4">		    
						<select class="form-control" name="mov" id="mov">
							<option value="1" <?php echo $r2['tipmov']==1 ? "selected" : ""; ?>>ADELANTO</option>
							<option value="2" <?php echo $r2['tipmov']==2 ? "selected" : ""; ?>>DEVOLUCIÓN</option>	
						</select>
					</div>
					<label for="mon" class="col-sm-2 control-label">Monto</label>
					<div class="col-sm-4">
						<div class="input-group">
							<span class="input-group-addon">S/</span>
							<input type="text" name="mon" id="mon" class="form-control" value="<?php echo $r2['monto']; ?>">			
						</div>				
					</div>
				</div>
				<div class="form-group">
					<label for="fecc" class="col-sm-2 control-label">Fecha</label>
				    <div class="col-sm-4">
				    	<div class="input-group">
				    		<input type="text" id="fecc" name="fecc" class="form-control" value="<?php echo fnormal($r2['fecha'])?>" placeholder="dd/mm/aaaa" autocomplete="off">
				        	<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				    	</div>		    	
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