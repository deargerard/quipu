<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["idec"]) && !empty($_POST["idec"])){
    $idec=iseguro($cone,$_POST["idec"]);
  ?>
                  <div class="form-group">
                    <label for="ini" class="col-sm-3 control-label">Inicia</label>
                    <div class="col-sm-3 valida">
                      <input type="hidden" id="idec" name="idec" value="<?php echo $idec ?>">
                      <input type="text" id="ini" name="ini" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fin" class="col-sm-3 control-label">Finaliza</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fin" name="fin" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mot" class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numres" class="col-sm-3 control-label">N° Resolución</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="numres" name="numres" class="form-control" placeholder="Número de resolución">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numdoc" class="col-sm-3 control-label">N° Documento</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="numdoc" name="numdoc" class="form-control" placeholder="Número de documento presentado">
                    </div>
                  </div>
<script>
  $('#ini,#fin').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    todayHighlight: true
  });
</script>
  <?php
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún personal</h4>";
  }
}else{
  echo accrestringidoa();
}
?>