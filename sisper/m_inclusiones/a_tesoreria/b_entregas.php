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
            $ca=mysqli_query($cone,"SELECT e.idteentrega, e.empleado, e.motivo, e.idEmpleado, sum(de.monto) tot FROM teentrega e INNER JOIN tedocentrega de ON e.idteentrega=de.idteentrega $wtra group by e.idteentrega ORDER BY idteentrega DESC LIMIT 600;");
            
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
                  <th>MONTO S/</th>
                  <th>PAGADO POR</th>
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
                    $cd=mysqli_query($cone,"SELECT g.idtegasto, g.numerocom, g.glosacom, g.totalcom, g.fechacom FROM tegasto g left JOIN comservicios cs ON g.idComServicios=cs.idComServicios WHERE g.idteentrega=$ide OR cs.idteentrega=$ide;");
                    if(mysqli_num_rows($cd)>0){           
                        while($rd=mysqli_fetch_assoc($cd)){            
                            $sdc=$sdc+$rd['totalcom'];
                        }
                    }
                    mysqli_free_result($cd);
                    $ee=n_2decimales($sde-$sdc);
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
                  <td><?php echo $ra["tot"]; ?></td>
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
              $anio = date("Y");
              $tasi=0;  
              $ca=mysqli_query($cone,"SELECT sum(monto) tasi FROM new_bdcaj.teasignacion WHERE date_format(fecha, '%Y')='$anio';");
                if ($ra=mysqli_fetch_assoc($ca)) {
                  $tasi=$ra['tasi'];
                }     

                mysqli_free_result($ca);
             $tpag=0;
              $cp=mysqli_query($cone,"SELECT SUM(de.monto) tpag FROM teentrega e INNER JOIN tedocentrega de ON e.idteentrega=de.idteentrega WHERE de.tipmov=1 AND date_format(fecha, '%Y')='$anio';");
                if ($rp=mysqli_fetch_assoc($cp)){
                  $tpag=$rp['tpag'];
                }

                mysqli_free_result($cp);
              $tdev=0;  
              $cd=mysqli_query($cone,"SELECT SUM(de.monto) tdev FROM teentrega e INNER JOIN tedocentrega de ON e.idteentrega=de.idteentrega WHERE de.tipmov=2 AND date_format(fecha, '%Y')='$anio';");
                if($rd=mysqli_fetch_assoc($cd)){
                  $tdev=$rd['tdev'];
                }

                mysqli_free_result($cd);
              $sal=0;
              $ttpa=$tpag-$tdev;
              $sal=$tasi-$ttpa;

          ?>
              </tbody>
            </table>
            <table class="table table-hover table-bordered">               
              <thead>
                <tr>
                  <th>ASIGNACIONES:</th>
                  <th class="text-maroon"><?php  echo "S/  ".n_2decimales($tasi); ?></th>
                  <th>PAGOS:</th>
                  <th class="text-maroon"><?php echo "S/  ".n_2decimales($ttpa); ?></th>
                  <th>SALDO:</th>
                  <th class="text-maroon"><?php echo "S/  ".n_2decimales($sal); ?></th>
                </tr>
              </thead>
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