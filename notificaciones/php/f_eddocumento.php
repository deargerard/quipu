<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(acceso($cone,$idusu,1)){
	if(isset($_POST['iddoc']) && !empty($_POST['iddoc']) && isset($_POST['res']) && !empty($_POST['res'])){
		$iddoc=iseguro($cone, $_POST['iddoc']);
    $res=iseguro($cone, $_POST['res']);
		$cd=mysqli_query($cone,"SELECT * FROM documento WHERE idDocumento=$iddoc;");
		if($rd=mysqli_fetch_assoc($cd)){
?>
						<h3 class="text-primary text-center">N° Doc: <?php echo "D-".$iddoc; ?></h3>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="pere">Personal</label>
                            <input type="hidden" name="iddoce" value="<?php echo $iddoc; ?>">
                            <input type="hidden" name="res" value="<?php echo $res; ?>">
                            <select class="form-control" name="pere" id="pere">
                            <?php
                              $cp=mysqli_query($cone, "SELECT u.idUsuario, Nombres, Apellidos FROM usuario u INNER JOIN modusu mu ON u.idUsuario=mu.idUsuario WHERE u.Estado=1 AND mu.idModulo=2 ORDER BY Apellidos, Nombres DESC;");
                              if(mysqli_num_rows($cp)>0){
                                while ($rp=mysqli_fetch_assoc($cp)) {
                            ?>
                              <option value="<?php echo $rp['idUsuario'] ?>" <?php echo $rd['idResponsable']==$rp['idUsuario'] ? "selected" : ""; ?>><?php echo $rp['Apellidos'].", ".$rp['Nombres']; ?></option>
                            <?php
                                }
                              }
                              mysqli_free_result($cp);
                            ?>
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="doce">Documento</label>
                            <input type="text" class="form-control" name="doce" id="doce" placeholder="Documento" value="<?php echo $rd['Documento']; ?>">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="orie">Origen</label>
                            <input type="text" class="form-control" name="orie" id="orie" placeholder="Origen" value="<?php echo $rd['Origen']; ?>">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="dese">Destino</label>
                            <input type="text" class="form-control" name="dese" id="dese" placeholder="Destino" value="<?php echo $rd['Destino']; ?>">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="fece">Fecha de recepción</label>
                            <input type="text" class="form-control" name="fece" id="fece" value="<?php echo fnormal($rd['FecRecepcion']); ?>">
                          </div>
                        </div>

                        <div id="r_eddocumento"></div>
						<script>
							$("#fece").datepicker({
								format: "dd/mm/yyyy",
							    language: "es",
							    autoclose: true,
							    todayHighlight: true
							});
              $("#doce").keypress(function(e){
                  if(e.which==13){
                      e.preventDefault();
                      e.stopPropagation();
                      $("#orie").focus();
                  }
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