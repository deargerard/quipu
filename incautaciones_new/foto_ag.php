<?php 
include("conect.php");
$sql=conect();
$id=strtolower($_POST['id']);
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
$actualizar="UPDATE inventario SET foto='$foto' WHERE id=$id";
mysqli_query($sql,$actualizar);
  //echo $codigo,"/",$boletai,"/",$caso,"/",$descripcion,"/",$marca,"/",$serie,"/",$estado,"/",$tipo,"/",$obs1,"/",$obs2,"/",$delito,"/",$fiscal,"/",$fiscalia,"/",$condicion;
header("Location: lista_casos.php");?>