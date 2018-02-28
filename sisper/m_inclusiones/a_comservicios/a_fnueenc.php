<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
  if(isset($_POST['idcs']) && !empty($_POST['idcs'])){
    $idcs=iseguro($cone,$_POST['idcs']);
    $ccs=mysqli_query($cone,"SELECT * FROM comservicios WHERE idComServicios=$idcs");
    if($rcs=mysqli_fetch_assoc($ccs)){
        ?>

        <div class="col-sm-12 text-center">
          <input type="hidden" name="idcs" value="<?php echo $idcs?>"> <!--envía id de personal-->
        </div>
        <div class="form-group valida">
          <label for="enc" class="col-sm-2 control-label">Encargado</label>
          <div class="col-sm-6 has-feedback">
            <select name="enc" id="enc" class="form-control select2peract" style="width: 100%;">
            </select>
          </div>
          <label for="tip" class="col-sm-1 control-label">Tipo</label>
          <div class="col-sm-3 has-feedback">
            <select name="tip" id="tip" class="form-control" style="width: 100%;">
              <option value="1">Des/Coor</option>
              <option value="2">Coordinación</option>
              <option value="3">Despacho</option>
            </select>
          </div>
        </div>

        <div class="form-group valida">
          <label for="inienc" class="col-sm-2 control-label">Inicia:</label>
          <div class="col-sm-4 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" id="inienc" name="inienc" class="form-control" value="<?php echo date('d/m/Y H:m', strtotime($rcs['FechaIni']))?>" placeholder="dd/mm/aaaa H:i">
          </div>
          <label for="finenc" class="col-sm-2 control-label">Termina:</label>
          <div class="col-sm-4 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" id="finenc" name="finenc" class="form-control" value="<?php echo date('d/m/Y H:m', strtotime($rcs['FechaFin']))?>" placeholder="dd/mm/aaaa H:i">
          </div>
        </div>

        <div class="text-center col-md-12">
          <p id="msg" class="text-maroon"></p>
        </div>

    <script>
    $('#inienc').datetimepicker({
      locale:'es',
      useCurrent: false,
      sideBySide:true,
      format:'DD/MM/YYYY HH:mm',
    }).on('dp.change', function(e){
      $('#finenc').data('DateTimePicker').minDate(e.date.format ('DD-MM-YYYY'));

    });


    $('#finenc').datetimepicker({
      locale:'es',
      format:'DD/MM/YYYY HH:mm',
      useCurrent: false,
      sideBySide:true,
    }).on('dp.change', function(e){
      $('#inienc').data('DateTimePicker').maxDate(e.date.format ('DD-MM-YYYY'));
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
        mysqli_close($cone);
    }
  }else{
    echo mensajewa("Error: No se selecciono ninguna comisión.");
  }
}else{
  echo accrestringidoa();
}
?>
