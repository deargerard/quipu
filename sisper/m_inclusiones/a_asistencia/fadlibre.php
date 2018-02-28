<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){

?>
        <div class="form-group valida">
          <label for="desdl" class="col-sm-3 control-label">Descripción</label>
          <div class="col-sm-9">
            <input type="text" name="desdl" id="desdl" class="form-control" placeholder="Descripción día libre">
          </div>
        </div>
        <div class="form-group valida">
          <label for="fecdl" class="col-sm-3 control-label">Fecha</label>
          <div class="col-sm-9 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fecdl" id="fecdl" class="form-control" placeholder="dd/mm/yyyy">
          </div>
        </div>
        <div id="d_adlibre"></div>
        <script>
          $('#fecdl').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            todayHighlight: true
          });
        </script>

<?php

}else{
  echo accrestringidoa();
}
?>