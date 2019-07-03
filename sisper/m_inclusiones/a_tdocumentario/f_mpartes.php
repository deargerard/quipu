<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],17)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);
		if($acc=="agrmpar"){
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <div class="col-sm-12">
                <label for="mpar">Denominación<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="mpar" name="mpar" placeholder="MESA DE PARTES ÚNICA DE CAJAMARCA">
            </div>
            <div class="col-sm-12">
                <label for="loc">Local<small class="text-red">*</small></label>
                <select class="form-control" id="loc" name="loc" style="width: 100%;">

                </select>
            </div>
        </div>
	    <div class="form-group" id="d_frespuesta">
	    </div>
        <script>
            $("#loc").select2({
              placeholder: 'Selecione un local',
              ajax: {
                url: 'm_inclusiones/a_general/a_sellocal.php',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: data
                  };
                },
                cache: true
              },
              minimumInputLength: 4
            })
        </script>  
<?php
		}elseif($acc=="edimpar"){
            if(isset($_POST['v1']) && !empty($_POST['v1'])){
                $v1=iseguro($cone, $_POST['v1']);
                $cm=mysqli_query($cone, "SELECT * FROM tdmesapartes WHERE idtdmesapartes=$v1;");
                if($rm=mysqli_fetch_assoc($cm)){
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="v1" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <label for="mpar">Denominación<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="mpar" name="mpar" placeholder="MESA DE PARTES ÚNICA DE CAJAMARCA" value="<?php echo $rm['denominacion']; ?>">
            </div>
            <div class="col-sm-12">
                <label for="loc">Local<small class="text-red">*</small></label>
                <select class="form-control" id="loc" name="loc" style="width: 100%;">
                    <option value="<?php echo $rm['idLocal']; ?>"><?php echo dirdisprolocal($cone, $rm['idLocal']); ?></option>
                </select>
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            $("#loc").select2({
              placeholder: 'Selecione un local',
              ajax: {
                url: 'm_inclusiones/a_general/a_sellocal.php',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: data
                  };
                },
                cache: true
              },
              minimumInputLength: 4
            })
        </script>  
<?php
                }else{
                    echo mensajewa("Error, datos invalidos.");
                }
                mysqli_free_result($cm);
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="estmpar"){
          if(isset($_POST['v1']) && !empty($_POST['v1'])){
            $v1=iseguro($cone, $_POST['v1']);
            $cm=mysqli_query($cone, "SELECT * FROM tdmesapartes WHERE idtdmesapartes=$v1;");
            if($rm=mysqli_fetch_assoc($cm)){
?>
        <div class="row text-center">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="v1" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <p class="text-muted"><i class="fa fa-warning text-yellow"></i> ¿Está seguro que desea <?php echo $rm['estado']==1 ? "desactivar" : "activar"; ?> la siguiente mesa de partes?</p>
                <h4 class="text-orange"><i class="fa fa-archive text-gray"></i> <?php echo $rm['denominacion'].'<br><small>'.dirdisprolocal($cone, $rm['idLocal']).'</small>'; ?></h4>
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
                 
        </script>  
<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
            mysqli_free_result($cm);
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="resmpar"){
          if(isset($_POST['v1']) && !empty($_POST['v1'])){
            $v1=iseguro($cone, $_POST['v1']);
            $cm=mysqli_query($cone, "SELECT * FROM tdmesapartes WHERE idtdmesapartes=$v1;");
            if($rm=mysqli_fetch_assoc($cm)){
?>
                <table class="table table-hover">
                    <tr>
                        <th class="text-maroon"><i class="fa fa-archive text-gray"></i> <?php echo $rm['denominacion']; ?></th>
                        <td class="text-muted"><i class="fa fa-street-view text-gray"></i> <?php echo dirdisprolocal($cone, $rm['idLocal']); ?></td>
                        <td class="text-right">
                            <button type="button" class="btn bg-teal btn-sm" onclick="f_mpartesp('agrres', <?php echo $v1; ?>, 0);"><i class="fa fa-user"></i> Responsable</button>
                        </td>
                    </tr>
                </table>
                <div class="row">
                    <div class="col-sm-12" id="li_rmpartes">
                        
                    </div>
                </div>
<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="estres"){
          if(isset($_POST['v1']) && !empty($_POST['v1']) && isset($_POST['v2']) && !empty($_POST['v2'])){
            $v1=iseguro($cone, $_POST['v1']);
            $v2=iseguro($cone, $_POST['v2']);
            $cm=mysqli_query($cone, "SELECT p.*, mp.denominacion FROM tdmesapartes mp INNER JOIN tdpersonalmp p WHERE p.idtdpersonalmp=$v1;");
            if($rm=mysqli_fetch_assoc($cm)){
?>
        <div class="row text-center">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="v1" value="<?php echo $v1; ?>">
            <input type="hidden" name="v2" value="<?php echo $v2; ?>">
            <div class="col-sm-12">
                <p class="text-muted"><i class="fa fa-warning text-yellow"></i> ¿Seguro que desea <?php echo $rm['estado']==1 ? "desactivar" : "activar"; ?> al siguiente personal?</p>
                <h4 class="text-orange"><i class="fa fa-user text-gray"></i> <?php echo nomempleado($cone, $rm['idEmpleado']).'<br><small>'.$rm['denominacion'].'</small>'; ?></h4>
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
                 
        </script>  
<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
            mysqli_free_result($cm);
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="agrres"){
            if(isset($_POST['v1']) && !empty($_POST['v1'])){
                $v1=iseguro($cone, $_POST['v1']);
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="v1" value="<?php echo $v1; ?>">
            <div class="col-sm-12 rint">
                <label for="per">Personal<small class="text-red">*</small></label>
                <select class="form-control" id="per" name="per" style="width: 100%;">

                </select>
            </div>
        </div>
        <div class="form-group" id="d_frespuestap">
        </div>
        <script>
            $("#per").select2({
              placeholder: 'Selecione un personal',
              ajax: {
                url: 'm_inclusiones/a_general/a_selpersonal.php',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                  return {
                    results: data
                  };
                },
                cache: true
              },
              minimumInputLength: 4
            })
        </script>
<?php
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }//acafin
	}else{
		echo mensajewa("Error: Faltan datos.");
	}
}else{
  echo accrestringidoa();
}
mysqli_close($cone);

?>