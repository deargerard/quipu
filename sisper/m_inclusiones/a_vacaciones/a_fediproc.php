<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(escoordinador($cone,$_SESSION['identi'])){
    if(isset($_POST['idvac']) && !empty($_POST['idvac'])  && isset($_POST['fii']) && !empty($_POST['fii']) && isset($_POST['ffi']) && !empty($_POST['ffi']) && isset($_POST['fff']) && !empty($_POST['fff'])){
        $idvac=iseguro($cone,$_POST['idvac']);
        $fii=iseguro($cone,$_POST['fii']);
        $ffi=iseguro($cone,$_POST['ffi']);
        $fff=iseguro($cone,$_POST['fff']);
        $dias=iseguro($cone,$_POST['dias']);
        //echo $fii ." --- ".$ffi." --- ".$fff;
        $cvac=mysqli_query($cone,"SELECT * FROM provacaciones WHERE idProVacaciones=$idvac");
        if($rvac=mysqli_fetch_assoc($cvac)){
?>
              <div class="form-group valida">
                <div class="col-sm-12 text-center">
                  <input type="hidden" name="idvac" value="<?php echo $idvac ?>"> <!--envía id de vacaciones-->
<?php
                  $vac=$rvac['idPeriodoVacacional'];
                  $cpv=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE idPeriodoVacacional=$vac");
                  $rpv=mysqli_fetch_assoc($cpv);
?>
                  <h4 class="text-orange"><i class="fa fa-plane text-gray"></i> <?php echo "PROGRAMACIÓN DE VACACIONES PERÍODO  ". $rpv['PeriodoVacacional']?></h4>
                  <input type="hidden" name="peva" value="<?php echo $pervac?>"> <!--envía id del periodo-->
                  <input type="hidden" name="dias" id="dias" value="<?php echo $dias; ?>">
                </div>
              </div>
              <div class="form-group valida">
                <div class="col-sm-6" >
                  <label for="inivac" class="col-sm-4 control-label">Inicia</label>
                  <div class="input-group col-sm-8">
                    <input type="text" id="inivac" name="inivac" class="form-control" value="<?php echo fnormal($rvac['FechaIni']); ?>" placeholder="dd/mm/aaaa" autocomplete="off">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
                <div class="col-sm-6" id="divter">
                  <label for="finvac" class="col-sm-4 control-label">Termina</label>
                  <div class="input-group col-sm-8">
                    <input type="text" id="finvac" name="finvac" class="form-control" value="<?php echo fnormal($rvac['FechaFin'])?>" placeholder="dd/mm/aaaa" readonly="readonly" autocomplete="off">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div>
              <div class="form-group valida text-center">
              <span id="msg" class="text-maroon">
<?php
                    $f1=$rvac['FechaFin'];
                    $f2=$rvac['FechaIni'];
                    $f1=date_create($f1);
                    $f2=date_create($f2);
                    $tie=date_diff($f1, $f2);
                    $dp=$tie->format('%a')+1;
?>
                <span class='text-success'>El período de vacaciones programado tiene <?php echo $dp ?> días. </span>
              </span>
              </div>
              <script>

                $('#inivac').datepicker({
                  format: "dd/mm/yyyy",
                  language: "es",
                  autoclose: true,
                  todayHighlight: true,
                  startDate: '<?php echo $fii; ?>',
                  endDate: '<?php echo $ffi; ?>'
                }).on('changeDate', function(e){
                  var fechai = $("#inivac").val();
                  var aFecha1 = fechai.split('/');
                  var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
                  var dp=parseInt(<?php echo $dp; ?>);

                  var afec = fechai.split('/');
                  var ffec = Date.UTC(afec[2],afec[1]-1,afec[0]);
                  var nfec = ffec + (dp*86400000);
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
      }
    }else{
        echo mensajewa("¡ERROR!, No se selecciono ningún registro.");
    }

}else{
  echo accrestringidoa();
}
?>
