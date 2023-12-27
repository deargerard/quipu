<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
	if(isset($_POST['fon']) && !empty($_POST['fon'])){
		$fon=iseguro($cone,$_POST['fon']);		

    $c1=mysqli_query($cone,"select tc.tipo, g.fechacom, g.numerocom, p.razsocial, g.glosacom, g.totalcom, r.codigo from tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN terendicion r ON g.idterendicion=r.idterendicion INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo INNER JOIN teproveedor p ON g.idteproveedor=p.idteproveedor WHERE f.idtefondo=$fon AND g.idteentrega is null AND g.idComServicios is null ORDER BY g.fechacom DESC;");
        if(mysqli_num_rows($c1)>0){
        ?>                
        <table class="table table-bordered table-hover">
          <tr>
            <td>
              <h4 class="text-orange"><i class="fa fa-calendar text-gray"></i> Comprobantes pendientes de pago al <?php echo date("d/m/Y"); ?></h4>                        
            </td>                     
          </tr>
        </table>
        
        <table class="table table-hover table-bordered" id="dtable">
          <thead>
            <tr>
              <th>#</th>
              <th>TIPO</th>
              <th>NUMERO</th>
              <th>RENDICIÓN</th>
              <th>PROVEEDOR</th>
              <th>GLOSA</th>
              <th>FECHA</th>
              <th>MONTO S/</th>             
            </tr>
          </thead>
          <tbody>
            <?php
            $c=0;
            $tc=0;
            while($r1=mysqli_fetch_assoc($c1)){
              $c++;
              $tc=$tc+$r1['totalcom'];
            ?>
            <tr>
              <td><?php echo $c; ?></td>
              <td><?php echo $r1['tipo']; ?></td>
              <td><?php echo $r1['numerocom']; ?></td>
              <td><?php echo $r1['codigo']; ?></td>
              <td><?php echo $r1['razsocial'] ?></td>
              <td><?php echo $r1['glosacom']; ?></td>
              <td><?php echo fnormal($r1['fechacom']); ?></td>
              <td><?php echo $r1['totalcom']; ?></td>              
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        
          <table class="table">
            <tr>
              <td class="text-orange">TOTAL PENDIENTE COMPROBANTES</td>
              <td class="text-orange"><strong><?php echo "S/ ".$tc; ?></strong></td>
            </tr>
          </table>                
              
        <script>
        	$('#dtable').DataTable();
        </script>
<?php
        }else{
          echo mensajewa("No hay comprobantes pendientes de pago.");
        }
    mysqli_free_result($c1);
    $c2=mysqli_query($cone,"SELECT cs.origen, cs.destino, cs.idEmpleado, cs.FechaIni, r.codigo, SUM(g.totalcom) as rendido FROM comservicios cs INNER JOIN terendicion r ON cs.idterendicion=r.idterendicion INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo INNER JOIN tegasto g ON g.idComServicios=cs.idComServicios WHERE cs.estadoren=4 AND f.idtefondo=$fon AND cs.idteentrega is null group by cs.idComServicios;");
        if(mysqli_num_rows($c2)>0){
        ?>                
        <table class="table table-bordered table-hover">
          <tr>
            <td>
              <h4 class="text-orange"><i class="fa fa-calendar text-gray"></i> Viáticos Pendientes de pago al <?php echo date("d/m/Y"); ?></h4>                        
            </td>                     
          </tr>
        </table>
        
        <table class="table table-hover table-bordered" id="dtable1">
          <thead>
            <tr>
              <th>#</th>
              <th>ORIGEN</th>
              <th>DESTINO</th>
              <th>COMISIONADO</th>
              <th>FECHA</th>
              <th>RENDICIÓN</th>
              <th>RENDIDO S/</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $c1=0;
            $tv=0;
            while($r2=mysqli_fetch_assoc($c2)){
              $c1++;
              $tv=$tv+$r2['rendido'];
            ?>
            <tr>
              <td><?php echo $c1; ?></td>
              <td><?php echo $r2['origen']; ?></td>
              <td><?php echo $r2['destino']; ?></td>
              <td><?php echo nomempleado($cone,$r2['idEmpleado']); ?></td>
              <td><?php echo fnormal($r2['FechaIni']); ?></td>
              <td><?php echo $r2['codigo']; ?></td>
              <td><?php echo $r2['rendido']; ?></td>
              
            </tr>
            <?php
            }
            ?>
          </tbody>           
          </table>
          <table class="table">
            <tr>
              <td class="text-orange">TOTAL PENDIENTE VIÁTICOS</td>
              <td class="text-orange"><strong><?php echo "S/ ".$tv; ?></strong></td>
            </tr>
          </table>        
              
          <script>
            $('#dtable1').DataTable();
        </script>
<?php
        }else{
          echo mensajewa("No hay viáticos pendientes de pago.");
        }
    mysqli_free_result($c2);          
    }else{
    	echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
?>