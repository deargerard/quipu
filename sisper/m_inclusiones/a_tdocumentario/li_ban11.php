<?php
session_start();
include("../php/conexion_sp.php");
include("../php/funciones.php");
if(accesocon($cone,$_SESSION['identi'],17)){
    $idem=$_SESSION['identi'];
    if(isset($_POST['origen']) && !empty($_POST['origen'])){
        $cm = mysqli_query($cone, "SELECT mp.idtdmesapartes, mp.denominacion FROM tdpersonalmp pm INNER JOIN tdmesapartes mp ON pm.idtdmesapartes=mp.idtdmesapartes WHERE pm.idEmpleado=$idem AND pm.estado=1 AND mp.estado=1;");
        if ($rm = mysqli_fetch_assoc($cm)) {
            $idmp = $rm['idtdmesapartes'];
        }
        $origen=iseguro($cone, $_POST['origen']);
        if($origen==1){
?>
<div class="col-sm-6">
    <h5 class="text-muted text-blue" style="font-weight: 600;"><i class="fa fa-table text-yellow"></i> <?php echo $rm['denominacion']; ?> <span class="text-aqua">(Remitos Generados)</span></h5>
</div>
<div class="col-sm-6">
    <p class="text-right text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-yellow"></i> Alctualizado al <?php echo date('d/m/Y h:i:s A'); ?></p>
</div>
<div class="col-sm-12">
<?php
    $cb=mysqli_query($cone, "SELECT idtdremito, num_remito, peso, fecha_remite, fecha_recepcion, fecha_cargo, destino.denominacion, destino.ambito FROM tdremito JOIN tdmesapartes AS destino ON tdremito.mp_destino = destino.idtdmesapartes WHERE mp_remite=".$idmp." ORDER BY idtdremito DESC LIMIT 100;");
    if(mysqli_num_rows($cb)>0){
?>
        <table class="table table-bordered table-hover" id="dt_ban111">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>REMITO</th>
                    <th>DESTINO</th>
                    <th>PESO</th>
                    <th>FECHA REMITE</th>
                    <th>FECHA RECEPCIÓN</th>
                    <th>FECHA CARGO</th>
                    <th class="text-center">ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
<?php
        while($rb=mysqli_fetch_assoc($cb)){
?>
                <tr style="font-size: 12px;">
                    <td><?php echo $rb['idtdremito']; ?></td>
                    <td class="text-maroon text-bold"><?php echo $rb['num_remito']; ?></td>
                    <td><?php echo $rb['denominacion']; ?></span></td>
                    <td class="text-orange"><?php echo $rb['peso']; ?></td>
                    <td><?php echo $rb['fecha_remite'] ? date('d/m/Y', strtotime($rb['fecha_remite'])) : ''; ?></td>
                    <td><?php echo $rb['fecha_recepcion'] ? date('d/m/Y', strtotime($rb['fecha_recepcion'])) : ''; ?></td>
                    <td><?php echo $rb['fecha_cargo'] ? date('d/m/Y', strtotime($rb['fecha_cargo'])) : ''; ?></td>
                    <td class="text-center">
                          <div class="btn-group">
                            <button class="btn bg-aqua btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-cog"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <?php if(!$rb['fecha_recepcion'] && !$rb['fecha_cargo']){ ?>
                              <li><a href="#" onclick="f_bandeja('edirem',<?php echo $rb['idtdremito'].',0'; ?>)"><i class="fa fa-pencil text-gray"></i> Editar</a></li>
                              <li class="divider"></li>
                              <li><a href="#" onclick="f_bandeja('fecrem',<?php echo $rb['idtdremito'].',0'; ?>)"><i class="fa fa-calendar-check-o text-gray"></i> Fecha remite</a></li>
                                <?php if($rb['ambito']==2){ ?>
                                <li><a href="#" onclick="f_bandeja('fecrec',<?php echo $rb['idtdremito'].',1'; ?>)"><i class="fa fa-calendar-check-o text-gray"></i> Fecha recepción</a></li>
                                <?php } ?>
                              <?php } ?>
                              <li><a href="#" onclick="f_bandeja('feccar',<?php echo $rb['idtdremito'].',0'; ?>)"><i class="fa fa-calendar-check-o text-gray"></i> Fecha cargo</a></li>
                              <li class="divider"></li>
                              <li><a href="#" onclick="f_bandeja('detrem',<?php echo $rb['idtdremito'].','.$idmp; ?>)"><i class="fa fa-file-text text-gray"></i> Detalle</a></li>
                              <?php if(!$rb['fecha_recepcion'] && !$rb['fecha_cargo']){ ?>
                              <li class="divider"></li>
                              <li><a href="#" onclick="f_bandeja('elirem',<?php echo $rb['idtdremito'].',0'; ?>)"><i class="fa fa-trash text-gray"></i> Eliminar</a></li>
                              <?php } ?>
                            </ul>
                          </div>
                    </td>
                </tr>
<?php
        }
?>
            </tbody>
        </table>
        <script>
            $("#dt_ban111").DataTable({
                "order": [[ 0, "desc" ]]
            });
        </script>
<?php
    }else{
        echo mensajewa("Aún no se han registrado remitos.");
    }
    mysqli_free_result($cb);
?>
</div>
<?php
        }elseif($origen==2){
?>
<div class="col-sm-6">
    <h5 class="text-muted text-blue" style="font-weight: 600;"><i class="fa fa-table text-yellow"></i> <?php echo $rm['denominacion']; ?> <span class="text-aqua">(Remitos Recibidos)</span></h5>
</div>
<div class="col-sm-6">
    <p class="text-right text-muted" style="font-size: 11px;"><i class="fa fa-refresh text-yellow"></i> Alctualizado al <?php echo date('d/m/Y h:i:s A'); ?></p>
</div>
<div class="col-sm-12">
<?php
    $cb=mysqli_query($cone, "SELECT idtdremito, num_remito, remite.denominacion, peso, fecha_remite, fecha_recepcion, fecha_cargo FROM tdremito JOIN tdmesapartes AS remite ON tdremito.mp_remite = remite.idtdmesapartes WHERE mp_destino=".$idmp." ORDER BY idtdremito DESC LIMIT 100;");
    if(mysqli_num_rows($cb)>0){
?>
        <table class="table table-bordered table-hover" id="dt_ban111">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>REMITO</th>
                    <th>REMITENTE</th>
                    <th>PESO</th>
                    <th>FECHA REMITE</th>
                    <th>FECHA RECEPCIÓN</th>
                    <th>FECHA CARGO</th>
                    <th class="text-center">ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
<?php
        while($rb=mysqli_fetch_assoc($cb)){
?>
                <tr style="font-size: 12px;">
                    <td><?php echo $rb['idtdremito']; ?></td>
                    <td class="text-aqua"><?php echo $rb['num_remito']; ?></td>
                    <td><?php echo $rb['denominacion']; ?></span></td>
                    <td class="text-orange"><?php echo $rb['peso']; ?></td>
                    <td><?php echo $rb['fecha_remite'] ? date('d/m/Y', strtotime($rb['fecha_remite'])) : ''; ?></td>
                    <td><?php echo $rb['fecha_recepcion'] ? date('d/m/Y', strtotime($rb['fecha_recepcion'])) : ''; ?></td>
                    <td><?php echo $rb['fecha_cargo'] ? date('d/m/Y', strtotime($rb['fecha_cargo'])) : ''; ?></td>
                    <td class="text-center">
                        <?php if(!$rb['fecha_cargo'] && !$rb['fecha_recepcion']){ ?>
                        <button type="button" class="btn btn-info btn-xs" id="btn-recibirmp" title="Recibir" onclick="g_fecharec(<?php echo $rb['idtdremito']; ?>)"><i class="fa fa-check"></i></button>
                        <?php } ?>
                          <div class="btn-group">
                            <button class="btn bg-maroon btn-xs dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-cog"></i>&nbsp;
                              <span class="caret"></span>
                              <span class="sr-only">Desplegar menú</span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <?php if(!$rb['fecha_cargo']){ ?>
                              <li><a href="#" onclick="f_bandeja('fecrec',<?php echo $rb['idtdremito'].',2'; ?>)"><i class="fa fa-calendar-check-o text-gray"></i> Fecha recepción</a></li>
                              <li class="divider"></li>
                              <?php } ?>
                              <li><a href="#" onclick="f_bandeja('detrem',<?php echo $rb['idtdremito'].','.$idmp; ?>)"><i class="fa fa-file-text text-gray"></i> Detalle</a></li>
                            </ul>
                          </div>
                    </td>
                </tr>
<?php
        }
?>
            </tbody>
        </table>
        <script>
            $("#dt_ban111").DataTable({
                "order": [[ 0, "desc" ]]
            });
        </script>
<?php
    }else{
        echo mensajewa("Aún no se han registrado remitos dirigidos a su mesa de partes.");
    }
    mysqli_free_result($cb);
?>
</div>
<?php
        }
    }else{
        echo mensajewa("Error: No se recibieron datos.");
        exit();
    }
}else{
  echo accrestringidoa();
}
mysqli_close($cone);
?>