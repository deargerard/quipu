$("#ano,#anio").datepicker({
  autoclose: true,
  format: " yyyy",
  language: "es",
  minViewMode: "years",
  maxViewMode: "years",
  startDate: '2000',
  endDate: new Date(),
  startView: "year" //does not work
});
$("#mes").datepicker({
  autoclose: true,
  format: "mm/yyyy",
  language: "es",
  minViewMode: "months",
  maxViewMode: "months",
  startDate: '01/2000',
  endDate: new Date(),
  startView: "month" //does not work
});
$("#f_licper").submit(function(e){
  e.preventDefault();
  var datos = $("#f_licper").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_licencias/a_blicper.php",
        type:  "post",
        beforeSend: function () {
          $("#b_blicper").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {
          $("#b_blicper").html("Buscar");
          $("#r_licper").html(response);
        }
    });
});
//funciones nueva licencia
function nuelic(id,ano){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_licencias/a_nuelic.php",
    data: { id : id, ano : ano },
    beforeSend: function () {
      $("#r_nuelic").html("<img src='m_images/cargando.gif' class='center-block'>");
      $("#b_gnuelic").hide();
    },
    success:function(a){
      $("#b_gnuelic").show();
      $("#r_nuelic").html(a);
      $(".ocu").addClass("hidden");
      $("#med").val("Ninguno");
      $("#col").val("Ninguna");
      //$("#emed option[value="+ 50 +"]").attr("selected",true);
      $("#emed").select2("val", "50");
      //$("#tdoc option[value="+ 3 +"]").attr("selected",true);
      $("#tdoc").select2("val", "3");
      $("#ndoc").val("Ninguno");
    }
  });
};
//fin funciones nueva licencia
//funcion enviar datos para guardar nuevo documento
$( "#f_nuedocu" ).validate( {
    rules: {
      tdoc:"required",
      num:{required:true,number:true},
      adoc:{required:true,minlength:4},
      sig:{required:true,minlength:5},
      fec:{required:true, datePE:true}
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
$( "#f_nuelic" ).validate( {
    rules: {
      tlic:"required",
      des:{required:true, datePE:true},
      has:{required:true, datePE:true},
      mot:{required:true, minlength:4},
      med:{required:true, minlength:6},
      col:{required:true, minlength:2},
      emed:"required",
      tdoc:"required",
      ndoc:{required:true, minlength:2},
      docapr:"required",
      leg:{required:false, minlength:2}
    },
    messages: {
      tlic:"Elija un tipo de licencia",
      des:{required:"Ingrese fecha de inicio de la licencia.",datePE:"Ingrese una fecha válida."},
      has:{required:"Ingrese fecha de fin de la licencia.",datePE:"Ingrese una fecha válida."},
      mot:{required:"Ingrese el motivo.",minlength:"Mínimo 4 caracteres."},
      med:{required:"Ingrese el médico.",minlength:"Mínimo 6 caracteres."},
      col:{required:"Ingrese # colegiatura.",minlength:"Mínimo 2 caracteres."},
      emed:"Elija una especialidad.",
      tdoc:"Elija el tipo de documento.",
      ndoc:{required:"Ingrese # colegiatura.",minlength:"Mínimo 2 caracteres."},
      docapr:"Elija el documento que aprueba la licencia.",
      leg:{minlength:"Mínimo 2 caracteres."}
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
      var datos = $("#f_nuelic").serializeArray();
      datos.push({name: "NomForm", value: "f_nuelic"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_licencias/a_gnuelic.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnuelic").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gnuelic").addClass("disabled");
         },
         success: function(data){
            $("#b_gnuelic").hide();
            $("#b_gnuelic").html("Guardar");
            $("#b_gnuelic").removeClass("disabled");
            $("#r_nuelic").html(data);
            $("#r_nuelic").slideDown();
         }
      });
    }
  } );
$('#m_nuelic,#m_edilic,#m_estlic').on('hidden.bs.modal', function () {
      var licper = $("#licper").val();
      var ano = $('#ano').val();
      if($('#vcan').prop('checked')){
        var vcan = "c";
      }else{
        var vcan = "";
      }
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_licencias/a_blicper.php",
         dataType: "html",
         data: {licper: licper, ano: ano, vcan: vcan},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_blicper").html("<i class='fa fa-spinner fa-spin'></i> Actualizando");
            $("#b_blicper").addClass("disabled");
         },
         success: function(data){
            $("#b_blicper").html("Buscar");
            $("#b_blicper").removeClass("disabled");
            $("#r_licper").html(data);
            $("#r_licper").slideDown();
         }
      });
});
//funciones detalle licencia
function detlic(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_licencias/a_detlic.php",
    data: { id : id },
    beforeSend: function () {
      $("#r_detlic").html("<img src='m_images/cargando.gif' class='center-block'>");
    },
    success:function(a){
      $("#r_detlic").html(a);
    }
  });
};
//fin funciones detalle licencia
//funciones enviar datos editar licencia
function edilic(id, ano){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_licencias/a_edilic.php",
    data: { id : id, ano : ano },
    beforeSend: function () {
      $("#r_edilic").html("<img src='m_images/cargando.gif' class='center-block'>");
      $("#b_gedilic").hide();
    },
    success:function(a){
      $("#r_edilic").html(a);
      $("#b_gedilic").show();
    }
  });
};
//fin funciones enviar datos editar licencia
//funcion validar formulario editar licencia
$( "#f_edilic" ).validate( {
    rules: {
      tlic:"required",
      des:{required:true, datePE:true},
      has:{required:true, datePE:true},
      mot:{required:true, minlength:4},
      med:{required:true, minlength:6},
      col:{required:true, minlength:2},
      emed:"required",
      tdoc:"required",
      ndoc:{required:true, minlength:2},
      docapr:"required",
      leg:{required:false, minlength:2}
    },
    messages: {
      tlic:"Elija un tipo de licencia",
      des:{required:"Ingrese fecha de inicio de la licencia.",datePE:"Ingrese una fecha válida."},
      has:{required:"Ingrese fecha de fin de la licencia.",datePE:"Ingrese una fecha válida."},
      mot:{required:"Ingrese el motivo.",minlength:"Mínimo 4 caracteres."},
      med:{required:"Ingrese el médico.",minlength:"Mínimo 6 caracteres."},
      col:{required:"Ingrese # colegiatura.",minlength:"Mínimo 2 caracteres."},
      emed:"Elija una especialidad.",
      tdoc:"Elija el tipo de documento.",
      ndoc:{required:"Ingrese # colegiatura.",minlength:"Mínimo 2 caracteres."},
      docapr:"Elija el documento que aprueba la licencia.",
      leg:{minlength:"Mínimo 2 caracteres."}
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
      var datos = $("#f_edilic").serializeArray();
      datos.push({name: "NomForm", value: "f_nuelic"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_licencias/a_gedilic.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedilic").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gedilic").addClass("disabled");
         },
         success: function(data){
            $("#b_gedilic").hide();
            $("#b_gedilic").html("Guardar");
            $("#b_gedilic").removeClass("disabled");
            $("#r_edilic").html(data);
            $("#r_edilic").slideDown();
         }
      });
    }
  } );
