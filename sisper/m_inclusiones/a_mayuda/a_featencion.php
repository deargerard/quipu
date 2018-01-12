<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(solucionador($cone,$_SESSION['identi'])){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $ca=mysqli_query($cone, "SELECT * FROM maatencion WHERE idAtencion=$id;");
    if($ra=mysqli_fetch_assoc($ca)){
      $idp=$ra['idProducto'];

?>




        <div class="form-group valida">
              <div class="col-sm-12">
                <label for="usu" class="control-label">Usuario</label>
                <input type="hidden" name="ida" value="<?php echo $id; ?>">
                <select class="form-control select2peract" id="usu" name="usu" style="width: 100%;">
                  <option value="<?php echo $ra['idEmpleado']; ?>"><?php echo nomempleado($cone,$ra['idEmpleado']); ?></option>
                </select>
              </div>
              <?php
              $cl=mysqli_query($cone,"SELECT mt.idTipo, ms.idSubCategoria, mc.idCategoria FROM maproducto mp INNER JOIN matipo mt ON mp.idTipo=mt.idTipo INNER JOIN masubcategoria ms ON mt.idSubCategoria=ms.idSubCategoria INNER JOIN macategoria mc ON ms.idCategoria=mc.idCategoria WHERE idProducto=$idp;");
              if($rl=mysqli_fetch_assoc($cl)){
                $idt=$rl['idTipo'];
                $ids=$rl['idSubCategoria'];
                $idc=$rl['idCategoria'];
              }
              mysqli_free_result($cl);
              ?>
              <div class="col-sm-6">
                <label for="cat" class="control-label">Categoria</label>
                <select class="form-control select2cat" id="cat" name="cat" style="width: 100%;">
                        <option value=""></option>
                  <?php
                    $ccat=mysqli_query($cone,"SELECT idCategoria, Categoria FROM macategoria WHERE Estado=1;");
                    if(mysqli_num_rows($ccat)>0){
                      while ($rcat=mysqli_fetch_assoc($ccat)) {                     
                  ?>
                        <option value="<?php echo $rcat['idCategoria']; ?>" <?php echo $rcat['idCategoria']==$idc ? "selected" : ""; ?>><?php echo $rcat['Categoria']; ?></option>
                  <?php
                      }
                    }else{
                  ?>
                        <option value="">SIN CATEGORIAS</option>
                  <?php
                    }
                    mysqli_free_result($ccat);
                  ?>
                </select>
              </div>
              <div class="col-sm-6">
                <label for="scat" class="control-label">Sub Categoria</label>
                <select class="form-control select2scat" id="scat" name="scat" style="width: 100%;">
                  <?php
                    $cscat=mysqli_query($cone,"SELECT idSubCategoria, SubCategoria FROM masubcategoria WHERE idCategoria=$idc AND Estado=1;");
                    if(mysqli_num_rows($cscat)>0){
                      while ($rscat=mysqli_fetch_assoc($cscat)) {                     
                  ?>
                        <option value="<?php echo $rscat['idSubCategoria']; ?>" <?php echo $rscat['idSubCategoria']==$ids ? "selected" : ""; ?>><?php echo $rscat['SubCategoria']; ?></option>
                  <?php
                      }
                    }else{
                  ?>
                        <option value="">SIN SUB CATEGORIAS</option>
                  <?php
                    }
                    mysqli_free_result($cscat);
                  ?>
                </select>
              </div>
              <div class="col-sm-6">
                <label for="tip" class="control-label">Tipo</label>
                <select class="form-control select2tip" id="tip" name="tip" style="width: 100%;">
                  <?php
                    $ctip=mysqli_query($cone,"SELECT idTipo, Tipo FROM matipo WHERE idSubCategoria=$ids AND Estado=1;");
                    if(mysqli_num_rows($ctip)>0){
                      while ($rtip=mysqli_fetch_assoc($ctip)) {                     
                  ?>
                        <option value="<?php echo $rtip['idTipo']; ?>" <?php echo $rtip['idTipo']==$idt ? "selected" : ""; ?>><?php echo $rtip['Tipo']; ?></option>
                  <?php
                      }
                    }else{
                  ?>
                        <option value="">SIN TIPOS</option>
                  <?php
                    }
                    mysqli_free_result($ctip);
                  ?>
                </select>
              </div>
              <div class="col-sm-6">
                <label for="pro" class="control-label">Producto</label>
                <select class="form-control select2pro" id="pro" name="pro" style="width: 100%;">
                  <?php
                    $cpro=mysqli_query($cone,"SELECT idProducto, Producto FROM maproducto WHERE idTipo=$idt AND Estado=1;");
                    if(mysqli_num_rows($cpro)>0){
                      while ($rpro=mysqli_fetch_assoc($cpro)) {                     
                  ?>
                        <option value="<?php echo $rpro['idProducto']; ?>" <?php echo $rpro['idProducto']==$idp ? "selected" : ""; ?>><?php echo $rpro['Producto']; ?></option>
                  <?php
                      }
                    }else{
                  ?>
                        <option value="">SIN PRODUCTOS</option>
                  <?php
                    }
                    mysqli_free_result($cpro);
                  ?>
                </select>
              </div>
              <div class="col-sm-12">
                <label for="des" class="control-label">Descripción</label>
                <textarea class="form-control" rows="3" name="des" id="des"><?php echo $ra['Descripcion'] ?></textarea>
              </div>


              <div class="col-md-12">
                <br>
                <div id="resultado">
                  
                </div>
              </div>
        </div>

        <script>
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
      echo mensajeda("No envió datos válidos.");
    }
  }else{
    echo mensajeda("No envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>
