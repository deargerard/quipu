<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Trámite Documentario - Bandeja";
  $css="\n<link rel='stylesheet' href='plugins/alertify/css/alertify.min.css' />\n<link rel='stylesheet' href='plugins/alertify/css/themes/bootstrap.min.css' />\n";
  include("m_estructura/e_up.php");
  include("m_vistas/tdbandeja.php");
  $js="<script src='plugins/alertify/alertify.min.js'></script>\n<script src='plugins/datatables.net/js/dataTables.buttons.min.js'></script>\n<script src='plugins/datatables.net/js/jszip.min.js'></script>\n<script src='plugins/datatables.net/js/pdfmake.min.js'></script>\n<script src='plugins/datatables.net/js/vfs_fonts.js'></script>\n<script src='plugins/datatables.net/js/buttons.html5.min.js'></script>\n<script src='plugins/datatables.net/js/buttons.print.min.js'></script>\n\n<script src='m_inclusiones/js/tramitedocg.js'></script>\n<script src='m_inclusiones/js/tramitedocm.js'></script>\n";
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#tramitedoc").addClass("active");
  $("#tdbandeja").addClass("active");
  //li_ban1();
  li_ban8();
});
</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
