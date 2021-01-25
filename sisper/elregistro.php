<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Elecciones - Registro";
  $css="<link rel='stylesheet' href='plugins\datetimepicker\bootstrap-datetimepicker.min.css'>\n<link rel='stylesheet' href='plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'>\n";
  include("m_estructura/e_up.php");
  include("m_vistas/elregistro.php");
  $js="<script src='plugins/moment/moment.js'></script>\n<script src='plugins/moment/locale/es.js'></script>\n<script src='plugins/datetimepicker/bootstrap-datetimepicker.min.js'></script>\n<script src='m_inclusiones/js/elecciones.js'></script>\n<script src='plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'></script>\n";
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");
  $("#elecciones").addClass("active");
  $("#elregistro").addClass("active");
  li_elecciones()
});
</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
