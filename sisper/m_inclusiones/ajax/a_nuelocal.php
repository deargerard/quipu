<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],6)){
?>

          <div class="form-group">
            <label for="ali" class="col-sm-2 control-label">Alias</label>
            <div class="col-sm-10 valida">
              <input type="text" class="form-control" id="ali" name="ali" placeholder="Alias de local">
            </div>
          </div>
          <div class="form-group">
            <label for="dir" class="col-sm-2 control-label">Dirección</label>
            <div class="col-sm-10 valida">
              <input type="text" class="form-control" id="dir" name="dir" placeholder="Dirección del local">
            </div>
          </div>
          <div class="form-group">
            <label for="urb" class="col-sm-2 control-label">Urbanización</label>
            <div class="col-sm-10 valida">
              <input type="text" class="form-control" id="urb" name="urb" placeholder="Urbanización">
            </div>
          </div>
          <div class="form-group">
            <label for="depubi" class="col-sm-2 control-label">Ubicación</label>
            <div class="col-sm-4 valida">
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
          <div class="form-group">
            <label for="tel" class="col-sm-2 control-label">Teléfonos</label>
            <div class="col-sm-10 valida">
              <input type="text" class="form-control" id="tel" name="tel" placeholder="Teléfono/Teléfono">
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
                ?>
                <option value="<?php echo $rc['idCondicionLoc']; ?>"><?php echo $rc['CondicionLocal']; ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
            <label for="pro" class="col-sm-2 control-label">Propietario</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="pro" name="pro" placeholder="Propietario">
            </div>
          </div>
          <div class="form-group">
            <label for="atot" class="col-sm-2 control-label">Área Total</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="atot" name="atot" placeholder="Área total">
            </div>
            <label for="acon" class="col-sm-2 control-label">Área Const</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="acon" name="acon" placeholder="Área construida">
            </div>
          </div>
          <div class="form-group">
            <label for="mat" class="col-sm-2 control-label">Material</label>
            <div class="col-sm-4 valida">
              <select id="mat" name="mat" class="form-control">
                <option value="">MATERIAL</option>
                <option value="ADOBE">ADOBE</option>
                <option value="NOBLE">NOBLE</option>
              </select>
            </div>
            <label for="npis" class="col-sm-2 control-label"># Pisos</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="npis" name="npis" placeholder="# Pisos">
            </div>
          </div>
          <div class="form-group">
            <label for="malq" class="col-sm-2 control-label">M. Alq.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="malq" name="malq" placeholder="Monto Alquiler">
            </div>
            <label for="mman" class="col-sm-2 control-label">M. Mto.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="mman" name="mman" placeholder="Monto Mantenimiento">
            </div>
          </div>
          <div class="form-group">
            <label for="san" class="col-sm-2 control-label">Saneado</label>
            <div class="col-sm-4 valida">
              <select id="san" name="san" class="form-control">
                <option value="">SANEADO</option>
                <option value="1">SÍ</option>
                <option value="2">NO</option>
                <option value="3">EN TRAMITE</option>
              </select>
            </div>
            <label for="ftsan" class="col-sm-2 control-label">F. T. San.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="ftsan" name="ftsan" placeholder="Fecha tramite sanemiento">
            </div>
          </div>
          <div class="form-group">
            <label for="acons" class="col-sm-2 control-label">A. Const.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="acons" name="acons" placeholder="Año Construcción">
            </div>
            <label for="finsp" class="col-sm-2 control-label">F. Insp.</label>
            <div class="col-sm-4 valida">
              <input type="text" class="form-control" id="finsp" name="finsp" placeholder="Fecha Inspección">
            </div>
          </div>
          <div class="form-group">
            <label for="upla" class="col-sm-2 control-label">Uso Plan.</label>
            <div class="col-sm-4 valida">
              <select id="upla" name="upla" class="form-control">
                <option value="">USO PLANIFICADO</option>
                <option value="ALMACEN">ALMACEN</option>
                <option value="NEGOCIO">NEGOCIO</option>
                <option value="OFICINAS">OFICINAS</option>
                <option value="VIVIENDA">VIVIENDA</option>
              </select>
            </div>
            <label for="urea" class="col-sm-2 control-label">Uso Real</label>
            <div class="col-sm-4 valida">
              <select id="urea" name="urea" class="form-control">
                <option value="">USO REAL</option>
                <option value="ALMACEN">ALMACEN</option>
                <option value="NEGOCIO">NEGOCIO</option>
                <option value="OFICINAS">OFICINAS</option>
                <option value="VIVIENDA">VIVIENDA</option>
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
  mysqli_close($cone);
}else{
  echo accrestringidoa();
}
?>
        