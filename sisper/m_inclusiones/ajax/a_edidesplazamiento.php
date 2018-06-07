<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1)){
  if(isset($_POST["id"]) && !empty($_POST["id"]) && isset($_POST["acc"]) && !empty($_POST["acc"])){
    $id=iseguro($cone,$_POST["id"]);
    $acc=iseguro($cone,$_POST["acc"]);

    if($acc=="edat"){
      $c=mysqli_query($cone, "SELECT * FROM cardependencia WHERE idCarDependencia=$id;");
      if($r=mysqli_fetch_assoc($c)){
    ?>
                    <div class="form-group">
                      <label for="dep" class="col-sm-3 control-label">Dependencia</label>
                      <div class="col-sm-9 valida">
                        <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
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
                            $td=$r['idTipoDesplaza']==1 ? "AND idTipoDesplaza=1" : "AND idTipoDesplaza!=1";
                            $q="SELECT * FROM tipodesplaza WHERE Estado=1 $td";
                            $ctd=mysqli_query($cone,$q);
                            while($rtd=mysqli_fetch_assoc($ctd)){

                          ?>
                          <option value="<?php echo $rtd['idTipoDesplaza'] ?>" <?php echo $rtd['idTipoDesplaza']==$r['idTipoDesplaza'] ? "selected" : ""; ?>><?php echo $rtd['TipoDesplaza'] ?></option>
                          <?php
                            }
                            mysqli_free_result($ctd);
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="numres" class="col-sm-3 control-label">N° Documento</label>
                      <div class="col-sm-6 valida">
                        <input type="text" id="numres" name="numres" class="form-control" placeholder="N° Documento" value="<?php echo $r['NumResolucion']; ?>" <?php echo $r['idTipoDesplaza']==1 ? "readonly" : ""; ?>>
                      </div>
                      <div class="col-sm-3">
                        <?php echo $r['idTipoDesplaza']==1 ? "<i class='fa fa-exclamation-circle text-orange'></i> <small>Editable al editar cargo</small>" : ""; ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="mot" class="col-sm-3 control-label">Motivo</label>
                      <div class="col-sm-9 valida">
                        <input type="text" id="mot" name="mot" class="form-control" placeholder="Motivo" value="<?php echo $r['Motivo']; ?>" <?php echo $r['idTipoDesplaza']==1 ? "readonly" : ""; ?>>
                      </div>
                    </div>
                    <div id="r_edesplazamiento" class="text-center">
                      
                    </div>
                    <script>
                      $(".select2").select2();
                    </script>
    <?php
      }else{
        echo mensajewa("Error: No se envio datos válidos.");
      }
      mysqli_free_result($c);

    }elseif($acc=="eofi"){
      $c=mysqli_query($cone, "SELECT idEmpleadoCargo, idDependencia FROM cardependencia WHERE idCarDependencia=$id;");
      if($r=mysqli_fetch_assoc($c)){
    ?>
        <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
        <input type="hidden" name="iec" value="<?php echo $r['idEmpleadoCargo'] ?>">
        <p class="text-center">Esta por <b>oficializar para Lima</b> la siguiente dependencia:</p>
        <h4 class="text-maroon text-center"><?php echo nomdependencia($cone, $r['idDependencia']); ?><br><small><?php echo cargoiec($cone,$r['idEmpleadoCargo']); ?></small></h4>
        <div id="r_edesplazamiento" class="text-center">
                      
        </div>
    <?php
      }else{
        echo mensajewa("Datos incorrectos");
      }
      mysqli_free_result($c);
    }elseif($acc=="efin"){
      $c=mysqli_query($cone, "SELECT idEmpleadoCargo, idDependencia, FecInicio, FecFin FROM cardependencia WHERE idCarDependencia=$id;");
      if($r=mysqli_fetch_assoc($c)){
?>
                    <div class="form-group">
                      <label for="fini" class="col-sm-3 control-label">Fecha Inicio</label>
                      <div class="col-sm-9 valida">
                        <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="iec" value="<?php echo $r['idEmpleadoCargo'] ?>">
                        <input type="hidden" name="finise" value="<?php echo fnormal($r['FecInicio']) ?>">
                        <input type="text" id="fini" name="fini" class="form-control" placeholder="mm/dd/aaaa" value="<?php echo fnormal($r['FecInicio']); ?>" autocomplete="off">
                      </div>
                    </div>
                    <div id="r_edesplazamiento" class="text-center">
                      
                    </div>
                    <script>
                      $("#fini").datepicker({
                        format: "dd/mm/yyyy",
                        language: "es",
                        autoclose: true,
                        todayHighlight: true,
                        <?php if($r['FecFin']!=""){ ?>
                        endDate: <?php echo '"'.fnormal($r['FecFin']).'"'; ?>
                        <?php } ?>
                      });
                    </script>
<?php
      }else{
        echo mensajewa("Datos incorrectos");
      }
      mysqli_free_result($c);
    }elseif($acc=="effi"){
      $c=mysqli_query($cone, "SELECT idEmpleadoCargo, idDependencia, FecInicio, FecFin FROM cardependencia WHERE idCarDependencia=$id;");
      if($r=mysqli_fetch_assoc($c)){
?>
                    <div class="form-group">
                      <label for="ffin" class="col-sm-3 control-label">Fecha Fin</label>
                      <div class="col-sm-9 valida">
                        <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="acc" value="<?php echo $acc; ?>">
                        <input type="hidden" name="iec" value="<?php echo $r['idEmpleadoCargo'] ?>">
                        <input type="hidden" name="ffinse" value="<?php echo fnormal($r['FecFin']) ?>">
                        <input type="text" id="ffin" name="ffin" class="form-control" placeholder="mm/dd/aaaa" value="<?php echo fnormal($r['FecFin']); ?>" autocomplete="off">
                      </div>
                    </div>
                    <div id="r_edesplazamiento" class="text-center">
                      
                    </div>
                    <script>
                      $("#ffin").datepicker({
                        format: "dd/mm/yyyy",
                        language: "es",
                        autoclose: true,
                        todayHighlight: true,
                        <?php if($r['FecInicio']!=""){ ?>
                        startDate: <?php echo '"'.fnormal($r['FecInicio']).'"'; ?>
                        <?php } ?>
                      });
                    </script>
<?php
      }else{
        echo mensajewa("Datos incorrectos");
      }
      mysqli_free_result($c);
    }
  }else{
    echo mensajewa("Error: No se envió datos.");
  }
}else{
  echo accrestringidoa();
}
?>