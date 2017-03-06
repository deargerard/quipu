<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$tit="Personal";
  include("m_estructura/e_up.php");
  include("m_vistas/repcargos.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#personal").addClass("active");
  $("#repcargos").addClass("active");
});
</script>
<?php
	mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
