<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $ano=iseguro($cone,$_POST['ano']);
    $cl=mysqli_query($cone, "SELECT * FROM licencia l INNER JOIN aprlicencia al ON l.idLicencia=al.idLicencia WHERE l.idLicencia=$id");
    if($rl=mysqli_fetch_assoc($cl)){
?>
        <div class="form-group">
          <label for="tlic" class="col-sm-2 control-label">T. Licencia</label>
          <div class="col-sm-10 valida">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
            <input type="hidden" name="idec" id="idec" value="<?php echo $rl['idEmpleadoCargo']; ?>">
            <select class="form-control select2tiplic" id="tlic" name="tlic" style="width: 100%;">
            <?php
            $c=mysqli_query($cone, "SELECT * FROM tipolic WHERE Estado=1 ORDER BY TipoLic, MotivoLic ASC;");
            if(mysqli_num_rows($c)>0){
              while ($r=mysqli_fetch_assoc($c)) {
            ?>
              <option value="<?php echo $r['idTipoLic']; ?>" <?php echo $r['idTipoLic']==$rl['idTipoLic'] ? "selected" : ""; ?>><?php echo $r['TipoLic']." - ".$r['MotivoLic']; ?></option>
            <?php
              }
            }
            mysqli_free_result($c);
            ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="des" class="col-sm-2 control-label">Desde</label>
          <div class="col-sm-3 valida">
            <input type="text" name="dese" id="dese" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rl['FechaIni']); ?>" autocomplete="off">
          </div>
          <label for="has" class="col-sm-2 control-label">Hasta</label>
          <div class="col-sm-3 valida">
            <input type="text" name="hase" id="hase" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rl['FechaFin']); ?>" autocomplete="off">
          </div>
          <div class="col-sm-2">
          <?php
          $f1=$rl['FechaFin'];
          $f2=$rl['FechaIni'];
          $f1=date_create($f1);
          $f2=date_create($f2);
          $tie=date_diff($f1, $f2);
          $dias=$tie->format('%a')+1;
          ?>
            <h5><strong class="ndias text-maroon"><?php echo $dias." Día(s)"; ?></strong></h5>
          </div>
  	        <script>
    			//fecha intranet
    			$('#dese,#hase').datepicker({
    			  format: "dd/mm/yyyy",
    			  language: "es",
    			  autoclose: true,
    			  todayHighlight: true,
            startDate: '01-01-<?php echo $ano; ?>',
            endDate: '31-12-<?php echo $ano; ?>'
    			})
          .on("changeDate", function(e){
            var f1=$("#dese").val();
            var f2=$("#hase").val();
            console.log(f1+f2);
            if(f1!="" && f2!=""){

              var aFecha1 = f1.split('/');
              var aFecha2 = f2.split('/');
              var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
              var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
              var dif = fFecha2 - fFecha1;
              var dias = Math.floor(dif / (1000 * 60 * 60 * 24))+1;

              if(dias > 0){
                $(".ndias").html(dias + ' Día(s)');
              }else{
                $(".ndias").html('Error de Fechas');
                $("#dese").val("");
                $("#hase").val("");
              }
            }else{
              $(".ndias").html('');
            }
          });
    			//fin fecha intranet
    			</script>
        </div>
        <div class="form-group">
          <label for="mot" class="col-sm-2 control-label">Motivo</label>
          <div class="col-sm-10 valida">
            <textarea class="form-control" name="mot" id="mot" rows="3" placeholder="Motivo"><?php echo $rl['Motivo']; ?></textarea>
          </div>
        </div>
        <div class="form-group has-feedback ocu">
          <label for="med" class="col-sm-2 control-label">Médico</label>
          <div class="col-sm-6 valida">
            <span class="fa fa-user-md form-control-feedback text-primary"></span>
            <input type="text" name="med" id="med" class="form-control" placeholder="Médico" value="<?php echo $rl['Medico']; ?>">
          </div>
          <label for="col" class="col-sm-1 control-label">Colg.</label>
          <div class="col-sm-3 valida">
            <input type="text" name="col" id="col" class="form-control" placeholder="# Colg." value="<?php echo $rl['Colegiatura']; ?>">
          </div>
        </div>
        <div class="form-group ocu">
          <label for="emed" class="col-sm-2 control-label">Especialidad</label>
          <div class="col-sm-10 valida">
            <select class="form-control select2lic" id="emed" name="emed" style="width: 100%;">
            <?php
            $c=mysqli_query($cone, "SELECT * FROM espmedica WHERE Estado=1 ORDER BY EspMedica ASC;");
            if(mysqli_num_rows($c)>0){
              while ($r=mysqli_fetch_assoc($c)) {
            ?>
              <option value="<?php echo $r['idEspMedica']; ?>" <?php echo $r['idEspMedica']==$rl['idEspMedica'] ? "selected" : ""; ?>><?php echo $r['EspMedica']; ?></option>
            <?php
              }
            }
            mysqli_free_result($c);
            ?>
            </select>
          </div>
        </div>
        <div class="form-group ocu has-feedback">
          <label for="tdoc" class="col-sm-2 control-label">Tipo Doc.</label>
          <div class="col-sm-4 valida">
            <select class="form-control select2lic" id="tdoc" name="tdoc" style="width: 100%;">
            <?php
            $c=mysqli_query($cone, "SELECT * FROM tipdoclicencia WHERE Estado=1 ORDER BY DocLicencia ASC;");
            if(mysqli_num_rows($c)>0){
              while ($r=mysqli_fetch_assoc($c)) {
            ?>
              <option value="<?php echo $r['idTipDocLicencia']; ?>" <?php echo $r['idTipDocLicencia']==$rl['idTipDocLicencia'] ? "selected" : ""; ?>><?php echo $r['DocLicencia']; ?></option>
            <?php
              }
            }
            mysqli_free_result($c);
            ?>
            </select>
          </div>
          <label for="ndoc" class="col-sm-2 control-label"># Doc.</label>
          <div class="col-sm-4 valida">
            <input type="text" name="ndoc" id="ndoc" class="form-control" placeholder="# Documento" value="<?php echo $rl['NumDoc']; ?>">
          </div>
        </div>
        <hr>
        <div class="form-group">
          <label for="tdoc" class="col-sm-2 control-label">Documento</label>
          <?php
          $d=$rl['idDoc'];
          $cd=mysqli_query($cone,"SELECT * FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE idDoc=$d;");
          $rd=mysqli_fetch_assoc($cd);
          ?>
          <div class="col-sm-7 valida">
              <select class="form-control select2doc" id="docapr" name="docapr" style="width: 100%;">
                <option value="<?php echo $rd['idDoc']; ?>"><?php echo $rd['Numero']."-".$rd['Ano']."-".$rd['Siglas']." ".$rd['TipoDoc']; ?></option>
              </select>
          </div>
          <div class="col-sm-3 valida">
            <button type="button" id="b_nuedoc" class="btn btn-default btn-block" data-toggle="modal" data-target="#m_nuedocu"><i class="fa fa-file-text-o"></i> Nuevo</button>
          </div>
        </div>
        <script>
          var li=$("#tlic").val();
          if(li!=1){
            $(".ocu").addClass("hidden");
          }
          $(".select2lic").select2();
          $(".select2tiplic").select2()
          .on("change",function(e){
            var lic=$("#tlic").val();
            if (lic==1 || lic ==2) {
              $(".ocu").removeClass("hidden");
              $("#med").val("");
              $("#col").val("");
              //$("#emed option[value="+ 50 +"]").attr("selected",true);
              $("#emed").select2("val", "1");
              //$("#tdoc option[value="+ 3 +"]").attr("selected",true);
              $("#tdoc").select2("val", "1");
              $("#ndoc").val("");
            }else{
              $(".ocu").addClass("hidden");
              $("#med").val("Ninguno");
              $("#col").val("Ninguna");
              //$("#emed option[value="+ 50 +"]").attr("selected",true);
              $("#emed").select2("val", "50");
              //$("#tdoc option[value="+ 3 +"]").attr("selected",true);
              $("#tdoc").select2("val", "3");
              $("#ndoc").val("Ninguno");
            }
          });
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
          //funcion llamar formulario nuevo documento
        </script>
<?php
    }else{
      echo mensajewa("Error: No se enviaron datos válidos.");
    }
  }else{
    echo mensajewa("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>
