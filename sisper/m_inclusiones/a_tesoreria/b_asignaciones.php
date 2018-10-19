<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
  if(isset($_POST['fecb']) && !empty($_POST['fecb'])){    
    $ids=$_SESSION['identi'];
    $fec=iseguro($cone, $_POST["fecb"]);
    $fecini=fmysql("01/".$fec);
    $fecfin=strtotime('+ 1 month',strtotime ($fecini) );
    $fecfin=date('Y-m-j', $fecfin);
    $fecfin=strtotime('- 1 day',strtotime ($fecfin) );
    $fecfin=date('Y-m-j', $fecfin);
    $fecb=explode('/',iseguro($cone,$_POST['fecb']));
    $mes=$fecb[0];
    $anio=$fecb[1];    
    ?>   
      <div class="col-md-10">
                    <h4 class="text-orange"><i class="fa fa-calendar text-gray"></i> <?php echo ucfirst(nombremes($mes))." de ".$anio; ?></h4>
                  </div>
                  <div class="col-md-2">
                    <?php if(accesoadm($cone,$_SESSION['identi'],16)){ ?>
                    <button type="button" class="btn btn-info btn-sm" onclick="fo_asignaciones('agrasig',<?php echo $mes.",".$anio; ?>)"><i class="fa fa-plus"></i> Agregar</button>
                    <?php } ?>
                  </div>
                  <div class="clearfix"></div>


      <div class="row">
        <div class="col-md-12" id="r_basig">
          <?php
            $ca=mysqli_query($cone,"SELECT * FROM teasignacion WHERE (Fecha BETWEEN '$fecini' AND '$fecfin') ;");
          ?>
            <table id="dtable" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>FECHA</th>
                  <th>TIPO</th>
                  <th>META</th>
                  <th>MONTO S/</th>
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
                  <td><?php echo fnormal($ra["fecha"]) ?></td>
                  <td><?php echo $ra["tipo"]; ?></td>
                  <td><?php echo $ra["idtemeta"]; ?></td>
                  <td><?php echo $ra["monto"]; ?></td> 
                  <td>                    
                    <td>
                      <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                        <button type="button" class="btn btn-default" title="Editar" onclick="fo_asignaciones('ediasig',<?php echo $ra['idteasignacion'].",0"; ?>)"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-default" title="Eliminar" onclick="fo_asignaciones('eliasig',<?php echo $ra['idteasignacion'].",0"; ?>)"><i class="fa fa-times-circle"></i></button>
                        <button type="button" class="btn btn-default" title="Ir" onclick="fo_asignaciones('infasig',<?php echo $ra['idteasignacion'].",0"; ?>)"><i class="fa fa-chevron-circle-right"></i></button>
                      </div>
                    </td>
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
      echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
?>