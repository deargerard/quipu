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
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- Jquery Validation -->
<script src="m_inclusiones/js/jquery.validate.js"></script>
<script src="m_inclusiones/js/messages_es_PE.js"></script>
<!--inicio-->
<script src="m_inclusiones/js/funcionesin.js"></script>
<script src="m_inclusiones/js/funcionesme.js"></script>
<script src="m_inclusiones/js/funcionesjq.js"></script>
<!--fin-->
<script>
  $("#f_camconpersonal").validate({
    rules: {
      actcon: {required:true, minlength:6},
      nuecon: {required:true, minlength:6},
      rnuecon: {required:true, equalTo:"#nuecon"}
    },
    messages: {
      actcon: {required:"Ingrese la actual contraseña.",minlength:"Mínimo 6 caracteres"},
      nuecon: {required:"Ingrese la nueva contraseña.",minlength:"Mínimo 6 caracteres"},
      rnuecon: {required:"Repita la nueva contraseña.",equalTo:"No coinciden las contraseñas."}
    },
    errorElement: "em",
    errorPlacement: function(error, element){
      // Add the `help-block` class to the error element
      error.addClass("help-block");

      if(element.prop("type") === "checkbox"){
        error.insertAfter(element.parent("label"));
      }else if(element.prop("type") === "radio"){
        error.insertAfter(element.parent("label"));
      }
      else{
        error.insertAfter(element);
      }
    },
    highlight: function ( element, errorClass, validClass ) {
      $( element ).parents(".valida").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function (element, errorClass, validClass) {
      $( element ).parents(".valida").addClass("has-success").removeClass("has-error");
    },
    submitHandler: function(form){
      var datos = $("#f_camconpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_camconpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gcamconpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         success: function(data){
            $("#b_gcamconpersonal").hide();
            $("#r_camconpersonal").html(data);
            $("#r_camconpersonal").slideDown();
            setTimeout(function(){
              window.location.href = "salir.php";
            }, 2000);
         }
      });
    }
  });
</script>
</body>
</html>