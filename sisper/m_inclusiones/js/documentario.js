$("#d_fini,#d_ffin").datepicker({
  autoclose: true,
  format: "dd/mm/yyyy",
  language: "es",
  startDate: '01/01/2000',
  endDate: new Date(),
});
$("#d_adoc").datepicker({
  autoclose: true,
  format: "yyyy",
  maxViewMode: 2,
  minViewMode: 2,
  language: "es",
  startDate: '2000',
  endDate: new Date(),
});
//ajax buscar documentos
$("#b_doc").click(function(){
  var numdoc = $("#numdoc").val();
  $.ajax({
        data:  {numdoc: numdoc},
        url:   "m_inclusiones/a_documentario/a_bdoc.php",
        type:  "post",
        beforeSend: function () {
          $("#r_bdoc").html("<h4 class='text-muted text-center'><i class='fa fa-spinner fa-spin text-yellow'></i> Buscando</h4>");
        },
        success:  function (response) {
          $("#r_bdoc").html(response);
        }
    });
});
$("#b_num").click(function(){
  var ndoc = $("#ndoc").val();
  var adoc = $("#adoc").val();
  $.ajax({
        data:  {ndoc: ndoc, adoc: adoc},
        url:   "m_inclusiones/a_documentario/a_bdoc.php",
        type:  "post",
        beforeSend: function () {
          $("#r_bdoc").html("<h4 class='text-muted text-center'><i class='fa fa-spinner fa-spin text-yellow'></i> Buscando</h4>");
        },
        success:  function (response) {
          $("#r_bdoc").html(response);
        }
    });
});
$("#b_fec").click(function(){
  var fini = $("#fini").val();
  var ffin = $("#ffin").val();
  $.ajax({
        data:  {fini: fini, ffin: ffin},
        url:   "m_inclusiones/a_documentario/a_bdoc.php",
        type:  "post",
        beforeSend: function () {
          $("#r_bdoc").html("<h4 class='text-muted text-center'><i class='fa fa-spinner fa-spin text-yellow'></i> Buscando</h4>");
        },
        success:  function (response) {
          $("#r_bdoc").html(response);
        }
    });
});
//ajax buscar documentos
//funcion llamar formulario nuevo documento
$("#b_ndoc").on("click",function(e){
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
//funcion llamar formulario nuevo documento
//llamar al formulario editar noticia
function edidocu(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_licencias/a_edidoc.php",
    data: { id : id },
    beforeSend: function () {
      $("#r_edidocu").html("<img src='m_images/cargando.gif' class='center-block'>");
      $("#b_gedidocu").hide();
    },
    success:function(a){
      $("#r_edidocu").html(a);
      $("#b_gedidocu").show();
    }
  });
};
//fin llamar al formulario editar noticia
//funcion validar y enviar formulario editar docu
$( "#f_edidocu" ).validate( {
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
      var datos = $("#f_edidocu").serializeArray();
      datos.push({name: "NomForm", value: "f_edidocu"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_licencias/a_gedidocu.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedidocu").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gedidocu").addClass("disabled");
         },
         success: function(data){
            $("#b_gedidocu").hide();
            $("#b_gedidocu").html("Guardar");
            $("#b_gedidocu").removeClass("disabled");
            $("#r_edidocu").html(data);
            $("#r_edidocu").slideDown();
         }
      });
    }
  } );
//validar y enviar formulario editar docu