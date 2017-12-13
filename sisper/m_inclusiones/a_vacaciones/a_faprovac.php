<?php
session_start();
include ("../php/conexion_sp.php");
include ("../php/funciones.php");
if(accesoadm($cone,$_SESSION['identi'],14)){
  $hoy = date("Y");
  $anos= $hoy + 1;
  $pv = trim($hoy." - ".$anos);
  $cpev=mysqli_query($cone,"SELECT * FROM periodovacacional WHERE PeriodoVacacional='$pv'");
  if ($rpev=mysqli_fetch_assoc($cpev)) {
    $pervac=$rpev['idPeriodoVacacional'];
  }
    ?>
          <div class="form-group valida">
            <div class="col-sm-12 text-center">
                <h4 class="text-danger"><?php echo "APROBACIÓN DE PROGRAMACIÓN VACACIONES  ". $pv?></h4>
                <hr>
            </div>
          </div>

          <div class="form-group valida text-center">
            <span id="msg" class="text-maroon"></span>
          </div>

          <div class="form-group valida">
            <label for="doc" class="col-sm-2" >Documento</label>
            <div class="col-sm-8">
              <select name="doc" id="doc" class="form-control select2doc" style="width:100%">
              </select>
            </div>
            <button id="b_nuedoc" class="btn btn-info" type="button" data-toggle="modal" data-target="#m_nuedocu" >Nuevo</button>
          </div>
<script>
//funcion seleccionar docuento
   $(".select2doc").select2({
     placeholder: 'Selecione a un documento',
     ajax: {
       url: 'm_inclusiones/a_general/a_seldocumento.php',
       dataType: 'json',
       delay: 250,
       processResults: function (data) {
         return {
           results: data
         };
       },
       cache: true
     },
     minimumInputLength: 1
   });
//fin funcion seleccionar docuento
   //funcion llamar formulario nuevo documento
    $("#b_nuedoc").on("click",function(e){
      $.ajax({
        type:"post",
        url:"m_inclusiones/a_licencias/a_nuedoc.php",
        beforeSend: function () {
          $("#r_nuedocu").html("<img scr='m_images/cargando.gif' class='center-block'>");
          $("#b_gnuedocu").hide();
        },
        success:function(a){
          $("#r_nuedocu").html(a);
          $("#b_gnuedocu").show();
        }
      });
    });
// fin funcion llamar formulario nuevo documento

//funcion enviar datos para guardar nuevo documento
$( "#f_nuedocu" ).validate( {
    rules: {
      tdoc:"required",
      num:{required:true,number:true},
      adoc:{required:true,minlength:4},
      sig:{required:true,minlength:5},
      fec:{required:true, datePE:true},
      leg:{required:false},
      des:{required:false}
    },
    messages: {
      tdoc:"Elija un tipo de documento",
      num:{required:"Ingrese el número",number:"Sólo números"},
      adoc:{required:"Ingrese el año",minlength:"Mínimo 4 caracteres."},
      sig:{required:"Ingrese las siglas.",minlength:"Mínimo 5 caracteres."},
      fec:{required:"Ingrese fecha.",datePE:"Ingrese una fecha válida."}
    },
    errorElement: "em",
    errorPlacement: function ( error, element ) {
      // Add the `help-block` class to the error element
      error.addClass( "help-block" );

      if ( element.prop( "type" ) === "checkbox" ) {
        error.insertAfter( element.parent( "label" ) );
      } else if ( element.prop( "type" ) === "radio" ){
        error.insertAfter( element.parent( "label" ) );
      }
      else {
        error.insertAfter( element );
      }
    },
    highlight: function ( element, errorClass, validClass ) {
      $( element ).parents( ".valida" ).addClass( "has-error" ).removeClass( "has-success" );
    },
    unhighlight: function (element, errorClass, validClass) {
      $( element ).parents( ".valida" ).addClass( "has-success" ).removeClass( "has-error" );
    },
    submitHandler: function(form){
      var datos = $("#f_nuedocu").serializeArray();
      datos.push({name: "NomForm", value: "f_nuedocu"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_licencias/a_gnuedocu.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnuedoc").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gnuedoc").addClass("disabled");
         },
         success: function(data){
            $("#b_gnuedocu").hide();
            $("#b_gnuedocu").html("Guardar");
            $("#b_gnuedocu").removeClass("disabled");
            $("#r_nuedocu").html(data);
            $("#r_nuedocu").slideDown();
         }
      });
    }
  } );
//funcion validar formulario nueva licencia

</script>
<?php
    mysqli_close($cone);

}else{
  echo accrestringidoa();
}
?>
