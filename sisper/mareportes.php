<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$tit="Mesa de Ayuda - Reportes";
  include("m_estructura/e_up.php");
  include("m_vistas/mareportes.php");
	$js="<script src='m_inclusiones/js/mayuda.js'></script>\n";
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $('#dtpersonal').DataTable();
  $("ul.sidebar-menu li").removeClass("active");
  $("#mesaayuda").addClass("active");
  $("#mareportes").addClass("active");
});

$(".select2sol").select2();

</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
