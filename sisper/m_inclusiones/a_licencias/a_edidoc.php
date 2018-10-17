<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],13)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $ano=date('Y');
    $anop=$ano-1;
    $id=iseguro($cone,$_POST['id']);
    $cd=mysqli_query($cone,"SELECT * FROM doc WHERE idDoc=$id;");
    if($rd=mysqli_fetch_assoc($cd)){
?>
        <div class="form-group valida">
          <label for="tdoc" class="col-sm-3 control-label">T. Doc.</label>
          <div class="col-sm-9">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
            <select class="form-control select2td" id="tdoc" name="tdoc" style="width: 100%;">
            <?php
            $c=mysqli_query($cone, "SELECT * FROM tipodoc WHERE Estado=1 ORDER BY TipoDoc ASC;");
            if(mysqli_num_rows($c)>0){
              while ($r=mysqli_fetch_assoc($c)) {
            ?>
              <option value="<?php echo $r['idTipoDoc']; ?>" <?php echo $r['idTipoDoc']==$rd['idTipoDoc'] ? "selected" : ""; ?>><?php echo $r['TipoDoc']; ?></option>
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
            <input type="text" name="num" id="num" class="form-control" value="<?php echo $rd['Numero']; ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="adoc" class="col-sm-3 control-label">Año</label>
          <div class="col-sm-9">
            <input type="text" name="adoc" id="adoc" class="form-control" value="<?php echo $rd['Ano']; ?>" autocomplete="off">
          </div>
        </div>
        <div class="form-group valida">
          <label for="sig" class="col-sm-3 control-label">Siglas</label>
          <div class="col-sm-9">
            <input type="text" name="sig" id="sig" class="form-control" value="<?php echo $rd['Siglas']; ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="fec" class="col-sm-3 control-label">Fecha</label>
          <div class="col-sm-9">
            <input type="text" name="fec" id="fec" class="form-control" value="<?php echo fnormal($rd['FechaDoc']); ?>" autocomplete="off">
          </div>
        </div>
        <div class="form-group valida">
          <label for="leg" class="col-sm-3 control-label">Legajo</label>
          <div class="col-sm-9">
            <input type="text" name="leg" id="leg" class="form-control" value="<?php echo $rd['Legajo']; ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="des" class="col-sm-3 control-label">Descrip.</label>
          <div class="col-sm-9">
            <textarea class="form-control" rows="4" name="des" id="des"><?php echo $rd['Descripcion']; ?></textarea>
          </div>
        </div>
        <script>
          $(".select2td").select2();
          //fecha intranet
          $("#adoc").datepicker({
            autoclose: true,
            format: " yyyy",
            minViewMode: "years",
            maxViewMode: "years",
            startDate: '<?php echo $anop; ?>',
            endDate: new Date(),
            startView: "year" //does not work
          });
          $('#fec').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            todayHighlight: true,
            startDate: '01-01-<?php echo $anop; ?>',
            endDate: '31-12-<?php echo $ano; ?>'
          });
          //fin fecha intranet
        </script>
<?php
    }else{
      echo mensajeda("Error: No se enviaron datos válidos.");
    }
  }else{
    echo mensajeda("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>
