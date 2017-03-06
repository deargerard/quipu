<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
?>
        <div class="form-group has-feedback valida">
          <label for="fec" class="col-sm-2 control-label">Fecha</label>
          <div class="col-sm-3">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fec" id="fec" class="form-control">
          </div>
  	        <script>
    			//fecha intranet
    			$('#fec').datepicker({
    			  format: "dd/mm/yyyy",
    			  language: "es",
    			  autoclose: true,
    			  todayHighlight: true
    			});
    			//fin fecha intranet
    			</script>
        </div>
        <div class="form-group valida">
          <label for="des" class="col-sm-2 control-label">Descripción</label>
          <div class="col-sm-10">
            <input type="text" name="des" id="des" class="form-control">
          </div>
        </div>
        <div class="form-group valida">
          <label for="con" class="col-sm-2 control-label">Contenido</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="con" id="wisy" rows="6"></textarea>
          </div>
            <script>
            	$("#wisy").wysihtml5();
            </script>
        </div>
<?php
}else{
  echo accrestringidoa();
}
?>
