<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
  if(isset($_POST['tra']) && !empty($_POST['tra'])){
  $tra=iseguro($cone, $_POST["tra"]); 
    if ($tra=="t") {
      $wtra="";
      }else{
      $wtra="WHERE idEmpleado=$tra";
          } 

        if ($tra!=="t") {
?>      
        <div class="col-md-10">
          
          <h4 class="text-orange"><strong><i class="fa fa-user"></i> <?php echo nomempleado($cone,$tra); ?> </strong></h4>
          </div>
      <div class="col-md-2">
<?php
        if(accesoadm($cone,$_SESSION['identi'],16)){ ?>
            <button type="button" class="btn btn-info btn-sm" onclick="fo_entregas('agrent',<?php echo $tra; ?>,0)"><i class="fa fa-plus"></i> Agregar</button>
<?php 
        } 
?>
      </div>
<?php      
        }
?>     
      <hr>
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12" id="r_bent">
<?php
            $ca=mysqli_query($cone,"SELECT * FROM teentrega $wtra ORDER BY idteentrega DESC LIMIT 100;");

?>
            <table id="dtable" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
<?php 
                  if ($tra=="t") {
?>
                  <th>EMPLEADO</th>
<?php      
        }
?>
                  <th>MOTIVO</th>
                  <th>ACCIÓN</th>
                </tr>
              </thead>
              <tbody>
          <?php
              $n=0;
              while($ra=mysqli_fetch_assoc($ca)){
                $n++;                          
          ?>
                <tr>
                  <td><?php echo $n; ?></td>
<?php 
                  if ($tra=="t") {
?>
                  <td><?php echo nomempleado($cone,$ra["idEmpleado"]);?></td>
<?php      
        }
?>                  
                  <td><?php echo $ra["motivo"]; ?></td>
                  
                                                      
                  <td>
                    <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                      <button type="button" class="btn btn-default" title="Editar" onclick="fo_entregas('edient',<?php echo ($tra=="t" ? $ra["idEmpleado"] : $tra) .','. $ra['idteentrega'] ?>)"><i class="fa fa-pencil"></i></button>
                      <button type="button" class="btn btn-default" title="Eliminar" onclick="fo_entregas('elient',<?php echo ($tra=="t" ? $ra["idEmpleado"] : $tra) .','. $ra['idteentrega'] ?>)"><i class="fa fa-trash"></i></button>
                      <button type="button" class="btn btn-default" title="ir" onclick="ldocentregas(<?php echo $ra['idteentrega'] ?>)"><i class="fa fa-chevron-circle-right"></i></button>
                    </div>
                  </td>                 
                </tr>
          <?php
              }
              mysqli_free_result($ca);
          ?>
              </tbody>
            </table>
        </div>
      </div>
<script>
	  $('#dtable').DataTable();
</script>
<?php
  }else{
      echo mensajewa("Seleccione a un trabajador");
    }
}else{
  echo accrestringidoa();
}
?>