//funciones estado licencia
function estlic(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_licencias/a_estlic.php",
    data: { id : id},
    beforeSend: function () {
      $("#r_estlic").html("<img src='m_images/cargando.gif' class='center-block'>");
      $("#b_siestlic").hide();
      $("#b_noestlic").html("Cerrar");
    },
    success:function(a){
      $("#r_estlic").html(a);
      $("#b_siestlic").show();
      $("#b_noestlic").html("No");
    }
  });
};
//fin funciones estado licencia
//funcion cambiar estado licencia.
$("#f_estlic").submit(function(e){
  e.preventDefault();
  var datos = $("#f_estlic").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_licencias/a_gestlic.php",
        type:  "post",
        beforeSend: function () {
          $("#r_estlic").html("<img scr='m_images/cargando.gif'>");
          $("#b_siestlic").hide();
        },
        success:  function (response) {
          $("#r_estlic").html(response);
          $("#b_noestlic").html("Cerrar");
        }
    });
});
//fin funcion cambiar estado licencia.
//select2licencia en reporte
$(".select2tiplic,.select2tiplice,.select2clab").select2();
//fin select2licencia en reporte
//reporte personal/tipolic/año
$("#f_pertlicano").submit(function(e){
  e.preventDefault();
  var datos = $("#f_pertlicano").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_licencias/a_bpertlicano.php",
        type:  "post",
        beforeSend: function () {
          $("#b_pertlicano").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {
          $("#b_pertlicano").html("Buscar");
          $("#r_pertlicano").html(response);
        }
    });
});
//reporte personal/tipolic/año
//reporte tipolic/año
$("#f_tlicano").submit(function(e){
  e.preventDefault();
  var datos = $("#f_tlicano").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_licencias/a_btlicano.php",
        type:  "post",
        beforeSend: function () {
          $("#b_tlicano").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {
          $("#b_tlicano").html("Buscar");
          $("#r_tlicano").html(response);
        }
    });
});
//reporte tipolic/año
//reporte C.laboral/Mes
$("#f_clabmes").submit(function(e){
  e.preventDefault();
  var datos = $("#f_clabmes").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_licencias/a_bclabmes.php",
        type:  "post",
        beforeSend: function () {
          $("#b_clabmes").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {
          $("#b_clabmes").html("Buscar");
          $("#r_clabmes").html(response);
        }
    });
});
//reporte C.laboral/Mes