<?php
///////////////////////////////////////////////////////////////////////////////////////////////
//Libreria para mostrar un calendario y obtener una fecha
//
//La página que llame a esta libreria debe contener un formulario con tres campos donde se introducirá el día el mes y el año que se desee
//Para que este calendario pueda actualizar los campos de formulario correctos debe recibir varios datos (por GET)
//formulario (con el nombre del formulario donde estan los campos
//dia (con el nombre del campo donde se colocará el día)
//mes (con el nombre del campo donde se colocará el mes)
//ano (con el nombre del campo donde se colocará el año)
///////////////////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>Calendario PHP</title>
	<link rel="STYLESHEET" type="text/css" href="estilo.css">
	<script>
		function devuelveFecha(dia,mes,ano){
			//Se encarga de escribir en el formulario adecuado los valores seleccionados
			//también debe cerrar la ventana del calendario
			var formulario_destino = '<?php echo $_GET["formulario"]?>'
			
			var campo_destino = '<?php echo $_GET["nomcampo"]?>'
					
			//meto el dia
			eval ("opener.document." + formulario_destino + "." + campo_destino + ".value='" + dia + "/" + mes + "/" + ano + "'")
			window.close()
		}
	</script>
</head>

<body>

<?php
//TOMO LOS DATOS QUE RECIBO POR LA url Y LOS COMPONGO PARA PASARLOS EN SUCESIVAS EJECUCIONES DEL CALENDARIO
$parametros_formulario = "formulario=" . $_GET["formulario"] . "&nomcampo=" . $_GET["nomcampo"];
?>

<div align="center">
<?php
require ("calendario.php");
$tiempo_actual=date_default_timezone_set('America/Lima');
//$tiempo_actual = time();
$dia_solo_hoy = date("d");
if (!$_POST && !isset($_GET["nuevo_mes"]) && !isset($_GET["nuevo_ano"])){
	$mes = date("n");
	$ano = date("Y");
}elseif ($_POST) {
	$mes = $_POST["nuevo_mes"];
	$ano = $_POST["nuevo_ano"];
}else{
	$mes = $_GET["nuevo_mes"];
	$ano = $_GET["nuevo_ano"];
}
	
mostrar_calendario($mes,$ano);
formularioCalendario($mes,$ano);
?>
</div>
</body>
</html>