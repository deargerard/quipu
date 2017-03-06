<?php
session_start();
include ("../sisper/m_inclusiones/php/conexion_sp.php");
include ("../sisper/m_inclusiones/php/funciones.php");
if(valaccasi($cone,$_SESSION['iden'],$_SESSION['docv'])){
  include("estructura/up.php");
  include("contenido/asistencia.php");
$s="<script>
$(document).ready(function(){
  $('#masistencia').addClass('active');
});
</script>";
  include("estructura/bottom.php");
	mysqli_close($cone);
}else{
  header('Location: index.html');
}
?>