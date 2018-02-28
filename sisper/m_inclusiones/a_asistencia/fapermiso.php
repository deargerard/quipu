<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],2)){
  if(isset($_POST['per']) && !empty($_POST['per']) && isset($_POST['ano']) && !empty($_POST['ano'])){
    $per=iseguro($cone,$_POST['per']);
    $ano=iseguro($cone,$_POST['ano']);

      $pd=$ano."-01-01";
      $ud=$ano."-12-31";

?>
        <div class="form-group valida">
          <input type="hidden" name="per" value="<?php echo $per; ?>">
          <label for="mot" class="col-sm-2 control-label">Motivo</label>
          <div class="col-sm-10">
            <select class="form-control" name="mot" id="mot">
            <?php
            $ctp=mysqli_query($cone, "SELECT * FROM tippermiso WHERE Estado=1 ORDER BY TipPermiso ASC;");
            if(mysqli_num_rows($ctp)>0){
              while($rtp=mysqli_fetch_assoc($ctp)){
            ?>
              <option value="<?php echo $rtp['idTipPermiso']; ?>"><?php echo $rtp['TipPermiso']; ?></option>
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
          <label for="fhini" class="col-sm-2 control-label">Inicia</label>
          <div class="col-sm-4 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fhini" id="fhini" class="form-control">
          </div>
          <label for="fhfin" class="col-sm-2 control-label">Finaliza</label>
          <div class="col-sm-4 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fhfin" id="fhfin" class="form-control">
          </div>
        </div>
        <div class="form-group valida">
          <label for="apr" class="col-sm-2 control-label">Aprobador</label>
          <div class="col-sm-10">
            <select class="form-control select2peract" name="apr" id="apr" style="width: 100%;">
              
            </select>
          </div>
        </div>
        <div class="form-group valida">
          <label for="obs" class="col-sm-2 control-label">Detalle</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="obs" name="obs"></textarea>
          </div>
        </div>
        <div id="d_apermiso"></div>
        <script>
          $('#fhini').datetimepicker({
              locale: 'es',
              format: 'DD/MM/YYYY HH:mm'
          });
          $('#fhfin').datetimepicker({
              locale: 'es',
              format: 'DD/MM/YYYY HH:mm',
              useCurrent: false
          });
          $("#fhini").on("dp.change", function (e) {
              $('#fhfin').data("DateTimePicker").minDate(e.date);
          });
          $("#fhfin").on("dp.change", function (e) {
              $('#fhini').data("DateTimePicker").maxDate(e.date);
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
    echo mensajewa("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>