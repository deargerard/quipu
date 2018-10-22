<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],16)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		$v2=iseguro($cone,$_POST['v2']);
		if($acc=="agrasig"){
?>		  
		<div class="form-group">
			<input type="hidden" name="acc" value="<?php echo $acc; ?>">
			<label for="mon" class="col-sm-2 control-label">Monto</label>
			<div class="col-sm-4">
				<div class="input-group">
					<span class="input-group-addon">S/</span>
					<input type="text" name="mon" id="mon" class="form-control">			
				</div>				
			</div>			
			<label for="tip" class="col-sm-2 control-label">Tipo</label>
			<div class="col-sm-4">		    
				<select class="form-control" name="tip" id="tip">
					<option value="2">Reembolso</option>
					<option value="1">Apertura</option>					
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="med" class="col-sm-2 control-label">Medio</label>
			<div class="col-sm-4">		    
				<select class="form-control" name="med" id="med">
					<option value="1">Cheque</option>
					<option value="2">Transferencia</option>
					<option value="3">Giro</option>
				</select>
			</div>
			<label for="num" class="col-sm-2 control-label">Número</label>
			<div class="col-sm-4">				
				<input type="text" name="num" id="num" class="form-control">											
			</div>			
			
		</div>

		<div class="form-group">
			<label for="met" class="col-sm-2 control-label">Meta</label>
			<div class="col-sm-4">								
				<select class="form-control" name="met" id="met">
					<option value="">Meta</option>
		<?php
						$c1=mysqli_query($cone, "SELECT m.*, f.nombre AS fondo FROM temeta m INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE m.estado=1 ORDER BY fondo, nombre DESC;");
							if(mysqli_num_rows($c1)>0){
								while($r1=mysqli_fetch_assoc($c1)){
					?>
					<option value="<?php echo $r1['idtemeta']; ?>"><?php echo $r1['fondo']."-".$r1['nombre']." (".$r1['mnemonico'].")"; ?></option>
		<?php
								}
							}
						mysqli_free_result($c1);
		?>
				</select>
			</div>

			<label for="feca" class="col-sm-2 control-label">Fecha</label>
		    <div class="col-sm-4">
		    	<div class="input-group">
		    		<input type="text" id="feca" name="feca" class="form-control" value="<?php echo fnormal($rvac['FechaIni'])?>" placeholder="dd/mm/aaaa" autocomplete="off">
		        	<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
		    	</div>		    	
		    </div>
		</div>
		<div class="form-group" id="d_frespuesta">
		  	
		</div>		  
<?php
		}elseif($acc=="ediasig"){
			$c2=mysqli_query($cone,"SELECT * FROM teasignacion WHERE idteasignacion=$v2;");
			if($r2=mysqli_fetch_assoc($c2)){
?>  
				<div class="form-group">
					<input type="hidden" name="acc" id="acc" value="<?php echo $acc; ?>">
					<input type="hidden" name="ida" id="ida" value="<?php echo $v2; ?>">
					<label for="mon" class="col-sm-2 control-label">Monto</label>
					<div class="col-sm-4">
						<div class="input-group">
							<span class="input-group-addon">S/</span>
							<input type="text" name="mon" id="mon" class="form-control" value="<?php echo $r2['monto']; ?>">			
						</div>				
					</div>			
					<label for="tip" class="col-sm-2 control-label">Tipo</label>
					<div class="col-sm-4">		    
						<select class="form-control" name="tip" id="tip">
							<option value="2" <?php echo $r2['tipo']==2 ? "selected" : ""; ?>>Reembolso</option>
							<option value="1" <?php echo $r2['tipo']==1 ? "selected" : ""; ?>>Apertura</option>					
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="med" class="col-sm-2 control-label">Medio</label>
					<div class="col-sm-4">		    
						<select class="form-control" name="med" id="med">
							<option value="1" <?php echo $r2['medio']==1 ? "selected" : ""; ?>>Cheque</option>
							<option value="2" <?php echo $r2['medio']==2 ? "selected" : ""; ?>>Transferencia</option>
							<option value="3" <?php echo $r2['medio']==3 ? "selected" : ""; ?>>Giro</option>
						</select>
					</div>
					<label for="num" class="col-sm-2 control-label">Número</label>
					<div class="col-sm-4">				
						<input type="text" name="num" id="num" class="form-control" value="<?php echo $r2['nummedio'] ?>">				
					</div>				
				</div>
				<div class="form-group">
					<label for="met" class="col-sm-2 control-label">Meta</label>
					<div class="col-sm-4">										
						<select class="form-control" name="met" id="met">
							<option value="">Meta</option>
<?php
								$c5=mysqli_query($cone, "SELECT m.*, f.nombre AS fondo FROM temeta m INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE m.estado=1 ORDER BY fondo, nombre DESC;");
									if(mysqli_num_rows($c5)>0){
										while($r5=mysqli_fetch_assoc($c5)){
?>
											<option value="<?php echo $r2['idtemeta']; ?>" <?php echo $r2['idtemeta']==$r5['idtemeta'] ? "selected" : ""; ?>><?php echo $r5['fondo']."-".$r5['nombre']." (".$r5['mnemonico'].")"; ?></option>
<?php
										}
									}
								mysqli_free_result($c1);
?>
						</select>
					</div>

					<label for="feca" class="col-sm-2 control-label">Fecha</label>
				    <div class="col-sm-4">
				    	<div class="input-group">
				    		<input type="text" id="feca" name="feca" class="form-control" value="<?php echo fnormal($r2['fecha'])?>" placeholder="dd/mm/aaaa" autocomplete="off">
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
		}elseif($acc=="eliasig"){

			$c3=mysqli_query($cone,"SELECT * FROM teasignacion WHERE idteasignacion=$v2;");
			if($r3=mysqli_fetch_assoc($c3)){

				$c5=mysqli_query($cone, "SELECT m.*, f.nombre AS fondo FROM temeta m INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE m.estado=1 ORDER BY fondo, nombre DESC;");									
?>
				<script>
      			$("#b_guardar").html("Sí eliminar");      			
      			</script>
				<div class="form-group">	
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
					<input type="hidden" name="ida" value="<?php echo $v2; ?>">
					<table class="table">
			          <thead>
			            <tr>
			              <th class="text-center"><?php echo "¿Está seguro que desea eliminar la Asignación?"; ?></th>
			            </tr>
			          </thead>
			          <tbody>
			            <tr>
<?php 
							if($r5=mysqli_fetch_assoc($c5)){
?>
								<td><h4 class="text-maroon text-center"> <?php echo $r2['tipo']== 1 ? "Apertura" : "Reembolso";?> de S/ <?php echo $r3['monto']?> para la meta <?php echo $r5['fondo']."-".$r5['nombre']; ?></h4></td>
<?php							
							}
								mysqli_free_result($c5);
?>			            				              
			            </tr>
			          </tbody>
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