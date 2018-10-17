<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
  if(isset($_POST['fecb']) && !empty($_POST['fecb'])){
    $ids=$_SESSION['identi'];
    $fec=iseguro($cone, $_POST["fec"]);
    $fecini=fmysql("01/".$fec);
    $fecfin=strtotime('+ 1 month',strtotime ($fecini) );
    $fecfin=date('Y-m-j', $fecfin);
    $fecfin=strtotime('- 1 day',strtotime ($fecfin) );
    $fecfin=date('Y-m-j', $fecfin);
    ?>   
      <div class="row">
        <div class="col-md-12" id="r_basig">
          <?php
            $ca=mysqli_query($cone,"SELECT * FROM teasignacion WHERE (Fecha BETWEEN '$fecini' AND '$fecfin') ;");
          ?>
            <table id="dtasig" class="table table-bordered table-hover">
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
                  <td><?php echo ftnormal($ra["Fecha"]) ?></td>
                  <td><?php echo $ra["tipo"]; ?></td>
                  <td><?php echo $ra["meta"]; ?></td>
                  <td><?php echo $ra["monto"]; ?></td> 
                  <td>
                    
                    <div class="btn-group">
                      <button class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cog"></i>&nbsp;
                        <span class="caret"></span>
                        <span class="sr-only">Desplegar menú</span>
                      </button>
                      <ul class="dropdown-menu pull-right" role="menu">                                    
                        <li><a href="#" onclick="easignacion(<?php echo $ra['idAtencion']; ?>)" data-toggle="modal" data-target="#m_eatencion"><i class="fa fa-pencil"></i> Editar</a></li>
                        <li><a href="#" onclick="dasignacion(<?php echo $ra['idAtencion']; ?>)" data-toggle="modal" data-target="#m_ratencion"><i class="fa fa-share"></i> Reasignar</a></li>
                        
                      </ul>
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
	  $('#dtasig').DataTable();
</script>
<?php
  }else{
      echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
?>