<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$js='<script src="m_inclusiones/js/vacaciones.js"></script>';
	$tit="Personal";
  include("m_estructura/e_up.php");
  include("m_vistas/aprvacaciones.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#vacaciones").addClass("active");
  $("#aprvacaciones").addClass("active");
  });
</script>
<?php
}else{
  header('Location: index.php');
}
?>
