<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Trámite Documentario - Bandeja";
  include("m_estructura/e_up.php");
  include("m_vistas/tdmesapartes.php");
  $js="<script src='m_inclusiones/js/tramitedocg.js'></script>\n<script src='m_inclusiones/js/tramitedocm.js'></script>\n";
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#tramitedoc").addClass("active");
  $("#tdmesapartes").addClass("active");
  li_mpartes()
});
</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
