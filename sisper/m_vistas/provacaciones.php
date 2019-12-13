<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(esResDespacho($cone, $_SESSION['identi'])){
?>
    <!-- Cabecera -->
    <section class="content-header">
      <h1>
      Programación de Vacaciones
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Vacaciones</li>
        <li class="active">Programación</li>
      </ol>
    </section>
    <!-- /.Cabecera -->
    <section class="content" id="r_provacacionesc">

    </section>
<!--Modal Nuevas programacion-->
<div class="modal fade" id="m_programarvacacionesc" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_provacaciones" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Programación de Oficio</h4>
      </div>
      <div class="modal-body" id="r_provacaciones">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gpvac">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal Nueva programacion-->
<!--Modal editar programacion-->
<div class="modal fade" id="m_editarprogramacionc" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_ediprogramacion" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vacaciones <?php echo $pv ?></h4>
      </div>
      <div class="modal-body" id="r_ediprogramacion">

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn bg-teal" id="b_gepro">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal editar programacion-->
<!--Modal Envio programacion-->
<div class="modal fade" id="m_envprovacc" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_provacaciones" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Aprobar y enviar vacaciones</h4>
      </div>
      <div class="modal-body" id="r_envprovacc">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin ModalEnvio programacion-->


<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>
