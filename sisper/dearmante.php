<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Mantenimiento - Dependencia";
  include("m_estructura/e_up.php");
  include("m_vistas/coomante.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#organizacional").addClass("active");
  $("#dearmante").addClass("active");
  $('#dtcoordinaciones,#dtcoordinadores').DataTable();
});
</script>
<?php
	mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
