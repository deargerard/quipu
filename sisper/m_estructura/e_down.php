  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Ministerio Público</b> Distrito Fiscal de Cajamarca
    </div>
    <strong>Copyright &copy; 2016 Oficina de Sistemas e Informática.</strong> Todos los derechos reservados.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->

</div>
<!-- ./wrapper -->
<!--Modal busqueda-->
<div class="modal fade" id="mb_persona" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">DATOS</h4>
      </div>
      <div class="modal-body" id="dmb_persona">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--Fin Modal Busqueda-->
<!--Modal cambiar contraseña personal-->
<div class="modal fade" id="m_camconpersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form id="f_camconpersonal" action="" class="form-horizontal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CAMBIAR CONTRASEÑA</h4>
      </div>
      <div class="modal-body" id="r_camconpersonal">
        <div class="form-group valida">
          <label for="actcon" class="col-sm-3 control-label">Actual Contraseña</label>
          <div class="col-sm-7">
            <input type="password" class="form-control" id="actcon" name="actcon" placeholder="Nueva contraseña">
            <input type="hidden" id="idemp" name="idemp" value="<?php echo $_SESSION['identi'] ?>">
          </div>
        </div>
        <div class="form-group valida">
          <label for="nuecon" class="col-sm-3 control-label">Nueva Contraseña</label>
          <div class="col-sm-7">
            <input type="password" class="form-control" id="nuecon" name="nuecon" placeholder="Nueva contraseña">
          </div>
        </div>
        <div class="form-group valida">
          <label for="rnuecon" class="col-sm-3 control-label">Repetir Contraseña</label>
          <div class="col-sm-7">
            <input type="password" class="form-control" id="rnuecon" name="rnuecon" placeholder="Repetir contraseña">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="b_gcamconpersonal"><i class="fa fa-floppy-o"></i> Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
  </form>
</div>
<!--Fin Modal cambiar contraseña personal-->

<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Jquery-iu -->
<script src="plugins/jQueryUI/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<!-- seleccion multiple -->
<script src="plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- Jquery Validation -->
<script src="m_inclusiones/js/jquery.validate.js"></script>
<script src="m_inclusiones/js/additional-methods.min.js"></script>
<script src="m_inclusiones/js/messages_es_PE.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!--inicio-->
<script src="m_inclusiones/js/funcionesin.js"></script>
<script src="m_inclusiones/js/funcionesme.js"></script>
<script src="m_inclusiones/js/funcionesjq.js"></script>
<script src="m_inclusiones/js/intranetjs.js"></script>
<script src="m_inclusiones/js/asistenciajs.js"></script>
<?php
if(!empty($js)){
  echo $js;
}
?>
<!--fin-->
<?php
if(!empty($sc)){
  echo $sc;
}
?>
</body>
</html>
