<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$tit="Asistencia";
	$css="<link rel='stylesheet' href='plugins\datetimepicker\bootstrap-datetimepicker.min.css'>\n<link rel='stylesheet' href='plugins/alertify/css/alertify.min.css' />\n<link rel='stylesheet' href='plugins/alertify/css/themes/bootstrap.min.css' />\n";
	$jsp="<script src='plugins/moment/moment.js'></script>\n<script src='plugins/moment/locale/es.js'></script>\n<script src='plugins/datetimepicker/bootstrap-datetimepicker.min.js'></script>\n<script src='plugins/alertify/alertify.min.js'></script>\n";
  include("m_estructura/e_up.php");
  include("m_vistas/asistencia.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $('#dtasistencia').DataTable();
  $("ul.sidebar-menu li").removeClass("active");
  $("#asistencia").addClass("active");
});
</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>