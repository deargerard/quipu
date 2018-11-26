<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],16)){
	if(isset($_POST['acc']) && !empty($_POST['acc']) && isset($_POST['v1']) && !empty($_POST['v1'])){
		$acc=iseguro($cone,$_POST['acc']);
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);

		if($acc=="agrren"){
?>
		  <div class="row">
			<div class="col-sm-8">
		    	<div class="form-group">
			      <label for="met">Meta</label>
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="mes" value="<?php echo $v1; ?>">
			      <input type="hidden" name="anio" value="<?php echo $v2; ?>">
			      <select class="form-control" name="met" id="met">
			      	<option value="">META</option>
<?php
				$c1=mysqli_query($cone, "SELECT m.*, f.nombre AS fondo FROM temeta m INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE m.estado=1 ORDER BY fondo, nombre DESC;");
				if(mysqli_num_rows($c1)>0){
					while($r1=mysqli_fetch_assoc($c1)){
?>
						<option value="<?php echo $r1['idtemeta']; ?>"><?php echo $r1['fondo']." / ".$r1['nombre']." (".$r1['mnemonico'].")"; ?></option>
<?php
					}
				}
				mysqli_free_result($c1);
?>
		      	  </select>
		    	</div>
		    </div>
		    <div class="col-sm-4">
		    	<div class="form-group">
		    		<label for="tr">Tipo Rendición</label>
			    	<select class="form-control" name="tr" id="tr">
			    		<option value="1">FONDOS Y PROGRAMAS</option>
			    		<option value="2">VIÁTICOS</option>
			    	</select>
		    	</div>
		    </div>
		  </div>
		  <div id="d_frespuesta">
		  	
		  </div>
<?php
		}elseif($acc=="ediren"){
			$c2=mysqli_query($cone,"SELECT idtemeta, trendicion FROM terendicion WHERE idterendicion=$v1;");
			if($r2=mysqli_fetch_assoc($c2)){
				$pev=true;
				$c3=mysqli_query($cone, "SELECT idtegasto FROM tegasto WHERE idterendicion=$v1;");
				if(mysqli_num_rows($c3)>0){
					$pev=false;
				};
				mysqli_free_result($c3);
				$c4=mysqli_query($cone,"SELECT idcomservicios FROM comservicios WHERE idterendicion=$v1;");
				if(mysqli_num_rows($c4)>0){
					$pev=false;
				};
				mysqli_free_result($c4);
?>
		  <div class="row">
		    <div class="col-sm-8">
		    	<div class="form-group">
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="idr" value="<?php echo $v1; ?>">
			      <input type="hidden" name="po" value="<?php echo $pev ? "si" : "no"; ?>">
			      <label for="met">Meta</label>
			      <select class="form-control" name="met" id="met">
			      	<option value="">Meta</option>
<?php
				$c1=mysqli_query($cone, "SELECT m.*, f.nombre AS fondo FROM temeta m INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE m.estado=1 ORDER BY fondo, nombre DESC;");
				if(mysqli_num_rows($c1)>0){
					while($r1=mysqli_fetch_assoc($c1)){
?>
						<option value="<?php echo $r1['idtemeta']; ?>" <?php echo $r1['idtemeta']==$r2['idtemeta'] ? "selected" : ""; ?>><?php echo $r1['fondo']." / ".$r1['nombre']." (".$r1['mnemonico'].")"; ?></option>
<?php
					}
				}
				mysqli_free_result($c1);
?>
		      	  </select>
		      	</div>
		    </div>
		    <div class="col-sm-4 <?php echo !$pev ? "hidden" : "" ?>">
		    	<div class="form-group">
		    		<label for="tr">Tipo Rendición</label>
			    	<select class="form-control" name="tr" id="tr">
			    		<option value="">TIPO RENDICIÓN</option>
			    		<option value="1" <?php echo $r2['trendicion']==1 ? "selected" : ""; ?>>FONDOS Y PROGRAMAS</option>
			    		<option value="2" <?php echo $r2['trendicion']==2 ? "selected" : ""; ?>>VIÁTICOS</option>
			    	</select>
			    </div>
		    </div>
		  </div>
		  <div id="d_frespuesta">
		  	
		  </div>
<?php
			}else{
				echo mensajewa("Datos inválidos");
			}
			mysqli_free_result($c2);
		}elseif($acc=="agrdoc"){
			if($v2==1){
?>
			  <div class="form-group">
			    <label for="esp" class="col-sm-2 control-label">Especifica</label>
			    <div class="col-sm-5">
			      <select class="form-control select2" id="esp" name="esp" style="width: 100%;">
			      	<option value="">ESPECIFICA</option>
<?php
					$ce=mysqli_query($cone,"SELECT * FROM teespecifica WHERE estado=1 ORDER BY nombre ASC;");
					if(mysqli_num_rows($ce)>0){
						while($re=mysqli_fetch_assoc($ce)){
?>
					<option value="<?php echo $re['idteespecifica'] ?>"><?php echo $re['nombre']; ?></option>
<?php
						}
					}
					mysqli_free_result($ce);
?>
			      </select>
			    </div>
			    <label for="feccom" class="col-sm-2 control-label">Fec. Comp.</label>
			    <div class="col-sm-3">
			      <input type="text" class="form-control" id="feccom" name="feccom" placeholder="dd/mm/aaaa" autocomplete="off">
			      <!--<span class="fa fa-calendar form-control-feedback"></span>-->
			    </div>
			  </div>
			  <div class="form-group">
			  	<label for="tcom" class="col-sm-2 control-label">Tip. Comp.</label>
			    <div class="col-sm-5">
			      <select class="form-control select2" id="tcom" name="tcom" style="width: 100%;">
			      	<option value="">TIPO COMPROBANTE</option>
<?php
					$ctd=mysqli_query($cone,"SELECT * FROM tetipocom WHERE estado=1 ORDER BY tipo ASC;");
					if(mysqli_num_rows($ctd)>0){
						while($rtd=mysqli_fetch_assoc($ctd)){
?>
					<option value="<?php echo $rtd['idtetipocom'] ?>"><?php echo $rtd['tipo']; ?></option>
<?php
						}
					}
					mysqli_free_result($ctd);
?>
			      </select>
			    </div>
			    <label for="numcom" class="col-sm-2 control-label">N° Comp.</label>
			    <div class="col-sm-3">
			      <input type="text" class="form-control" id="numcom" name="numcom" placeholder="1-123">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="des" class="col-sm-2 control-label">Descripción</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="des" name="des" placeholder="Descripción">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="imp" class="col-sm-2 control-label">Importe</label>
			    <div class="col-sm-4">
			      <input type="number" class="form-control" id="imp" name="imp" placeholder="0.00" autocomplete="off">
			    </div>
			    <label for="codser" class="col-sm-2 control-label">Cod. Serv.</label>
			    <div class="col-sm-4">
			      <input type="text" class="form-control" id="codser" name="codser" placeholder="F524Y">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="can" class="col-sm-2 control-label">Cantidad</label>
			    <div class="col-sm-4">
			      <input type="number" class="form-control" id="can" name="can" placeholder="0.00">
			    </div>
			    <label for="uni" class="col-sm-2 control-label">Unid. Med.</label>
			    <div class="col-sm-4">
			      <input type="text" class="form-control" id="uni" name="uni" placeholder="Kg">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="pro" class="col-sm-2 control-label">Proveedor</label>
			    <div class="col-sm-8">
			      <select class="form-control select2pro" id="pro" name="pro" style="width: 100%;">
			      	<option value="">PROVEEDOR</option>
			      </select>
			    </div>
			    <button type="button" class="btn btn-default" onclick="fo_rendiciones1('agrpro',1,0);"><i class="fa fa-plus"></i> Agregar</button>
			  </div>
			  <div class="form-group">
			    <label for="dep" class="col-sm-2 control-label">Dependencia</label>
			    <div class="col-sm-10">
			      <select class="form-control select2dep" id="dep" name="dep" style="width: 100%;">
			      	<option value="">DEPENDENCIA</option>
			      </select>
			    </div>
			  </div>
			  <script>
			  	$(".select2").select2({
			  		dropdownParent: $("#m_modal")
			  	});
			  	$(".select2pro").select2({
				  placeholder: 'Seleccione empresa',
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
				  minimumInputLength: 3,
				  dropdownParent: $("#m_modal")
				});
				$(".select2dep").select2({
				  placeholder: 'Seleccione dependencia',
				  ajax: {
				    url: 'm_inclusiones/a_tesoreria/bu_dependencias.php',
				    dataType: 'json',
				    delay: 250,
				    processResults: function (data) {
				      return {
				        results: data
				      };
				    },
				    cache: true
				  },
				  minimumInputLength: 3,
				  dropdownParent: $("#m_modal")
				});
				$('#feccom').datepicker({
				    format: 'dd/mm/yyyy',
				    autoclose: true,
				    minViewMode: 0,
				    maxViewMode: 2,
				    todayHighlight: true
				});
			  </script>
<?php
			}elseif($v2==2){
				echo "VIÁTICOS";
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