<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
  if(isset($_POST['ide']) && !empty($_POST['ide'])){
    $ide=iseguro($cone,$_POST['ide']);
    ?>
    <div class="form-group valida">
      <div class="col-sm-6 valida">
        <label for="inicom">Inicia:</label>
        <div class="has-feedback">
          <span class="fa fa-calendar form-control-feedback"></span>
          <input type="hidden" name="ide" value="<?php echo $ide; ?>">
          <input type="text" id="inicom" name="inicom" class="form-control" placeholder="dd/mm/aaaa H:m" autocomplete="off">
        </div>        
      </div>
      <div class="col-sm-6 valida">
        <label for="fincom">Termina:</label>
        <div class="has-feedback">
          <span class="fa fa-calendar form-control-feedback"></span>
          <input type="text" id="fincom" name="fincom" class="form-control" placeholder="dd/mm/aaaa H:m" autocomplete="off">
        </div>
      </div>      
    </div>
    <div class="text-center col-md-12">
      <p id="msg" class="text-maroon"></p>
    </div>
    <div class="form-group valida">
      <div class="col-sm-5 valida">
        <label for="ori">Origen:</label>
        <div class="has-feedback">
          <span class="fa fa-map-marker form-control-feedback"></span>
          <input type="text" id="ori" name="ori" class="form-control" placeholder="Cajamarca">
        </div>        
      </div>
      <div class="col-sm-7 valida">
        <label for="des">Destino:</label>
        <div class="has-feedback">
          <span class="fa fa-map-marker form-control-feedback"></span>
          <input type="text" id="des" name="des" class="form-control" placeholder="Cliclayo-La Florida">
        </div>
      </div>      
    </div> 
    <div class="form-group valida">
      <div class="col-sm-12">
        <label for="desc">Descripcion:</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-6">
        <label for="veh" class="col-sm-6 control-label" >Con vehículo:</label>
        <div class="checkbox col-sm-6">
          <label><input type="checkbox" value="1" id="veh" name="veh"></label>
        </div>
        <small><span class="text-danger">*</span> Si se incluye vehículo de la institución</small>
      </div>
      <div class="col-sm-6">
        <label for="sv" class="col-sm-6 control-label" >Sin viáticos:</label>
        <div class="checkbox col-sm-6">
          <label><input type="checkbox" value="5" id="sv" name="sv"></label>
        </div>
      </div>
    </div>
    <div class="form-group valida">
      <label for="doc" class="col-sm-2 control-label" >Documento:</label>
      <div class="col-sm-8">
        <select name="doc" id="doc" class="form-control select2doc" style="width:100%">
        </select>
      </div>
      <button id="b_nuedoc" class="btn btn-info" type="button" data-toggle="modal" data-target="#m_nuedocu" >Nuevo</button>
    </div>
    <div class="form-group" id="d_mensaje">

    </div>

<script>
$('#inicom').datetimepicker({
  locale:'es',
  useCurrent: false,
  sideBySide:true,
  format:'DD/MM/YYYY HH:mm',
}).on('dp.change', function(e){
  $('#fincom').data('DateTimePicker').minDate(e.date.format ('DD-MM-YYYY'));

});


$('#fincom').datetimepicker({
  locale:'es',
  format:'DD/MM/YYYY HH:mm',
  useCurrent: false,
  sideBySide:true,
}).on('dp.change', function(e){
  $('#inicom').data('DateTimePicker').maxDate(e.date.format ('DD-MM-YYYY'));
});

//funcion seleccionar documento
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
//fin funcion seleccionar documento
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
