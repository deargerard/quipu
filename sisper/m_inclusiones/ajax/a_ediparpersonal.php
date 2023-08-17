<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idpa"]) && !empty($_POST["idpa"])){
    $idpa=iseguro($cone,$_POST["idpa"]);
    $cpa=mysqli_query($cone,"SELECT * FROM pariente WHERE idPariente=$idpa");
    if($rpa=mysqli_fetch_assoc($cpa)){
  ?>
                  <div class="form-group">
                    <label for="tippar" class="col-sm-3 control-label">Parentezco</label>
                    <div class="col-sm-3 valida">
                      <input type="hidden" id="idpa" name="idpa" value="<?php echo $idpa ?>">
                      <select name="tippar" id="tippar" class="form-control">
                        <option value="">PARENTEZCO</option>
                        <?php
                        $ctp=mysqli_query($cone,"SELECT * FROM tipopariente");
                        while($rtp=mysqli_fetch_assoc($ctp)){
                          if($rtp['idTipoPariente']==$rpa['idTipoPariente']){
                        ?>
                        <option value="<?php echo $rtp['idTipoPariente'] ?>" selected="selected"><?php echo $rtp['TipoPariente'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rtp['idTipoPariente'] ?>"><?php echo $rtp['TipoPariente'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($ctp);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="apepat" class="col-sm-3 control-label">Apellido Paterno</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="apepat" name="apepat" class="form-control" placeholder="Apellido Paterno" value="<?php echo $rpa['ApellidoPat'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="apemat" class="col-sm-3 control-label">Apellido Materno</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="apemat" name="apemat" class="form-control" placeholder="Apellido Materno" value="<?php echo $rpa['ApellidoMat'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="nom" class="col-sm-3 control-label">Nombres</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="nom" name="nom" class="form-control" placeholder="Nombres" value="<?php echo $rpa['Nombres'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="sex" class="col-sm-3 control-label">Sexo</label>
                    <div class="col-sm-3">
                      <div class="radio">
                        <?php
                        if($rpa['Sexo']=='M'){
                        ?>
                        <label for="sexmas"><input type="radio" id="sexmas" name="sex" value="M" checked="checked">Masculino</label>
                        <?php
                        }else{
                        ?>
                        <label for="sexmas"><input type="radio" id="sexmas" name="sex" value="M">Masculino</label>
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="radio">
                        <?php
                        if($rpa['Sexo']=='F'){
                        ?>
                        <label for="sexfem"><input type="radio" id="sexfem" name="sex" value="F" checked="checked">Femenino</label>
                        <?php
                        }else{
                        ?>
                        <label for="sexfem"><input type="radio" id="sexfem" name="sex" value="F">Femenino</label>
                        <?php
                        }
                        ?>
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
                          if($rec['idEstadoCivil']==$rpa['idEstadoCivil']){
                        ?>
                        <option value="<?php echo $rec['idEstadoCivil'] ?>" selected="selected"><?php echo $rec['EstadoCivil'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rec['idEstadoCivil'] ?>"><?php echo $rec['EstadoCivil'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($cec);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="fecnac" class="col-sm-3 control-label">Fecha Nacimiento</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fecnac" name="fecnac" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rpa['FechaNac']) ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tipdoc" class="col-sm-3 control-label">Documento Identidad</label>
                    <div class="col-sm-3 valida">
                      <select name="tipdoc" id="tipdoc" class="form-control">
                        <option value="">TIPO DOCUMENTO</option>
                        <?php if($rpa['TipoDoc']=="DNI"){ ?>
                        <option value="DNI" selected="selected">DNI</option>
                        <?php }else{ ?>
                        <option value="DNI">DNI</option>
                        <?php } ?>
                        <?php if($rpa['TipoDoc']=="CARNET EXTRANJERÍA"){ ?>
                        <option value="CARNET EXTRANJERÍA" selected="selected">CARNET EXTRANJERÍA</option>
                        <?php }else{ ?>
                        <option value="CARNET EXTRANJERÍA">CARNET EXTRANJERÍA</option>
                        <?php } ?>
                        <?php if($rpa['TipoDoc']=="PASAPORTE"){ ?>
                        <option value="PASAPORTE" selected="selected">PASAPORTE</option>
                        <?php }else{ ?>
                        <option value="PASAPORTE">PASAPORTE</option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <input type="text" id="numdoc" name="numdoc" class="form-control" placeholder="N° de Documento" value="<?php echo $rpa['NumeroDoc'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ocu" class="col-sm-3 control-label">Ocupación</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="ocu" name="ocu" class="form-control" placeholder="Ocupación" value="<?php echo $rpa['Ocupacion'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="entlab" class="col-sm-3 control-label">Entidad Laboral</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="entlab" name="entlab" class="form-control" placeholder="Entidad Laboral" value="<?php echo $rpa['EntidadLab'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="telfij" class="col-sm-3 control-label">Teléfono Fijo</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="telfij" name="telfij" class="form-control" placeholder="Teléfono Fijo" value="<?php echo $rpa['TelefonoFij'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="telmov" class="col-sm-3 control-label">Teléfono Móvil</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="telmov" name="telmov" class="form-control" placeholder="Teléfono Móvil" value="<?php echo $rpa['TelefonoMov'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="eme" class="col-sm-3 control-label">Contacto Emergencia</label>
                    <div class="col-sm-3">
                      <div class="checkbox">
                        <?php if($rpa['ContactoEme']==1){ ?>
                        <label for="eme"><input type="checkbox" id="eme" name="eme" value="1" checked="checked">Sí</label>
                        <?php }else{ ?>
                        <label for="eme"><input type="checkbox" id="eme" name="eme" value="1">Sí</label>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="viv" class="col-sm-3 control-label">Vive</label>
                    <div class="col-sm-3">
                      <div class="checkbox">
                        <?php if($rpa['Vive']==1){ ?>
                        <label for="viv"><input type="checkbox" id="viv" name="viv" value="1" checked="checked">Sí</label>
                        <?php }else{ ?>
                        <label for="viv"><input type="checkbox" id="viv" name="viv" value="1">Sí</label>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="cor" class="col-sm-3 control-label">Correo</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="cor" name="cor" class="form-control" placeholder="Correo" value="<?php echo $rpa['Correo'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="grains" class="col-sm-3 control-label">Grado Instrucción</label>
                    <div class="col-sm-3 valida">
                      <?php
                      $idgi=$rpa['idGradoInstruccion'];
                      $cgi=mysqli_query($cone,"SELECT GradoInstruccion, Nivel FROM gradoinstruccion WHERE idGradoInstruccion=$idgi");
                      $rgi=mysqli_fetch_assoc($cgi);
                      $gi=$rgi['GradoInstruccion'];
                      $ni=$rgi['Nivel'];
                      ?>
                      <select name="grains" id="grains" class="form-control" onChange="cnivel(this.value)">
                        <option value="">GRADO</option>
                        <?php
                        $cgin=mysqli_query($cone,"SELECT distinct GradoInstruccion FROM gradoinstruccion");
                        while($rgin=mysqli_fetch_assoc($cgin)){
                          if($rgin['GradoInstruccion']==$gi){
                        ?>
                        <option value="<?php echo $rgin['GradoInstruccion'] ?>" selected="selected"><?php echo $rgin['GradoInstruccion'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rgin['GradoInstruccion'] ?>"><?php echo $rgin['GradoInstruccion'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($cgin);
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-3 valida">
                      <select name="nivins" id="nivins" class="form-control">
                        <option value="">NIVEL</option>
                        <?php
                        $cgint=mysqli_query($cone,"SELECT idGradoInstruccion, Nivel FROM gradoinstruccion WHERE GradoInstruccion='$gi'");
                        while($rgint=mysqli_fetch_assoc($cgint)){
                          if($rgint['Nivel']==$ni){
                        ?>
                        <option value="<?php echo $rgint['idGradoInstruccion'] ?>" selected="selected"><?php echo $rgint['Nivel'] ?></option>
                        <?php
                          }else{
                        ?>
                        <option value="<?php echo $rgint['idGradoInstruccion'] ?>"><?php echo $rgint['Nivel'] ?></option>
                        <?php
                          }
                        }
                        mysqli_free_result($cgint);
                        mysqli_free_result($cgi);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="esp" class="col-sm-3 control-label">Especialidad</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="esp" name="esp" class="form-control" placeholder="Especialidad" value="<?php echo $rpa['Especialidad'] ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ins" class="col-sm-3 control-label">Institución</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="ins" name="ins" class="form-control" placeholder="Institución" value="<?php echo $rpa['Institucion'] ?>">
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
      echo "<h4>Error: No se eligió un pariente válido.</h4>";
    }
    mysqli_free_result($cpa);
    mysqli_close($cone);
  }else{
    echo "<h4 class='text-maroon'>Error: No se eleigió ningún pariente</h4>";
  }
}else{
  echo accrestringidoa();
}
?>