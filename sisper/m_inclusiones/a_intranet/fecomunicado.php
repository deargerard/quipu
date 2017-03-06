<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
	if(isset($_POST['id']) && !empty($_POST['id'])){
		$id=iseguro($cone,$_POST['id']);
		$c=mysqli_query($cone,"SELECT * FROM comunicado WHERE idComunicado=$id");
		if($r=mysqli_fetch_assoc($c)){
?>
        <div class="form-group has-feedback valida">
          <label for="fec" class="col-sm-2 control-label">Fecha</label>
          <div class="col-sm-3">
          	<input type="hidden" name="idcom" value="<?php echo $id; ?>">
            <span class="fa fa-calendar form-control-feedback"></span>
            <input type="text" name="fec" id="fec" class="form-control" value="<?php echo fnormal($r['Fecha']); ?>">
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
          <label for="des" class="col-sm-2 control-label">Descripción</label>
          <div class="col-sm-10">
            <input type="text" name="des" id="des" class="form-control" value="<?php echo $r['Descripcion']; ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="con" class="col-sm-2 control-label">Contenido</label>
          <div class="col-sm-10">
            <textarea class="form-control" name="con" id="con" rows="10"><?php echo $r['Contenido']; ?></textarea>
          </div>
            <script>
            	$("#con").wysihtml5();
            </script>
        </div>
<?php
		}else{
			echo mensajeda("Error: No se pudo obtener datos.");
		}
	}else{
		echo mensajeda("Error: No se enviaron datos.");
	}
}else{
  echo accrestringidoa();
}
?>
