<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(acceso($cone,$idusu,3)){
	if(isset($_POST['idd']) && !empty($_POST['idd'])){
		$idd=iseguro($cone, $_POST['idd']);
		$cd=mysqli_query($cone,"SELECT * FROM doc WHERE idDoc=$idd;");
		if($rd=mysqli_fetch_assoc($cd)){
?>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="mtip">Tipo</label>
                            <input type="hidden" name="idd" value="<?php echo $idd; ?>">
                            <select class="form-control" id="mtip" name="mtip">
                              <option value="">TIPO</option>
                              <?php
                              $ctd=mysqli_query($cone,"SELECT * FROM tipodoc WHERE Estado=1 ORDER BY Tipo ASC;");
                              if(mysqli_num_rows($ctd)>0){
                                while ($rtd=mysqli_fetch_assoc($ctd)) {
                              ?>
                              <option value="<?php echo $rtd['idTipoDoc']; ?>" <?php echo $rtd['idTipoDoc']==$rd['idTipoDoc'] ? "selected" : ""; ?>><?php echo $rtd['Tipo']; ?></option>
                              <?php
                                }
                              }
                              mysqli_free_result($ctd);
                              ?>
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="mnum">Número</label>
                            <input type="text" class="form-control" name="mnum" id="mnum" placeholder="Numero" value="<?php echo $rd['Numero']; ?>">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="mori">Origen</label>
                            <input type="text" class="form-control" name="mori" id="mori" value="<?php echo $rd['Origen']; ?>">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="mrem">Remitente</label>
                            <input type="text" class="form-control" name="mrem" id="mrem" value="<?php echo $rd['Remitente']; ?>">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="mdes">Destino</label>
                            <input type="text" class="form-control" name="mdes" id="mdes" value="<?php echo $rd['Destino']; ?>">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="mdest">Destinatario</label>
                            <input type="text" class="form-control" name="mdest" id="mdest" value="<?php echo $rd['Destinatario']; ?>">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="mdcar" name="mdcar" value="si" <?php echo $rd['Cargo']==1 ? "checked" : ""; ?>> Devolución cargo
                              </label>
                            </div>
                          </div>
                        </div>

                        <div id="r_eddoc"></div>
<?php
		}else{
			echo mensajewa("No envió datos válidos.");
		}
    mysqli_free_result($cd);
	}else{
		echo mensajewa("No envió datos.");
	}
}else{
	echo mensajewa("Acceso restingido.");
}
?>