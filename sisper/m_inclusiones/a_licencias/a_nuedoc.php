<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4) || accesoadm($cone,$_SESSION['identi'],3) || accesoadm($cone,$_SESSION['identi'],13)){
  $ano=date('Y');
  $anop=$ano-1;
?>
        <div class="form-group valida">
          <label for="tdoc" class="col-sm-3 control-label">T. Doc.</label>
          <div class="col-sm-9">
            <select class="form-control select2td" id="tdoc" name="tdoc" style="width: 100%;">
            <?php
            $c=mysqli_query($cone, "SELECT * FROM tipodoc WHERE Estado=1 ORDER BY TipoDoc ASC;");
            if(mysqli_num_rows($c)>0){
              while ($r=mysqli_fetch_assoc($c)) {
            ?>
              <option value="<?php echo $r['idTipoDoc']; ?>"><?php echo $r['TipoDoc']; ?></option>
            <?php
              }
            }
            mysqli_free_result($c);
            ?>
            </select>
          </div>
        </div>
        <div class="form-group valida">
          <label for="num" class="col-sm-3 control-label">Núm.</label>
          <div class="col-sm-9">
            <input type="text" name="num" id="num" class="form-control">
          </div>
        </div>
        <div class="form-group valida">
          <label for="adoc" class="col-sm-3 control-label">Año</label>
          <div class="col-sm-9">
            <div class="input-group date" id="dd_adoc">
              <input type="text" name="adoc" id="adoc" class="form-control" value="<?php echo $ano; ?>" autocomplete="off">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group valida">
          <label for="sig" class="col-sm-3 control-label">Siglas</label>
          <div class="col-sm-9">
            <input type="text" name="sig" id="sig" class="form-control">
          </div>
        </div>
        <div class="form-group valida">
          <label for="fec" class="col-sm-3 control-label">Fecha</label>
          <div class="col-sm-9">
            <div class="input-group date" id="d_fec">
              <input type="text" name="fec" id="fec" class="form-control" autocomplete="off">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group valida">
          <label for="leg" class="col-sm-3 control-label">Legajo</label>
          <div class="col-sm-9">
            <input type="text" name="leg" id="leg" class="form-control">
          </div>
        </div>
        <div class="form-group valida">
          <label for="des" class="col-sm-3 control-label">Descrip.</label>
          <div class="col-sm-9">
            <textarea class="form-control" rows="4" name="des" id="des"></textarea>
          </div>
        </div>
        <script>
          $(".select2td").select2();
          //fecha intranet
          $("#dd_adoc").datepicker({
            autoclose: true,
            format: "yyyy",
            maxViewMode: 2,
            minViewMode: 2,
            language: "es",
            startDate: '2000',
            endDate: new Date(),
          });
          $('#d_fec').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            todayHighlight: true,
            endDate: '31-12-<?php echo $ano; ?>'
          });
          //fin fecha intranet
        </script>
<?php
}else{
  echo accrestringidoa();
}
?>
