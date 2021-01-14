<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],4)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $c=mysqli_query($cone,"SELECT FechaIni, FechaFin, TipoLic, MotivoLic, l.Estado FROM licencia l INNER JOIN tipolic tl ON l.idTipoLic=tl.idTipoLic WHERE idLicencia=$id;");
    if($r=mysqli_fetch_assoc($c)){
      $e=$r['Estado'];
?>
     <div class="row">
       <div class="col-sm-12 text-center">
        <h5>¿Seguro que deseas <?php echo $e==1 ? "<strong>dejar sin efecto</strong>" : "<strong>activar</strong>"; ?> la siguiente licencia?</h5>
         <h4 class="text-maroon"><strong><?php echo $r['MotivoLic']; ?></strong><small> (<?php echo $r['TipoLic']; ?>)</small></h4>
         <span><?php echo "Del ".fnormal($r['FechaIni'])." al ".fnormal($r['FechaFin']); ?></span>
         <input type="hidden" name="idl" id="idl" value="<?php echo $id; ?>">
         <hr>
         <div class="form-group">
          <label for="tdoc" class="col-sm-2 control-label">Documento</label>
          <div class="col-sm-7 valida">
              <select class="form-control select2doc" id="docapr" name="docapr" style="width: 100%;">

              </select>
          </div>
          <div class="col-sm-3 valida">
            <button type="button" id="b_nuedoc" class="btn btn-default btn-block" data-toggle="modal" data-target="#m_nuedocu"><i class="fa fa-file-text-o"></i> Nuevo</button>
          </div>
        </div>
       </div>       
     </div>   
<?php
    }else{
      echo mensajewa("Error: No se enviaron datos válidos.");
    }
    mysqli_free_result($c);
  }else{
    echo mensajewa("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>
<script>
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
