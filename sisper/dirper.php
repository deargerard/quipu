<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
	$tit="Intranet";
  include("m_estructura/e_up.php");
  include("m_vistas/dirper.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $('#dtdirper').DataTable();
  $("ul.sidebar-menu li").removeClass("active");
  $("#directorio").addClass("active");
  $("#dirper").addClass("active");
<<<<<<< HEAD
	$(".select2").select2();
=======
  $(".select2").select2();
>>>>>>> 0e8e4d3887489604116c24b05f3dbd894fb245c7
});
</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
