<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["idec"]) && !empty($_POST["idec"])){
    $idec=iseguro($cone,$_POST["idec"]);
    $c=mysqli_query($cone,"SELECT * FROM estadocargo WHERE idEstadocargo=$idec");
    if($r=mysqli_fetch_assoc($c)){
      $idempcar=$r['idEmpleadoCargo'];
      $fesac=$r['FechaIni'];
      $cesan=mysqli_query($cone,"SELECT idEstadoCar FROM estadocargo WHERE idEmpleadoCargo=$idempcar AND FechaIni<'$fesac' ORDER BY FechaIni DESC LIMIT 1;");
      if($resan=mysqli_fetch_assoc($cesan)){
        $esan=$resan['idEstadoCar'];
      }
  ?>
    
                  <div class="form-group">
                    <label for="estcar" class="col-sm-3 control-label">Nuevo Estado</label>
                    <div class="col-sm-6 valida">
                      <input type="hidden" id="idec" name="idec" value="<?php echo $idec; ?>">
                      <input type="hidden" id="emca" name="emca" value="<?php echo $idempcar; ?>">
                      <select name="estcar" id="estcar" class="form-control">
                        <option value="">ESTADO CARGO</option>
                        <?php
                        $cecar=mysqli_query($cone,"SELECT * FROM estadocar WHERE Estado=1 AND idEstadoCar!=$esan");
                        while ($rec=mysqli_fetch_assoc($cecar)) {
                        ?>
                        <option value="<?php echo $rec['idEstadoCar']; ?>" <?php echo $rec['idEstadoCar']==$r['idEstadoCar'] ? "selected" : ""; ?>><?php echo $rec['EstadoCar']; ?></option>
                        <?php
                        }
                        mysqli_free_result($cecar);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ini" class="col-sm-3 control-label">Desde</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="ini" name="ini" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($r['FechaIni']); ?>">
                    </div>
                  </div>
                  <div class="form-group<?php echo $r['idEstadoCar']==2 ? "" : " hidden"; ?>" id="pfin">
                    <label for="fin" class="col-sm-3 control-label">Probable fin</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fin" name="fin" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($r['FechaFin']); ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numres" class="col-sm-3 control-label">N° Documento</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numres" name="numres" class="form-control" placeholder="N° Documento" value="<?php echo $r['NumResolucion']; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mot" class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo" value="<?php echo $r['Motivo']; ?>">
                    </div>
                  </div>
<script>
  $('#ini,#fin').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true
  });
  $("#estcar").change(function(){
    var ve = this.value;
    if(ve=='2'){
      $("#pfin").removeClass("hidden");
    }else{
      $("#pfin").addClass("hidden");
      $("#fin").val("");
    }
  });
</script>

  <?php
    }else{
      echo mensajewa("Error: No envio datos válidos.");
    }
  }else{
    echo mensajewa("Error: No se selecciono ningún estado.");
  }
}else{
  echo accrestringidoa();
}
?>