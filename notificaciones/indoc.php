<?php
session_start();
include 'php/cone.php';
include 'php/func.php';
include 'const.php';
$idusu=$_SESSION['idusu'];
if(isset($_SESSION['nusu']) && !empty($_SESSION['nusu']) && isset($_SESSION['idusu']) && !empty($_SESSION['idusu'])){
  $tit="Ingresar Documentos";
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
          include('contenido/indoc.php');
          ?>

          <?php
          include('estructura/footer.php');
          ?>
        </div>
      </div>
    </div>
    <!-- Modal Editar-->
    <div id="m_eddoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
      <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Editar Documento</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <form id="f_eddoc">

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="b_eddoc" form="f_eddoc">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Detalle-->
    <div id="m_dedoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Detalle Documento</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <form id="f_dedoc">

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Eliminar-->
    <div id="m_eldoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
      <div role="document" class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 id="exampleModalLabel" class="modal-title">Eliminar Documento</h4>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <form id="f_eldoc">

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="b_eldoc" form="f_eldoc">Si</button>
          </div>
        </div>
      </div>
    </div>
    <?php
    include('estructura/js.php');
    ?>
  <script>
    //$("#documentop").addClass("active");
    $("#guiah").addClass("show");
    $("#reguia").addClass("active");
  </script>
  </body>
</html>
<?php
  mysqli_close($cone);
}else{
  header('Location:'.URL);
}
?>