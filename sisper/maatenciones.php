<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$tit="Mesa de Ayuda - Atenciones";
  $css="<link rel='stylesheet' href='plugins/datetimepicker/bootstrap-datetimepicker.min.css'>\n";
  include("m_estructura/e_up.php");
  include("m_vistas/maatenciones.php");
  $jsp="<script src='plugins/moment/moment.js'></script>\n<script src='plugins/moment/locale/es.js'></script>\n<script src='plugins/datetimepicker/bootstrap-datetimepicker.min.js'></script>\n";
  $js="<script src='m_inclusiones/js/mayuda.js'></script>\n";
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $('#dtpersonal').DataTable();
  $('#dtatendidas').DataTable();
  $("ul.sidebar-menu li").removeClass("active");
  $("#mesaayuda").addClass("active");
  $("#maatenciones").addClass("active");
});
</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>