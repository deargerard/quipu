<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["idec"]) && !empty($_POST["idec"])){
    $idec=iseguro($cone,$_POST["idec"]);
    $c=mysqli_query($cone,"SELECT idEstadoCar, FechaIni FROM estadocargo WHERE idEmpleadoCargo=$idec AND Estado=1");
    if($r=mysqli_fetch_assoc($c)){
      if($r['idEstadoCar']=="1"){
        $pc="AND idEstadoCar!=".$r['idEstadoCar'];
      }else{
        $pc="";
      }
      $f=$r['FechaIni'];
    }
    mysqli_free_result($c);
  ?>
    
                  <div class="form-group">
                    <label for="estcar" class="col-sm-3 control-label">Nuevo Estado</label>
                    <div class="col-sm-6 valida">
                      <input type="hidden" id="idec" name="idec" value="<?php echo $idec; ?>">
                      <select name="estcar" id="estcar" class="form-control">
                        <option value="">ESTADO CARGO</option>
                        <?php
                        $cecar=mysqli_query($cone,"SELECT * FROM estadocar WHERE Estado=1 $pc;");
                        while ($rec=mysqli_fetch_assoc($cecar)) {
                        ?>
                        <option value="<?php echo $rec['idEstadoCar']; ?>"><?php echo $rec['EstadoCar']; ?></option>
                        <?php
                        }
                        mysqli_free_result($cecar);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ini" class="col-sm-3 control-label">Fecha Inicio</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="ini" name="ini" class="form-control" placeholder="dd/mm/aaaa" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group hidden" id="pfin">
                    <label for="fven" class="col-sm-3 control-label">Fecha Vencimiento</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fven" name="fven" class="form-control" placeholder="dd/mm/aaaa" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numres" class="col-sm-3 control-label">N° Documento</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numres" name="numres" class="form-control" placeholder="N° Documento">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mot" class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo">
                    </div>
                  </div>
<script>
  $('#ini,#fven').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true,
    startDate: <?php echo '"'.fnormal($f).'"'; ?>
  });
  $("#estcar").change(function(){
    var ve = this.value;
    if(ve=='2' || ve=='4'){
      $("#pfin").removeClass("hidden");
    }else{
      $("#pfin").addClass("hidden");
      $("#fven").val("");
    }
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