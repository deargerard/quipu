//fecha intranet
$('#fec,#fec1').datepicker({
  format: "dd/mm/yyyy",
  language: "es",
  autoclose: true,
  todayHighlight: true
});
//fin fecha intranet
//funcion validar formulario buscar asistencia diaria
$( "#f_badiaria" ).validate( {
    rules: {
      fec: {required:true, datePE:true},
      tip: {required:true}
    },
    messages: {
      fec: {required:"Ingrese la fecha"},
      tip: {required:"Elija un tipo de marcación"}
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
      var datos = $("#f_badiaria").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_asistencia/badiaria.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_badiaria").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
            $("#b_badiaria").addClass("disabled");
         },
         success: function(data){
            $("#b_badiaria").html("Buscar");
            $("#b_badiaria").removeClass("disabled");
            $(".d_adiaria").html(data);
            $(".d_adiaria").slideDown();
         }
      });
    }
  } );
//funcion validar formulario buscar asistencia diaria
//funcion validar formulario buscar asistencia empleado
$( "#f_baempleado" ).validate( {
    rules: {
      mes: {required:true},
      ano: {required:true},
      emp: {required:true}
    },
    messages: {
      mes: {required:"Elija un mes"},
      ano: {required:"Elija un año"},
      tip: {required:"Elija un empleado"}
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
      var datos = $("#f_baempleado").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_asistencia/baempleado.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_baempleado").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
            $("#b_baempleado").addClass("disabled");
         },
         success: function(data){
            $("#b_baempleado").html("Buscar");
            $("#b_baempleado").removeClass("disabled");
            $(".d_aempleado").html(data);
            $(".d_aempleado").slideDown();
         }
      });
    }
  } );
//funcion validar formulario buscar asistencia empleado