<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
  if(isset($_POST['id']) && !empty($_POST['id'])){
    $id=iseguro($cone,$_POST['id']);
    $cn=mysqli_query($cone,"SELECT * FROM noticia WHERE idNoticia=$id");
    if($rn=mysqli_fetch_assoc($cn)){
?>
        <div class="form-group has-feedback valida">
          <label for="fec" class="col-sm-1 control-label">Fecha</label>
          <div class="col-sm-3">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fec" id="fec" class="form-control" value="<?php echo fnormal($rn['Fecha']); ?>">
            <input type="hidden" name="idno" value="<?php echo $id; ?>">
          </div>
  	        <script>
    			//fecha intranet
    			$('#fec').datepicker({
    			  format: "dd/mm/yyyy",
    			  language: "es",
    			  autoclose: true,
    			  todayHighlight: true
    			});
    			//fin fecha intranet
    			</script>
        </div>
        <div class="form-group valida">
          <label for="tit" class="col-sm-1 control-label">Titular</label>
          <div class="col-sm-11">
            <input type="text" name="tit" id="tit" class="form-control" value="<?php echo $rn['Titular']; ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="con" class="col-sm-1 control-label">Contenido</label>
        </div>
        <div id="summernotee"><?php echo html_entity_decode($rn['Cuerpo']); ?></div>
        <script>
          $(document).ready(function() {
              $('#summernotee').summernote({
                height: 250,
                lang: 'es-ES'
              });
          });
        </script>
<?php
    }else{
      echo mensajewa("Error: No se enviaron datos válidos.");
    }
    mysqli_free_result($cn);
  }else{
    echo mensajewa("Error: No se enviaron datos.");
  }
}else{
  echo accrestringidoa();
}
?>
