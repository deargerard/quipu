<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],17)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);
		if($acc=="agrdoc"){
?>		<div class="row">
            <div class="col-sm-2">
                    <label for="sercom">Serie<small class="text-red">*</small></label>
                    <input type="text" class="form-control" id="sercom" name="sercom" placeholder="B001">
            </div>
            <div class="col-sm-3">
                    <label for="numcom">Número<small class="text-red">*</small></label>
                    <input type="text" class="form-control" id="numcom" name="numcom" placeholder="56234">
            </div>
            <div class="col-sm-12">
                    <label for="des">Descripción<small class="text-red">*</small></label>
                    <input type="text" class="form-control" id="des" name="des" placeholder="Descripción">
            </div>
            <div class="col-sm-3">
                    <label for="imp">Importe<small class="text-red">*</small></label>
                    <input type="number" class="form-control" id="imp" name="imp" placeholder="0.00" step="0.01">
            </div>
            <div class="col-sm-3">
                    <label for="can">Cantidad</label>
                    <input type="number" class="form-control" id="can" name="can" placeholder="0.00" step="0.01">
            </div>
        </div>
		<div class="form-group" id="d_frespuesta">
		  	
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