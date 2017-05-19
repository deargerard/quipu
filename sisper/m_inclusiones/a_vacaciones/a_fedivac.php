<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
  if(isset($_POST['idvac']) && !empty($_POST['idvac']) && isset($_POST['idav']) && !empty($_POST['idav']) && isset($_POST['fii']) && !empty($_POST['fii']) && isset($_POST['ffi']) && !empty($_POST['ffi']) && isset($_POST['fff']) && !empty($_POST['fff'])){
    $idvac=iseguro($cone,$_POST['idvac']);
    $idav=iseguro($cone,$_POST['idav']);
    $fii=iseguro($cone,$_POST['fii']);
    $ffi=iseguro($cone,$_POST['ffi']);
    $fff=iseguro($cone,$_POST['fff']);
    //echo $fii ." --- ".$ffi." --- ".$fff;
    $cvac=mysqli_query($cone,"SELECT * FROM provacaciones WHERE idProVacaciones=$idvac");
    $cav=mysqli_query($cone,"SELECT * FROM aprvacaciones WHERE idAprVacaciones=$idav");
    if($rvac=mysqli_fetch_assoc($cvac)){
?>
          <div class="form-group valida"> <!--Período-->
            <label for="peva" class="col-sm-3 control-label">Período</label>
            <div class="col-sm-8">
              <input type="hidden" name="idvac" value="<?php echo $idvac ?>"> <!--envía id de vacaciones-->
              <input type="hidden" name="idav" value="<?php echo $idav ?>"> <!--envía id de aprobacion-->
              <?php
                $vac=$rvac['idPeriodoVacacional'];
                $cpv=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE idPeriodoVacacional=$vac");
                $rpv=mysqli_fetch_assoc($cpv);
                ?>
              <h5><strong><?php echo $rpv['PeriodoVacacional']?></strong></h5>
            </div>

          </div>
          <div class="form-group valida"> <!--Inicia-->
            <label for="inivac" class="col-sm-3 control-label">Inicia</label>
            <div class="col-sm-8">
              <input type="text" id="inivac" name="inivac" class="form-control" value="<?php echo fnormal($rvac['FechaIni'])?>" placeholder="dd/mm/aaaa">
            </div>

          </div>
            <div class="form-group valida" id="divteredi">
            </div>
          <span id="msg" class="text-maroon"></span>
          <hr>
          <label for="doc" >Documento de Aprobación</label>
          <div class="form-group valida">
            <div class="col-sm-12"> <!--Documento-->
              <div class="input-group">
                <select name="doc" id="doc" class="form-control">
                  <option value="">DOCUMENTO DE APROBACIÓN</option>
                  <?php
                  if($rav=mysqli_fetch_assoc($cav)){
                    $cdoc=mysqli_query($cone,"SELECT idDoc, concat(Numero,'-',Ano,'-',Siglas) AS Resolucion, FechaDoc FROM doc ORDER BY Ano, Numero DESC");
                    while($rdoc=mysqli_fetch_assoc($cdoc)){
                  ?>
                  <option value="<?php echo $rdoc['idDoc'] ?>" <?php echo $rav['idDoc']==$rdoc['idDoc'] ? "selected" : "";?>><?php echo $rdoc['Resolucion']." Del ". fnormal($rdoc['FechaDoc'])?></option>
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
            <div class="col-lg-12"> <!--legajo-->
              <input name="leg" id="leg" type="text" class="form-control" value="<?php echo $rav['Legajo'] ?>">
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
        url     :  "m_inclusiones/a_vacaciones/divteredi.php",
        type    :  "post",
        success :   function(r){
          $("#divteredi").html(r);
        }
      });
   });
  $(".select2").select2();
</script>
<?php
    mysqli_close($cone);
    }
  }
}
  else{
    echo mensajewa("Error: No se selecciono vacaciones.");
  }
}else{
  echo accrestringidoa();
}
?>
