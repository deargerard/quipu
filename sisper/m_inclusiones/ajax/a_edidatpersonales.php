<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
  if(isset($_POST["idp"]) && !empty($_POST["idp"])){
    $idp=iseguro($cone,$_POST["idp"]);
    $cdp=mysqli_query($cone,"SELECT * FROM empleado WHERE idEmpleado=$idp");
    $rdp=mysqli_fetch_assoc($cdp);
  ?>

            <div class="form-group">
              <label for="apepat" class="col-sm-3 control-label">Apellido Paterno</label>
              <div class="col-sm-3  valida">
                <input type="text" id="apepat" name="apepat" class="form-control" placeholder="Apellido Paterno" value="<?php echo $rdp['ApellidoPat'] ?>">
                <input type="hidden" name="idpe" id="idpe" value="<?php echo $idp ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="apemat" class="col-sm-3 control-label">Apellido Materno</label>
              <div class="col-sm-3  valida">
                <input type="text" id="apemat" name="apemat" class="form-control" placeholder="Apellido Materno" value="<?php echo $rdp['ApellidoMat'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="nom" class="col-sm-3 control-label">Nombres</label>
              <div class="col-sm-6  valida">
                <input type="text" id="nom" name="nom" class="form-control" placeholder="Nombres" value="<?php echo $rdp['Nombres'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Sexo</label>
              <div class="col-sm-3">
                <div class="radio">
                <?php
                if($rdp['Sexo']=='M'){
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
                if($rdp['Sexo']=='F'){
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
              <label for="fecnaci" class="col-sm-3 control-label">Fecha de Nacimiento</label>
              <div class="col-sm-3 valida">
                <input type="text" id="fecnac" name="fecnac" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rdp['FechaNac']) ?>">
              </div>
              <script>
                $('#fecnac').datepicker({
                  format: "dd/mm/yyyy",
                  language: "es",
                  autoclose: true,
                  todayHighlight: true
                });
              </script>   
            </div>
            <div class="form-group">
              <label for="nac" class="col-sm-3 control-label">Nacionalidad</label>
              <div class="col-sm-3 valida">
                <input type="text" id="nac" name="nac" class="form-control" placeholder="Nacionalidad" value="<?php echo $rdp['Nacionalidad'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="depnac" class="col-sm-3 control-label">Lugar de Nacimiento</label>
              <?php
              $iddis=$rdp['idDistrito'];
              $cubi=mysqli_query($cone,"SELECT de.idDepartamento, pr.idProvincia FROM distrito AS di INNER JOIN provincia AS pr ON di.idProvincia=pr.idProvincia INNER JOIN departamento AS de ON pr.idDepartamento=de.idDepartamento WHERE di.idDistrito=$iddis");
              $rubi=mysqli_fetch_assoc($cubi);
              ?>
              <div class="col-sm-3 valida">
                <select name="depnac" id="depnac" class="form-control" onChange="cprovincia(this.value)">
                  <option value="">DEPARTAMENTO</option>
                  <?php
                  $cdep=mysqli_query($cone,"SELECT * FROM departamento");
                  while($rdep=mysqli_fetch_assoc($cdep)){
                    if($rdep['idDepartamento']==$rubi['idDepartamento']){
                  ?>
                  <option value="<?php echo $rdep['idDepartamento'] ?>" selected><?php echo $rdep['NombreDep'] ?></option>
                  <?php
                    }else{
                  ?>
                  <option value="<?php echo $rdep['idDepartamento'] ?>"><?php echo $rdep['NombreDep'] ?></option>
                  <?php
                    }                  
                  }
                  mysqli_free_result($cdep);
                  ?>
                </select>
              </div>
              <div class="col-sm-3 valida">
                <select name="pronac" id="pronac" class="form-control" onChange="cdistrito(this.value)">
                  <option value="">PROVINCIA</option>
                  <?php
                  $iddep=$rubi['idDepartamento'];
                  $cpro=mysqli_query($cone,"SELECT * FROM provincia WHERE idDepartamento=$iddep");
                  while($rpro=mysqli_fetch_assoc($cpro)){
                    if($rpro['idProvincia']==$rubi['idProvincia']){
                  ?>
                  <option value="<?php echo $rpro['idProvincia'] ?>" selected><?php echo $rpro['NombrePro'] ?></option>
                  <?php
                    }else{
                  ?>
                  <option value="<?php echo $rpro['idProvincia'] ?>"><?php echo $rpro['NombrePro'] ?></option>
                  <?php
                    }                  
                  }
                  mysqli_free_result($cpro);
                  ?>
                </select>
              </div>
              <div class="col-sm-3 valida">
                <select name="disnac" id="disnac" class="form-control">
                  <option value="">DISTRITO</option>
                  <?php
                  $idpro=$rubi['idProvincia'];
                  $cdis=mysqli_query($cone,"SELECT * FROM distrito WHERE idProvincia=$idpro");
                  while($rdis=mysqli_fetch_assoc($cdis)){
                    if($rdis['idDistrito']==$iddis){
                  ?>
                  <option value="<?php echo $rdis['idDistrito'] ?>" selected><?php echo $rdis['NombreDis'] ?></option>
                  <?php
                    }else{
                  ?>
                  <option value="<?php echo $rdis['idDistrito'] ?>"><?php echo $rdis['NombreDis'] ?></option>
                  <?php
                    }                  
                  }
                  mysqli_free_result($cdis);
                  mysqli_free_result($cubi);
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="estciv" class="col-sm-3 control-label">Estado Civil</label>
              <div class="col-sm-3 valida">
                <select name="estciv" id="estciv" class="form-control">
                  <option value="">ESTADO CIVIL</option>
                  <?php
                  $idec=$rdp['idEstadoCivil'];
                  $cec=mysqli_query($cone,"SELECT * FROM estadocivil");
                  while($rec=mysqli_fetch_assoc($cec)){
                    if($rec['idEstadoCivil']==$idec){
                  ?>
                  <option value="<?php echo $rec['idEstadoCivil'] ?>" selected><?php echo $rec['EstadoCivil'] ?></option>
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
              <label for="tipdoc" class="col-sm-3 control-label">Documento Identidad</label>
              <div class="col-sm-3 valida">
                <input type="text" class="form-control" value="<?php echo $rdp['TipoDoc'] ?>" disabled>
              </div>
              <div class="col-sm-3 valida">
                <input type="text" class="form-control" value="<?php echo $rdp['NumeroDoc'] ?>" disabled>
              </div>
            </div>
            <div class="form-group">
              <label for="libmil" class="col-sm-3 control-label">N° de Libreta Militar</label>
              <div class="col-sm-3 valida">
                <input type="text" id="libmil" name="libmil" class="form-control" placeholder="N° de Libreta Militar" value="<?php echo $rdp['LibretaMil'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="aut" class="col-sm-3 control-label">ESSALUD (Autogenerado)</label>
              <div class="col-sm-3 valida">
                <input type="text" id="aut" name="aut" class="form-control" placeholder="Autogenerado" value="<?php echo $rdp['Autogenerado'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="ruc" class="col-sm-3 control-label">RUC</label>
              <div class="col-sm-3 valida">
                <input type="text" id="ruc" name="ruc" class="form-control" placeholder="RUC" value="<?php echo $rdp['RUC'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="corins" class="col-sm-3 control-label">Correo Institucional</label>
              <div class="col-sm-6 valida">
                <input type="email" id="corins" name="corins" class="form-control" placeholder="Correo Institucional" value="<?php echo $rdp['CorreoIns'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="corper" class="col-sm-3 control-label">Correo Personal</label>
              <div class="col-sm-6 valida">
                <input type="email" id="corper" name="corper" class="form-control" placeholder="Correo Personal" value="<?php echo $rdp['CorreoPer'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="numcue" class="col-sm-3 control-label">N° de cuenta BN</label>
              <div class="col-sm-6 valida">
                <input type="text" id="numcue" name="numcue" class="form-control" placeholder="N° de cuenta BN" value="<?php echo $rdp['NumeroCuenta'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="entcts" class="col-sm-3 control-label">Entidad CTS</label>
              <div class="col-sm-6 valida">
                <input type="text" id="entcts" name="entcts" class="form-control" placeholder="Entidad CTS" value="<?php echo $rdp['EntidadCts'] ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="grusan" class="col-sm-3 control-label">Grupo Sanguíneo</label>
              <div class="col-sm-3 valida">
                <select name="grusan" id="grusan" class="form-control">
                  <option value="">GRUPO SANGUINEO</option>
                  <?php
                  if($rdp['GrupoSan']=='O-'){
                  ?>
                  <option value="O-" selected>O-</option>
                  <?php
                  }else{
                  ?>
                  <option value="O-">O-</option>
                  <?php
                  }
                  ?>
                  <?php
                  if($rdp['GrupoSan']=='O+'){
                  ?>
                  <option value="O+" selected>O+</option>
                  <?php
                  }else{
                  ?>
                  <option value="O+">O+</option>
                  <?php
                  }
                  ?>
                  <?php
                  if($rdp['GrupoSan']=='A-'){
                  ?>
                  <option value="A-" selected>A-</option>
                  <?php
                  }else{
                  ?>
                  <option value="A-">A-</option>
                  <?php
                  }
                  ?>
                  <?php
                  if($rdp['GrupoSan']=='A+'){
                  ?>
                  <option value="A+" selected>A+</option>
                  <?php
                  }else{
                  ?>
                  <option value="A+">A+</option>
                  <?php
                  }
                  ?>
                  <?php
                  if($rdp['GrupoSan']=='B-'){
                  ?>
                  <option value="B-" selected>B-</option>
                  <?php
                  }else{
                  ?>
                  <option value="B-">B-</option>
                  <?php
                  }
                  ?>
                  <?php
                  if($rdp['GrupoSan']=='B+'){
                  ?>
                  <option value="B+" selected>B+</option>
                  <?php
                  }else{
                  ?>
                  <option value="B+">B+</option>
                  <?php
                  }
                  ?>
                  <?php
                  if($rdp['GrupoSan']=='AB-'){
                  ?>
                  <option value="AB-" selected>AB-</option>
                  <?php
                  }else{
                  ?>
                  <option value="AB-">AB-</option>
                  <?php
                  }
                  ?>
                  <?php
                  if($rdp['GrupoSan']=='AB+'){
                  ?>
                  <option value="AB+" selected>AB+</option>
                  <?php
                  }else{
                  ?>
                  <option value="AB+">AB+</option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
     
  <?php
    mysqli_free_result($cdp);
    mysqli_close($cone);
  }else{
    echo "<h3 class='text-maroon'>No se selecciono ningún personal</h3>";
  }
}else{
  echo accrestringidoa();
}
?>