<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(acceso($cone,$_SESSION['identi'])){
	if(isset($_POST['per']) && !empty($_POST['per'])){
		$per=iseguro($cone, $_POST['per']);
?>
		<option value="<?php echo iddependenciae($cone,$per); ?>"><?php echo dependenciae($cone,$per); ?></option>
<?php
	}else{
		echo mensajewa("Faltan datos.");
	}
}else{
	echo accrestringidoa();
}
mysqli_close($cone);
?>