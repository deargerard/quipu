<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
	if(isset($_POST['anob']) && !empty($_POST['anob'])){
		$anob=iseguro($cone,$_POST['anob']);		

    $c1=mysqli_query($cone,"select g.idteentrega, g.idtegasto, tc.abreviatura, g.fechacom, g.numerocom, g.glosacom, g.totalcom, p.razsocial, p.ruc from tegasto g INNER JOIN tetipocom tc ON g.idtetipocom=tc.idtetipocom INNER JOIN terendicion r ON g.idterendicion=r.idterendicion INNER JOIN temeta m ON r.idtemeta=m.idtemeta INNER JOIN tefondo f ON m.idtefondo=f.idtefondo INNER JOIN teproveedor p ON g.idteproveedor=p.idteproveedor WHERE date_format(g.fechacom, '%Y')='$anob' ORDER BY g.fechacom DESC;");
        if(mysqli_num_rows($c1)>0){
        ?>      
        <table class="table table-hover table-bordered" id="dtable">
          <thead>
            <tr>
              <th>FECHA</th>
              <th>COMPROBANTE</th>              
              <th>GLOSA</th>
              <th>PROVEEDOR</th>              
              <th>MONTO S/</th>
              <th>ESTADO</th>             
            </tr>
          </thead>
          <tbody>
            <?php            
            $tc=0;
            while($r1=mysqli_fetch_assoc($c1)){             
              $tc=$tc+$r1['totalcom'];
            ?>
            <tr>              
              <td><?php echo fnormal($r1['fechacom']); ?></td>
              <td><?php echo $r1['abreviatura']." ".$r1['numerocom']; ?></td>
              <td><?php echo $r1['glosacom']; ?></td>
              <td><?php echo $r1['razsocial']."(".$r1['ruc'].")"; ?></td>              
              <td><?php echo $r1['totalcom']; ?></td>
              <td>
                <?php if($r1['idteentrega'] != null){ ?>            
                <button type="button" class="btn btn-success btn-xs" title="Estado" onclick="fo_det(<?php echo $r1['idteentrega']; ?>)">Rendido</button>
                <?php }else { ?>
                <button type="button" class="btn btn-danger btn-xs" title="Estado"> Pendiente</button>
                <?php } ?>                              
              </td> <!--columna ESTADO-->               
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        
          <table class="table">
            <tr>
              <td class="text-orange">MONTO TOTAL DE COMPROBANTES REGISTRADOS EN EL AÑO <?php echo $anob; ?></td>
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
             
    }else{
    	echo mensajeda("Error: No se recibieron datos.");
    }
}else{
  echo accrestringidoa();
}
?>