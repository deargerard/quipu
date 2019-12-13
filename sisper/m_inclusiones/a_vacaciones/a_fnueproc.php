<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");

if(escoordinador($cone,$_SESSION['identi'])){
  if(isset($_POST['idec']) && !empty($_POST['idec']) && isset($_POST['pervac']) && !empty($_POST['pervac'])&& isset($_POST['fii']) && !empty($_POST['fii'])&& isset($_POST['ffi']) && !empty($_POST['ffi'])){
    $pervac=iseguro($cone,$_POST['pervac']);
    $fii=iseguro($cone,$_POST['fii']);
    $ffi=iseguro($cone,$_POST['ffi']);
    $idec=iseguro($cone,$_POST['idec']);
    $nd=iseguro($cone,$_POST['nd']);

  //echo $fii ." --- ".$ffi." --- ".$fff;
    ?>
          <div class="form-group valida">
            <div class="col-sm-12 text-center">
              <input type="hidden" name="idec" value="<?php echo $idec?>"> <!--envía id de personal-->
              <?php
                $cpv=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE idPeriodoVacacional=$pervac");
                $rpv=mysqli_fetch_assoc($cpv);
              ?>
                <h4 class="text-orange"><i class="fa fa-plane text-gray"></i> <?php echo "PROGRAMACIÓN DE VACACIONES PERÍODO  ". $rpv['PeriodoVacacional']?></h4>
                <input type="hidden" name="peva" value="<?php echo $pervac?>"> <!--envía id del periodo-->

            </div>
          </div>
          <div class="form-group valida">
            <div class="col-sm-6" >
              <label for="inivac" class="col-sm-4 control-label">Inicia</label>
              <div class="input-group col-sm-8">
                <input type="text" id="inivac" name="inivac" class="form-control" placeholder="dd/mm/aaaa" autocomplete="off">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="col-sm-6" id="divter">
              <label for="finvac" class="col-sm-4 control-label">Termina</label>
              <div class="input-group col-sm-8">
              <input type="text" id="finvac" name="finvac" class="form-control disabled" placeholder="dd/mm/aaaa" readonly="readonly" autocomplete="off">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12 text-center">
              <span id="msg" class="text-maroon"></span><br>
              <small class="text-purple">La programación de oficio unicamente podrá hacerla, en un solo bloque, por todos los días pendientes.</small>
            </div>
          </div>

<script>

  $('#inivac').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true,
    startDate: "<?php echo $fii ?>",
    endDate: "<?php echo $ffi?>",

  }).on('changeDate', function(e){
      var fechai= $("#inivac").val();
      var aFecha1 = fechai.split('/');
      var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
      var nd = <?php echo $nd; ?>

      var afec = fechai.split('/');
      var ffec = Date.UTC(afec[2],afec[1]-1,afec[0]);
      var nfec = ffec + nd*86400000;
      var nfecf= new Date(nfec);

      var nf = new Date();
      var dia = nfecf.getDate();
      var mes = nfecf.getMonth()+1;
      var ano = nfecf.getFullYear();

      $('#finvac').val(("0"+dia).slice(-2)+'/'+("0"+mes).slice(-2)+'/'+ano);
      $("#msg").html("");

   });
</script>
<?php
    mysqli_close($cone);
  }else{
    echo mensajewa("¡ERROR!, No se selecciono ningún personal.");
  }
}else{
  echo accrestringidoa();
}
?>
