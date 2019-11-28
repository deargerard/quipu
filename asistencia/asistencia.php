<?php
session_start();
include ("../sisper/m_inclusiones/php/conexion_sp.php");
include ("../sisper/m_inclusiones/php/funciones.php");
if(valaccasi($cone,$_SESSION['iden'],$_SESSION['docv'])){
  include("estructura/up.php");
  include("contenido/asistencia.php");
  $fec=@date("Y-m-d h:i A");
$s="<script>
$(document).ready(function(){
  $('#masistencia').addClass('active');
  function hora(){
      $.ajax({
          url: 'ajax/hora.php',
          success: function(data) {
              $('#reloj').html(data);
          }
      });
  }

  setInterval(hora, 60000);
});
</script>";
  include("estructura/bottom.php");
	mysqli_close($cone);
}else{
  header('Location: index.html');
}
?>