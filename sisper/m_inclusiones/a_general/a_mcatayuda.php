<?php
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(isset($_POST['idcat']) && !empty($_POST['idcat'])){
	$idcat=iseguro($cone,$_POST['idcat']);
	$csc=mysqli_query($cone, "SELECT idSubCategoria, SubCategoria FROM masubcategoria WHERE idCategoria=$idcat AND Estado=1;");
	if(mysqli_num_rows($csc)>0){
		while ($rsc=mysqli_fetch_assoc($csc)) {
?>
			<option value="<?php echo $rsc['idSubCategoria']; ?>"><?php echo $rsc['SubCategoria']; ?></option>
<?php
		}
	}else{
?>
			<option value="">SIN SUBCATEGORIAS</option>
<?php
	}
	mysqli_free_result($csc);
}

if(isset($_POST['idscat']) && !empty($_POST['idscat'])){
	$idscat=iseguro($cone,$_POST['idscat']);
	$ctip=mysqli_query($cone, "SELECT idTipo, Tipo FROM matipo WHERE idSubCategoria=$idscat AND Estado=1;");
	if(mysqli_num_rows($ctip)>0){
		while ($rtip=mysqli_fetch_assoc($ctip)) {
?>
			<option value="<?php echo $rtip['idTipo']; ?>"><?php echo $rtip['Tipo']; ?></option>
<?php
		}
	}else{
?>
			<option value="">SIN TIPOS</option>
<?php
	}
	mysqli_free_result($ctip);
}

if(isset($_POST['idtip']) && !empty($_POST['idtip'])){
	$idtip=iseguro($cone,$_POST['idtip']);
	$cpro=mysqli_query($cone, "SELECT idProducto, Producto FROM maproducto WHERE idTipo=$idtip AND Estado=1;");
	if(mysqli_num_rows($cpro)>0){
		while ($rpro=mysqli_fetch_assoc($cpro)) {
?>
			<option value="<?php echo $rpro['idProducto']; ?>"><?php echo $rpro['Producto']; ?></option>
<?php
		}
	}else{
?>
			<option value="">SIN PRODUCTOS</option>
<?php
	}
	mysqli_free_result($ctip);
}
mysqli_close($cone);
?>