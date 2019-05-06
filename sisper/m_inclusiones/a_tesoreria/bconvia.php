<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
	if(isset($_POST['anob']) && !empty($_POST['anob'])){
		$anob=iseguro($cone,$_POST['anob']);		

    $c1=mysqli_query($cone,"Select e.idEmpleado, count(distinct(g.idComServicios)) comisiones, sum(g.totalcom) gasto FROM empleado e INNER JOIN comservicios cs ON e.idEmpleado=cs.idEmpleado INNER JOIN tegasto g ON cs.idComServicios=g.idComServicios where date_format(g.fechacom, '%Y')=$anob group by e.idEmpleado order by gasto desc;");
        if(mysqli_num_rows($c1)>0){
        ?>      
        <table class="table table-hover table-bordered" id="dtablev">
          <thead>
            <tr>
              <th>#</th>
              <th>EMPLEADO</th>              
              <th>NRO COMISIONES</th>
              <th>MONTO CONSUMIDO S/</th>                                         
            </tr>
          </thead>
          <tbody>
            <?php            
            $c=0;
            while($r1=mysqli_fetch_assoc($c1)){             
              $c++;
            ?>
            <tr>              
              <td><?php echo $c; ?></td>
              <td><?php echo nomempleado($cone, $r1['idEmpleado']); ?></td>
              <td><?php echo $r1['comisiones']; ?></td>
              <td><?php echo $r1['gasto']; ?></td>                            
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
                     
        <script>
        	$('#dtablev').DataTable();
        </script>
<?php
        }else{
          echo mensajewa("No hay datos que mostrar.");
        }
    mysqli_free_result($c1);
             
    }else{
    	echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
?>