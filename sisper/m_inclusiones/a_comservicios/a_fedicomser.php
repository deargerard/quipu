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
          <input type="hidden" name="idcs" value="<?php echo $idcs ?>"> <!--envía id de comisión de servicios-->
          <h4 class="text-danger"><?php echo "EDITAR COMISIÓN DE SERVICIOS"?></h4>
          <br>
        </div>

        <div class="form-group valida">
          <label for="inicom" class="col-sm-2 control-label">Inicia:</label>
          <div class="col-sm-4 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" id="inicom" name="inicom" class="form-control" value="<?php echo date('d/m/Y H:i', strtotime($rcs['FechaIni']))?>" placeholder="dd/mm/aaaa H:i">
          </div>
          <label for="fincom" class="col-sm-2 control-label">Termina:</label>
          <div class="col-sm-4 has-feedback">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" id="fincom" name="fincom" class="form-control" value="<?php echo date('d/m/Y H:i', strtotime($rcs['FechaFin']))?>" placeholder="dd/mm/aaaa H:i">
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
           <span class='text-success'>La comisión de servicios registrada tiene <?php echo $dcs ?> días. </span>
          </p>
        </div>

        <div class="form-group valida">
          <label for="desc" class="col-sm-2 control-label" >Descripcion</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="desc" name="desc" rows="3" ><?php echo $rcs['Descripcion']?></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="veh" class="col-sm-2 control-label" >Vehículo</label>
          <div class="checkbox col-sm-10">
            <label><input type="checkbox" value="1" id="veh" name="veh" <?php echo $rcs['Vehiculo']== 1 ? "checked" : "" ?>></label><small>  * Marcar sólo si la comisión incluye vehículo</small>
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

        <script>
          $('#inicom').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            autoclose: true,
            todayHighlight: true,
          })
          .on('changeDate', function(e){
            var fechini = new Date(e.date.valueOf());
            $('#fincom').datepicker('setStartDate', fechini);
            var fechai= $("#inicom").val();
            var fechaf= $("#fincom").val();
            if (fechai!="" && fechaf!="") {
              var aFecha1 = fechai.split('/');
              var aFecha2 = fechaf.split('/');
              var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
              var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
              var dif = fFecha2 - fFecha1;
              var dias = Math.floor(dif / (1000 * 60 * 60 * 24))+1;
              if(dias > 0){
                $("#msg").html("<span class='text-success'>Usted está registrando una Comisión de servicios de "+dias+" días.</span>");
              }else{
                $("#msg").html('¡Error!, la fecha inicial no puede ser mayor a la fecha final.');
                $("#inicom").val("");
                $("#fincom").val("");
              }
            }else {
              $("#msg").html("");
            }
           });
           $(' #fincom').datepicker({
             format: "dd/mm/yyyy",
             language: "es",
             autoclose: true,
             todayHighlight: true,

           })
           .on('changeDate', function(e){
             var fechfin = new Date(e.date.valueOf());
             $('#inicom').datepicker('setEndDate', fechfin);
             var fechai= $("#inicom").val();
             var fechaf= $("#fincom").val();
             if (fechai!="" && fechaf!="") {
               var aFecha1 = fechai.split('/');
               var aFecha2 = fechaf.split('/');
               var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
               var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
               var dif = fFecha2 - fFecha1;
               var dias = Math.floor(dif / (1000 * 60 * 60 * 24))+1;
               if(dias > 0){
                $("#msg").html("<span class='text-success'>Usted está registrando una Comisión de servicios de "+dias+" días.</span>");
               }else{
                 $("#inicom").val("");
                 $("#fincom").val("");
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
      }
    }
  }else{
    echo mensajewa("Error: No se selecciono ninguna comisión de servicio.");
  }
}else{
  echo accrestringidoa();
}
?>
