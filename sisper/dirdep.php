<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$tit="Intranet";
  include("m_estructura/e_up.php");
  include("m_vistas/dirdep.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $('#dtdirdep').DataTable();
  $("ul.sidebar-menu li").removeClass("active");
  $("#directorio").addClass("active");
  $("#dirdep").addClass("active");
	$(".select2").select2();
});
</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
