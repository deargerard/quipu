<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Personal";
	$js="<script src='m_inclusiones/js/vacaciones.js'></script>\n<script src='plugins/toexcel/xlsx.full.min.js'></script>\n<script src='plugins/toexcel/FileSaver.min.js'></script>";
  include("m_estructura/e_up.php");
  include("m_vistas/repvacaciones.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $('#dtvacaciones').DataTable();
  $("ul.sidebar-menu li").removeClass("active");
  $("#vacaciones").addClass("active");
  $("#repvacaciones").addClass("active");
  });
</script>
<?php
}else{
  header('Location: index.php');
}
?>
