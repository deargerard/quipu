<?php
session_start();
include 'php/cone.php';
include 'php/func.php';
include 'const.php';
$idusu=$_SESSION['idusu'];
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
  $tit="Contraseña";
?>
<!DOCTYPE html>
<html>
  <?php
  include('estructura/head.php');
  ?>
  <body>
    <div class="page">
      <?php
      include('estructura/header.php');
      ?>
      <div class="page-content d-flex align-items-stretch"> 
        <?php
        include('estructura/nav.php');
        ?>
        <div class="content-inner">
          <?php
          include('estructura/breadcrumb.php');
          ?>

          <?php
          include('contenido/contrasena.php');
          ?>

          <?php
          include('estructura/footer.php');
          ?>
        </div>
      </div>
    </div>

    <?php
    include('estructura/js.php');
    ?>
  <script>
    $("#contrasena").addClass("active");
  </script>
  </body>
</html>
<?php
  mysqli_close($cone);
}else{
  header('Location:'.URL);
}
?>