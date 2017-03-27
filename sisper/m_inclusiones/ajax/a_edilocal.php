<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
  if(isset($_POST['idlo']) && !empty($_POST['idlo'])){
    $idlo=iseguro($cone,$_POST['idlo']);
    $clo=mysqli_query($cone,"SELECT * FROM local WHERE idLocal=$idlo");
    if($rlo=mysqli_fetch_assoc($clo)){
?>
          <div class="form-group">
            <label for="ali" class="col-sm-2 control-label">Alias</label>
            <div class="col-sm-10 valida">
              <input type="text" class="form-control" id="ali" name="ali" placeholder="Alias de local" value="<?php echo $rlo['Alias']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="dir" class="col-sm-2 control-label">Dirección</label>
            <div class="col-sm-10 valida">
              <input type="hidden" id="idlo" name="idlo" value="<?php echo $idlo ?>">
              <input type="text" class="form-control" id="dir" name="dir" placeholder="Dirección del local" value="<?php echo $rlo['Direccion'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="urb" class="col-sm-2 control-label">Urbanización</label>
            <div class="col-sm-10 valida">
              <input type="text" class="form-control" id="urb" name="urb" placeholder="Urbanización" value="<?php echo $rlo['Urbanizacion'] ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="depubi" class="col-sm-2 control-label">Ubicación</label>
            <?php
            $iddis=$rlo['idDistrito'];
            $ti=0;
            if(!empty($iddis)){
            $cubi=mysqli_query($cone,"SELECT de.idDepartamento, pr.idProvincia FROM distrito AS di INNER JOIN provincia AS pr ON di.idProvincia=pr.idProvincia INNER JOIN departamento AS de ON pr.idDepartamento=de.idDepartamento WHERE di.idDistrito=$iddis");
            $rubi=mysqli_fetch_assoc($cubi);
            $ti=1;
            }
            ?>
            <div class="col-sm-4 valida">
              <input type="hidden" id="ti" name="ti" value="<?php echo $ti ?>">
              <select name="depubi" id="depubi" class="form-control" onChange="cprovinciad(this.value)">
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
              <select name="proubi" id="proubi" class="form-control" onChange="cdistritod(this.value)">
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
              <select name="disubi" id="disubi" class="form-control">
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
            <label for="tel" class="col-sm-2 control-label">Teléfonos</label>
            <div class="col-sm-10 valida">
              <input type="text" class="form-control" id="tel" name="tel" placeholder="Teléfono/Teléfono" value="<?php echo $rlo['Telefono']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="con" class="col-sm-2 control-label">Condición</label>
            <div class="col-sm-4 valida">
              <select id="con" name="con" class="form-control">
                <option value="">CONDICIÓN</option>
                <?php
                $cc=mysqli_query($cone,"SELECT idCondicionLoc, CondicionLocal FROM condicionloc WHERE Estado=1;");
                if(mysqli_num_rows($cc)>0){
                  while($rc=mysqli_fetch_assoc($cc)){
                    if($rc['idCondicionLoc']==$rlo['idCondicionLoc']){
                ?>
                <option value="<?php echo $rc['idCondicionLoc']; ?>" selected><?php echo $rc['CondicionLocal']; ?></option>
                <?php
                    }else{
                ?>
                <option value="<?php echo $rc['idCondicionLoc']; ?>"><?php echo $rc['CondicionLocal']; ?></option>
                <?php
                    }
                  }
                }
                ?>
              </select>
            </div>
            <label for="pro" class="col-sm-2 control-label">Propietario</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="pro" name="pro" placeholder="Propietario" value="<?php echo $rlo['Propietario']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="atot" class="col-sm-2 control-label">Área Total</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="atot" name="atot" placeholder="Área total" value="<?php echo $rlo['AreaTot']; ?>">
            </div>
            <label for="acon" class="col-sm-2 control-label">Área Const</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="acon" name="acon" placeholder="Área construida" value="<?php echo $rlo['AreaCons']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="mat" class="col-sm-2 control-label">Material</label>
            <div class="col-sm-4 valida">
              <select id="mat" name="mat" class="form-control">
                <option value="">MATERIAL</option>
                <option value="ADOBE" <?php echo $rlo['Material']=="ADOBE" ? "selected" : ""; ?>>ADOBE</option>
                <option value="NOBLE" <?php echo $rlo['Material']=="NOBLE" ? "selected" : ""; ?>>NOBLE</option>
              </select>
            </div>
            <label for="npis" class="col-sm-2 control-label"># Pisos</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="npis" name="npis" placeholder="# Pisos" value="<?php echo $rlo['NumPisos']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="malq" class="col-sm-2 control-label">M. Alq.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="malq" name="malq" placeholder="Monto Alquiler" value="<?php echo $rlo['MonAlquiler']; ?>">
            </div>
            <label for="mman" class="col-sm-2 control-label">M. Mto.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="mman" name="mman" placeholder="Monto Mantenimiento" value="<?php echo $rlo['MonMantenimiento']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="san" class="col-sm-2 control-label">Saneado</label>
            <div class="col-sm-4 valida">
              <select id="san" name="san" class="form-control">
                <option value="">SANEADO</option>
                <option value="1" <?php echo $rlo['Saneamiento']==1 ? "selected" : ""; ?>>SÍ</option>
                <option value="2" <?php echo $rlo['Saneamiento']==2 ? "selected" : ""; ?>>NO</option>
                <option value="3" <?php echo $rlo['Saneamiento']==3 ? "selected" : ""; ?>>EN TRAMITE</option>
              </select>
            </div>
            <label for="ftsan" class="col-sm-2 control-label">F. T. San.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="ftsan" name="ftsan" placeholder="Fecha tramite sanemiento" value="<?php echo fnormal($rlo['FecTraSaneamiento']); ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="acons" class="col-sm-2 control-label">A. Const.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="acons" name="acons" placeholder="Año Construcción" value="<?php echo $rlo['AnoConstruccion'] ?>">
            </div>
            <label for="finsp" class="col-sm-2 control-label">F. Insp.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="finsp" name="finsp" placeholder="Fecha Inspección" value="<?php echo fnormal($rlo['FecInspeccion']); ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="upla" class="col-sm-2 control-label">Uso Plan.</label>
            <div class="col-sm-4 valida">
              <select id="upla" name="upla" class="form-control">
                <option value="">USO PLANIFICADO</option>
                <option value="ALMACEN" <?php echo $rlo['UsoPlanificado']=='ALMACEN' ? 'selected' : ''; ?>>ALMACEN</option>
                <option value="NEGOCIO" <?php echo $rlo['UsoPlanificado']=='NEGOCIO' ? 'selected' : ''; ?>>NEGOCIO</option>
                <option value="OFICINAS" <?php echo $rlo['UsoPlanificado']=='OFICINAS' ? 'selected' : ''; ?>>OFICINAS</option>
                <option value="VIVIENDA" <?php echo $rlo['UsoPlanificado']=='VIVIENDA' ? 'selected' : ''; ?>>VIVIENDA</option>
              </select>
            </div>
            <label for="urea" class="col-sm-2 control-label">Uso Real</label>
            <div class="col-sm-4 valida">
              <select id="urea" name="urea" class="form-control">
                <option value="">USO REAL</option>
                <option value="ALMACEN" <?php echo $rlo['UsoReal']=='ALMACEN' ? 'selected' : ''; ?>>ALMACEN</option>
                <option value="NEGOCIO" <?php echo $rlo['UsoReal']=='NEGOCIO' ? 'selected' : ''; ?>>NEGOCIO</option>
                <option value="OFICINAS" <?php echo $rlo['UsoReal']=='OFICINAS' ? 'selected' : ''; ?>>OFICINAS</option>
                <option value="VIVIENDA" <?php echo $rlo['UsoReal']=='VIVIENDA' ? 'selected' : ''; ?>>VIVIENDA</option>
              </select>
            </div>
          </div>
          <script>
            $('#ftsan,#finsp').datepicker({
              format: "dd/mm/yyyy",
              language: "es",
              todayHighlight: true,
              autoclose: true
            });
            $("#acons").datepicker( {
              format: " yyyy", // Notice the Extra space at the beginning
              viewMode: "years", 
              minViewMode: "years",
              todayHighlight: true,
              autoclose: true
            });
          </script>
<?php
    }else{
      echo '<h4 class="text-maroon">Error: No seleccionó ningún local válido.</h4>';
    }
    mysqli_free_result($clo);
    mysqli_close($cone);
  }else{
    echo '<h4 class="text-maroon">Error: No seleccionó ningún local.</h4>';
  }
}else{
  echo accrestringidoa();
}
?>
        