<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
  if(isset($_POST['idec']) && !empty($_POST['idec']) && isset($_POST['pervac']) && !empty($_POST['pervac'])&& isset($_POST['fii']) && !empty($_POST['fii'])&& isset($_POST['ffi']) && !empty($_POST['ffi'])&& isset($_POST['fff']) && !empty($_POST['fff'])){
    $pervac=iseguro($cone,$_POST['pervac']);
    $fii=iseguro($cone,$_POST['fii']);
    $ffi=iseguro($cone,$_POST['ffi']);
    $fff=iseguro($cone,$_POST['fff']);
    $idec=iseguro($cone,$_POST['idec']);
    //echo $fii ." --- ".$ffi." --- ".$fff;
    ?>
          <div class="form-group valida">
            <label for="peva" class="col-sm-3 control-label">Período</label>
            <div class="col-sm-8">
              <input type="hidden" name="idec" value="<?php echo $idec ?>"> <!--envía id de personal-->
              <?php
                $cpv=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE idPeriodoVacacional=$pervac");
                $rpv=mysqli_fetch_assoc($cpv);
              ?>
                <h5><strong><?php echo $rpv['PeriodoVacacional']?></strong></h5>
                <input type="hidden" name="peva" value="<?php echo $pervac?>"> <!--envía id del periodo-->
            </div>
          </div>
          <div class="form-group valida">
            <label for="inivac" class="col-sm-3 control-label">Inicia</label>
            <div class="col-sm-8">
              <input type="text" id="inivac" name="inivac" class="form-control" placeholder="dd/mm/aaaa">
            </div>
          </div>
            <div class="form-group valida" id="divter">
            </div>
          <span id="msg" class="text-maroon"></span>
          <hr>
          <label for="doc" >Documento de Aprobación</label>
          <div class="form-group valida">
            <div class="col-sm-12">
              <div class="input-group">
                <select name="doc" id="doc" class="form-control">
                  <option value="">DOCUMENTO DE APROBACIÓN</option>
                  <?php
                    $cdoc=mysqli_query($cone,"SELECT idDoc, concat(Numero,'-',Ano,'-',Siglas) AS Resolucion, FechaDoc FROM doc ORDER BY Ano, Numero DESC");
                    while($rdoc=mysqli_fetch_assoc($cdoc)){
                  ?>
                  <option value="<?php echo $rdoc['idDoc'] ?>"><?php echo $rdoc['Resolucion']." Del ". fnormal($rdoc['FechaDoc'])?></option>
                  <?php
                    }
                    mysqli_free_result($cdoc);
                  ?>
                </select>
                <span class="input-group-btn">
                  <button class="btn btn-info" type="button">Nuevo</button>
                </span>
              </div>
            </div>
            <label for="finvac" class="col-sm-3 control-label">Legajo</label>
            <div class="col-lg-12">
              <input name="leg" id="leg" type="text" class="form-control">
            </div>

<script>
  $('#inivac').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true,
    startDate: "<?php echo $fii ?>",
    endDate: "<?php echo $ffi?>",
  })
  .on('hide', function(e){
      var ini=$("#inivac").val();
      var fin= '<?php echo $fff?>';
      $.ajax({
        data    : {ini : ini, fin : fin},
        url     :  "m_inclusiones/a_vacaciones/divter.php",
        type    :  "post",
        success :   function(r){
          $("#divter").html(r);
        }
      });
   });
  $(".select2").select2();
</script>

<?php
    mysqli_close($cone);
  }else{
    echo mensajewa("Error: No se selecciono ningún personal.");
  }
}else{
  echo accrestringidoa();
}
?>
