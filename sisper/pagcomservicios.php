<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$css='<link rel="stylesheet" href="plugins\datetimepicker\bootstrap-datetimepicker.min.css">';
	$js= '<script src="plugins\moment\moment.js"></script>'."\n";
	$js.= '<script src="plugins\moment\locale\es.js"></script>'."\n";
	$js.='<script src="plugins\datetimepicker\bootstrap-datetimepicker.min.js"></script>'."\n";
	$js.='<script src="m_inclusiones/js/comisiones.js"></script>'."\n";
	$js.='<script src="m_inclusiones/js/licencias.js"></script>';
	$tit="Comisión de Servicios";
  include("m_estructura/e_up.php");
  include("m_vistas/pagcomservicios.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#comservicios").addClass("active");
  $("#pagcomservicios").addClass("active");
});
</script>
<?php
}else{
  header('Location: index.php');
}
?>
