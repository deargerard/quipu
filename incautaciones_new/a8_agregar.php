<!--<body onload='document.agregar.submit()'>-->
<?php 
include("conect.php");
$link=conect();
$link1=conect();
$link2=conect();
//$lib = mysqli_query($sql,"select max(id) as ultimo_id from inventario");
//$rs_lib = mysqli_fetch_assoc($lib);
//$codigo= $rs_lib['ultimo_id'] + 1;
$id=$_POST['id'];
$fecha=$_POST['fecha'];
$hora=$_POST['hora'];
$nombre=strtolower($_POST['nombre']);
$dni=strtolower($_POST['dni']);
$cargo=strtolower($_POST['cargo']);
$codigo=strtolower($_POST['codigo']);
$proposito=strtolower($_POST['proposito']);
$autorizacion=strtolower($_POST['autorizacion']);
$obs=strtolower($_POST['obs']);
$fecha1=$_POST['fecha1'];
$hora1=$_POST['hora1'];
$nombre1=strtolower($_POST['nombre1']);
$dni1=strtolower($_POST['dni1']);
$cargo1=strtolower($_POST['cargo1']);
$codigo1=strtolower($_POST['codigo1']);
$proposito1=strtolower($_POST['proposito1']);
$autorizacion1=strtolower($_POST['autorizacion1']);
$obs1=strtolower($_POST['obs1']);
$caso=strtolower($_POST['caso']);
$almacen=strtolower($_POST['almacen']);
$domicilio=$_POST['domicilio'];
$ubicacion=$_POST['ubicacion'];
$estante=$_POST['estante'];
$nivel=strtolower($_POST['nivel']);
	$ubica_almacen=$ubicacion."-".$estante."-".$nivel;
$descripcion=strtolower($_POST['descripcion']);
$ubic_caja=strtolower($_POST['ubic_caja']);
	$ubicacion_caja=$descripcion."-".$ubic_caja;
$autoridad=$_POST['autoridad'];
$fiscalia=$_POST['fiscalia'];
$juzgado=$_POST['juzgado'];
 $aut_fisca_juz=$autoridad."-".$fiscalia."-".$juzgado;
$delito=strtolower($_POST['delito']);
$autor=strtolower($_POST['autor']);
$agraviado=strtolower($_POST['agraviado']);
$origen=$_POST['origen'];
$distrito=$_POST['distrito'];
$provincia=$_POST['provincia'];
	$lugar=$origen."-".$distrito."-".$provincia;
$embalaje=strtolower($_POST['embalaje']);
$serie=strtolower($_POST['serie']);
$marca=strtolower($_POST['marca']);
$anio=$_POST['anio'];
$color=$_POST['color'];
$tamano=$_POST['tamano'];
$volumen=strtolower($_POST['volumen']);
$peso=strtolower($_POST['peso']);
$otro=strtolower($_POST['otro']);
	$caracteristicas=$serie."-".$marca."-".$anio."-".$color."-".$tamano."-".$volumen."-".$peso."-".$otro;
echo $caracteristicas;
$naturaleza="";
$numero=$_POST["tipo"];
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $numero=$_POST["tipo"];
    $count = count($numero);
    for ($i = 0; $i < $count; $i++) {
        //echo $numero[$i];
		$naturaleza=$naturaleza."-".$numero[$i];
    }
}
$otro_tipo=$_POST['otro_tipo'];
	echo "<br>".$naturaleza;
$drogas=strtolower($_POST['drogas']);
$resp_entrega=strtolower($_POST['resp_entrega']);
$custodia1=strtolower($_POST['custodia1']);
$custodia2=strtolower($_POST['custodia2']);
$fecha2=strtolower($_POST['fecha2']);
$fecha3=strtolower($_POST['fecha3']);
$obs2=strtolower($_POST['obs2']);
//////////////////////////////////////////////////////////////////////////////////////////////////
mysqli_query($link,"insert into detalle_2_a7 values($id,1,'$fecha','$hora','$nombre','$dni','$cargo','$codigo','$proposito','$autorizacion','$obs')");
mysqli_query($link1,"insert into detalle_2_a7 values($id,2,'$fecha1','$hora1','$nombre1','$dni1','$cargo1','$codigo1','$proposito1','$autorizacion1','$obs1')");
mysqli_query($link2,"insert into formato_a8 values($id,'$caso','$almacen','$domicilio','$ubica_almacen','$ubicacion_caja','$aut_fisca_juz','$delito','$autor','$agraviado','$lugar','$embalaje','$caracteristicas','$naturaleza','$resp_entrega','$custodia1','$fecha2','$custodia2','$fecha3','$obs2')");
  //echo $id."1".$fecha.$hora.$nombre.$dni.$cargo.$codigo.$proposito.$autorizacion.$obs."<br>";
	//echo $id."2".$fecha.$hora.$nombre.$dni.$cargo.$codigo.$proposito.$autorizacion.$obs1;
header("Location: a7-a8-imprimir.php?id=$id&caso=$caso");?>