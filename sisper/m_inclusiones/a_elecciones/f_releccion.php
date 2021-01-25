<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],18)){
	if(isset($_POST['acc']) && !empty($_POST['acc'])){
		$acc=iseguro($cone,$_POST['acc']);		
		$v1=iseguro($cone,$_POST['v1']);
		$v2=iseguro($cone,$_POST['v2']);
		if($acc=="agrele"){
            $idem=$_SESSION['identi'];
            
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <div class="col-sm-12 rint">
                <label for="des">Descripcion<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="des" name="des" placeholder="Descripción">
            </div>
            <div class="col-sm-6">
                <label for="ini">Inicia<small class="text-red">*</small></label>
                <div class="input-group date" id="d_ini">
                    <input type="text" class="form-control" id="ini" name="ini" placeholder="dd/mm/aaaa" value="<?php echo date('d/m/Y H:i'); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>  
            <div class="col-sm-6">
                <label for="fin">Finaliza<small class="text-red">*</small></label>
                <div class="input-group date" id="d_fin">
                    <input type="text" class="form-control" id="fin" name="fin" placeholder="dd/mm/aaaa">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
	    <div class="form-group" id="d_frespuesta">
	    </div>
        <script>
            $('#ini, #fin').datetimepicker({
              locale: 'es',
              format: 'DD/MM/YYYY HH:mm',
              useCurrent: true,
            });
        </script>  
<?php
		}elseif($acc=="ediele"){
            $idem=$_SESSION['identi'];
            if(isset($v1) && !empty($v1)){
                $ce=mysqli_query($cone, "SELECT * FROM elecciones WHERE id=$v1;");
                if($re=mysqli_fetch_assoc($ce)){
            
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="id" value="<?php echo $v1; ?>">
            <div class="col-sm-12 rint">
                <label for="des">Descripcion<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="des" name="des" placeholder="Descripción" value="<?php echo $re['nombre'] ?>">
            </div>
            <div class="col-sm-6">
                <label for="ini">Inicia<small class="text-red">*</small></label>
                <div class="input-group date" id="d_ini">
                    <input type="text" class="form-control" id="ini" name="ini" placeholder="dd/mm/aaaa" value="<?php echo ftnormal($re['inicio']); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>  
            <div class="col-sm-6">
                <label for="fin">Finaliza<small class="text-red">*</small></label>
                <div class="input-group date" id="d_fin">
                    <input type="text" class="form-control" id="fin" name="fin" placeholder="dd/mm/aaaa" value="<?php echo ftnormal($re['fin']); ?>">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
        <script>
            $('#ini, #fin').datetimepicker({
              locale: 'es',
              format: 'DD/MM/YYYY HH:mm',
              useCurrent: true,
            });
        </script>  
<?php
                }else{
                    echo mensajewa("Error, datos inválidos.");
                }
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="estele"){
            $idem=$_SESSION['identi'];
            if(isset($v1) && !empty($v1)){
                $ce=mysqli_query($cone, "SELECT nombre, estado FROM elecciones WHERE id=$v1;");
                if($re=mysqli_fetch_assoc($ce)){
            
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="id" value="<?php echo $v1; ?>">
            <div class="col-sm-12 text-center">
                <h4 class="text-primary"><i class="fa fa-info-circle text-yellow"></i> ¿Está seguro que desea <b><?php echo $re['estado']==1 ? 'Desactivar' : 'Activar'; ?></b>, <?php echo $re['nombre'] ?>?</h4>
            </div>
        </div>
        <div class="form-group" id="d_frespuesta">
        </div>
<?php
                }else{
                    echo mensajewa("Error, datos inválidos.");
                }
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="elidoc"){
          if(isset($v1) && !empty($v1)){
            $cd=mysqli_query($cone, "SELECT d.Numero, d.Ano, d.Siglas, d.numdoc, td.TipoDoc FROM doc d INNER JOIN tipodoc td ON d.idTipoDoc=td.idTipoDoc WHERE d.idDoc=$v1;");
            if($rd=mysqli_fetch_assoc($cd)){
?>
        <div class="row text-center">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="v1" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <p class="text-muted"><i class="fa fa-warning text-yellow"></i> ¿Está seguro que desea eliminar este documento?</p>
                <h4 class="text-orange"><i class="fa fa-file-text text-gray"></i> <?php echo $rd['TipoDoc']." ".(!is_null($rd['Numero']) ? $rd['Numero']."-" : "").$rd['Ano']."-".$rd['Siglas'].' <small class="text-muted">[<b>'.$rd['numdoc'].'-'.$rd['Ano'].'</b>]</small>'; ?></h4>
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
            mysqli_free_result($cd);
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="verlis"){
            if(isset($v1) && !empty($v1)){
            $idem=$_SESSION['identi'];

            $ce=mysqli_query($cone, "SELECT * FROM elecciones WHERE id=$v1;");
                if($re=mysqli_fetch_assoc($ce)){
?>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-hover">
                                <tr>
                                    <th><?php echo $re['nombre'] ?></th>
                                    <td><?php echo $re['inicio'] ?></td>
                                    <td><?php echo $re['fin'] ?></td>
                                    <td><?php echo estado($re['estado']) ?></td>
                                    <?php if($re['estado']){ ?>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-info btn-sm" title="Editar" onclick="f_eleccionp('agrlis',<?php echo $re['id'].",0"; ?>)"><i class="fa fa-plus"></i> Agregar Lista</button>
                                    </td>
                                    <?php } ?>
                                </tr>
                                
                            </table>
                        </div>           
                    </div>
                    <div class="row" id="d_listas">
                    </div>  
                    <div class="row" id="d_frespuesta">
                    </div>
                    <script>

                    </script>            
<?php
                }else{
                    echo mensajewa("error, datos inválidos.");
                }
            }else{
                echo mensajewa("Error, faltan datos.");
            }
        }elseif($acc=="agrlis"){
            $idem=$_SESSION['identi'];
            
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="id" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <label for="nom">Nombre<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nombre">
            </div>
            <div class="col-sm-12">
                <label for="des">Descripción<small class="text-red">*</small></label>
                <textarea class="form-control" id="des" name="des" placeholder="Descripción"></textarea>
            </div>  
        </div>
        <div class="form-group" id="d_frespuestap">
        </div>
        <script>
            $("#des").wysihtml5();
        </script>  
<?php
        }elseif($acc=="edilis"){
            $idem=$_SESSION['identi'];

            $cl=mysqli_query($cone, "SELECT * FROM listas WHERE id=$v2;");
            if($rl=mysqli_fetch_assoc($cl)){
            
?>
        <div class="row">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="eleccione_id" value="<?php echo $v1; ?>">
            <input type="hidden" name="id" value="<?php echo $v2; ?>">
            <div class="col-sm-12">
                <label for="nom">Nombre<small class="text-red">*</small></label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nombre" value="<?php echo $rl['nombre'] ?>">
            </div>
            <div class="col-sm-12">
                <label for="des">Descripción<small class="text-red">*</small></label>
                <textarea class="form-control" id="des" name="des" placeholder="Descripción"><?php echo $rl['descripcion'] ?></textarea>
            </div>  
        </div>
        <div class="form-group" id="d_frespuestap">
        </div>
        <script>
            $("#des").wysihtml5();
        </script>  
<?php
            }else{
                echo mensajewa("Datos inválidos");
            }
        }elseif($acc=="elilis"){
          if(isset($v1) && !empty($v1) && isset($v2) && !empty($v2)){
            $cl=mysqli_query($cone, "SELECT * FROM listas WHERE id=$v2;");
            if($rl=mysqli_fetch_assoc($cl)){
?>
        <div class="row text-center">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="eleccione_id" value="<?php echo $v1; ?>">
            <input type="hidden" name="id" value="<?php echo $v2; ?>">
            <div class="col-sm-12">
                <h4 class="text-primary"><i class="fa fa-info-circle text-yellow"></i> ¿Está seguro que desea <b>eliminar</b>, <?php echo $rl['nombre'] ?>?</h4>
            </div>
        </div>
        <div class="form-group" id="d_frespuestap">
        </div>
        <script>
                 
        </script>  
<?php
            }else{
                echo mensajewa("Error, datos inválidos.");
            }
            mysqli_free_result($cl);
          }else{
            echo mensajewa("Error, faltan datos.");
          }
        }elseif($acc=="eliele"){
          if(isset($v1) && !empty($v1)){
            $cl=mysqli_query($cone, "SELECT * FROM elecciones WHERE id=$v1;");
            if($rl=mysqli_fetch_assoc($cl)){
?>
        <div class="row text-center">
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
            <input type="hidden" name="id" value="<?php echo $v1; ?>">
            <div class="col-sm-12">
                <h4 class="text-primary"><i class="fa fa-info-circle text-yellow"></i> ¿Está seguro que desea <b>eliminar</b>, <?php echo $rl['nombre'] ?>?</h4>
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
            mysqli_free_result($cl);
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