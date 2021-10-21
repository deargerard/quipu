<?php 
include("conect.php");
$sql=conect();
$id=strtolower($_POST['id']);
/*registro del recibo de ingreso*/
/////////////////////////////////////////////////////////////////////////////////////////////

$nombre_img1 = $_FILES['imagen1']['name'];
//$tamano1 = $_FILES['imagen1']['size'];
//echo $nombre_img1."<br>";
//echo $tipo_img1;
//Si existe imagen y tiene un tamaño correcto
if ($nombre_img1 == !NULL) 
{	$tipo_img1 = $_FILES['imagen1']['type'];
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($tipo_img1 == "image/gif")
   || ($tipo_img1 == "image/jpeg")
   || ($tipo_img1 == "image/jpg")
   || ($tipo_img1 == "image/png")
	   || ($tipo_img1== "application/pdf"))
   {
	  /////// cambiar de nombre si es que ya existe////////////////
	   $actual_name = pathinfo($nombre_img1,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($nombre_img1, PATHINFO_EXTENSION);
while(file_exists('fotos/'.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name.$id;
    $nombre_img1 = $actual_name.".".$extension;
}
	   //echo $nombre_1;
	   //$_FILES["imagen2"]['name'];
	   ////////////////// fin de cambiar nombre ///////////////////
	   
	   move_uploaded_file($_FILES["imagen1"]['tmp_name'],"fotos/" . $nombre_img1);
	   //echo "imagen subida: ".$nombre_img."<br>";
	   //echo $foto=$nombre_img1;
	   mysqli_query($sql,"insert into docs values($id,1,'$nombre_img1','')");
    } 
} 
/* fin registro de la imagen */
//////////////////////////////////////////////////////////////////////////////////////////////////
/* inicio de subida de archivo 2*/
/////////////////////////////////////////////////////////////////////////////////////////////

$nombre_img2 = $_FILES['imagen2']['name'];
//$tamano1 = $_FILES['imagen1']['size'];
//echo $nombre_img2."<br>";
//echo $tipo_img1;
//Si existe imagen y tiene un tamaño correcto
if ($nombre_img2 == !NULL) 
{	$tipo_img2 = $_FILES['imagen2']['type'];
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($tipo_img2 == "image/gif")
   || ($tipo_img2 == "image/jpeg")
   || ($tipo_img2 == "image/jpg")
   || ($tipo_img2 == "image/png")
	   || ($tipo_img2== "application/pdf"))
   {
	  /////// cambiar de nombre si es que ya existe////////////////
	   $actual_name = pathinfo($nombre_img2,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($nombre_img2, PATHINFO_EXTENSION);
while(file_exists('fotos/'.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name.$id;
    $nombre_img2 = $actual_name.".".$extension;
}
	   //echo $nombre_1;
	   //$_FILES["imagen2"]['name'];
	   ////////////////// fin de cambiar nombre ///////////////////
	   
	   move_uploaded_file($_FILES["imagen2"]['tmp_name'],"fotos/" . $nombre_img2);
	   //echo "imagen subida: ".$nombre_img."<br>";
	   //echo $foto=$nombre_img1;
	   mysqli_query($sql,"insert into docs values($id,2,'$nombre_img2','')");
    } 
} 
/* fin registro de la imagen */
//////////////////////////////////////////////////////////////////////////////////////////////////
/* inicio de subida de archivo 3*/
/////////////////////////////////////////////////////////////////////////////////////////////

$nombre_img3 = $_FILES['imagen3']['name'];
//$tamano1 = $_FILES['imagen1']['size'];
//echo $nombre_img3."<br>";
//echo $tipo_img1;
//Si existe imagen y tiene un tamaño correcto
if ($nombre_img3 == !NULL) 
{	$tipo_img3 = $_FILES['imagen3']['type'];
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($tipo_img3 == "image/gif")
   || ($tipo_img3 == "image/jpeg")
   || ($tipo_img3 == "image/jpg")
   || ($tipo_img3 == "image/png")
	   || ($tipo_img3== "application/pdf"))
   {
	  /////// cambiar de nombre si es que ya existe////////////////
	   $actual_name = pathinfo($nombre_img3,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($nombre_img3, PATHINFO_EXTENSION);
while(file_exists('fotos/'.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name.$id;
    $nombre_img3 = $actual_name.".".$extension;
}
	   //echo $nombre_1;
	   //$_FILES["imagen3"]['name'];
	   ////////////////// fin de cambiar nombre ///////////////////
	   
	   move_uploaded_file($_FILES["imagen3"]['tmp_name'],"fotos/" . $nombre_img3);
	   //echo "imagen subida: ".$nombre_img."<br>";
	   //echo $foto=$nombre_img1;
	   mysqli_query($sql,"insert into docs values($id,3,'$nombre_img3','')");
    } 
} 
/* fin registro de la imagen */
//////////////////////////////////////////////////////////////////////////////////////////////////
/* inicio de subida de archivo 4*/
/////////////////////////////////////////////////////////////////////////////////////////////

$nombre_img4 = $_FILES['imagen4']['name'];
//$tamano1 = $_FILES['imagen1']['size'];
//echo $nombre_img4."<br>";
//echo $tipo_img1;
//Si existe imagen y tiene un tamaño correcto
if ($nombre_img4 == !NULL) 
{	$tipo_img4 = $_FILES['imagen4']['type'];
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($tipo_img4 == "image/gif")
   || ($tipo_img4 == "image/jpeg")
   || ($tipo_img4 == "image/jpg")
   || ($tipo_img4 == "image/png")
	   || ($tipo_img4== "application/pdf"))
   {
	  /////// cambiar de nombre si es que ya existe////////////////
	   $actual_name = pathinfo($nombre_img4,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($nombre_img4, PATHINFO_EXTENSION);
while(file_exists('fotos/'.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name.$id;
    $nombre_img4 = $actual_name.".".$extension;
}
	   //echo $nombre_1;
	   //$_FILES["imagen4"]['name'];
	   ////////////////// fin de cambiar nombre ///////////////////
	   
	   move_uploaded_file($_FILES["imagen4"]['tmp_name'],"fotos/" . $nombre_img4);
	   //echo "imagen subida: ".$nombre_img."<br>";
	   //echo $foto=$nombre_img1;
	   mysqli_query($sql,"insert into docs values($id,4,'$nombre_img4','')");
    } 
} 
/* fin registro de la imagen */
//////////////////////////////////////////////////////////////////////////////////////////////////
/* inicio de subida de archivo 5*/
/////////////////////////////////////////////////////////////////////////////////////////////

$nombre_img5 = $_FILES['imagen5']['name'];
//$tamano1 = $_FILES['imagen1']['size'];
//echo $nombre_img5."<br>";
//echo $tipo_img1;
//Si existe imagen y tiene un tamaño correcto
if ($nombre_img5 == !NULL) 
{	$tipo_img5 = $_FILES['imagen5']['type'];
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($tipo_img5 == "image/gif")
   || ($tipo_img5 == "image/jpeg")
   || ($tipo_img5 == "image/jpg")
   || ($tipo_img5 == "image/png")
	   || ($tipo_img5== "application/pdf"))
   {
	  /////// cambiar de nombre si es que ya existe////////////////
	   $actual_name = pathinfo($nombre_img5,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($nombre_img5, PATHINFO_EXTENSION);
while(file_exists('fotos/'.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name.$id;
    $nombre_img5 = $actual_name.".".$extension;
}
	   //echo $nombre_1;
	   //$_FILES["imagen5"]['name'];
	   ////////////////// fin de cambiar nombre ///////////////////
	   
	   move_uploaded_file($_FILES["imagen5"]['tmp_name'],"fotos/" . $nombre_img5);
	   //echo "imagen subida: ".$nombre_img."<br>";
	   //echo $foto=$nombre_img1;
	   mysqli_query($sql,"insert into docs values($id,5,'$nombre_img5','')");
    } 
} 
/* fin registro de la imagen */
//////////////////////////////////////////////////////////////////////////////////////////////////
/* inicio de subida de archivo 6*/
/////////////////////////////////////////////////////////////////////////////////////////////

$nombre_img6 = $_FILES['imagen6']['name'];
//Si existe imagen y tiene un tamaño correcto
if ($nombre_img6 == !NULL) 
{	$tipo_img6 = $_FILES['imagen6']['type'];
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($tipo_img6 == "image/gif")
   || ($tipo_img6 == "image/jpeg")
   || ($tipo_img6 == "image/jpg")
   || ($tipo_img6 == "image/png")
	   || ($tipo_img6== "application/pdf"))
   {
	  /////// cambiar de nombre si es que ya existe////////////////
	   $actual_name = pathinfo($nombre_img6,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($nombre_img6, PATHINFO_EXTENSION);
while(file_exists('fotos/'.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name.$id;
    $nombre_img6 = $actual_name.".".$extension;
}
	   ////////////////// fin de cambiar nombre ///////////////////
	   
	   move_uploaded_file($_FILES["imagen6"]['tmp_name'],"fotos/" . $nombre_img6);
	   mysqli_query($sql,"insert into docs values($id,6,'$nombre_img6','')");
    } 
} 
/* fin registro de la imagen */
//////////////////////////////////////////////////////////////////////////////////////////////////
/* inicio de subida de archivo 7*/
/////////////////////////////////////////////////////////////////////////////////////////////

$nombre_img7 = $_FILES['imagen7']['name'];
//Si existe imagen y tiene un tamaño correcto
if ($nombre_img7 == !NULL) 
{	$tipo_img7 = $_FILES['imagen7']['type'];
   //indicamos los formatos que permitimos subir a nuestro servidor
   if (($tipo_img7 == "image/gif")
   || ($tipo_img7 == "image/jpeg")
   || ($tipo_img7 == "image/jpg")
   || ($tipo_img7 == "image/png")
	   || ($tipo_img7== "application/pdf"))
   {
	  /////// cambiar de nombre si es que ya existe////////////////
	   $actual_name = pathinfo($nombre_img7,PATHINFO_FILENAME);
$original_name = $actual_name;
$extension = pathinfo($nombre_img7, PATHINFO_EXTENSION);
while(file_exists('fotos/'.$actual_name.".".$extension))
{           
    $actual_name = (string)$original_name.$id;
    $nombre_img7 = $actual_name.".".$extension;
}
	   ////////////////// fin de cambiar nombre ///////////////////
	   
	   move_uploaded_file($_FILES["imagen7"]['tmp_name'],"fotos/" . $nombre_img7);
	   mysqli_query($sql,"insert into docs values($id,7,'$nombre_img7','')");
    } 
} 
/* fin registro de la imagen */
//////////////////////////////////////////////////////////////////////////////////////////////////

  //echo $codigo,"/",$boletai,"/",$caso,"/",$descripcion,"/",$marca,"/",$serie,"/",$estado,"/",$tipo,"/",$obs1,"/",$obs2,"/",$delito,"/",$fiscal,"/",$fiscalia,"/",$condicion;
header("Location: casos_docs.php");?>