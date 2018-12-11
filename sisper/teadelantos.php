<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Tesorería - Adelantos";
  include("m_estructura/e_up.php");
  include("m_vistas/teadelantos.php");
  $js="<script src='m_inclusiones/js/tesoreria.js'></script>\n";
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#tesoreria").addClass("active");
  $("#teadelantos").addClass("active");
  $('#dtrend').DataTable();
});
</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
