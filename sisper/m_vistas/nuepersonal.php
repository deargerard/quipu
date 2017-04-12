<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesoadm($cone,$_SESSION['identi'],1)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Nuevo
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li>Personal</li>
        <li class="active">Nuevo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Nuevo Personal</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <form action="" class="form-horizontal" id="f_nuepersonal">
                <div class="box-body">
                  <div id="r_nuepersonal">
                  <fieldset class="fieldset">
                    <legend class="text-orange"><i class="fa fa-user"></i> Datos Personales</legend>
                  <div class="form-group">
                    <label for="apepat" class="col-sm-3 control-label">Apellido Paterno</label>
                    <div class="col-sm-3  valida">
                      <input type="text" id="apepat" name="apepat" class="form-control" placeholder="Apellido Paterno">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="apemat" class="col-sm-3 control-label">Apellido Materno</label>
                    <div class="col-sm-3  valida">
                      <input type="text" id="apemat" name="apemat" class="form-control" placeholder="Apellido Materno">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="nom" class="col-sm-3 control-label">Nombres</label>
                    <div class="col-sm-6  valida">
                      <input type="text" id="nom" name="nom" class="form-control" placeholder="Nombres">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Sexo</label>
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
                    <label for="fecnac" class="col-sm-3 control-label">Fecha de Nacimiento</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecnac" name="fecnac" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="nac" class="col-sm-3 control-label">Nacionalidad</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="nac" name="nac" class="form-control" placeholder="Nacionalidad">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="depnac" class="col-sm-3 control-label">Lugar de Nacimiento</label>
                    <div class="col-sm-3 valida">
                      <select name="depnac" id="depnac" class="form-control" onChange="cprovincia(this.value)">
                        <option value="">DEPARTAMENTO</option>
                        <?php echo listadep($cone) ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="pronac" id="pronac" class="form-control" onChange="cdistrito(this.value)">
                        <option value="">PROVINCIA</option>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="disnac" id="disnac" class="form-control">
                        <option value="">DISTRITO</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="estciv" class="col-sm-3 control-label">Estado Civil</label>
                    <div class="col-sm-3 valida">
                      <select name="estciv" id="estciv" class="form-control">
                        <option value="">ESTADO CIVIL</option>
                        <?php echo listaec($cone) ?>
                      </select>
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
                    <label for="libmil" class="col-sm-3 control-label">N° de Libreta Militar</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="libmil" name="libmil" class="form-control" placeholder="N° de Libreta Militar">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="aut" class="col-sm-3 control-label">ESSALUD (Autogenerado)</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="aut" name="aut" class="form-control" placeholder="Autogenerado">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ruc" class="col-sm-3 control-label">RUC</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="ruc" name="ruc" class="form-control" placeholder="RUC">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="corper" class="col-sm-3 control-label">Correo Personal</label>
                    <div class="col-sm-6 valida">
                      <input type="email" id="corper" name="corper" class="form-control" placeholder="Correo Personal">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numcue" class="col-sm-3 control-label">N° de cuenta BN</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numcue" name="numcue" class="form-control" placeholder="N° de cuenta BN">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="entcts" class="col-sm-3 control-label">Entidad CTS</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="entcts" name="entcts" class="form-control" placeholder="Entidad CTS">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="grusan" class="col-sm-3 control-label">Grupo Sanguíneo</label>
                    <div class="col-sm-3 valida">
                      <select name="grusan" id="grusan" class="form-control">
                        <option value="">GRUPO SANGUINEO</option>
                        <option value="O-">O-</option>
                        <option value="O+" selected>O+</option>
                        <option value="A-">A-</option>
                        <option value="A+">A+</option>
                        <option value="B-">B-</option>
                        <option value="B+">B+</option>
                        <option value="AB-">AB-</option>
                        <option value="AB+">AB+</option>
                      </select>
                    </div>
                  </div>
                  </fieldset>
                  <!--Grado Instrucción-->
                  <fieldset class="fieldset">
                    <legend class="text-orange"><i class="fa fa-graduation-cap"></i> Grado Instrucción</legend>
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
                  </fieldset>
                  <!--Sistema Pensión-->
                  <fieldset class="fieldset">
                    <legend class="text-orange"><i class="fa fa-hospital-o"></i> Sistema Pensión</legend>
                  <div class="form-group">
                    <label for="penins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-3 valida">
                      <select name="penins" id="penins" class="form-control">
                        <option value="">INSTITUCIÓN</option>
                        <?php echo listapen($cone) ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="dcuspp">
                    <label for="cuspp" class="col-sm-3 control-label">Código CUSPP</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="cuspp" name="cuspp" class="form-control" placeholder="CUSPP">
                    </div>
                  </div>
                  <div class="form-group" id="dfecafi">
                    <label for="fecafi" class="col-sm-3 control-label">Fecha Afiliación</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecafi" name="fecafi" class="form-control" placeholder="dd/mm/aaaa">
                    </div>
                  </div>
                  </fieldset>
                  <!--Domicilio-->
                  <fieldset class="fieldset">
                    <legend class="text-orange"><i class="fa fa-building-o"></i> Domicilio</legend>
                  <div class="form-group">
                    <label for="conviv" class="col-sm-3 control-label">Condición Vivienda</label>
                    <div class="col-sm-3 valida">
                      <select name="conviv" id="conviv" class="form-control">
                        <option value="">CONDICIÓN</option>
                        <option value="PROPIA">PROPIA</option>
                        <option value="ALQUILER">ALQUILER</option>
                        <option value="FAMILIAR">FAMILIAR</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="dir" class="col-sm-3 control-label">Dirección</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="dir" name="dir" class="form-control" placeholder="Dirección">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="urb" class="col-sm-3 control-label">Urbanización</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="urb" name="urb" class="form-control" placeholder="Urbanización">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="depubi" class="col-sm-3 control-label">Ubicación</label>
                    <div class="col-sm-3 valida">
                      <select name="depubi" id="depubi" class="form-control" onChange="cprovinciad(this.value)">
                        <option value="">DEPARTAMENTO</option>
                        <?php echo listadep($cone) ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="proubi" id="proubi" class="form-control" onChange="cdistritod(this.value)">
                        <option value="">PROVINCIA</option>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="disubi" id="disubi" class="form-control">
                        <option value="">DISTRITO</option>
                      </select>
                    </div>
                  </div>
                  </fieldset>
                  <!--Teléfono-->
                  <fieldset class="fieldset">
                    <legend class="text-orange"><i class="fa fa-phone"></i> Teléfono</legend>
                  <div class="form-group">
                    <label for="tiptel" class="col-sm-3 control-label">Teléfono</label>
                    <div class="col-sm-3 valida">
                      <select name="tiptel" id="tiptel" class="form-control">
                        <option value="">TIPO TELÉFONO</option>
                        <?php echo listattel($cone) ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <input type="text" id="numtel" name="numtel" class="form-control" placeholder="Número">
                    </div>
                  </div>
                  </fieldset>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="reset" class="btn btn-default" id="b_rnuepersonal"><i class="fa fa-eraser"></i>  Restablecer</button>
                  <button type="submit" class="btn btn-info pull-right" id="b_gnuepersonal"><i class="fa fa-floppy-o"></i>  Guardar</button>
                </div>
                <!-- /.box-footer-->
              </form>
            </div>
            <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>