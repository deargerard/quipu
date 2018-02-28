<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$js='<script src="m_inclusiones/js/comisiones.js"></script>';
	$tit="Personal";
  include("m_estructura/e_up.php");
  include("m_vistas/repcomservicios.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  //$('#dtvacaciones').DataTable();
  $("ul.sidebar-menu li").removeClass("active");
  $("#comservicios").addClass("active");
  $("#repcomservicios").addClass("active");
  });
</script>
<?php
}else{
  header('Location: index.php');
}
?>
