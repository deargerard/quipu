<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["idec"]) && !empty($_POST["idec"])){
    $idec=iseguro($cone,$_POST["idec"]);
  ?>
                  <div class="form-group">
                    <label for="dep" class="col-sm-3 control-label">Dependencia</label>
                    <div class="col-sm-9 valida">
                      <input type="hidden" id="idec" name="idec" value="<?php echo $idec ?>">
                      <select name="dep" id="dep" class="form-control select2" style="width: 100%;">
                        <option value="">DEPENDENCIA</option>
                        <?php echo listadepe($cone) ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tipdes" class="col-sm-3 control-label">Tipo Desplazamiento</label>
                    <div class="col-sm-6 valida">
                      <select name="tipdes" id="tipdes" class="form-control">
                        <option value="">TIPO DESPLAZAMIENTO</option>
                        <?php
                          $ctd=mysqli_query($cone,"SELECT * FROM tipodesplaza WHERE Estado=1 AND idTipoDesplaza!=1");
                          while($rtd=mysqli_fetch_assoc($ctd)){
                        ?>
                        <option value="<?php echo $rtd['idTipoDesplaza'] ?>"><?php echo $rtd['TipoDesplaza'] ?></option>
                        <?php
                          }
                          mysqli_free_result($ctd);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ini" class="col-sm-3 control-label">Fecha Inicio</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="ini" name="ini" class="form-control" placeholder="dd/mm/aaaa" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fven" class="col-sm-3 control-label">Fecha Vencimiento</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fven" name="fven" class="form-control" placeholder="dd/mm/aaaa" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numres" class="col-sm-3 control-label">N° Documento</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numres" name="numres" class="form-control" placeholder="N° Documento">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mot" class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ofi" class="col-sm-3 control-label">Oficial para Lima</label>
                    <div class="col-sm-9 valida checkbox">
                      <label><input type="checkbox" id="ofi" name="ofi" value="1">Sí</label>
                    </div>
                  </div>
<script>
  $('#ini,#fven').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true
  });
  $(".select2").select2();
</script>
  <?php
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún personal.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>