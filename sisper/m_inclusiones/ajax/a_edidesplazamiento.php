<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id=iseguro($cone,$_POST["id"]);
    $c=mysqli_query($cone, "SELECT * FROM cardependencia WHERE idCarDependencia=$id;");
    if($r=mysqli_fetch_assoc($c)){
  ?>
                  <div class="form-group">
                    <label for="dep" class="col-sm-3 control-label">Dependencia</label>
                    <div class="col-sm-9 valida">
                      <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                      <select name="dep" id="dep" class="form-control select2" style="width: 100%;">
                        <option value="">DEPENDENCIA</option>
                        <?php
                        $cd=mysqli_query($cone, "SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1;");
                        if(mysqli_num_rows($cd)>0){
                          while($rd=mysqli_fetch_assoc($cd)){
                        ?>
                        <option value="<?php echo $rd['idDependencia']; ?>" <?php echo $rd['idDependencia']==$r['idDependencia'] ? "selected" : ""; ?>><?php echo $rd['Denominacion']; ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tipdes" class="col-sm-3 control-label">Tipo Desplazamiento</label>
                    <div class="col-sm-6 valida">
                      <select name="tipdes" id="tipdes" class="form-control">
                        <option value="">TIPO DESPLAZAMIENTO</option>
                        <?php
                          $ctd=mysqli_query($cone,"SELECT * FROM tipodesplaza WHERE Estado=1");
                          while($rtd=mysqli_fetch_assoc($ctd)){
                            if($r['idTipoDesplaza']==1){
                        ?>
                        <option value="<?php echo $rtd['idTipoDesplaza'] ?>" <?php echo $rtd['idTipoDesplaza']==$r['idTipoDesplaza'] ? "selected" : "disabled"; ?>><?php echo $rtd['TipoDesplaza'] ?></option>
                        <?php
                            }else{
                        ?>
                        <option value="<?php echo $rtd['idTipoDesplaza'] ?>" <?php echo $rtd['idTipoDesplaza']==$r['idTipoDesplaza'] ? "selected" : ""; echo $rtd['idTipoDesplaza']==1 ? "disabled" : ""; ?>><?php echo $rtd['TipoDesplaza'] ?></option>
                        <?php
                            }
                          }
                          mysqli_free_result($ctd);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ini" class="col-sm-3 control-label">Inicia</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="ini" name="ini" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($r['FecInicio']); ?>" <?php echo $r['idTipoDesplaza']==1 ? "readonly" : ""; ?>>
                    </div>
                  </div>
                  <div class="form-group <?php echo $r['idTipoDesplaza']==1 ? "hidden" : ""; ?>">
                    <label for="fin" class="col-sm-3 control-label">Probable fin</label>
                    <div class="col-sm-3 valida">
                      <input type="text" id="fin" name="fin" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo fnormal($r['FecFin']); ?>" <?php echo $r['idTipoDesplaza']==1 ? "readonly" : ""; ?>>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="numres" class="col-sm-3 control-label">N° Documento</label>
                    <div class="col-sm-6 valida">
                      <input type="text" id="numres" name="numres" class="form-control" placeholder="N° Documento" value="<?php echo $r['NumResolucion']; ?>" <?php echo $r['idTipoDesplaza']==1 ? "readonly" : ""; ?>>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="mot" class="col-sm-3 control-label">Motivo</label>
                    <div class="col-sm-9 valida">
                      <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo" value="<?php echo $r['Motivo']; ?>" <?php echo $r['idTipoDesplaza']==1 ? "readonly" : ""; ?>>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ofi" class="col-sm-3 control-label">Oficial para Lima</label>
                    <div class="col-sm-9 valida checkbox">
                      <label><input type="checkbox" id="ofi" name="ofi" value="1" <?php echo $r['Oficial']==1 ? "checked" : ""; ?>>Sí</label>
                    </div>
                  </div>
<script>
  $('<?php echo $r['idTipoDesplaza']==1 ? "" : "#fin, #ini"; ?>').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true
  });
  $(".select2").select2();
</script>
  <?php
    }else{
      echo mensajewa("Error: No se envio datos válidos.");
    }
    mysqli_free_result($c);
  }else{
    echo mensajewa("Error: No se envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>