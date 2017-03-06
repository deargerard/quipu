<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"])){
    $idp=iseguro($cone,$_POST["idp"]);
  ?>
                  <div class="form-group">
                    <label for="tippar" class="col-sm-3 control-label">Parentezco</label>
                    <div class="col-sm-3 valida">
                      <input type="hidden" id="idpe" name="idpe" value="<?php echo $idp ?>">
                      <select name="tippar" id="tippar" class="form-control">
                        <option value="">PARENTEZCO</option>
                        <?php
                        $ctp=mysqli_query($cone,"SELECT * FROM tipopariente");
                        while($rtp=mysqli_fetch_assoc($ctp)){
                        ?>
                        <option value="<?php echo $rtp['idTipoPariente'] ?>"><?php echo $rtp['TipoPariente'] ?></option>
                        <?php
                        }
                        mysqli_free_result($ctp);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="apepat" class="col-sm-3 control-label">Apellido Paterno</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="apepat" name="apepat" class="form-control" placeholder="Apellido Paterno">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="apemat" class="col-sm-3 control-label">Apellido Materno</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="apemat" name="apemat" class="form-control" placeholder="Apellido Materno">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="nom" class="col-sm-3 control-label">Nombres</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="nom" name="nom" class="form-control" placeholder="Nombres">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="sex" class="col-sm-3 control-label">Sexo</label>
                    <div class="col-sm-3">
                      <div class="radio">
                        <label for="sexmas"><input type="radio" id="sexmas" name="sex" value="M" checked="checked">Masculino</label>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="radio">
                        <label for="sexfem"><input type="radio" id="sexfem" name="sex" value="F">Femenino</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="estciv" class="col-sm-3 control-label">Estado Civil</label>
                    <div class="col-sm-3 valida">
                      <select name="estciv" id="estciv" class="form-control">
                        <option value="">ESTADO CIVIL</option>
                        <?php
                        $cec=mysqli_query($cone,"SELECT * FROM estadocivil");
                        while($rec=mysqli_fetch_assoc($cec)){
                        ?>
                        <option value="<?php echo $rec['idEstadoCivil'] ?>"><?php echo $rec['EstadoCivil'] ?></option>
                        <?php
                        }
                        mysqli_free_result($cec);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecnac" class="col-sm-3 control-label">Fecha Nacimiento</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecnac" name="fecnac" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tipdoc" class="col-sm-3 control-label">Documento Identidad</label>
                    <div class="col-sm-3 valida">
                      <select name="tipdoc" id="tipdoc" class="form-control">
                        <option value="">TIPO DOCUMENTO</option>
                        <option value="DNI">DNI</option>
                        <option value="CARNET EXTRANJERÍA">CARNET EXTRANJERÍA</option>
                        <option value="PASAPORTE">PASAPORTE</option>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <input type="text" id="numdoc" name="numdoc" class="form-control" placeholder="N° de Documento">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ocu" class="col-sm-3 control-label">Ocupación</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="ocu" name="ocu" class="form-control" placeholder="Ocupación">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="entlab" class="col-sm-3 control-label">Entidad Laboral</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="entlab" name="entlab" class="form-control" placeholder="Entidad Laboral">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="telfij" class="col-sm-3 control-label">Teléfono Fijo</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="telfij" name="telfij" class="form-control" placeholder="Teléfono Fijo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="telmov" class="col-sm-3 control-label">Teléfono Móvil</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="telmov" name="telmov" class="form-control" placeholder="Teléfono Móvil">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="eme" class="col-sm-3 control-label">Contacto Emergencia</label>
                    <div class="col-sm-3">
                      <div class="checkbox">
                        <label for="eme"><input type="checkbox" id="eme" name="eme" value="1">Sí</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="viv" class="col-sm-3 control-label">Vive</label>
                    <div class="col-sm-3">
                      <div class="checkbox">
                        <label for="viv"><input type="checkbox" id="viv" name="viv" value="1" checked="checked">Sí</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="cor" class="col-sm-3 control-label">Correo</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="cor" name="cor" class="form-control" placeholder="Correo">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="grains" class="col-sm-3 control-label">Grado Instrucción</label>
                    <div class="col-sm-3 valida">
                      <select name="grains" id="grains" class="form-control" onChange="cnivel(this.value)">
                        <option value="">GRADO</option>
                        <?php echo listagra($cone) ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="nivins" id="nivins" class="form-control">
                        <option value="">NIVEL</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="esp" class="col-sm-3 control-label">Especialidad</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="esp" name="esp" class="form-control" placeholder="Especialidad">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución">
                    </div>
                  </div>
<script>
  $('#fecnac').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true
  });
</script>
  <?php
  }else{
    echo "<h4 class='text-maroon'>Error: No se selecciono ningún personal.</h4>";
  }
}else{
  echo accrestringidoa();
}
?>