<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$tit="Registro Documento";
	$js='<script src="m_inclusiones/js/documentario.js"></script>';
  $js.='<script src="m_inclusiones/js/licencias.js"></script>';
  include("m_estructura/e_up.php");
  include("m_vistas/regdocumentario.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#documentario").addClass("active");
  $("#regdocumentario").addClass("active");
});
</script>
<?php
}else{
  header('Location: index.php');
}
?>
