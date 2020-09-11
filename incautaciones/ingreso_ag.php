<!--<body onload='document.agregar.submit()'>-->
<?php 
include("conect.php");
$sql=conect();
$link=conect();
$lib = mysqli_query($sql,"select max(id) as ultimo_id from inventario");
$rs_lib = mysqli_fetch_assoc($lib);
$codigo= $rs_lib['ultimo_id'] + 1;
$boletai=$_POST['boletai'];
$fechai=$_POST['fechai'];
$ubicacion=$_POST['ubicacion'];
$caso=strtolower($_POST['caso']);
$descripcion=strtolower($_POST['descripcion']);
$marca=strtolower($_POST['marca']);
$serie=strtolower($_POST['serie']);
$estado=strtolower($_POST['estado']);
$tipo=strtolower($_POST['tipo']);
$obs1=strtolower($_POST['obs1']);
$obs2=strtolower($_POST['obs2']);
$delito=strtolower($_POST['delito']);
$fiscal=strtolower($_POST['fiscal']);
$fiscalia=strtolower($_POST['fiscalia']);
$condicion=strtolower($_POST['condicion']);
/*registro del recibo de ingreso*/
mysqli_query($link,"insert into inventario values($codigo,'$ubicacion','$boletai','$fechai','$caso','$descripcion','$marca','$serie','$estado','$tipo','$obs1','$obs2','$delito','$fiscal','$fiscalia','$condicion','00-0000','0001-01-01','000-0000','XP')");
  //echo $codigo,"/",$boletai,"/",$caso,"/",$descripcion,"/",$marca,"/",$serie,"/",$estado,"/",$tipo,"/",$obs1,"/",$obs2,"/",$delito,"/",$fiscal,"/",$fiscalia,"/",$condicion;
header("Location: ingreso.php");?>
<?php /*?><form action="file:///C|/wamp64/www/clinica/libres.php" method="GET" name="agregar">
<input type="hidden" name="codigo" <?php echo "value=",$codigo?> />
</form><?php */?>