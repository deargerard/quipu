<?php
    include ("sisper/m_inclusiones/php/conexion_sp.php");
    include ("sisper/m_inclusiones/php/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">
<?php
  include("estructura/head.php");
?>
<body>
<?php
if($conex){
  include("estructura/header.php");
?>
    <!-- Header Carousel -->
<div class="container">
    <div class="row">
<?php
  include("contenido/noti.php");
  include("estructura/aderecha.php");
?>
    </div>
<?php
  include("estructura/enlaces.php");
?>

</div>

    <!-- Page Content -->

<?php
  include("estructura/modales.php");
?>
<!-- Footer -->
<?php
  include("estructura/footer.php");
  include("estructura/jss.php");
?>

<?php
}else{
  echo mensajeda("Error: No existe conexión a la base de datos.");
}
?>
</body>

</html>