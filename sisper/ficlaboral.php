<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  if(vcontrasena($cone,$_SESSION['identi'])){
    header('Location: camcontra.php');
  }
	$tit="Perfil";
	$js="<script src='m_inclusiones/js/upload.js'></script>\n";
	$js.="<script src='m_inclusiones/js/bootstrap-filestyle.min.js'></script>\n";
  $js.="<script src='m_inclusiones/js/vacaciones.js'></script>";
  include("m_estructura/e_up.php");
  include("m_vistas/ficlaboral.php");
  include("m_estructura/e_down.php");
?>
<script>
$(document).ready(function(){
  $("ul.sidebar-menu li").removeClass("active");

  $("#miperfil").addClass("active");
  $("#fichalaboral").addClass("active");
<?php for ($i=1; $i < ($n+1); $i++) {  ?>

  $("#dtable<?php echo $i ?>").DataTable({
    "order": [[7,"asc"]]
  });
  <?php } ?>
  <?php if(!$v){ ?>
      $("#b_provac").hide();
  <?php } ?>
  
  $('#dtcomser').DataTable({
    "order": [[4,"asc"]]
  });

});
</script>
<?php
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>
