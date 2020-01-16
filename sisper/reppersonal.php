<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$tit="Personal";
  $js="<script src='plugins/toexcel/xlsx.full.min.js'></script>\n<script src='plugins/toexcel/FileSaver.min.js'></script>";
  include("m_estructura/e_up.php");
  include("m_vistas/reppersonal.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#personal").addClass("active");
  $("#reppersonal").addClass("active");
  $(".select2").select2();
  $('#d_vig').datepicker({
      format: 'mm/yyyy',
      autoclose: true,
      language: 'es',
      minViewMode: 0,
      maxViewMode: 2,
      todayHighlight: true
  });
});
</script>
<?php
	mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
