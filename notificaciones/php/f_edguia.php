<?php
session_start();
include 'cone.php';
include 'func.php';
include '../const.php';
$idusu=$_SESSION['idusu'];
if(acceso($cone,$idusu,3)){
	if(isset($_POST['idg']) && !empty($_POST['idg'])){
		$idg=iseguro($cone, $_POST['idg']);
		$cd=mysqli_query($cone,"SELECT g.*, d.Destino FROM guia g INNER JOIN destino d ON g.idDestino=d.idDestino WHERE idGuia=$idg;");
		if($rd=mysqli_fetch_assoc($cd)){
?>
						<h3 class="text-primary text-center">GUÍA N°: <?php echo $rd['Numero']."-".date('Y',strtotime($rd['Fecha'])); ?></h3>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label for="mdes">Destino</label>
                            <input type="hidden" name="idg" value="<?php echo $idg; ?>">
                            <input type="hidden" name="ano" value="<?php echo date('Y',strtotime($rd['Fecha'])); ?>">
                            <select class="form-control" name="mdes" id="mdes">
                              <option value="">DESTINO</option>
	                          <?php
	                          $cde=mysqli_query($cone,"SELECT * FROM destino WHERE Estado=1");
	                          if(mysqli_num_rows($cde)>0){
	                            while($rde=mysqli_fetch_assoc($cde)){
	                          ?>
	                          <option value="<?php echo $rde['idDestino']; ?>" <?php echo $rde['idDestino']==$rd['idDestino'] ? "selected" : ""; ?>><?php echo $rde['Destino']; ?></option>
	                          <?php
	                            }
	                          }
	                          mysqli_free_result($cde);
	                          ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="mfec">Fecha</label>
                            <input type="text" class="form-control" name="mfec" id="mfec" value="<?php echo fnormal($rd['Fecha']); ?>">
                          </div>
                        </div>

                        <div id="r_edguia"></div>
						<script>
							$("#mfec").datepicker({
								format: "dd/mm/yyyy",
							    language: "es",
							    autoclose: true,
							    todayHighlight: true,
			                  startDate: "01/01/<?php echo date('Y',strtotime($rd['Fecha'])); ?>",
			                  endDate: "31/12/<?php echo date('Y',strtotime($rd['Fecha'])); ?>"
							});
						</script>
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