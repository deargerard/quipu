<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Vacaciones";
  $css="\n<link rel='stylesheet' href='plugins/alertify/css/alertify.min.css' />\n<link rel='stylesheet' href='plugins/alertify/css/themes/bootstrap.min.css' />\n";
	$js="<script src='plugins/alertify/alertify.min.js'></script>\n<script src='m_inclusiones/js/vacaciones.js'></script>\n<script src='m_inclusiones/js/licencias.js'></script>";
	
  include("m_estructura/e_up.php");
  include("m_vistas/pagvacaciones.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#vacaciones").addClass("active");
  $("#pagvacaciones").addClass("active");
});
</script>
<?php
}else{
  header('Location: index.php');
}
?>
