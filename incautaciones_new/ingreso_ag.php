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
/////////////////////////////////////////////////////////////////////////////////////////////
/* regsitro de la imagen */
$nombre_img = $_FILES['imagen']['name'];
$tipo_img = $_FILES['imagen']['type'];
$tamano = $_FILES['imagen']['size'];
//Si existe imagen y tiene un tamaño correcto
if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 2000000)) 
{
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($_FILES["imagen"]["type"] == "image/gif")
   || ($_FILES["imagen"]["type"] == "image/jpeg")
   || ($_FILES["imagen"]["type"] == "image/jpg")
   || ($_FILES["imagen"]["type"] == "image/png"))
   {
	  move_uploaded_file($_FILES["imagen"]['tmp_name'],"fotos/" . $_FILES["imagen"]['name']);
	   //echo "imagen subida: ".$nombre_img."<br>";
	   $foto=$nombre_img;
    } 
    else 
    {
       //si no cumple con el formato
       echo "No se puede subir una imagen con ese formato ";
		$foto="";
    }
} 
else 
{
   //si existe la variable pero se pasa del tamaño permitido
   if($nombre_img == !NULL) echo "La imagen es demasiado grande "; 
	$foto="";
}
/* fin registro de la imagen */
//////////////////////////////////////////////////////////////////////////////////////////////////
mysqli_query($link,"insert into inventario values($codigo,'$ubicacion','$boletai','$fechai','$caso','$descripcion','$marca','$serie','$estado','$tipo','$obs1','$obs2','$delito','$fiscal','$fiscalia','$condicion','00-0000','0001-01-01','000-0000','XP','$foto')");
  //echo $codigo,"/",$boletai,"/",$caso,"/",$descripcion,"/",$marca,"/",$serie,"/",$estado,"/",$tipo,"/",$obs1,"/",$obs2,"/",$delito,"/",$fiscal,"/",$fiscalia,"/",$condicion;
header("Location: ingreso.php");?>
<?php /*?><form action="file:///C|/wamp64/www/clinica/libres.php" method="GET" name="agregar">
<input type="hidden" name="codigo" <?php echo "value=",$codigo?> />
</form><?php */?>