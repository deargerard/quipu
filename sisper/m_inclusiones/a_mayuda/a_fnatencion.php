<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  $idu=$_SESSION['identi'];
?>




        <div class="form-group valida">
              <div class="col-md-12">
                <p class="text-orange" style="border-bottom: 1px solid #CCC; font-size: 16px;">Datos Atención</p>
              </div>
              <div class="col-sm-6">
                <label for="usu" class="control-label">Usuario</label>
                <select class="form-control select2peract" id="usu" name="usu" style="width: 100%;">
                </select>
              </div>
              <div class="col-sm-6">
                <label for="sol" class="control-label">Asignado a</label>
                <select class="form-control select2sol" id="sol" name="sol" style="width: 100%;">
                  <?php
                    $csol=mysqli_query($cone,"SELECT ms.idEmpleado, idSolucionador, ApellidoPat, ApellidoMat, Nombres FROM masolucionador ms INNER JOIN empleado e ON ms.idEmpleado=e.idEmpleado WHERE ms.Estado=1 ORDER BY ApellidoPat, ApellidoMat, Nombres ASC;");
                    if(mysqli_num_rows($csol)>0){
                      while($rsol=mysqli_fetch_assoc($csol)){
                  ?>
                        <option value="<?php echo $rsol['idSolucionador']; ?>" <?php echo $idu==$rsol['idEmpleado'] ? "selected" : ""; ?>><?php echo $rsol['ApellidoPat']." ".$rsol['ApellidoMat'].", ".$rsol['Nombres']; ?></option>
                  <?php
                      }
                    }else{
                  ?>
                        <option value="">SIN SOLUCIONADORES</option>
                  <?php
                    }
                    mysqli_free_result($csol);
                  ?>
                </select>
              </div>
              <div class="col-sm-6">
                <label for="cat" class="control-label">Categoria</label>
                <select class="form-control select2cat" id="cat" name="cat" style="width: 100%;">
                        <option value=""></option>
                  <?php
                    $ccat=mysqli_query($cone,"SELECT idCategoria, Categoria FROM macategoria WHERE Estado=1;");
                    if(mysqli_num_rows($ccat)>0){
                      while ($rcat=mysqli_fetch_assoc($ccat)) {                     
                  ?>
                        <option value="<?php echo $rcat['idCategoria']; ?>"><?php echo $rcat['Categoria']; ?></option>
                  <?php
                      }
                    }else{
                  ?>
                        <option value="">SIN CATEGORIAS</option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div class="col-sm-6">
                <label for="scat" class="control-label">Sub Categoria</label>
                <select class="form-control select2scat" id="scat" name="scat" style="width: 100%;">
                </select>
              </div>
              <div class="col-sm-6">
                <label for="tip" class="control-label">Tipo</label>
                <select class="form-control select2tip" id="tip" name="tip" style="width: 100%;">
                </select>
              </div>
              <div class="col-sm-6">
                <label for="pro" class="control-label">Producto</label>
                <select class="form-control select2pro" id="pro" name="pro" style="width: 100%;">
                </select>
              </div>
              <div class="col-sm-12">
                <label for="des" class="control-label">Descripción</label>
                <textarea class="form-control" rows="3" name="des" id="des"></textarea>
              </div>
              <div class="col-sm-6">
                <label for="fec" class="control-label">Fecha</label>
                <input type="text" name="fec" id="fec" class="form-control" value="<?php echo date('d/m/Y H:i'); ?>" readonly>
              </div>
              <div class="col-sm-6">
                <label for="est" class="control-label">Estado</label>
                <select class="form-control select2est" id="est" name="est" style="width: 100%;">
                  <option value="2" selected>PENDIENTE</option>
                  <option value="1">RESUELTO</option>
                  <option value="3">CANCELADO</option>
                </select>
              </div>
              <div id="ocu">
              <div class="col-md-12">
                <br>
                <p class="text-orange" style="border-bottom: 1px solid #CCC; font-size: 16px;">Datos Estado Resuelto/Cancelado</p>
              </div>
              <div class="col-sm-12">
                <label for="solu" class="control-label">Detalle lo realizado</label>
                <textarea class="form-control" rows="3" name="solu" id="solu"></textarea>
              </div>
              <!--<div class="col-sm-6">
                <label for="fsol" class="control-label">Fecha Resolvió/Canceló</label>
                <input type="text" name="fsol" id="fsol" class="form-control" value="<?php echo date('d/m/Y H:i') ?>" readonly>
              </div>-->
              <div class="col-sm-12" id="msol">
                <label for="med" class="control-label">Medio de Solución</label>
                <select class="form-control select2med" id="med" name="med" style="width: 100%;">
                  <option value="1" selected>PRESENCIAL</option>
                  <option value="2">TELÉFONO</option>
                  <option value="3">EMAIL</option>
                  <option value="4">ACCESO REMOTO</option>
                </select>
              </div>
              </div>
              <div class="col-md-12">
                <br>
                <div id="resultado">
                  
                </div>
              </div>
        </div>


        <script>
          $(".select2sol").select2();
          $(".select2cat").select2({
            placeholder: 'Selecione una categoria'
          }).on('change', function(e){
            var idcat=$("#cat").val();
            $.ajax({
              type: 'post',
              url: 'm_inclusiones/a_general/a_mcatayuda.php',
              dataType: 'html',
              data: {idcat: idcat},
              beforeSend: function(){
                $(".select2scat").select2("val", "");
                $(".select2tip").select2("val", "");
                $(".select2pro").select2("val", "");
                $("#scat").html('<option value="">CARGANDO...</option>');
              },
              success: function(e){
                $("#scat").html(e);
                $(".select2scat").select2("val", "");
              }
            });
          });
          $(".select2scat").select2({
            placeholder: 'Selecione una subcategoria'
          }).on('change', function(e){
            var idscat=$("#scat").val();
            $.ajax({
              type: 'post',
              url: 'm_inclusiones/a_general/a_mcatayuda.php',
              dataType: 'html',
              data: {idscat: idscat},
              beforeSend: function(){
                $(".select2tip").select2("val", "");
                $(".select2pro").select2("val", "");
                $("#tip").html('<option value="">CARGANDO...</option>');
              },
              success: function(e){
                $("#tip").html(e);
                $(".select2tip").select2("val", "");
              }
            });
          });
          $(".select2tip").select2({
            placeholder: 'Selecione un tipo'
          }).on('change', function(e){
            var idtip=$("#tip").val();
            $.ajax({
              type: 'post',
              url: 'm_inclusiones/a_general/a_mcatayuda.php',
              dataType: 'html',
              data: {idtip: idtip},
              beforeSend: function(){
                $(".select2pro").select2("val", "");
                $("#pro").html('<option value="">CARGANDO...</option>');
              },
              success: function(e){
                $("#pro").html(e);
                $(".select2pro").select2("val", "");
              }
            });
          });
          $(".select2pro").select2({
            placeholder: 'Selecione una producto'
          });
          $(".select2est").select2()
          .on('change',function(e){
            var est=$("#est").val();
            if(est==3){
              $("#ocu").show();
              $("#msol").hide();
            }else if(est==1){
              $("#ocu").show();
              $("#msol").show();
            }else if(est==2){
              $("#ocu").hide();
              $("#msol").show();
            }
          });
          $(".select2med").select2();
          //fecha intranet
          $("#adoc").datepicker({
            autoclose: true,
            format: " yyyy",
            minViewMode: "years",
            maxViewMode: "years",
            startDate: '<?php echo $anop; ?>',
            endDate: new Date(),
            startView: "year" //does not work
          });
          //fin fecha intranet
          $("#fec").datetimepicker({
            locale: 'es'
          });

          //buscar personal
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
}else{
  echo accrestringidoa();
}
?>
