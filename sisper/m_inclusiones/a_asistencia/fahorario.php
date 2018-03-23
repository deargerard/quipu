<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){

?>
        <div class="form-group valida">
          <label for="des" class="col-sm-3 control-label">Horario</label>
          <div class="col-sm-9">
            <input type="text" name="des" id="des" class="form-control" placeholder="Horario">
          </div>
        </div>
        <div class="form-group valida">
          <label for="rmar" class="col-sm-3 control-label">Requiere Marcar</label>
          <div class="col-sm-3">
            <label class="checkbox-inline"><input type="checkbox" value="1" id="rmar" name="rmar">Sí</label>
          </div>
          <label for="rdlib" class="col-sm-4 control-label ocu">Respeta día libre</label>
          <div class="col-sm-2 ocu">
            <label class="checkbox-inline"><input type="checkbox" value="1" id="rdlib" name="rdlib">Sí</label>
          </div>
        </div>
        <div class="form-group valida ocu">
          <label for="hing" class="col-sm-3 control-label">Hora Ingreso</label>
          <div class="col-sm-3 has-feedback">
            <span class="fa fa-hourglass-half form-control-feedback"></span>
            <input type="text" name="hing" id="hing" class="form-control" placeholder="Hora">
          </div>
          <label for="hsal" class="col-sm-3 control-label">Hora Salida</label>
          <div class="col-sm-3 has-feedback">
            <span class="fa fa-hourglass-half form-control-feedback"></span>
            <input type="text" name="hsal" id="hsal" class="form-control" placeholder="Hora">
          </div>
        </div>
        <div class="form-group valida ocu">
          <label for="hsalr" class="col-sm-3 control-label">H. Sal. Refrigerio</label>
          <div class="col-sm-3 has-feedback">
            <span class="fa fa-hourglass-half form-control-feedback"></span>
            <input type="text" name="hsalr" id="hsalr" class="form-control" placeholder="Hora">
          </div>
          <label for="hingr" class="col-sm-3 control-label">H. Ing. Refrigerio</label>
          <div class="col-sm-3 has-feedback">
            <span class="fa fa-hourglass-half form-control-feedback"></span>
            <input type="text" name="hingr" id="hingr" class="form-control" placeholder="Hora">
          </div>
        </div>
        <div class="form-group valida ocu">
          <label class="col-sm-3 control-label">Excluir</label>
          <div class="col-sm-4 ">
            <label for="esab" class="checkbox-inline"><input type="checkbox" value="1" id="esab" name="esab">Sábados </label>
            <label for="edom" class="checkbox-inline"><input type="checkbox" value="1" id="edom" name="edom">Domingos</label>
          </div>
          <label class="col-sm-3 control-label ocu">Sale Siguiente Día</label>
          <div class="col-sm-2">
            <label for="ssigd" class="checkbox-inline"><input type="checkbox" value="1" id="ssigd" name="ssigd">Sí</label>
          </div>
        </div>
        <div id="d_ahorario"></div>
        <script>
          $(".ocu").hide();
          $("#rmar").click(function(){
            if (this.checked) $(".ocu").show();
            else $(".ocu").hide();
          });
          $('#hing, #hsal, #hingr, #hsalr').datetimepicker({
              locale: 'es',
              format: 'HH:mm'
          });

        </script>

<?php

}else{
  echo accrestringidoa();
}
?>