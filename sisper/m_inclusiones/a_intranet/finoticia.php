<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],11)){
	if(isset($_POST['id']) && !empty($_POST['id'])){
		$inot=iseguro($cone,$_POST['id']);
		$ci=mysqli_query($cone,"SELECT Imagen FROM noticia WHERE idNoticia=$inot;");
		if($ri=mysqli_fetch_assoc($ci)){

?>
		<div class="col-md-12">
			<?php echo $ri['Imagen']=="" ? mensajewa("Aún no ha subido ninguna imagen.") : "<img src='files_intranet/".$ri['Imagen']."' class='img-responsive img-thumbnail'>"; ?>
			<br><br>
		</div>
        <div class="form-group valida">
          <label for="img" class="col-sm-2 control-label">Imagen</label>
          <div class="col-sm-10">
            <input type="file" name="img" id="img" class="form-control" accept="image/*">
            <input type="hidden" name="inot" value="<?php echo $inot; ?>">
            <p class="help-block">Hasta 1Mb. (600x400 pixeles)</p>
          </div>
        </div>
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
