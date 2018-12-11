<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],16)){
	if(isset($_POST['ide']) && !empty($_POST['ide'])){    
		$ide=iseguro($cone,$_POST['ide']);   
      $c1=mysqli_query($cone,"SELECT * FROM teentrega WHERE idteentrega=$ide");
      if ($r1=mysqli_fetch_assoc($c1)) {        
?>
      <br>
      <table class="table table-hover table-bordered">
        <tr>
          <th class="text-blue"><h4>Entrega de dinero a : </h4></th>
          <th class="text-blue"><h4><?php echo nomempleado($cone,$r1['idEmpleado']); ?></h4></th>
          <th class="text-blue"><h4> por : <?php echo $r1['motivo']; ?></h4></th>                   
          <td align="right">
            <div class="btn-group btn-group-sm" role="group" aria-label="...">
              <button type="button" class="btn btn-info" title="Agregar" onclick="fo_entregas('agrdent',<?php echo $ide ?>,0)"><i class="fa fa-plus"></i> Agregar</button>                           
              <button type="button" class="btn btn-info" title="Regresar" onclick="bentregas(<?php echo $r1['idEmpleado']; ?>);"><i class="fa fa-chevron-circle-left"></i></button>
            </div>
          </td>
        </tr>        
      </table>      
      <table class="table table-hover table-bordered" id="dtable">
        <thead>
          <tr>
            <th>N°</th>
            <th>TIPO</th>
            <th>NÚMERO</th>
            <th>MOVIMIENTO</th>
            <th>MONTO</th>
            <th>FECHA</th>            
            <th>ACCIÓN</th>
          </tr>
        </thead>
        <tbody>
<?php
          $c=0;
          $c2=mysqli_query($cone,"SELECT de.*, e.motivo, e.idEmpleado, e.idteentrega FROM tedocentrega de INNER JOIN teentrega e ON e.idteentrega = de.idteentrega WHERE de.idteentrega=$ide");
          while($r2=mysqli_fetch_assoc($c2)){
            $c++;
?>
            <tr>
              <td><?php echo $c; ?></td>
              <td><?php echo $r2['tipo']==1 ? "VALE" : "RECIBO" ; ?></td>
              <td><?php echo $r2['numero']; ?></td>
              <td><?php echo $r2['tipmov']==1 ? "ADELANTO" : "DEVOLUCIÓN" ; ; ?></td>
              <td><?php echo $r2['monto']; ?></td>
              <td><?php echo $r2['fecha']; ?></td>              
              <td>
                <div class="btn-group btn-group-xs" role="group" aria-label="Basic">
                  <?php if(accesocon($cone,$_SESSION['identi'],16)){ ?>
                  <button type="button" class="btn btn-default" title="Editar" onclick="fo_entregas('edident',<?php echo $r2['idteentrega'] .','. $r2['idtedocentrega']; ?>)"><i class="fa fa-pencil"></i></button>
                  <button type="button" class="btn btn-default" title="Eliminar" onclick="fo_entregas('elident',<?php echo $r2['idteentrega'] .','. $r2['idtedocentrega']; ?>)"><i class="fa fa-trash"></i></button>
                  <?php } ?>
                  
                </div>
              </td>
            </tr>
<?php
          }
?>
        </tbody>
      </table>
      <script>
        $('#dtable').DataTable();
      </script>
<?php
       }
    
    mysqli_free_result($c2);
  }else{
  	echo mensajeda("Error: No se recibieron datos.");
  }
}else{
  echo accrestringidoa();
}
?>