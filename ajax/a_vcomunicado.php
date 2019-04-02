<?php
    include ("../sisper/m_inclusiones/php/conexion_sp.php");
    include ("../sisper/m_inclusiones/php/funciones.php");
    $idc=iseguro($cone,$_POST["idc"]);
    if(isset($idc) && !empty($idc)){
    	$cco=mysqli_query($cone,"SELECT * FROM comunicado WHERE idComunicado=$idc");
    	$rco=mysqli_fetch_assoc($cco);
?>
	<table class="table">
		<thead>
			<tr>
				<th>
					<span class="text-info" style="font-size: 18px;"><?php echo $rco['Descripcion']; ?></span>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<span class="text-primary"><i class="fa fa-calendar"></i> <?php echo data_text(fnormal($rco['Fecha'])); ?></span>
					<p class="text-justify"><?php echo html_entity_decode($rco['Contenido']); ?></p>
				</td>
			</tr>
			<?php
			if($rco['Adjunto']!=""){
				$arc=$rco['Adjunto'];
				$narc=strtolower(end(explode('_', $arc)));
				$ext=strtolower(end(explode('.', $arc)));
				if ($ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='gif') {		
			?>
			<tr>
				<td>
					<img src="sisper/files_intranet/<?php echo $arc; ?>" class="img-thumbnail img-responsive">
				</td>
			</tr>
			<?php
				}else{
			?>
			<tr>
				<td>
					<i class="fa fa-paperclip"></i> <a href="sisper/files_intranet/<?php echo $arc; ?>" target="_blank"><?php echo $narc; ?></a>
				</td>
			</tr>
			<?php
				}
			}
			?>
		</tbody>
	</table>
	<button class="btn btn-primary" data-dismiss="modal" type="button">
	<i class="fas fa-times"></i>
	Cerrar</button>

<?php
	mysqli_free_result($cco);
	}
?>