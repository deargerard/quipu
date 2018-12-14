<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
	if(isset($_POST['acc']) && !empty($_POST['acc']) && isset($_POST['v1']) && !empty($_POST['v1'])){
		$acc=iseguro($cone,$_POST['acc']);
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);

		if($acc=="verpla"){
			if(accesocon($cone,$_SESSION['identi'],16)){
				$cc=mysqli_query($cone, "SELECT cs.*, d.Numero, d.Ano, d.Siglas, e.ApellidoPat, e.ApellidoMat, e.Nombres, e.NumeroDoc, td.TipoDoc FROM comservicios cs INNER JOIN doc d ON cs.idDoc=d.idDoc INNER JOIN empleado e ON cs.idEmpleado=e.idEmpleado INNER JOIN tipodoc td ON d.idTipoDoc=d.idTipoDoc WHERE idComServicios=$v1;");
				if($rc=mysqli_fetch_assoc($cc)){
					$idec=idecxidexfecha($cone, $rc['idEmpleado'], date('Y-m-d', strtotime($rc['FechaIni'])));
?>
				<table class="table table-bordered table-hover">
					<tr>
						<th>Apellidos y Nombres</th>
						<td colspan="8"><?php echo $rc['ApellidoPat']." ".$rc['ApellidoMat']." ".$rc['Nombres']; ?></td>
					</tr>
					<tr>
						<th>Dependencia</th>
						<td colspan="3"><?php echo dependenciaxiecxfecha($cone, $idec, date('Y-m-d', strtotime($rc['FechaIni']))); ?></td>
						<th colspan="2">D.N.I.</th>
						<td colspan="3"><?php echo $rc['NumeroDoc']; ?></td>
					</tr>
					<tr>
						<th>Cargo</th>
						<td colspan="3"><?php echo cargoiec($cone, idecxidexfecha($cone, $rc['idEmpleado'], date('Y-m-d', strtotime($rc['FechaIni'])))); ?></td>
						<th colspan="2">Regimen</th>
						<td colspan="3"><?php echo condicionlabxiec($cone, $idec); ?></td>
					</tr>
					<tr>
						<th>Mnemonico</th>
						<td><?php echo $rc['mnemonico']; ?></td>
						<th colspan="2">N° de Cuenta</th>
						<td colspan="5"></td>
					</tr>
					<tr>
						<th>Lugar de la comisión</th>
						<td><?php echo disprodep($cone, $rc['idDistrito']); ?></td>
						<th colspan="2">Doc. Autoriza</th>
						<td colspan="5"><?php echo $rc['TipoDoc']." ".$rc['Numero']."-".$rc['Ano']."-".$rc['Siglas']; ?></td>
					</tr>
					<tr>
						<th>Motivo de la comisión</th>
						<td colspan="9"></td>
					</tr>
					<tr>
						<th>Hora salida</th>
						<td><?php echo date('d/m/Y', strtotime($rc['FechaIni'])); ?></td>
						<th colspan="2">Hora retorno</th>
						<td colspan="3"><?php echo date('d/m/Y', strtotime($rc['FechaFin'])); ?></td>
						<th colspan="2">TOTAL HORAS</th>
					</tr>
					<tr>
						<th>Fecha salida</th>
						<td><?php echo date('H:i:s', strtotime($rc['FechaIni'])); ?></td>
						<th colspan="2">Fecha retorno</th>
						<td colspan="3"><?php echo date('H:i:s', strtotime($rc['FechaFin'])); ?></td>
						<th colspan="2">TOTAL HORAS</th>
					</tr>
					
				</table>
<?php
				}else{
					echo mensajewa("Datos inválidos.");
				}
				mysqli_free_result($cc);
			}else{
			  echo accrestringidoa();
			}
		}elseif($acc=="ediren"){
			$c2=mysqli_query($cone,"SELECT idtemeta, trendicion FROM terendicion WHERE idterendicion=$v1;");
			if($r2=mysqli_fetch_assoc($c2)){
				$pev=true;
				$c3=mysqli_query($cone, "SELECT idtegasto FROM tegasto WHERE idterendicion=$v1;");
				if(mysqli_num_rows($c3)>0){
					$pev=false;
				};
				mysqli_free_result($c3);
				$c4=mysqli_query($cone,"SELECT idcomservicios FROM comservicios WHERE idterendicion=$v1;");
				if(mysqli_num_rows($c4)>0){
					$pev=false;
				};
				mysqli_free_result($c4);
?>
		  <div class="row">
		    <div class="col-sm-8">
		    	<div class="form-group">
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="idr" value="<?php echo $v1; ?>">
			      <input type="hidden" name="po" value="<?php echo $pev; ?>">
			      <label for="met">Meta<small class="text-red">*</small></label>
			      <select class="form-control" name="met" id="met">
			      	<option value="">Meta</option>
<?php
				$c1=mysqli_query($cone, "SELECT m.*, f.nombre AS fondo FROM temeta m INNER JOIN tefondo f ON m.idtefondo=f.idtefondo WHERE m.estado=1 ORDER BY fondo, nombre DESC;");
				if(mysqli_num_rows($c1)>0){
					while($r1=mysqli_fetch_assoc($c1)){
?>
						<option value="<?php echo $r1['idtemeta']; ?>" <?php echo $r1['idtemeta']==$r2['idtemeta'] ? "selected" : ""; ?>><?php echo $r1['fondo']." / ".$r1['nombre']." (".$r1['mnemonico'].")"; ?></option>
<?php
					}
				}
				mysqli_free_result($c1);
?>
		      	  </select>
		      	</div>
		    </div>
		    <div class="col-sm-4 <?php echo !$pev ? "hidden" : "" ?>">
		    	<div class="form-group">
		    		<label for="tr">Tipo Rendición<small class="text-red">*</small></label>
			    	<select class="form-control" name="tr" id="tr">
			    		<option value="">TIPO RENDICIÓN</option>
			    		<option value="1" <?php echo $r2['trendicion']==1 ? "selected" : ""; ?>>FONDOS Y PROGRAMAS</option>
			    		<option value="2" <?php echo $r2['trendicion']==2 ? "selected" : ""; ?>>VIÁTICOS</option>
			    	</select>
			    </div>
		    </div>
		  </div>
		  <div id="d_frespuesta">
		  	
		  </div>
<?php
			}else{
				echo mensajewa("Datos inválidos");
			}
			mysqli_free_result($c2);
		}elseif($acc=="agrdoc"){
			if($v2==1){
?>
			<div class="row">
			    <div class="col-sm-7 esin">
					<div class="form-group">
			    	  <label for="esp">Especifica<small class="text-red">*</small></label>
				      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
				      <input type="hidden" name="v1" value="<?php echo $v1; ?>">
				      <input type="hidden" name="v2" value="<?php echo $v2; ?>">
				      <select class="form-control select2" id="esp" name="esp" style="width: 100%;">
				      	<option value="">ESPECIFICA</option>
	<?php
						$ce=mysqli_query($cone,"SELECT * FROM teespecifica WHERE estado=1 ORDER BY nombre ASC;");
						if(mysqli_num_rows($ce)>0){
							while($re=mysqli_fetch_assoc($ce)){
	?>
						<option value="<?php echo $re['idteespecifica'] ?>"><?php echo $re['nombre']; ?></option>
	<?php
							}
						}
						mysqli_free_result($ce);
	?>
				  		</select>
				  	</div>
			    </div>
			    <div class="col-sm-5 esin">
			    	<div class="form-group">
					    <label for="feccom">Fecha Comprobante<small class="text-red">*</small></label>
					    <div class="has-feedback">
					      <input type="text" class="form-control" id="feccom" name="feccom" placeholder="dd/mm/aaaa" autocomplete="off">
					      <span class="fa fa-calendar form-control-feedback"></span>
						</div>
					</div>
			    </div>
			    <div class="col-sm-7 esin">
			    	<div class="form-group">
				      	<label for="tcom">Tipo Comprobante<small class="text-red">*</small></label>
				      	<select class="form-control select2" id="tcom" name="tcom" style="width: 100%;">
				      		<option value="">TIPO COMPROBANTE</option>
<?php
					$ctd=mysqli_query($cone,"SELECT * FROM tetipocom WHERE estado=1 ORDER BY tipo ASC;");
					if(mysqli_num_rows($ctd)>0){
						while($rtd=mysqli_fetch_assoc($ctd)){
?>
					<option value="<?php echo $rtd['idtetipocom'] ?>"><?php echo $rtd['tipo']; ?></option>
<?php
						}
					}
					mysqli_free_result($ctd);
?>
			      		</select>
			      	</div>
			    </div>
			    <div class="col-sm-2 esin">
			    	<div class="form-group">
				      <label for="sercom">Serie<small class="text-red">*</small></label>
				      <input type="text" class="form-control" id="sercom" name="sercom" placeholder="B001">
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="numcom">Número<small class="text-red">*</small></label>
				      <input type="text" class="form-control" id="numcom" name="numcom" placeholder="56234">
				    </div>
			    </div>
			    <div class="col-sm-12 esin">
					<div class="form-group">
				      <label for="des">Descripción<small class="text-red">*</small></label>
				      <input type="text" class="form-control" id="des" name="des" placeholder="Descripción">
					</div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="imp">Importe<small class="text-red">*</small></label>
				      <input type="number" class="form-control" id="imp" name="imp" placeholder="0.00" step="0.01">
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="can">Cantidad</label>
				      <input type="number" class="form-control" id="can" name="can" placeholder="0.00" step="0.01">
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="uni">Unidad Medida</label>
				      <select name="uni" id="uni" class="form-control" style="width: 100%;">
				      		<option value="">Ninguno</option>
<?php
						$cum=mysqli_query($cone, "SELECT idteumedida, umedida, abreviatura FROM teumedida WHERE estado=1 ORDER BY umedida ASC;");
						if(mysqli_num_rows($cum)>0){
							while($rum=mysqli_fetch_assoc($cum)){
?>
							<option value="<?php echo $rum['idteumedida']; ?>"><?php echo $rum['umedida']." [".$rum['abreviatura']."]"; ?></option>
<?php
							}
						}
						mysqli_free_result($cum);
?>
				      </select>
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="codser">Cod. Serv.</label>
				      <input type="text" class="form-control" id="codser" name="codser" placeholder="F524Y">
				    </div>
			    </div>
			    <div class="col-sm-9 esin">
			    	<div class="form-group">
				      <label for="pro">Proveedor<small class="text-red">*</small></label>
				      <select class="form-control select2pro" id="pro" name="pro" style="width: 100%;">

				      </select>
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				    	<label>&nbsp;</label>
				    	<button type="button" class="btn btn-default btn-block" onclick="fo_rendiciones1('agrpro',1,0);"><i class="fa fa-plus"></i> Agregar</button>
				    </div>
			    </div>
			    <div class="col-sm-12 esin">
			    	<div class="form-group">
				      <label for="dep">Dependencia<small class="text-red">*</small></label>
				      <select class="form-control select2dep" id="dep" name="dep" style="width: 100%;">

				      </select>
				    </div>
			    </div>
				<div id="d_frespuesta">
				  	
				</div>
			</div>
			  <script>
			  	$(".select2").select2();
			  	$(".select2pro").select2({
				  placeholder: 'Seleccione proveedor',
				  ajax: {
				    url: 'm_inclusiones/a_tesoreria/bu_proveedores.php',
				    dataType: 'json',
				    delay: 250,
				    processResults: function (data) {
				      return {
				        results: data
				      };
				    },
				    cache: true
				  },
				  minimumInputLength: 3
				});
				$(".select2dep").select2({
				  placeholder: 'Seleccione dependencia',
				  ajax: {
				    url: 'm_inclusiones/a_tesoreria/bu_dependencias.php',
				    dataType: 'json',
				    delay: 250,
				    processResults: function (data) {
				      return {
				        results: data
				      };
				    },
				    cache: true
				  },
				  minimumInputLength: 3
				});
				$('#feccom').datepicker({
				    format: 'dd/mm/yyyy',
				    autoclose: true,
				    minViewMode: 0,
				    maxViewMode: 2,
				    todayHighlight: true
				});
			  </script>
<?php
			}elseif($v2==2){
				echo "VIÁTICOS";
			}
		}elseif($acc=="edidoc"){
			if($v2==1){
				$cg=mysqli_query($cone, "SELECT * FROM tegasto WHERE idtegasto=$v1;");
				if($rg=mysqli_fetch_assoc($cg)){
?>
			<div class="row">
			    <div class="col-sm-7 esin">
					<div class="form-group">
			    	  <label for="esp">Especifica<small class="text-red">*</small></label>
				      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
				      <input type="hidden" name="v1" value="<?php echo $v1; ?>">
				      <input type="hidden" name="v2" value="<?php echo $v2; ?>">
				      <input type="hidden" name="idre" value="<?php echo $rg['idterendicion']; ?>">
				      <select class="form-control select2" id="esp" name="esp" style="width: 100%;">
				      	<option value="">ESPECIFICA</option>
	<?php
						$ce=mysqli_query($cone,"SELECT * FROM teespecifica WHERE estado=1 ORDER BY nombre ASC;");
						if(mysqli_num_rows($ce)>0){
							while($re=mysqli_fetch_assoc($ce)){
	?>
						<option value="<?php echo $re['idteespecifica'] ?>" <?php echo $re['idteespecifica']==$rg['idteespecifica'] ? "selected" : ""; ?>><?php echo $re['nombre']; ?></option>
	<?php
							}
						}
						mysqli_free_result($ce);
	?>
				  		</select>
				  	</div>
			    </div>
			    <div class="col-sm-5 esin">
			    	<div class="form-group">
					    <label for="feccom">Fecha Comprobante<small class="text-red">*</small></label>
					    <div class="has-feedback">
					      <input type="text" class="form-control" id="feccom" name="feccom" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rg['fechacom']); ?>">
					      <span class="fa fa-calendar form-control-feedback"></span>
						</div>
					</div>
			    </div>
			    <div class="col-sm-7 esin">
			    	<div class="form-group">
				      	<label for="tcom">Tipo Comprobante<small class="text-red">*</small></label>
				      	<select class="form-control select2" id="tcom" name="tcom" style="width: 100%;">
				      		<option value="">TIPO COMPROBANTE</option>
<?php
					$ctd=mysqli_query($cone,"SELECT * FROM tetipocom WHERE estado=1 ORDER BY tipo ASC;");
					if(mysqli_num_rows($ctd)>0){
						while($rtd=mysqli_fetch_assoc($ctd)){
?>
					<option value="<?php echo $rtd['idtetipocom']; ?>" <?php echo $rtd['idtetipocom']==$rg['idtetipocom'] ? "selected" : ""; ?>><?php echo $rtd['tipo']; ?></option>
<?php
						}
					}
					mysqli_free_result($ctd);
?>
			      		</select>
			      	</div>
			    </div>
<?php
				$nc=explode('-',$rg['numerocom']);
?>
			    <div class="col-sm-2 esin">
			    	<div class="form-group">
				      <label for="sercom">Serie<small class="text-red">*</small></label>
				      <input type="text" class="form-control" id="sercom" name="sercom" placeholder="B001" value="<?php echo $nc['0']; ?>">
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="numcom">Número<small class="text-red">*</small></label>
				      <input type="text" class="form-control" id="numcom" name="numcom" placeholder="56234" value="<?php echo $nc['1']; ?>">
				    </div>
			    </div>
			    <div class="col-sm-12 esin">
					<div class="form-group">
				      <label for="des">Descripción<small class="text-red">*</small></label>
				      <input type="text" class="form-control" id="des" name="des" placeholder="Descripción" value="<?php echo $rg['glosacom']; ?>">
					</div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="imp">Importe<small class="text-red">*</small></label>
				      <input type="number" class="form-control" id="imp" name="imp" placeholder="0.00" step="0.01" value="<?php echo $rg['totalcom']; ?>">
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="can">Cantidad</label>
				      <input type="number" class="form-control" id="can" name="can" placeholder="0.00" step="0.01" value="<?php echo $rg['cantidadcom']; ?>">
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="uni">Unidad Medida</label>
				      <select name="uni" id="uni" class="form-control" style="width: 100%;">
				      		<option value="">Ninguno</option>
<?php
						$cum=mysqli_query($cone, "SELECT idteumedida, umedida, abreviatura FROM teumedida WHERE estado=1 ORDER BY umedida ASC;");
						if(mysqli_num_rows($cum)>0){
							while($rum=mysqli_fetch_assoc($cum)){
?>
							<option value="<?php echo $rum['idteumedida']; ?>" <?php echo $rum['idteumedida']==$rg['idteumedida'] ? "selected" : ""; ?>><?php echo $rum['umedida']." [".$rum['abreviatura']."]"; ?></option>
<?php
							}
						}
						mysqli_free_result($cum);
?>
				      </select>
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				      <label for="codser">Cod. Serv.</label>
				      <input type="text" class="form-control" id="codser" name="codser" placeholder="F524Y" value="<?php echo $rg['codservicio']; ?>">
				    </div>
			    </div>
			    <div class="col-sm-9 esin">
			    	<div class="form-group">
				      <label for="pro">Proveedor<small class="text-red">*</small></label>
				      <select class="form-control select2pro" id="pro" name="pro" style="width: 100%;">
<?php
					$idpr=$rg['idteproveedor'];
					$cp=mysqli_query($cone, "SELECT idteproveedor, razsocial FROM teproveedor WHERE idteproveedor=$idpr;");
					if($rp=mysqli_fetch_assoc($cp)){
?>
						<option value="<?php echo $rp['idteproveedor']; ?>"><?php echo $rp['razsocial']; ?></option>
<?php
					}
					mysqli_free_result($cp);
?>

				      </select>
				    </div>
			    </div>
			    <div class="col-sm-3 esin">
			    	<div class="form-group">
				    	<label>&nbsp;</label>
				    	<button type="button" class="btn btn-default btn-block" onclick="fo_rendiciones1('agrpro',1,0);"><i class="fa fa-plus"></i> Agregar</button>
				    </div>
			    </div>
			    <div class="col-sm-12 esin">
			    	<div class="form-group">
				      <label for="dep">Dependencia<small class="text-red">*</small></label>
				      <select class="form-control select2dep" id="dep" name="dep" style="width: 100%;">
<?php
					$idde=$rg['idDependencia'];
					$cd=mysqli_query($cone, "SELECT idDependencia, Denominacion FROM dependencia WHERE idDependencia=$idde;");
					if($rd=mysqli_fetch_assoc($cd)){
?>
						<option value="<?php echo $rd['idDependencia']; ?>"><?php echo $rd['Denominacion']; ?></option>
<?php
					}
					mysqli_free_result($cd);
?>
				      </select>
				    </div>
			    </div>
				<div id="d_frespuesta">
				  	
				</div>
			</div>
			  <script>
			  	$(".select2").select2();
			  	$(".select2pro").select2({
				  placeholder: 'Seleccione proveedor',
				  ajax: {
				    url: 'm_inclusiones/a_tesoreria/bu_proveedores.php',
				    dataType: 'json',
				    delay: 250,
				    processResults: function (data) {
				      return {
				        results: data
				      };
				    },
				    cache: true
				  },
				  minimumInputLength: 3
				});
				$(".select2dep").select2({
				  placeholder: 'Seleccione dependencia',
				  ajax: {
				    url: 'm_inclusiones/a_tesoreria/bu_dependencias.php',
				    dataType: 'json',
				    delay: 250,
				    processResults: function (data) {
				      return {
				        results: data
				      };
				    },
				    cache: true
				  },
				  minimumInputLength: 3
				});
				$('#feccom').datepicker({
				    format: 'dd/mm/yyyy',
				    autoclose: true,
				    minViewMode: 0,
				    maxViewMode: 2,
				    todayHighlight: true
				});
			  </script>
<?php
				}else{
					echo mensajewa("Error, datos inválidos.");
				}
				mysqli_free_result($cg);
			}elseif($v2==2){
				echo "VIÁTICOS";
			}
		}elseif($acc=="elidoc"){
			$cg=mysqli_query($cone, "SELECT glosacom, totalcom, idterendicion FROM tegasto WHERE idtegasto=$v1;");
			if($rg=mysqli_fetch_assoc($cg)){
?>
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="v1" value="<?php echo $v1; ?>">
			      <input type="hidden" name="v2" value="<?php echo $v2; ?>">
			      <input type="hidden" name="idre" value="<?php echo $rg['idterendicion']; ?>">
				<table class="table table-bordered">
					<tr>
						<td align="center">
							<i class="fa fa-warning text-red"></i> <b>Eliminará el comprobante por:</b>
						</td>
					</tr>
					<tr>
						<td align="center">
							<?php echo $rg['glosacom']." | S/ ".$rg['totalcom']; ?>
						</td>
					</tr>
				</table>
				<div id="d_frespuesta">
				  	
				</div>
<?php
			}else{
				echo mensajewa("Error, datos inválidos.");
			}
			mysqli_free_result($cg);
		}elseif($acc=="agrpro"){
?>
		  <div class="form-group">
		    <label for="razsoc">Razón Social<small class="text-red">*</small></label>
		    <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		    <input type="text" class="form-control" id="razsoc" name="razsoc" placeholder="Razón Social">
		  </div>
		  <div class="form-group">
		    <label for="ruc">RUC<small class="text-red">*</small></label>
		    <input type="text" class="form-control" id="ruc" name="ruc" placeholder="12345678">
		  </div>
		  <div class="form-group">
		    <label for="dir">Dirección</label>
		    <input type="text" class="form-control" id="dir" name="dir" placeholder="Dirección">
		  </div>
		  <div class="form-group">
		    <label for="tel">Teléfono</label>
		    <input type="text" class="form-control" id="tel" name="tel" placeholder="Teléfono">
		  </div>
		  <div id="d1_frespuesta">
				  	
		  </div>
<?php
		}elseif($acc=="estren"){
			$cg=mysqli_query($cone, "SELECT codigo, mes, anio, estado FROM terendicion WHERE idterendicion=$v1;");
			if($rg=mysqli_fetch_assoc($cg)){
?>
			      <input type="hidden" name="acc" value="<?php echo $acc; ?>">
			      <input type="hidden" name="v1" value="<?php echo $v1; ?>">
			      <input type="hidden" name="es" value="<?php echo $rg['estado']; ?>">
				<table class="table table-bordered">
					<tr>
						<td align="center">
							<i class="fa fa-warning text-red"></i> <b><?php echo $rg['estado']==1 ? "Archivará" : "Reabrirá"; ?> la rendición:</b>
						</td>
					</tr>
					<tr>
						<td align="center">
							<?php echo $rg['codigo']." | ".strtoupper(nombremes($rg['mes']))." de ".$rg['anio']; ?>
						</td>
					</tr>
				</table>
				<div id="d_frespuesta">
				  	
				</div>
<?php
			}else{
				echo mensajewa("Error, datos inválidos.");
			}
			mysqli_free_result($cg);
		}//acafin
	}else{
		echo mensajewa("Error: Faltan datos.");
	}

mysqli_close($cone);
?>