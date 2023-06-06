<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],15)){
  if(isset($_POST['idcs']) && !empty($_POST['idcs'])){
    $idcs=iseguro($cone,$_POST['idcs']);
    $ccs=mysqli_query($cone,"SELECT idComServicios, FechaIni, FechaFin, Descripcion, Vehiculo, idDoc, origen, destino, idEmpleado, estadoren FROM comservicios WHERE idComServicios=$idcs");
    if($rcs=mysqli_fetch_assoc($ccs)){
    ?>
        <div class="form-group valida">
          <div class="col-sm-6 valida">
            <label for="inicome" class="control-label">Inicia:</label>
            <div class="has-feedback">
              <input type="hidden" name="idcs" value="<?php echo $idcs; ?>">
              <input type="hidden" name="ide" value="<?php echo $rcs['idEmpleado']; ?>">
              <span class="fa fa-calendar form-control-feedback"></span>
              <input type="text" id="inicome" name="inicome" class="form-control" value="<?php echo date('d/m/Y H:i', strtotime($rcs['FechaIni']))?>" placeholder="dd/mm/aaaa H:i">
            </div>
          </div>
          <div class="col-sm-6 valida">
            <label for="fincome" class="control-label">Termina:</label>
            <div class="has-feedback">
              <span class="fa fa-calendar form-control-feedback"></span>
              <input type="text" id="fincome" name="fincome" class="form-control" value="<?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin']))?>" placeholder="dd/mm/aaaa H:i">
            </div>
          </div>         
        </div>
        <div class="text-center col-md-12">
          <p id="msg" class="text-maroon">
          <?php
            $f1=$rcs['FechaFin'];
            $f2=$rcs['FechaIni'];
            $f1=date_create($f1);
            $f2=date_create($f2);
            $tie=date_diff($f1, $f2);
            $dcs=$tie->format('%a')+1;

           ?>
           <span class='text-success'>La comisión de servicios registrada tiene <b><?php echo $dcs ?></b> días. </span>
          </p>
        </div>
        <div class="form-group valida">
          <div class="col-sm-5 valida">
            <label for="ori">Origen:</label>
            <div class="has-feedback">
              <span class="fa fa-map-marker form-control-feedback"></span>
              <input type="text" id="ori" name="ori" class="form-control" placeholder="Cajamarca" value="<?php echo $rcs['origen'] ?>">
            </div>        
          </div>
          <div class="col-sm-7 valida">
            <label for="des">Destino:</label>
            <div class="has-feedback">
              <span class="fa fa-map-marker form-control-feedback"></span>
              <input type="text" id="des" name="des" class="form-control" placeholder="Cliclayo-La Florida" value="<?php echo $rcs['destino'] ?>">
            </div>
          </div>      
        </div>
        <div class="form-group valida">
          <div class="col-sm-12">
            <label for="desc">Descripcion</label>
            <textarea class="form-control" id="desc" name="desc" rows="3" ><?php echo $rcs['Descripcion']?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <label for="veh" class="col-sm-6 control-label" >Con vehículo:</label>
            <div class="checkbox col-sm-6">
              <label><input type="checkbox" value="1" id="veh" name="veh" <?php echo $rcs['Vehiculo']== 1 ? "checked" : "" ?>></label>
            </div>
            <small><span class="text-danger">*</span> Si se incluye vehículo de la institución</small>
          </div>
          <div class="col-sm-6">
            <label for="sv" class="col-sm-6 control-label" >Sin viáticos:</label>
            <div class="checkbox col-sm-6">
              <label><input type="checkbox" value="5" id="sv" name="sv" <?php echo $rcs['estadoren']== 5 ? "checked" : "" ?>></label>
            </div>
          </div>
        </div>
        <?php
        $doc=$rcs['idDoc'];
        $cdoc=mysqli_query($cone,"SELECT * FROM doc WHERE idDoc=$doc");
          if($rdoc=mysqli_fetch_assoc($cdoc)){
            ?>
            <div class="form-group valida">
              <label for="doc" class="col-sm-2 control-label" >Documento</label>
              <div class="col-sm-8">
                <select name="doc" id="doc" class="form-control select2doc" style="width:100%">
                  <option value="<?php echo $rdoc['idDoc']; ?>"><?php echo $rdoc['Numero']."-".$rdoc['Ano']."-".$rdoc['Siglas']." ".$rdoc['TipoDoc'];?></option>
                </select>
              </div>
              <button id="b_nuedoc" class="btn btn-info" type="button" data-toggle="modal" data-target="#m_nuedocu" >Nuevo</button>
            </div>
            <div class="form-group" id="d_mensaje">

            </div>

        <script>
          $('#inicome').datetimepicker({
            locale:'es',
            useCurrent: false,
            sideBySide:true,
            format:'DD/MM/YYYY HH:mm',
          }).on('dp.change', function(e){
            $('#fincome').data('DateTimePicker').minDate(e.date.format ('DD-MM-YYYY'));

          });


          $('#fincome').datetimepicker({
            locale:'es',
            format:'DD/MM/YYYY HH:mm',
            useCurrent: false,
            sideBySide:true,
          }).on('dp.change', function(e){
            $('#inicome').data('DateTimePicker').maxDate(e.date.format ('DD-MM-YYYY'));
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
      }
    }
  }else{
    echo mensajewa("Error: No se selecciono ninguna comisión de servicio.");
  }
}else{
  echo accrestringidoa();
}
?>
