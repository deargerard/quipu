<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(acceso($cone,$idusu,1)){
	if(isset($_POST['iddoc']) && !empty($_POST['iddoc']) && isset($_POST['res']) && !empty($_POST['res'])){
		$iddoc=iseguro($cone, $_POST['iddoc']);
		$res=iseguro($cone, $_POST['res']);
		$cd=mysqli_query($cone,"SELECT * FROM documento WHERE idDocumento=$iddoc;");
		if($rd=mysqli_fetch_assoc($cd)){
?>
	<input type="hidden" name="iddoce" value="<?php echo $iddoc; ?>">
	<input type="hidden" name="res" value="<?php echo $res; ?>">
	<p class="text-secondary text-center">Seguro que desea eliminar el siguiente documento:</p>
	<h4 class="text-danger text-center"><small class="text-blue">N° Doc:</small> D-<?php echo $rd['idDocumento']; ?> <small class="text-blue">Documento:</small> <?php echo $rd['Documento']; ?></h4>
	<div id="r_eldocumento"></div>
<?php
		}else{
			echo mensajewa("No envió datos válidos.");
		}
	}else{
		echo mensajewa("No envió datos.");
	}
}else{
	echo mensajewa("Acceso restingido.");
}
?>