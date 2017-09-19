<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");

if(accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST['idec']) && !empty($_POST['idec']) && isset($_POST['pervac']) && !empty($_POST['pervac'])&& isset($_POST['fii']) && !empty($_POST['fii'])&& isset($_POST['ffi']) && !empty($_POST['ffi'])&& isset($_POST['fff']) && !empty($_POST['fff'])){
    $pervac=iseguro($cone,$_POST['pervac']);
    $fii=iseguro($cone,$_POST['fii']);
    $ffi=iseguro($cone,$_POST['ffi']);
    $fff=iseguro($cone,$_POST['fff']);
    $idec=iseguro($cone,$_POST['idec']);

  //echo $fii ." --- ".$ffi." --- ".$fff;

    ?>
          <div class="form-group valida">
            <div class="col-sm-12 text-center">
              <input type="hidden" name="idec" value="<?php echo $idec?>"> <!--envía id de personal-->
              <?php
                $cpv=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE idPeriodoVacacional=$pervac");
                $rpv=mysqli_fetch_assoc($cpv);
              ?>
                <h4 class="text-danger"><?php echo "PROGRAMACIÓN DE VACACIONES PERÍODO  ". $rpv['PeriodoVacacional']?></h4>
                <input type="hidden" name="peva" value="<?php echo $pervac?>"> <!--envía id del periodo-->

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


<script>

  $('#inivac').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true,
    startDate: "<?php echo $fii ?>",
    endDate: "<?php echo $ffi?>",

  })
  .on('changeDate', function(e){
    var fechini = new Date(e.date.valueOf());
    $('#finvac').datepicker('setStartDate', fechini);
    var fechai= $("#inivac").val();
    var fechaf= $("#finvac").val();

      var aFecha1 = fechai.split('/');
      var aFecha2 = fechaf.split('/');
      var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
      var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
      var dif = fFecha2 - fFecha1;
      var dias = Math.floor(dif / (1000 * 60 * 60 * 24))+1;

      if (aFecha1[0]==1 || aFecha1[0]==16 ) {
        if (fechai!="" && fechaf!="") {
          if(dias > 0){
            var df=$("#df").val();
             if (dias>df) {
               $("#msg").html("¡ERROR!, sólo tiene "+df+" días pendientes y ha escogido un período de "+dias+" días.");
               $("#finvac").val("");
             }else{
               $("#msg").html("<span class='text-success'>Usted está programando "+dias+" días de vacaciones.</span>");
             }
          }else{
            $("#msg").html("<span class='text-warning'>¡Atención!, la fecha de inicio no puede ser mayor a la fecha de fin.</span>");
            //$("#inivac").val("");
            $("#finvac").val("");
          }
        }else {
          $("#msg").html("");
        }
      }else{

        $("#msg").html("¡ERROR!, sólo puede seleccionar como fecha de inicio el 01 ó el 16 del mes.");
        $("#inivac").val("");

      }


   });
   $('#finvac').datepicker({
     format: "dd/mm/yyyy",
     language: "es",
     autoclose: true,
     todayHighlight: true,
     startDate: "<?php echo $fii ?>",
     endDate: "<?php echo $fff?>",
   })
   .on('changeDate', function(e){
     var fechfin = new Date(e.date.valueOf());
     $('#inivac').datepicker('setEndDate', fechfin);
     var fechai= $("#inivac").val();
     var fechaf= $("#finvac").val();

       var aFecha1 = fechai.split('/');
       var aFecha2 = fechaf.split('/');
       var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
       var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
       var dif = fFecha2 - fFecha1;
       var dias = Math.floor(dif / (1000 * 60 * 60 * 24))+1;

       if (aFecha2[0]==15 || aFecha2[0]==30 ) {
         if (fechai!="" && fechaf!="") {
           if(dias > 0){
             var df=$("#df").val();
              if (dias>df) {
                $("#msg").html("¡ERROR!, sólo tiene "+df+" días pendientes y ha escogido un período de "+dias+" días. ");
                $("#inivac").val("");
              }else{
                $("#msg").html("<span class='text-success'>Usted está programando "+dias+" días de vacaciones.</span>");
              }
           }else{
             $("#inivac").val("");
             //$("#finvac").val("");
             $("#msg").html("<span class='text-warning'>¡Atención!, la fecha de inicio no puede ser mayor a la fecha de fin.</span>");
           }
         }else{
           $("#msg").html("");
         }
      }else if (aFecha1[1]==2) {
        if  (aFecha2[0]==2 || aFecha2[0]==3 ) {
          if (fechai!="" && fechaf!="") {
            if(dias > 0){
              var df=$("#df").val();
               if (dias>df) {
                 $("#msg").html("¡ERROR!, sólo tiene "+df+" días pendientes y ha escogido un período de "+dias+" días. ");
                 $("#inivac").val("");
               }else{
                 $("#msg").html("<span class='text-success'>Usted está programando "+dias+" días de vacaciones.</span>");
               }
            }else{
              $("#inivac").val("");
              //$("#finvac").val("");
              $("#msg").html("<span class='text-warning'>¡Atención!, la fecha de inicio no puede ser mayor a la fecha de fin.</span>");
            }
          }else{
            $("#msg").html("");
          }
        }else {
          $("#msg").html("¡ERROR!, sólo puede seleccionar como fecha de fin el 02 ó el 03 de Marzo");
          $("#finvac").val("");
        }
      }else {
        $("#msg").html("¡ERROR!, sólo puede seleccionar como fecha de fin el 15 ó el 30 del mes");
        $("#finvac").val("");
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
    echo mensajewa("¡ERROR!, No se selecciono ningún personal.");
  }
}else{
  echo accrestringidoa();
}
?>
