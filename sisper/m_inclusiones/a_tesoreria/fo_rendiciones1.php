<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],16)){
	if(isset($_POST['acc']) && !empty($_POST['acc']) && isset($_POST['v1']) && !empty($_POST['v1'])){
		$acc=iseguro($cone,$_POST['acc']);
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);

		if($acc=="agrpro"){
?>
		  <div class="form-group">
		    <label for="razsoc">Razón Social</label>
		    <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		    <input type="text" class="form-control" id="razsoc" name="razsoc" placeholder="Razón Social">
		  </div>
		  <div class="form-group">
		    <label for="">RUC</label>
		    <input type="text" class="form-control" id="" name="" placeholder="12345678">
		  </div>
		  <div class="form-group">
		    <label for="dir">Dirección</label>
		    <input type="text" class="form-control" id="dir" name="dir" placeholder="Dirección">
		  </div>
		  <div class="form-group">
		    <label for="tel">Teléfono</label>
		    <input type="text" class="form-control" id="tel" name="tel" placeholder="Teléfono">
		  </div>
		  <div id="d1_frespuesta">
		  	
		  </div>
<?php
		}//acafin
	}else{
		echo mensajewa("Error: Faltan datos.");
	}
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>