<?php
    include ("../php/conexion_sp.php");
    include ("../php/funciones.php");
    $idc=iseguro($cone,$_POST["idc"]);
    if(isset($idc) && !empty($idc)){
    	$cco=mysqli_query($cone,"SELECT * FROM comunicado WHERE idComunicado=$idc");
    	$rco=mysqli_fetch_assoc($cco);
?>
	<table class="table">
		<thead>
			<tr>
				<th>
					<span class="text-orange" style="font-size: 18px;"><?php echo $rco['Descripcion']; ?></span>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<span class="text-primary"><?php echo data_text(fnormal($rco['Fecha'])); ?></span>
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
					<img src="files_intranet/<?php echo $arc; ?>" class="img-thumbnail img-responsive">
				</td>
			</tr>
			<?php
				}else{
			?>
			<tr>
				<td>
					<i class="fa fa-paperclip"></i> <a href="files_intranet/<?php echo $arc; ?>" target="_blank"><?php echo $narc; ?></a>
				</td>
			</tr>
			<?php
				}
			}
			?>
		</tbody>
	</table>

<?php
	mysqli_free_result($cco);
	}
?>