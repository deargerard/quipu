<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],3)){
  if(isset($_POST['idec']) && !empty($_POST['idec']) && isset($_POST['pervac']) && !empty($_POST['pervac']) && isset($_POST['fav']) && !empty($_POST['fav'])&& isset($_POST['st'])){
    $pervac=iseguro($cone,$_POST['pervac']);
    $fav=fmysql(iseguro($cone,$_POST['fav']));
    $idec=iseguro($cone,$_POST['idec']);
    $st=iseguro($cone,$_POST['st']);

  //echo $fav." --- ".$st;

    ?>
          <div class="form-group valida">
            <div class="col-sm-12 text-center">
              <input type="hidden" name="idec" value="<?php echo $idec?>"> <!--envía id de personal-->
              <?php
                $cpv=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE idPeriodoVacacional=$pervac");
                $rpv=mysqli_fetch_assoc($cpv);
              ?>
                <h4 class="text-danger"><?php echo "REPROGRAMACIÓN PARA EL PERÍODO  ". $rpv['PeriodoVacacional']?></h4>
                <input type="hidden" name="peva" value="<?php echo $pervac?>"> <!--envía id del periodo-->
                <input type="hidden" name="st" value="<?php echo $st?>"> <!--envía el estado inicial-->
                <input type="hidden" name="fav" value="<?php echo $fav?>"> <!--envía la fecha de vacaciones-->
            </div>
          </div>
          <div class="form-group valida">
            <div class="col-sm-6" >
              <label for="inivac" class="col-sm-4 control-label">Inicia</label>
              <div class="input-group col-sm-8">
                <input type="text" id="inivac" name="inivac" class="form-control" placeholder="dd/mm/aaaa">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
            <div class="col-sm-6" id="divter">
              <label for="finvac" class="col-sm-4 control-label">Termina</label>
              <div class="input-group col-sm-8">
              <input type="text" id="finvac" name="finvac" class="form-control" placeholder="dd/mm/aaaa">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              </div>
            </div>
          </div>
          <div class="form-group valida text-center">
            <span id="msg" class="text-maroon"></span>
          </div>

          <div class="form-group valida">
            <label for="doc" class="col-sm-2" >Documento</label>
            <div class="col-sm-8">
              <select name="doc" id="doc" class="form-control select2doc" style="width:100%">
              </select>
            </div>
            <button id="b_nuedoc" class="btn btn-info" type="button" data-toggle="modal" data-target="#m_nuedocu" >Nuevo</button>
          </div>
<script>
  $('#inivac').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true,
  })
  .on('changeDate', function(e){
    var fechini = new Date(e.date.valueOf());
    $('#finvac').datepicker('setStartDate', fechini);
    var fechai= $("#inivac").val();
    var fechaf= $("#finvac").val();
    if (fechai!="" && fechaf!="") {
      var aFecha1 = fechai.split('/');
      var aFecha2 = fechaf.split('/');
      var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
      var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
      var dif = fFecha2 - fFecha1;
      var dias = Math.floor(dif / (1000 * 60 * 60 * 24))+1;
      if(dias > 0){
        var df=$("#df").val();
         if (dias>df) {
           $("#msg").html("¡Error!, solo tiene "+df+" días pendientes y ha escogido un período de "+dias+" días.");
           $("#inivac").val("");
         }else{
           $("#msg").html("<span class='text-success'>Usted está programando "+dias+" días de vacaciones.</span>");
         }
      }else{
        $("#msg").html('¡Error!, la fecha inicial no puede ser mayor a la fecha final.');
        $("#inivac").val("");
        $("#finvac").val("");
      }
    }else {
      $("#msg").html("");
    }
   });
   $(' #finvac').datepicker({
     format: "dd/mm/yyyy",
     language: "es",
     autoclose: true,
     todayHighlight: true,

   })
   .on('changeDate', function(e){
     var fechfin = new Date(e.date.valueOf());
     $('#inivac').datepicker('setEndDate', fechfin);
     var fechai= $("#inivac").val();
     var fechaf= $("#finvac").val();
     if (fechai!="" && fechaf!="") {
       var aFecha1 = fechai.split('/');
       var aFecha2 = fechaf.split('/');
       var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
       var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
       var dif = fFecha2 - fFecha1;
       var dias = Math.floor(dif / (1000 * 60 * 60 * 24))+1;
       if(dias > 0){
         var df=$("#df").val();
          if (dias>df) {
            $("#msg").html("¡Error!, solo tiene "+df+" días pendientes y ha escogido un período de "+dias+" días.");
            $("#finvac").val("");
          }else{
            $("#msg").html("<span class='text-success'>Usted está programando "+dias+" días de vacaciones.</span>");
          }
       }else{
         $("#inivac").val("");
         $("#finvac").val("");
         $("#msg").html('¡Error!, la fecha inicial no puede ser mayor a la fecha final.');
       }
     }else{
       $("#msg").html("");
     }
    });
//funcion seleccionar docuento
   $(".select2doc").select2({
     placeholder: 'Selecione a un documento',
     ajax: {
       url: 'm_inclusiones/a_general/a_seldocumento.php',
       dataType: 'json',
       delay: 250,
       processResults: function (data) {
         return {
           results: data
         };
       },
       cache: true
     },
     minimumInputLength: 1
   });
//fin funcion seleccionar docuento
   //funcion llamar formulario nuevo documento
    $("#b_nuedoc").on("click",function(e){
      $.ajax({
        type:"post",
        url:"m_inclusiones/a_licencias/a_nuedoc.php",
        beforeSend: function () {
          $("#r_nuedocu").html("<img scr='m_images/cargando.gif' class='center-block'>");
          $("#b_gnuedocu").hide();
        },
        success:function(a){
          $("#r_nuedocu").html(a);
          $("#b_gnuedocu").show();
        }
      });
    });
// fin funcion llamar formulario nuevo documento
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
