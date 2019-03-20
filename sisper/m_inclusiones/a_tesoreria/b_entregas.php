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
            $ca=mysqli_query($cone,"SELECT * FROM teentrega $wtra ORDER BY idteentrega DESC LIMIT 200;");
?>
            <table id="dtable" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
<?php 
                  if ($tra=="t") {
?>
                  <th>NOMBRE</th>
<?php      
        }
?>
                  <th>MOTIVO</th>
                  <th>POR</th>
                  <th>ESTADO</th>
                  <th>ACCIÓN</th>
                </tr>
              </thead>
              <tbody>
          <?php
              $n=0;
              $ee=0;
              $est="";
              $col="";
              while($ra=mysqli_fetch_assoc($ca)){
                $n++;
                $ide=$ra['idteentrega'];
                    $sde=0; 
                    $ce=mysqli_query($cone,"SELECT de.*, e.motivo, e.idEmpleado, e.idteentrega, e.empleado FROM tedocentrega de INNER JOIN teentrega e ON e.idteentrega = de.idteentrega WHERE de.idteentrega=$ide");
                    if(mysqli_num_rows($ce)>0){
                          while($re=mysqli_fetch_assoc($ce)){            
                            if($re['tipmov']==1){
                              $sde=$sde+$re['monto'];
                            }elseif($re['tipmov']==2){
                              $sde=$sde-$re['monto'];
                            }
                        }
                      }
                    mysqli_free_result($ce);
                    $sdc=0;
                    $cd=mysqli_query($cone,"SELECT g.idtegasto, g.numerocom, g.glosacom, g.totalcom, g.fechacom, tc.tipo FROM tegasto g INNER JOIN tetipocom tc ON g.idtetipocom = tc.idtetipocom WHERE g.idteentrega=$ide;");
                    if(mysqli_num_rows($cd)>0){           
                        while($rd=mysqli_fetch_assoc($cd)){            
                            $sdc=$sdc+$rd['totalcom'];
                        }
                    }
                    mysqli_free_result($cd);
                    $ee=$sde-$sdc;
                    if ($ee==0) {
                      $est="Pagado";
                      $col="success";      
                    }else{
                      $est="Pendiente";
                      $col="danger";
                    }
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
                  <td><?php echo nomempleado($cone, $ra['empleado']); ?></td>
                  <td><span class="label label-<?php echo $col;?>"><?php echo $est; ?></span></td>
                                                      
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