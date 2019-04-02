<?php
    include ("sisper/m_inclusiones/php/conexion_sp.php");
    include ("ajax/a_coneenc.php");
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
  include("contenido/index.php");
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
    $c=mysqli_query($cone,"SELECT idComunicado FROM comunicado WHERE Estado=1 ORDER BY Fecha DESC LIMIT 1;");
    if($r=mysqli_fetch_assoc($c)){
      $idco=$r['idComunicado'];
    ?>
    <script>
      $(document).ready(function(){
        $("#mcomunicado").modal("show");
        vcomunicado(<?php echo $idco; ?>);
      });
    </script>
    <?php
    }
    ?>
<?php
}else{
  echo mensajeda("Error: No existe conexión a la base de datos.");
}
?>
</body>

</html>