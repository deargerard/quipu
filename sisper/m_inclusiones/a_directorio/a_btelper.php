<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],12)){

if(isset($_POST['per']) && !empty($_POST['per'])){
	$per=iseguro($cone,$_POST['per']);
	$c=mysqli_query($cone,"SELECT idTelefonoEmp, Numero, te.Estado, TipoTelefono FROM telefonoemp te INNER JOIN tipotelefono tt ON te.idTipoTelefono=tt.idTipoTelefono WHERE te.idEmpleado=$per ORDER BY Numero ASC;");
?>
<div class="row">
	<div class="col-md-2">
<?php  
	if(accesoadm($cone,$_SESSION['identi'],12)){
?>
		<button class="btn btn-info" id="b_nuetel" data-toggle="modal" data-target="#m_nuetel" onclick="nuetel(<?php echo $per; ?>)">Nuevo</button>
<?php  
	}
?>
	</div>
	<div class="col-md-10">
		<h4 class="text-aqua"><strong><?php echo nomempleado($cone,$per); ?></strong></h4>
	</div>
</div>
<?php
	if(mysqli_num_rows($c)>0){
?>
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>TIPO</th>
				<th>NÚMERO</th>
<?php
				if(accesoadm($cone,$_SESSION['identi'],12)){
?>
				<th>ACCIÓN</th>
<?php
				}
?>
			</tr>
		</thead>
		<tbody>
<?php
		while ($r=mysqli_fetch_assoc($c)) {
		
?>
			<tr>
				<td><?php echo $r['TipoTelefono']; ?></td>
				<td><?php echo $r['Numero']; ?></td>
<?php
				if(accesoadm($cone,$_SESSION['identi'],12)){
?>
				<td>

                  <div class="btn-group">
                    <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-cog"></i>&nbsp;
                      <span class="caret"></span>
                      <span class="sr-only">Desplegar menú</span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li><a href="#" data-toggle="modal" data-target="#m_editel" onclick="editel(<?php echo $r['idTelefonoEmp'] ?>)">Editar</a></li>
                      <li class="divider"></li>
                      <li><a href="#" data-toggle="modal" data-target="#m_elitel" onclick="elitel(<?php echo $r['idTelefonoEmp'] ?>)">Eliminar</a></li>
                    </ul>
                  </div>

<?php
				}
?>

					
				</td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
<?php
	}else{
		echo mensajewa("No tiene registrado ningún teléfono.");
	}
	mysqli_free_result($c);
	mysqli_close($cone);
}else{
	echo mensajewa("Error: No envió datos.");
}
}else{
  echo accrestringidoa();
}
?>