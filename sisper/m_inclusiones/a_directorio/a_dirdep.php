<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],12)){
	$dep=iseguro($cone,$_POST["dep"]);
	if(isset($dep) && !empty($dep)){
    $cdep=mysqli_query($cone,"SELECT Denominacion FROM dependencia WHERE idDependencia=$dep");
    $rdep=mysqli_fetch_assoc($cdep)
?>
<div class="row">
  <div class="col-sm-2">
    <button id="b_nuetel" class="btn btn-info" data-toggle="modal" data-target="#m_ntelefono" onclick="nueteld(<?php echo $dep ?>)">Nuevo</button>
  </div>
  <div class="col-sm-10">
    <h4 class="text-aqua"><strong><?php echo $rdep['Denominacion']?> </strong></h4>
  </div>
</div>
<br>
  <table id="dtdir" class="table table-bordered table-hover">
		  <thead>
				<tr>
					<th>AMBIENTE</th>
          <th>NUMERO</th>
          <th>TIPO</th>
					<th>ACCIÓN</th>
				</tr>
			</thead>
			<tbody>
				<?php
						$camb=mysqli_query($cone,"SELECT dl.idDependenciaLocal, dl.Estado, t.Tipo, dl.Oficina, l.Direccion, p.Piso, td.Numero, tt.TipoTelefono, td.idTelefonoDep FROM dependencialocal as dl INNER JOIN local AS l ON dl.idLocal=l.idLocal INNER JOIN tipolocal AS t ON dl.idTipoLocal= t.idTipoLocal INNER JOIN piso AS p ON dl.idPiso=p.idPiso INNER JOIN telefonodep AS td ON dl.idDependenciaLocal=td.idDependenciaLocal INNER JOIN tipotelefono AS tt ON td.idTipoTelefono=tt.idTipoTelefono WHERE dl.idDependencia=$dep and dl.Estado=1");
					if(mysqli_num_rows($camb)>0){
						while($ramb=mysqli_fetch_assoc($camb)){
				?>
				<tr>
					<td><?php echo $ramb['Tipo']?> - <?php echo $ramb['Oficina']?> - <?php echo $ramb['Piso']?> - <?php echo $ramb['Direccion']?></td>
					<td><?php echo $ramb['Numero']?></td>
					<td><?php echo $ramb['TipoTelefono']?></td>
          <td>
            <div class="btn-group">
              <button class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-cog"></i>&nbsp;
                <span class="caret"></span>
                <span class="sr-only">Desplegar menú</span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="#" data-toggle="modal" data-target="#m_editel" onclick="editeld(<?php echo $ramb['idTelefonoDep'].", ".$dep ?>)">Editar</a></li>
                <li><a href="#" data-toggle="modal" data-target="#m_elitelefono" onclick="eliteld(<?php echo $ramb['idTelefonoDep'].", '".$ramb['TipoTelefono'].": ".$ramb['Numero']." de ".$ramb['Tipo']."-".$ramb['Oficina']."-".$ramb['Piso']."-".$ramb['Direccion']."'" ?>)">Eliminar</a></li>
              </ul>
            </div>
          </td>
				</tr>
				<?php
					}
				}else{
				?>
				<tr>
					<td colspan="4" class="text-maroon text-center">Esta dependencia no cuenta con teléfono</td>
				</tr>
				<?php
				}
						mysqli_free_result($camb);
				?>
			</tbody>
		</table>
	<?php
		mysqli_close($cone);
	}else{
		echo "<h4 class='text-maroon'>Error: No se seleccionó ninguna dependencia.</h4>";
	}
}else{
  echo accrestringidoa();
}
?>
