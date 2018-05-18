<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(acceso($cone,$idusu,2)){
	if(isset($_POST['iddoc']) && !empty($_POST['iddoc'])){
		$iddoc=iseguro($cone, $_POST['iddoc']);
		$cd=mysqli_query($cone,"SELECT * FROM documento WHERE idDocumento=$iddoc;");
		if($rd=mysqli_fetch_assoc($cd)){
?>
						            <h3 class="text-primary text-center"><small class="text-blue">N° Doc:</small> <?php echo "D-".$iddoc; ?> <small class="text-blue">Documento:</small> <?php echo $rd['Documento']; ?></h3>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="est">Estado</label>
                            <input type="hidden" name="iddoc" value="<?php echo $iddoc; ?>">
                            <select class="form-control" name="est" id="est">
                              <option value="">Estado</option>
                              <option value="2">Notificado</option>
                              <option value="3">Devuelto</option>
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="fec">Fecha not./dev.</label>
                            <input type="text" class="form-control" name="fec" id="fec" value="<?php echo fnormal($rd['FecNotificacion']) ?>">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label for="mnot">Modo Notificación</label>
                            <select class="form-control" name="mnot" id="mnot">
                              <option value="">Modo Notificación</option>
                              <option value="1">Personal</option>
                              <option value="2">Bajo Puerta</option>
                              <option value="3">No se ubicó dirección</option>
                              <option value="4">Se nego firmar</option>
                              <option value="5">Mesa de partes</option>
                              <option value="6">Familiar</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label for="orie">Observaciones</label>
                            <textarea class="form-control" name="obs" id="obs" rows="3"><?php echo $rd['Observaciones']; ?></textarea>
                          </div>
                        </div>

                        <div id="r_redocumento"></div>
						<script>
							$("#fec").datepicker({
								format: "dd/mm/yyyy",
							    language: "es",
							    autoclose: true,
							    todayHighlight: true
							});
						</script>
<?php
		}else{
			echo mensajewa("No envió datos válidos.");
		}
	}else{
		echo mensajewa("No envió datos.");
	}
}else{
	echo mensajewa("Acceso restingido.");
}
?>