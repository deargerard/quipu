<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
?>
        <div class="form-group has-feedback valida">
          <label for="fec" class="col-sm-1 control-label">Fecha</label>
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
          <label for="tit" class="col-sm-1 control-label">Titular</label>
          <div class="col-sm-11">
            <input type="text" name="tit" id="tit" class="form-control">
          </div>
        </div>
        <div class="form-group valida">
          <label for="con" class="col-sm-1 control-label">Contenido</label>
        </div>
        <div id="summernote"></div>
        <script>
          $(document).ready(function() {
              $('#summernote').summernote({
                height: 250,
                lang: 'es-ES'
              });
          });
        </script>
<?php
}else{
  echo accrestringidoa();
}
?>
