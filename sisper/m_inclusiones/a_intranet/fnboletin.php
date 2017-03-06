<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
?>
        <div class="form-group valida">
          <label for="des" class="col-sm-2 control-label">Descripción</label>
          <div class="col-sm-10">
            <input type="text" name="des" id="des" class="form-control">
          </div>
        </div>
        <div class="form-group has-feedback valida">
          <label for="fecb" class="col-sm-2 control-label">Fecha</label>
          <div class="col-sm-4">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fecb" id="fecb" class="form-control">
          </div>
            <script>
          //fecha intranet
          $('#fecb').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            todayHighlight: true
          });
          //fin fecha intranet
          </script>
        </div>
        <div class="form-group valida">
          <label for="bol" class="col-sm-2 control-label">Boletín</label>
          <div class="col-sm-10">
            <input type="file" name="bol" id="bol" class="form-control" accept="application/pdf">
            <p class="help-block">Hasta 6Mb.</p>
          </div>
        </div>
<?php
}else{
  echo accrestringidoa();
}
?>
