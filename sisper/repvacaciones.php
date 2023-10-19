<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Personal";
	$js="<script src='plugins/datatables.net/js/dataTables.buttons.min.js'></script>\n<script src='plugins/datatables.net/js/jszip.min.js'></script>\n<script src='plugins/datatables.net/js/pdfmake.min.js'></script>\n<script src='plugins/datatables.net/js/vfs_fonts.js'></script>\n<script src='plugins/datatables.net/js/buttons.html5.min.js'></script>\n<script src='plugins/datatables.net/js/buttons.print.min.js'></script>\n<script src='m_inclusiones/js/vacaciones.js'></script>";
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
