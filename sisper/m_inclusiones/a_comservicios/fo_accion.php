<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		
		if($acc=="edienc"){
			$enc= iseguro($cone,$_POST['v1']);			
			$c2=mysqli_query($cone,"SELECT * FROM encargatura WHERE idEncargatura=$enc;");
			if($r2=mysqli_fetch_assoc($c2)){
?>  
				<div class="form-group valida">
				  <input type="hidden" name="acc" id="acc" value="<?php echo $acc; ?>">					
				  <input type="hidden" name="enc" id="enc" value="<?php echo $enc; ?>">
				  <input type="hidden" name="cs" id="cs" value="<?php echo $r2['idComServicios']; ?>">
		          <label for="enc" class="col-sm-2 control-label">Encargado</label>
		          <div class="col-sm-6 has-feedback">
		            <select name="encar" id="encar" class="form-control select2peract" style="width: 100%;">
		            	<option> <?php echo nomempleado($cone, $r2['idEmpleado']); ?></option>
		            </select>
		          </div>
		          <label for="tip" class="col-sm-1 control-label">Tipo</label>
		          <div class="col-sm-3 has-feedback">
		            <select name="tip" id="tip" class="form-control" style="width: 100%;">
		              <option value="1" <?php echo $r2['Tipo']==1 ? "selected" : ""; ?>>Des/Coor</option>
		              <option value="2" <?php echo $r2['Tipo']==2 ? "selected" : ""; ?>>Coordinación</option>
		              <option value="3" <?php echo $r2['Tipo']==3 ? "selected" : ""; ?>>Despacho</option>
		            </select>
		          </div>
		        </div>

		        <div class="form-group valida">
		          <label for="inienc" class="col-sm-2 control-label">Inicia:</label>
		          <div class="col-sm-4 has-feedback">
		            <span class="fa fa-calendar form-control-feedback"></span>
		            <input type="text" id="inienc" name="inienc" class="form-control" value="<?php echo date('d/m/Y H:m', strtotime($r2['Inicio']))?>" placeholder="dd/mm/aaaa H:i" autocomplete="off">
		          </div>
		          <label for="finenc" class="col-sm-2 control-label">Termina:</label>
		          <div class="col-sm-4 has-feedback">
		            <span class="fa fa-calendar form-control-feedback"></span>
		            <input type="text" id="finenc" name="finenc" class="form-control" value="<?php echo date('d/m/Y H:m', strtotime($r2['Fin']))?>" placeholder="dd/mm/aaaa H:i" autocomplete="off">
		          </div>
		        </div>

		        <div class="text-center col-md-12">
		          <p id="msg" class="text-maroon"></p>
		        </div>					  
<?php
					}else{
						echo mensajewa("Datos inválidos");
					}
					mysqli_free_result($c2);
		}elseif($acc=="elienc"){
			$enc= iseguro($cone,$_POST['v1']);			
			$c3=mysqli_query($cone,"SELECT * FROM encargatura WHERE idEncargatura=$enc;");
			if($r3=mysqli_fetch_assoc($c3)){
?>
				<div class="form-group">	
					<input type="hidden" name="acc" id="acc" value="<?php echo $acc; ?>">					
					<input type="hidden" name="enc" id="enc" value="<?php echo $enc; ?>">
					<input type="hidden" name="cs" id="cs" value="<?php echo $r3['idComServicios']; ?>">		
			        <h4 class="text-maroon text-center">¿Está seguro que desea eliminar la encargatura de: <?php echo nomempleado($cone, $r3['idEmpleado']); ?> ?</h4>
			    </div>
<?php 
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
    $('#inienc').datetimepicker({
      locale:'es',
      useCurrent: false,
      sideBySide:true,
      format:'DD/MM/YYYY HH:mm',
    }).on('dp.change', function(e){
      $('#finenc').data('DateTimePicker').minDate(e.date.format ('DD-MM-YYYY'));

    });


    $('#finenc').datetimepicker({
      locale:'es',
      format:'DD/MM/YYYY HH:mm',
      useCurrent: false,
      sideBySide:true,
    }).on('dp.change', function(e){
      $('#inienc').data('DateTimePicker').maxDate(e.date.format ('DD-MM-YYYY'));
    });

    $(".select2peract").select2({
      placeholder: 'Selecione a un personal',
      ajax: {
        url: 'm_inclusiones/a_general/a_selpersonal.php',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
          return {
            results: data
          };
        },
        cache: true
      },
      minimumInputLength: 4
    });
    </script>