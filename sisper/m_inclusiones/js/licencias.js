var fecha = new Date();
fecha.setFullYear(fecha.getFullYear()+1);
$("#ano,#anio").datepicker({
  autoclose: true,
  format: " yyyy",
  language: "es",
  minViewMode: "years",
  maxViewMode: "years",
  startDate: '2000',
  endDate: fecha,
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
$("#f1").datepicker({
  autoclose: true,
  todayHighlight: true,
  format: "dd/mm/yyyy",
  language: "es",
  endDate: new Date(),
})
.on('changeDate', function (selected) {
  var minDate = new Date(selected.date.valueOf());
  $('#f2').datepicker('setStartDate', minDate);
});
$("#f2").datepicker({
  autoclose: true,
  todayHighlight: true,
  format: "dd/mm/yyyy",
  language: "es",
  endDate: new Date(),
})
.on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#f1').datepicker('setEndDate', maxDate);
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
      docapr:"required"
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
      docapr:"Elija el documento que aprueba la licencia."
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
         dataType: "json",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnuelic").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gnuelic").addClass("disabled");
         },
         success: function(data){
            $("#b_gnuelic").hide();
            $("#b_gnuelic").html("Guardar");
            $("#b_gnuelic").removeClass("disabled");
            $("#r_nuelic").html(data.msg);
            $("#r_nuelic").slideDown();            
            if (data.e) {            
             $("#m_nuelic").modal('hide');
             $("#m_detlic").modal('show');
             detlic(data.idli);
            }
         }
      });
    }
  } );
$('#m_nuelic,#m_edilic,#m_estlic').on('hidden.bs.modal', function () {
      var datos = $("#f_licper").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_licencias/a_blicper.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
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

//----->

//funcion actualizar encargaturas
function actencargaturas(idli){
  $.ajax({
        data:  {idli : idli},
        url:   "m_inclusiones/a_licencias/a_encargaturas.php",
        type:  "post",
        beforeSend: function () {
          $("#r_encargatura").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {

          $("#r_encargatura").html(response);
        }
    });
}
//Fin Función actualizar encargaturas


//funcion llamar formulario Encargatura 
function nueencali(idli){
  $.ajax({
    type:"post",
    url:"m_inclusiones/a_licencias/a_fnueenc.php",
    dataType: "html",
    data: { idli : idli},
    beforeSend: function () {
      $("#f_nencargatura").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#f_nencargatura").html(a);
      $("#b_gnencarg").show();
    }
  });
};
//fin funcion llamar formulario Encargatura
//funcion validar Encargatura
$( "#f_nencargatura").validate({
  rules: {
    idli:"required",
    inienc:"required",
    finenc:"required",
    enc:"required",
    tip:"required",
   },
  messages: {
    idli:"Debe seleccionar una comisión de servicios",
    inienc:"Seleccione el inicio de la encargatura",
    finenc:"Seleccione el final de la encargatura",
    enc:"Seleccione encargargado",
    tip:"Seleccionar Tipo de encargatura",
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
   var datos = $("#f_nencargatura").serializeArray();
   datos.push({name: "NomForm", value: "f_nencargatura"});
   $.ajax({
      type: "POST",
      url: "m_inclusiones/a_licencias/a_gnueenc.php",
      dataType: "json",
      data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
      beforeSend: function () {
         $("#b_gnencarg").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
         $("#b_gnencarg").addClass("disabled");
      },
      success: function(data){
         $("#b_gnencarg").hide();
         $("#b_gnencarg").html("Guardar");
         $("#b_gnencarg").removeClass("disabled");
         $("#b_cnencarg").html("Cerrar");
         $("#f_nencargatura").html(data.msg);
         $("#f_nencargatura").slideDown();
         if (data.e) {
           actencargaturas(data.idli);

         }
      }
   });
 }
} );
//fin función validar Encargatura 

// FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS EDITAR Y ELIMINAR ENCARGATURAS
function fo_accion(acc, v1){
  
  switch(acc) {
    case 'edienc':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar Encargatura";
        break;
    case 'elienc':
        var mt="<i class='fa fa-times-circle text-gray'></i> Eliminar Encargatura";
        break;    
  }
  $(".titulo-enc").html(mt);
  $("#m_encargatura").modal("show");

  $.ajax({
    type: "post",
    url: "m_inclusiones/a_licencias/fo_accion.php",
    data: {acc: acc, v1: v1},
    dataType: "html",
    beforeSend: function () {
      $("#f_encargatura").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_gencarg").addClass("hidden");
    },
    success:function(a){
      $("#f_encargatura").html(a);
      $("#b_gencarg").removeClass("hidden");
    }
  });
}

// FIN FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS EDITAR Y ELIMINAR ENCARGATURAS

// FUNCIÓN QUE LLAMA ARVHIVO EDITAR O ELIMINAR ENCARGATURAS 

$('#f_encargatura').submit(function(e){
  e.preventDefault();
  var datos = $("#f_encargatura").serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_licencias/gu_edi_eli_enc.php",
    data: datos,
    dataType: "json",
    beforeSend: function () {
      $("#f_encargatura").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_gencarg").addClass("hidden");
    },
    success:function(a){

      if(a.e){
        $("#f_encargatura").html(a.m);

        detlic(datos[2].value);

        $("#b_gencarg").addClass("hidden");
        $("#b_cencarg").html("Cerrar");
      }else{
        $("#f_encargatura").html(a.m);
        $("#b_gencarg").removeClass("hidden");
      }
    }
  });
})
// FIN FUNCIÓN QUE LLAMA ARHIVO EDITAR O ELIMINAR ENCARGATURAS 

//----->

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
      docapr:"required"
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
      docapr:"Elija el documento que aprueba la licencia."
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
         dataType: "json",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedilic").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gedilic").addClass("disabled");
         },
         success: function(data){
            $("#b_gedilic").hide();
            $("#b_gedilic").html("Guardar");
            $("#b_gedilic").removeClass("disabled");
            $("#r_edilic").html(data.msg);
            $("#r_edilic").slideDown();
            if (data.e) {
              $("#m_edilic").modal('hide');
              $("#m_detlic").modal('show');
              detlic(data.idli);
            }
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
//reporte personal/tipolic/fechas
$("#f_pertlicfec").submit(function(e){
  e.preventDefault();
  var datos = $("#f_pertlicfec").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_licencias/a_bpertlicfec.php",
        type:  "post",
        beforeSend: function () {
          $("#b_pertlicfec").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {
          $("#b_pertlicfec").html("Buscar");
          $("#r_pertlicfec").html(response);
        }
    });
});
//reporte personal/tipolic/fechas
//reporte personal/tipolic/fechas
$("#f_slabtlicano").submit(function(e){
  e.preventDefault();
  var datos = $("#f_slabtlicano").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_licencias/a_bslabtlicano.php",
        type:  "post",
        beforeSend: function () {
          $("#b_slabtlicano").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {
          $("#b_slabtlicano").html("Buscar");
          $("#r_slabtlicano").html(response);
        }
    });
});
//reporte personal/tipolic/fechas
//reporte licencias sin goce
$("#f_licsg").submit(function(e){
  e.preventDefault();
  var datos = $("#f_licsg").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_licencias/a_blicsg.php",
        type:  "post",
        beforeSend: function () {
          $("#b_licsg").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {
          $("#b_licsg").html("Buscar");
          $("#r_licsg").html(response);
        }
    });
});
//reporte licencias sin goce