<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],1) || accesoadm($cone,$_SESSION['identi'],9)){
if(isset($_POST['doc']) && !empty($_POST['doc'])){
$doc=iseguro($cone,$_POST['doc']);
?>
        <div class="row">
            <div class="col-sm-12">
                <div class="progress">
                  <div class="progress-bar" id="p_carfoto" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
                <div class="text-center">
                    <img src="<?php echo mfotom($doc) ?>" id="mfoto" alt="Foto" class="img-thumbnail" width="150">
                </div>
                <div id="resultado" class="text-center"></div>
                <div>
                    <br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <input type="file" name="foto" id="foto">
            </div>                    
        </div>
        <script>
            function subirArchivos() {
                $("#foto").upload('m_inclusiones/ajax/a_gcamfoto.php',
                {
                    numdoc: <?php echo "'$doc'" ?>
                },
                function(respuesta) {
                    //Subida finalizada.
                    $("#resultado").html(respuesta);
                    $(".progress").hide();
                    $("#foto").attr({ value: '' });
                }, function(progreso, valor) {
                    //Barra de progreso.
                    $(".progress").show();
                    $("#p_carfoto").attr('aria-valuenow',valor).css('width',valor+'%');
                    $("#p_carfoto").html(valor+'%');
                });
            }
            $(".progress").hide();
            $('#foto').filestyle({
                buttonText: 'Buscar Foto',
                buttonName : 'btn-primary'
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#mfoto').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#foto").change(function(){
                readURL(this);
            });
        </script>
<?php
}
}else{
  echo accrestringidoa();
}
?>