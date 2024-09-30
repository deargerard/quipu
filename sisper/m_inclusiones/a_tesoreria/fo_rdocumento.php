<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");

if(accesoadm($cone,$_SESSION['identi'],9)){
	if(isset($_POST['acc']) && !empty($_POST['acc']) && isset($_POST['idcs']) && !empty($_POST['idcs'])){
		$acc=iseguro($cone,$_POST['acc']);
		$idcs=iseguro($cone,$_POST['idcs']);
		$cc=mysqli_query($cone,"SELECT estadoren, FechaIni, FechaFin, aneplanilla, observacion, origen, destino FROM comservicios WHERE idComServicios=$idcs;");
		if($rc=mysqli_fetch_assoc($cc)){              
            $er=$rc['estadoren'];
            $ap=$rc['aneplanilla'];
            $fi=fnormal($rc['FechaIni']);
            $ff=fnormal($rc['FechaFin']);
        }
        mysqli_free_result($cc);			
		if($acc=="agrre"){		
			$c2=mysqli_query($cone,"SELECT idtegasto, idtetipocom FROM tegasto WHERE idComServicios=$idcs;");           
        	if (mysqli_num_rows($c2)>0){
        		$e=true;
        		while ($r2=mysqli_fetch_assoc($c2)){
        			if($r2['idtetipocom']==2){
        				$dj=true;
        			}
	        	}
	    	}
    		mysqli_free_result($c2);		
?>
			<table class="table table-hover">
			  <tr>
			    <td><i class="fa fa-map-marker text-orange"></i> <?php echo $rc['origen']."-".$rc['destino']; ?></td>
			    <td><?php echo fnormal($rc['FechaIni']); ?></td>
			    <td><?php echo fnormal($rc['FechaFin']); ?></td>

			    <td align="right">
					<?php
		        	if($er==0 || $er==2){ 
		        	?>
		          		<button type="button" class="btn bg-teal" title="Agregar Comprobante" onclick="fo_drendicion('agrdr',<?php echo $idcs ?>,0)"><i class="fa fa-plus"></i> Agregar comprobante</button>
		          		<?php if ($e){ ?>
		          			<button type="button" class="btn bg-primary" title="Enviar Rendición" onclick="fo_drendicion('envre',<?php echo $idcs ?>,0)"><i class="fa fa-send"></i> Enviar Rendición</button>
		          		<?php } ?>
		          		
		          	<?php
		          	}elseif(($er==3 || $er==4) && $e){
		          	
		          		if ($ap==1) {          		
		          	?>
		          		<a href="m_inclusiones/a_tesoreria/pdf_anexo01.php?idcs=<?php echo $idcs;?>" type="button" class="btn btn-warning" title="Anexo 01 Planilla" target="_blank">A01</a> <?php } ?>				  	
		        	<?php
		        		if ($dj) {
		        	?>
							<a href="m_inclusiones/a_tesoreria/te_anexo02pdf.php?idcs=<?php echo $idcs;?>" type="button" class="btn btn-warning" title="Declaración Jurada" target="_blank">DJ</a>
		        	<?php 
		        		} 
		        	?>
		        		<a href="m_inclusiones/a_tesoreria/te_anexo04pdf.php?idcs=<?php echo $idcs;?>" type="button" class="btn btn-warning" title="Anexo 04" target="_blank">A04</a>
		        		<?php if ($ap==7) {       			
		        		 ?>
		        		<a href="m_inclusiones/a_tesoreria/pdf_anexo07.php?idcs=<?php echo $idcs;?>" type="button" class="btn btn-warning" title="Anexo 07 Planilla" target="_blank">A07</a>
		          	<?php
		          		}
		          	?>
						<a href="m_inclusiones/a_tesoreria/pdf_anexo05.php?idcs=<?php echo $idcs;?>" type="button" class="btn btn-warning" title="Anexo 05 Recibo" target="_blank">A05</a>
		          	<?php
		          	}
		          	?>			      
			    </td>
			  </tr>			  
			</table>
<?php 
		    $c2=mysqli_query($cone,"SELECT idtegasto FROM tegasto WHERE idComServicios=$idcs;");
		    if (mysqli_num_rows($c2)>0) {
?>   
		    <table class="table table-hover" id="dtable">
		        <thead>
		          	<tr>
			            <th>FECHA</th>
			            <th>TIPO</th>
			            <th>NUMERO</th> 
			            <th>CONCEPTO</th>                       
			            <th style="text-align: right;">MONTO S/</th>
						<?php if($er==0 || $er==2){ ?>
						<th>ACCIÓN</th>
						<?php } ?>

		          	</tr>
		        </thead>
		        <tbody>
<?php
          			$c2=mysqli_query($cone,"SELECT g.idtegasto, g.fechacom, tc.abreviatura, cv.conceptov, g.numerocom, g.totalcom FROM tegasto g INNER JOIN tetipocom tc ON tc.idtetipocom=g.idtetipocom INNER JOIN teconceptov cv ON g.idteconceptov=cv.idteconceptov WHERE g.idComServicios=$idcs;");
          			$st=0; 
          			while($r2=mysqli_fetch_assoc($c2)){
          				$st=$st+$r2['totalcom'];
?>
			            <tr>              
				            <td><?php echo fnormal($r2['fechacom']); ?></td>
				            <td><?php echo $r2['abreviatura']; ?></td>
				            <td><?php echo $r2['numerocom']; ?></td>
				            <td><?php echo $r2['conceptov']; ?></td>              
				            <td style="text-align: right;"><?php echo $r2['totalcom']; ?></td>   
				            <?php if($er==0 || $er==2){ ?>           
				            <td>
				                <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
				                  	<button type="button" class="btn btn-default" title="Editar" onclick="fo_drendicion('edidr',<?php echo $idcs.",".$r2['idtegasto']; ?>)"><i class="fa fa-pencil"></i></button>
				                  	<button type="button" class="btn btn-default" title="Eliminar" onclick="fo_drendicion('elidr',<?php echo $idcs.",". $r2['idtegasto']; ?>)"><i class="fa fa-trash"></i></button>
				                </div>
			              	</td>
			              	<?php } ?>
			            </tr>
<?php
         			}
?>
						<tr class="text-maroon">
							<th colspan="4" style="text-align: right;">TOTAL</th>
							<th style="text-align: right;"><?php echo n_2decimales($st); ?></th>
							<?php if($er==0 || $er==2){ ?>  
							<th></th>
							<?php } ?>
						</tr>
        		</tbody>
      		</table>      		    
<?php
		if ($er==2) {
?>
		<table class="table table-bordered table-hover">		  
		  <tr>
		    <td><i class="fa fa-warning text-orange"></i> OBSERVACIÓN:</td>
		  </tr>
		  <tr>
		  	<td><?php echo $rc['observacion']; ?></td>
		  </tr> 
		  
		</table>
<?php
		  }  
    		mysqli_free_result($c2);
    		}else{
      			echo mensajewa("No se han registrado comprobantes de gasto.");
    		}
		}elseif($acc=="agrdr"){
			$idcs=iseguro($cone,$_POST['idcs']);
?>
			<div class="form-group">
				<input type="hidden" name="acc" value="<?php echo $acc; ?>">
				<input type="hidden" name="idcs" value="<?php echo $idcs; ?>">
				
				<div class="col-sm-6">
					<label for="doc" class="control-label">Tipo de comprobante <small class="text-red">*</small></label>	    
					<select class="form-control select2doc" name="doc" id="doc" style="width: 100%;">
					<option value="">Seleccione el tipo</option>					
<?php
						$c1=mysqli_query($cone, "SELECT * FROM tetipocom WHERE estado=1 ORDER BY tipo ASC;");
							if(mysqli_num_rows($c1)>0){
								while($r1=mysqli_fetch_assoc($c1)){
?>
								<option value="<?php echo $r1['idtetipocom']; ?>"><?php echo $r1['tipo'];?></option>
<?php
								}
							}
							mysqli_free_result($c1);
?>				
					</select>
				</div>
				
				<div class="col-sm-3">
					<label for="ser" class="control-label ocu">Serie: <small class="text-red">*</small></label>		
					<input type="text" name="ser" id="ser" class="form-control ocu" placeholder="Digite serie">									
				</div>
				<div class="col-sm-3">
					<label for="num" class="control-label ocu">Número: <small class="text-red">*</small></label>		
					<input type="text" name="num" id="num" class="form-control ocu" placeholder="Digite número">									
				</div>					
			</div>
			<div class="form-group">				
				<div class="col-sm-8">		    
					<label for="con" class="control-label">Concepto: <small class="text-red">*</small></label>
					<select class="form-control select2" name="con" id="con" style="width: 100%;">
					<option value=""> Seleccione el Concepto</option>					
<?php
						$c2=mysqli_query($cone, "SELECT * FROM teconceptov WHERE nanexo=4 ORDER BY conceptov ASC;");
							if(mysqli_num_rows($c2)>0){
								while($r2=mysqli_fetch_assoc($c2)){
?>
									<option value="<?php echo $r2['idteconceptov']; ?>"><?php echo $r2['conceptov'];?></option>
<?php
								}
							}
							mysqli_free_result($c2);
?>				
					</select>
				</div>
				
				<div class="col-sm-4">
					<label for="mon" class="control-label">Monto: <small class="text-red">*</small></label>
					<div class="input-group">
						<span class="input-group-addon">S/</span>
						<input type="text" name="mon" id="mon" class="form-control" placeholder="Digite el monto">			
					</div>				
				</div>			
			</div>
			<div class="form-group">			
				
				<div class="col-sm-12">	
					<label for="glo" class="control-label">Glosa:</label>
					<!-- <input type="text" name="glo" id="glo" class="form-control" placeholder="Digite la glosa del comprobante"> -->
					<select name="glo" id="glo" class="form-control">
						<option value="Desayuno">Desayuno</option>
						<option value="Almuerzo">Almuerzo</option>
						<option value="Cena">Cena</option>
						<option value="Hospedaje">Hospedaje</option>
						<option value="Movilidad local">Movilidad local</option>
						<option value="Pasaje terrestre">Pasaje terrestre</option>
						<option value="Movilidad de embarque">Movilidad de embarque</option>
					</select>	
				</div>			
			</div>

			<div class="form-group ocu">				
				<div class="col-sm-9">								
					<label for="pro" class=" control-label">Proveedor: <small class="text-red">*</small></label>
					<select class="form-control select2pro" name="pro" id="pro" style="width: 100%;">
						<option value="sd">Ninguno</option>		
					</select>
				</div>
				<div class="col-sm-3">
					<label class="control-label">&nbsp;</label>
					<button type="button" class="btn bg-teal btn-block" title="Agregar" onclick="fo_aproveedor('agrpro',<?php echo $idcs; ?>)"><i class="fa fa-plus"></i> Agregar</button>
				</div>
							
			</div>
			<div class="form-group">				
			    <div class="col-sm-4">
			    	<label for="fecg" class="control-label">Fecha <small class="text-red">*</small></label>
			    	<div class="input-group">
			    		<input type="text" id="fecg" name="fecg" class="form-control" placeholder="dd/mm/aaaa" autocomplete="off">
			        	<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			    	</div>		    	
			    </div>
			</div>
			<div class="form-group" id="d_frespuesta">
			  	
			</div>		
<?php 
		}elseif($acc=="edidr"){
		$idg=iseguro($cone,$_POST['idg']);
		$c3=mysqli_query($cone,"SELECT g.idtegasto, tc.tipo, tc.idtetipocom, cv.conceptov, g.numerocom, g.totalcom, g.idteproveedor, g.glosacom, g.fechacom, g.idteconceptov, p.razsocial FROM tegasto g INNER JOIN teconceptov cv ON g.idteconceptov=cv.idteconceptov LEFT JOIN teproveedor p ON g.idteproveedor=p.idteproveedor LEFT JOIN tetipocom tc ON tc.idtetipocom=g.idtetipocom WHERE idtegasto=$idg");
			if ($r3=mysqli_fetch_assoc($c3)) {					
?> 
			<div class="form-group">
				<input type="hidden" name="acc" value="<?php echo $acc; ?>">
				<input type="hidden" name="idcs" value="<?php echo $idcs; ?>">
				<input type="hidden" name="idg" value="<?php echo $idg; ?>">
				
				<div class="col-sm-6">		    
					<label for="doc" class="control-label">Tipo de comprobante: <small class="text-red">*</small></label>
					<select class="form-control select2doc" name="doc" id="doc" style="width: 100%;">			
<?php
						$c1=mysqli_query($cone, "SELECT * FROM tetipocom WHERE estado=1 ORDER BY tipo ASC;");
							if(mysqli_num_rows($c1)>0){
								while($r1=mysqli_fetch_assoc($c1)){
?>
								<option value="<?php echo $r1['idtetipocom']; ?>" <?php echo $r1['idtetipocom']==$r3['idtetipocom'] ? "selected" : ""; ?>><?php echo $r1['tipo'];?></option>
<?php
								}
							}
							mysqli_free_result($c1);
?>				
					</select>
				</div>
				<?php 
				$m=explode('-', $r3['numerocom']);
				?>
				<div class="col-sm-3">
					<label for="ser" class="control-label ocu <?php echo $r3['idtetipocom']==2 ? "hidden" : "" ?>">Serie: <small class="text-red">*</small></label>		
					<input type="text" name="ser" id="ser" class="form-control ocu <?php echo $r3['idtetipocom']==2 ? "hidden" : "" ?>" value="<?php echo $r3['numerocom']=="" ? "sd" : $m[0]; ?>">									
				</div>
				
				<div class="col-sm-3">
					<label for="num" class="control-label ocu <?php echo $r3['idtetipocom']==2 ? "hidden" : "" ?>">Número: <small class="text-red">*</small></label>				
					<input type="text" name="num" id="num" class="form-control ocu <?php echo $r3['idtetipocom']==2 ? "hidden" : "" ?>" value="<?php echo $r3['numerocom']=="" ? "sd" : $m[1]; ?>">
				</div>					
			</div>
			<div class="form-group">
				
				<div class="col-sm-8">		    
					<label for="con" class="control-label">Concepto: <small class="text-red">*</small></label>
					<select class="form-control select2" name="con" id="con" style="width: 100%;">						
<?php
						$c2=mysqli_query($cone, "SELECT * FROM teconceptov WHERE nanexo=4 ORDER BY conceptov ASC;");
							if(mysqli_num_rows($c2)>0){
								while($r2=mysqli_fetch_assoc($c2)){
?>
									<option value="<?php echo $r2['idteconceptov']; ?>" <?php echo $r2['idteconceptov']==$r3['idteconceptov'] ? "selected" : ""; ?>><?php echo $r2['conceptov'];?></option>
<?php
								}
							}
							mysqli_free_result($c2);
?>				
					</select>
				</div>
				
				<div class="col-sm-4">
					<label for="mon" class="control-label">Monto: <small class="text-red">*</small></label>
					<div class="input-group">
						<span class="input-group-addon">S/</span>
						<input type="text" name="mon" id="mon" class="form-control" value="<?php echo $r3['totalcom'] ?>">			
					</div>				
				</div>			
			</div>
			<div class="form-group">			
				
				<div class="col-sm-12">
					<label for="glo" class="control-label">Glosa:</label>									
					<!-- <input type="text" name="glo" id="glo" class="form-control" value=""> -->
					<select name="glo" id="glo" class="form-control">
						<option value="Desayuno" <?php echo $r3['glosacom']=="Desayuno" ? "selected" : "" ?>>Desayuno</option>
						<option value="Almuerzo" <?php echo $r3['glosacom']=="Almuerzo" ? "selected" : "" ?>>Almuerzo</option>
						<option value="Cena" <?php echo $r3['glosacom']=="Cena" ? "selected" : "" ?>>Cena</option>
						<option value="Hospedaje" <?php echo $r3['glosacom']=="Hospedaje" ? "selected" : "" ?>>Hospedaje</option>
						<option value="Movilidad local" <?php echo $r3['glosacom']=="Movilidad local" ? "selected" : "" ?>>Movilidad local</option>
						<option value="Movilidad de embarque" <?php echo $r3['glosacom']=="Movilidad de embarque" ? "selected" : "" ?>>Movilidad de embarque</option>
					</select>		
				</div>			
			</div>
			<div class="form-group ocu <?php echo $r3['idtetipocom']==2 ? "hidden" : "" ?>">				
				<div class="col-sm-9">
					<label for="pro" class="control-label">Proveedor: <small class="text-red">*</small></label>	
					<select class="form-control select2pro" name="pro" id="pro" style="width: 100%;">
						<option value="<?php echo $r3['idteproveedor'] ?>"><?php echo $r3['razsocial']; ?></option>
						<option value="sd" <?php echo $r3['idtetipocom']==2 ? "selected" : "" ?>>Ninguno</option>	
					</select>
				</div>
				<div class="col-sm-3">
					<label class="control-label">&nbsp;</label>
					<button type="button" class="btn bg-teal btn-block" title="Agregar" onclick="fo_aproveedor('agrpro',<?php echo $idcs; ?>)"><i class="fa fa-plus"></i> Agregar</button>
				</div>								
			</div>
			<div class="form-group">
				
			    <div class="col-sm-4">
			    	<label for="fecg" class="control-label">Fecha: <small class="text-red">*</small></label>
			    	<div class="input-group">
			    		<input type="text" id="fecg" name="fecg" class="form-control" value="<?php echo fnormal($r3['fechacom'])?>" placeholder="dd/mm/aaaa" autocomplete="off">
			        	<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			    	</div>		    	
			    </div>
			</div>
			<div class="form-group" id="d_frespuesta">
			  	
			</div>
<?php
			mysqli_free_result($c3);
    		}
		}elseif($acc=="elidr"){			
			$idcs=iseguro($cone,$_POST['idcs']);
			$idg=iseguro($cone,$_POST['idg']);
			$c4=mysqli_query($cone,"SELECT tc.idtetipocom, tc.tipo, g.numerocom, g.fechacom FROM tegasto g INNER JOIN tetipocom tc ON tc.idtetipocom=g.idtetipocom WHERE idtegasto=$idg");
			if ($r4=mysqli_fetch_assoc($c4)) {

				$n=$r4['idtetipocom']==2 ? " s/n " : " N° ";
?>
				<div class="form-group">	
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
					<input type="hidden" name="idcs" value="<?php echo $idcs; ?>">					
					<input type="hidden" name="idg" value="<?php echo $idg; ?>">					
			        <h4 class="text-center">Eliminará el comprobante:<br><br><b><span class="text-maroon"><?php echo $r4['tipo']. $n . $r4['numerocom']."<br>del ". fnormal($r4['fechacom'])."." ?></span></b></h4>
			    </div>
<?php 
			}
			mysqli_free_result($c4);			
		}elseif($acc=="envre"){			
			$idcs=iseguro($cone,$_POST['idcs']);
			$idg=iseguro($cone,$_POST['idg']);
?>
			<div class="form-group">	
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
					<input type="hidden" id='idcs' name="idcs" value="<?php echo $idcs; ?>">								
			        <h4 class="text-maroon text-center"><i class="fa fa-info-circle text-gray"></i> Cargue en un solo archivo sus comprobantes escaneados.</h4>
			</div>			
			<div class="form-group">
						
				<div class="col-sm-8">
					<input class="form-control" type="file" name="desc" id="desc" accept="application/pdf">
					<p class="help-block">Hasta 6Mb.</p>		
				</div>
				<div class="col-sm-4">
					<button type="button" class="btn btn-primary btn-block" onclick="enviarr();">Enviar</button>
				</div>						
			</div>
			<div class="form-group" id="d_frespuesta">
			  	
			</div>			
<?php					
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
$(' #fecg').datepicker({
  format: "dd/mm/yyyy",
  language: "es",
  autoclose: true,
  todayHighlight: true,
  startDate: "<?php echo $fi ?>",
  endDate: "<?php echo $ff ?>",
})
$(".select2").select2();
$(".select2doc").select2()
.on("change",function(e){
var tip=$(this).val();
if (tip==2) {
  $(".ocu").addClass("hidden");
  $("#num").val("sd");
  $("#ser").val("sd");  
  $("#pro").select2("val", "sd");  
}else{
  $(".ocu").removeClass("hidden");
  $("#num").val("");
  $("#ser").val("");   
}
});

$(".select2pro").select2({
	placeholder: 'Seleccione proveedor',
	ajax: {
	url: 'm_inclusiones/a_tesoreria/bu_proveedores.php',
	dataType: 'json',
	delay: 250,
		processResults: function (data) {
		    return {
		    	results: data
		    };
		},
		    cache: true
	},
		minimumInputLength: 3
});
</script>