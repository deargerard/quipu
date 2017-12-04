<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesoadm($cone,$_SESSION['identi'],14)){
?>
<!-- Cabecera -->
<section class="content-header">
  <h1>
  Vacaciones
  </h1>
  <ol class="breadcrumb">
    <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
    <li>Vacaciones</li>
    <li class="active">Aprobación</li>
  </ol>
</section>
<!-- /.Cabecera -->
<!-- Sección de Busqueda -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
       <!-- Default box -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Aprobación</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">


              </div>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">

          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </div>
  </div>

  </section>
  <!-- /.Sección de Busqueda -->


  <?php
  }else{
  echo accrestringidop();
  }
  }else{
  header('Location: ../index.php');
  }
  ?>
