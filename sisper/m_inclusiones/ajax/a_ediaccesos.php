<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],7)){
              $ide=iseguro($cone,$_POST['ide']);
              if(isset($ide) && !empty($ide)){
                $ce=mysqli_query($cone,"SELECT ApellidoPat, ApellidoMat, Nombres, NumeroDoc FROM empleado WHERE idEmpleado=$ide");
                if($re=mysqli_fetch_assoc($ce)){
?>
                <div class="row">
                  <div class="col-md-2">
                    <img src="<?php echo mfotom($re['NumeroDoc']) ?>" alt="Personal" class="img-thumbnail" width="70">
                  </div>
                  <div class="col-md-10">
                    <h3 class="text-maroon"><?php echo $re['ApellidoPat']." ".$re['ApellidoMat'].", ".$re['Nombres'] ?></h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" id="r_accpersonal">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>MODULO</th>
                          <th>CONSULTAR</th>
                          <th>ADMINISTRAR</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $cm=mysqli_query($cone,"SELECT * FROM modulo WHERE Estado=1 ORDER BY Modulo ASC");
                          while($rm=mysqli_fetch_assoc($cm)){
                            $idmo=$rm['idModulo'];
                        ?>
                        <tr>
                        <?php
                            $cme=mysqli_query($cone,"SELECT Administrar, Consultar FROM empleadomodulo WHERE idEmpleado=$ide and idModulo=$idmo");
                            if($rme=mysqli_fetch_assoc($cme)){
                              if($rme['Consultar']==1){
                        ?>
                          <td><?php echo $rm['Modulo'] ?></td>
                          <td><input type="radio" id="radiob" name="<?php echo $rm['idModulo'] ?>" value="CONSULTAR" checked></td>
                          <td><input type="radio" id="radiob" name="<?php echo $rm['idModulo'] ?>" value="ADMINISTRAR"></td>
                        <?php
                              }elseif($rme['Administrar']==1){
                        ?>
                          <td><?php echo $rm['Modulo'] ?></td>
                          <td><input type="radio" id="radiob" name="<?php echo $rm['idModulo'] ?>" value="CONSULTAR"></td>
                          <td><input type="radio" id="radiob" name="<?php echo $rm['idModulo'] ?>" value="ADMINISTRAR" checked></td>
                        <?php
                              }elseif($rme['Administrar']==0 && $rme['Consultar']==0){
                        ?>
                          <td><?php echo $rm['Modulo'] ?></td>
                          <td><input type="radio" id="radiob" name="<?php echo $rm['idModulo'] ?>" value="CONSULTAR"></td>
                          <td><input type="radio" id="radiob" name="<?php echo $rm['idModulo'] ?>" value="ADMINISTRAR"></td>
                        <?php
                              }
                            }else{
                        ?>
                          <td><?php echo $rm['Modulo'] ?></td>
                          <td><input type="radio" id="radiob" name="<?php echo $rm['idModulo'] ?>" value="CONSULTAR"></td>
                          <td><input type="radio" id="radiob" name="<?php echo $rm['idModulo'] ?>" value="ADMINISTRAR"></td>
                        <?php
                            }
                        ?>
                        </tr>
                        <?php
                          }
                        ?>
                      </tbody>
                    </table>
                    <input type="hidden" name="idpe" value="<?php echo $ide ?>">
                  </div>
                </div>
              <?php
                }else{
              ?>
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="text-maroon">Error: Los datos enviados no son válidos.</h4>
                  </div>
                </div>
              <?php
                }
                mysqli_free_result($cme);
                mysqli_free_result($cm);
                mysqli_close($cone);
              }else{
              ?>
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="text-maroon">Error: No Selecionó un personal.</h4>
                  </div>
                </div>
              <?php
              }
              ?>
<script>
$("input[type='radio']").click(function()
{
  var previousValue = $(this).attr('previousValue');
  var name = $(this).attr('name');

  if (previousValue == 'checked')
  {
    $(this).removeAttr('checked');
    $(this).attr('previousValue', false);
  }
  else
  {
    $("input[name="+name+"]:radio").attr('previousValue', false);
    $(this).attr('previousValue', 'checked');
  }
});
</script>
<?php
}else{
  echo accrestringidoa();
}
?>