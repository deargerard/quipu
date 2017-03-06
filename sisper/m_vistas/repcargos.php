<?php
if(isset($_SESSION['identi']) && !empty($_SESSION['identi'])){
  if(accesocon($cone,$_SESSION['identi'],1)){
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reporte
      </h1>
      <ol class="breadcrumb">
        <li><a href="dboard.php"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Personal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           <!-- Default box -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Cargos por Dependencia</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body">
                  <form action="" id="f_repcargos" class="form-horizontal">
                    <div class="form-group">
                      <label for="cargo" class="col-sm-1 control-label">Cargo</label>
                      <div class="col-sm-4 valida">
                        <select name="cargo" id="cargo" class="form-control">
                          <option value="">CARGO</option>
                          <option value="t">TODOS</option>
                      <?php
                        $ccar=mysqli_query($cone,"SELECT idCargo, Denominacion, SistemaLab FROM cargo as ca INNER JOIN sistemalab as sl ON ca.idSistemaLab=sl.idSistemaLab WHERE ca.Estado=1 ORDER BY SistemaLab, Denominacion ASC");
                        while($rcar=mysqli_fetch_assoc($ccar)){
                      ?>
                        <option value="<?php echo $rcar['idCargo'] ?>"><?php echo substr($rcar['SistemaLab'],0,1).'-'.$rcar['Denominacion'] ?></option>
                      <?php
                        }
                        mysqli_free_result($ccar);
                      ?>
                        </select>
                      </div>
                      <label for="depen" class="col-sm-1 control-label">Dependencia</label>
                      <div class="col-sm-6 valida">
                        <select name="depen" id="depen" class="form-control">
                          <option value="">DEPENDENCIA</option>
                          <option value="t">TODAS</option>
                      <?php
                        $cdep=mysqli_query($cone,"SELECT idDependencia, Denominacion FROM dependencia WHERE Estado=1 ORDER BY Denominacion ASC");
                        while($rdep=mysqli_fetch_assoc($cdep)){
                      ?>
                        <option value="<?php echo $rdep['idDependencia'] ?>"><?php echo $rdep['Denominacion'] ?></option>
                      <?php
                        }
                        mysqli_free_result($cdep);
                      ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-1 col-sm-11">
                        <button type="submit" id="b_rcargos" class="btn btn-default">Buscar</button>
                      </div>
                    </div>
                    
                  </form>

                <div class="row">

                  <div class="col-md-12" id="r_rcargos">

                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
              </div>
              <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
<?php
}else{
  echo accrestringidop();
}
}else{
  header('Location: ../index.php');
}
?>