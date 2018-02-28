<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['idp']) && !empty($_POST['idp']) && isset($_POST['per']) && !empty($_POST['per'])){
    $idp=iseguro($cone,$_POST['idp']);
    $per=iseguro($cone,$_POST['per']);
    $cp=mysqli_query($cone,"SELECT * FROM permiso WHERE idPermiso=$idp;");
    if($rp=mysqli_fetch_assoc($cp)){

?>
        <div class="form-group valida">
          <input type="hidden" name="pere" value="<?php echo $per; ?>">
          <input type="hidden" name="idp" value="<?php echo $idp; ?>">
          <label for="mote" class="col-sm-2 control-label">Motivo</label>
          <div class="col-sm-10">
            <select class="form-control" name="mote" id="mote">
            <?php
            $ctp=mysqli_query($cone, "SELECT * FROM tippermiso WHERE Estado=1 ORDER BY TipPermiso ASC;");
            if(mysqli_num_rows($ctp)>0){
              while($rtp=mysqli_fetch_assoc($ctp)){
            ?>
              <option value="<?php echo $rtp['idTipPermiso']; ?>" <?php echo $rp['idTipPermiso']==$rtp['idTipPermiso'] ? "selected" : ""; ?>><?php echo $rtp['TipPermiso']; ?></option>
            <?php
              }
            }else{
            ?>
              <option value="">SIN MOTIVOS</option>
            <?php
            }
            ?>
              
            </select>
          </div>
        </div>
        <div class="form-group valida">
          <label for="fhinie" class="col-sm-2 control-label">Inicia</label>
          <div class="col-sm-4 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fhinie" id="fhinie" class="form-control" value="<?php echo date('d/m/Y H:i',strtotime($rp['FechaIni'])); ?>">
          </div>
          <label for="fhfine" class="col-sm-2 control-label">Finaliza</label>
          <div class="col-sm-4 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fhfine" id="fhfine" class="form-control" value="<?php echo date('d/m/Y H:i',strtotime($rp['FechaFin'])); ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="apre" class="col-sm-2 control-label">Aprobador</label>
          <div class="col-sm-10">
            <select class="form-control select2peract" name="apre" id="apre" style="width: 100%;">
              <option value="<?php echo $rp['Aprobador'] ?>" selected><?php echo nomempleado($cone,$rp['Aprobador']); ?></option>
            </select>
          </div>
        </div>
        <div class="form-group valida">
          <label for="obse" class="col-sm-2 control-label">Detalle</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="obse" name="obse"><?php echo $rp['Observacion']; ?></textarea>
          </div>
        </div>
        <div id="d_epermiso"></div>
        <script>
          $('#fhinie').datetimepicker({
              locale: 'es',
              format: 'DD/MM/YYYY HH:mm'
          });
          $('#fhfine').datetimepicker({
              locale: 'es',
              format: 'DD/MM/YYYY HH:mm',
              useCurrent: false
          });
          $("#fhinie").on("dp.change", function (e) {
              $('#fhfine').data("DateTimePicker").minDate(e.date);
          });
          $("#fhfine").on("dp.change", function (e) {
              $('#fhinie').data("DateTimePicker").maxDate(e.date);
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

<?php
    }else{
      echo mensajewa("No envió datos validos.");
    }
    mysqli_free_result($cp);
  }else{
    echo mensajewa("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>