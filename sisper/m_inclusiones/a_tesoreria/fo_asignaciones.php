<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],16)){
	if(isset($_POST['acc']) && !empty($_POST['acc']) && isset($_POST['v1']) && !empty($_POST['v1'])){
		$acc=iseguro($cone,$_POST['acc']);
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);

		if($acc=="agrren"){
?>
		  <div class="form-group">
		    <label for="met" class="col-sm-2 control-label">Meta</label>
		    <div class="col-sm-10">
		      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		      <input type="hidden" name="mes" value="<?php echo $v1; ?>">
		      <input type="hidden" name="anio" value="<?php echo $v2; ?>">
		      <select class="form-control" name="met" id="met">
		      	<option value="">Meta</option>
<?php
				$c1=mysqli_query($cone, "SELECT m.*, f.nombre AS fondo FROM temeta m INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE m.estado=1 ORDER BY fondo, nombre DESC;");
				if(mysqli_num_rows($c1)>0){
					while($r1=mysqli_fetch_assoc($c1)){
?>
						<option value="<?php echo $r1['idtemeta']; ?>"><?php echo $r1['fondo']."-".$r1['nombre']." (".$r1['mnemonico'].")"; ?></option>
<?php
					}
				}
				mysqli_free_result($c1);
?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group" id="d_frespuesta">
		  	
		  </div>
<?php
		}elseif($acc=="ediren"){
			$c2=mysqli_query($cone,"SELECT idtemeta FROM terendicion WHERE idterendicion=$v1;");
			if($r2=mysqli_fetch_assoc($c2)){
?>
		  <div class="form-group">
		    <label for="met" class="col-sm-2 control-label">Meta</label>
		    <div class="col-sm-10">
		      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		      <input type="hidden" name="idr" value="<?php echo $v1; ?>">
		      <select class="form-control" name="met" id="met">
		      	<option value="">Meta</option>
<?php
				$c1=mysqli_query($cone, "SELECT m.*, f.nombre AS fondo FROM temeta m INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE m.estado=1 ORDER BY fondo, nombre DESC;");
				if(mysqli_num_rows($c1)>0){
					while($r1=mysqli_fetch_assoc($c1)){
?>
						<option value="<?php echo $r1['idtemeta']; ?>" <?php echo $r1['idtemeta']==$r2['idtemeta'] ? "selected" : ""; ?>><?php echo $r1['fondo']."-".$r1['nombre']." (".$r1['mnemonico'].")"; ?></option>
<?php
					}
				}
				mysqli_free_result($c1);
?>
		      </select>
		    </div>
		  </div>
		  <div class="form-group" id="d_frespuesta">
		  	
		  </div>
<?php
			}else{
				echo mensajewa("Datos inválidos");
			}
			mysqli_free_result($c2);
		}//acafin
	}else{
		echo mensajewa("Error: Faltan datos.");
	}
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>