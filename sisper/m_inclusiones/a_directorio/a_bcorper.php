<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],12)){

if(isset($_POST['per1']) && !empty($_POST['per1'])){
	$per=iseguro($cone,$_POST['per1']);
	$c=mysqli_query($cone,"SELECT CorreoIns, CorreoPer FROM empleado WHERE idEmpleado=$per;");
?>
<div class="row">
	<div class="col-md-12">
		<h4 class="text-aqua"><strong><?php echo nomempleado($cone,$per); ?></strong></h4>
	</div>
</div>
<?php
	if($r=mysqli_fetch_assoc($c)){
?>
	<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>TIPO</th>
				<th>CORREO</th>
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
			<tr>
				<td>INSTITUCIONAL</td>
				<td><?php echo $r['CorreoIns']=="" ? "Sin correo" : $r['CorreoIns']; ?></td>
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
                      <li><a href="#" data-toggle="modal" data-target="#m_edicor" onclick="edicor(<?php echo $per ?>,1)">Editar</a></li>
                    </ul>
                  </div>

<?php
				}
?>

					
				</td>
			</tr>
			<tr>
				<td>PERSONAL</td>
				<td><?php echo $r['CorreoPer']=="" ? "Sin correo" : $r['CorreoPer']; ?></td>
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
                      <li><a href="#" data-toggle="modal" data-target="#m_edicor" onclick="edicor(<?php echo $per ?>,2)">Editar</a></li>
                    </ul>
                  </div>

<?php
				}
?>

					
				</td>
			</tr>
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