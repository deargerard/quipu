// Recibir Persona y periodo vacacional
$("#f_vacper").submit(function(e){
 e.preventDefault();
 var datos = $("#f_vacper").serializeArray();
 datos.push({name: "NomForm", value: "f_vacper"});
 $.ajax({
       data:  datos,
       url:   "m_inclusiones/a_vacaciones/a_vacper.php",
       type:  "post",
       beforeSend: function () {
         $("#b_bvacper").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_bvacper").html("Buscar");
         $("#r_vacper").html(response);
       }
   });
});
// Fin Recibir Persona y periodo vacacional
// funciÃ³n reprogramacion de vacaciones
function nuevac(idec, pervac, st, fav){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_vacaciones/a_fnuevac.php",
 data: { idec : idec, pervac : pervac, st : st, fav  : fav},
 beforeSend: function () {
   $("#r_nuevacaciones").html("<img src='m_images/cargando.gif'>");
   $("#b_gnvac").hide();
 },
 success:function(a){
   $("#b_gnvac").show();
   $("#r_nuevacaciones").html(a);
 }
});
};
//fin reprogramacion de vacaciones
//funcion validar reprogramacion de vacaciones
$( "#f_nuevacaciones").validate( {
 rules: {
   peva:"required",
   inivac:"required",
   finvac:"required",
   doc:"required",
  },
 messages: {
   peva:"Seleccione el periodo vacacional",
   inivac:"Seleccione el inicio de las vacaciones",
   finvac:"Seleccione el final de las vacaciones",
   doc:"Seleccione el documento de aprobaciÃ³n de las vacaciones",
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
   var datos = $("#f_nuevacaciones").serializeArray();
   datos.push({name: "NomForm", value: "f_nuevacaciones"});
   $.ajax({
      type: "POST",
      url: "m_inclusiones/a_vacaciones/a_gnuevac.php",
      dataType: "html",
      data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
      beforeSend: function () {
         $("#b_gnvac").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
         $("#b_gnvac").addClass("disabled");
      },
      success: function(data){
         $("#b_gnvac").hide();
         $("#b_gnvac").html("Guardar");
         $("#b_gnvac").removeClass("disabled");
         $("#r_nuevacaciones").html(data);
         $("#r_nuevacaciones").slideDown();
      }
   });
 }
} );
//fin funciÃ³n validar reprogramacion de vacaciones
// funciÃ³n editar reprogramacion de vacaciones
function edivac(perm, idvac, idav, fav){
$.ajax({
type: "post",
url: "m_inclusiones/a_vacaciones/a_fedivac.php",
data: { perm  : perm, idvac : idvac, idav: idav, fav: fav },
beforeSend: function () {
  $("#r_evacaciones").html("<img src='m_images/cargando.gif'>");
  $("#b_gevacaciones").hide();
},
success:function(a){
  $("#b_gevacaciones").show();
  $("#r_evacaciones").html(a);
}
});
};
//fin editar reprogramacion de vacaciones
//funcion validar editar reprogramacion de vacaciones
$( "#f_evacaciones" ).validate( {
  rules: {
    inivac:"required",
    finvac:"required",
    doc:"required",
   },
  messages: {
    inivac:"Seleccione el inicio de las vacaciones",
    finvac:"Seleccione el final de las vacaciones",
    doc:"Seleccione el documento de aprobaciÃ³n de las vacaciones",
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
   var datos = $("#f_evacaciones").serializeArray();
   datos.push({name: "NomForm", value: "f_evacaciones"});
   $.ajax({
      type: "POST",
      url: "m_inclusiones/a_vacaciones/a_gedivac.php",
      dataType: "html",
      data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
      beforeSend: function () {
         $("#b_gevacaciones").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
         $("#b_gevacaciones").addClass("disabled");
      },
      success: function(data){
         $("#b_gevacaciones").hide();
         $("#b_gevacaciones").html("Guardar");
         $("#b_gevacaciones").removeClass("disabled");
         $("#r_evacaciones").html(data);
         $("#r_evacaciones").slideDown();
      }
   });
 }
} );
//fin funciÃ³n validar editar reprogramacion de vacaciones
// funciÃ³n cancelar vacaciones
function canvac(perm, idvac){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_vacaciones/a_fcanvac.php",
 data: { perm  : perm, idvac : idvac},
 beforeSend: function () {
   $("#r_cvacaciones").html("<img src='m_images/cargando.gif'>");
   $("#b_sicvacaciones").hide();
   $("#b_nocvacaciones").html("Cerrar");
 },
 success:function(a){
   $("#b_sicvacaciones").show();
   $("#b_nocvacaciones").html("No");
   $("#r_cvacaciones").html(a);
 }
});
};
//fin funciÃ³n cancelar vacaciones
//funciÃ³n enviar vacaciones a cancelar
$("#f_cvacaciones").submit(function(e){
  e.preventDefault();
  var datos = $("#f_cvacaciones").serializeArray();
  datos.push({name: "NomForm", value: "f_cvacaciones"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_vacaciones/a_gcanvac.php",
        type:  "post",
        beforeSend: function () {
          $("#r_cvacaciones").html("<img scr='m_images/cargando.gif'>");
          $("#b_sicvacaciones").hide();
        },
        success:  function (response) {
          $("#r_cvacaciones").html(response);
          $("#b_nocvacaciones").html("Cerrar");
        }
    });
});
//fin funciÃ³n enviar vacaciones a cancelar
//funcion actualizar lista de vacaciones
$('#m_nvacaciones, #m_evacaciones, #m_cvacaciones').on('hidden.bs.modal', function () {
  var datos = $('#f_vacper').serializeArray()
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_vacaciones/a_vacper.php",
     dataType: "html",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#b_bvacper").html("<i class='fa fa-spinner fa-spin'></i> Actualizando");
        $("#b_bvacper").addClass("disabled");
     },
     success: function(data){
        $("#b_bvacper").html("Buscar");
        $("#b_bvacper").removeClass("disabled");
        $("#r_vacper").html(data);
        $("#r_vacper").slideDown();
     }
  });
})
//fin funcion actualizar lista de vacaciones
//funcion llamar formulario nuevo perÃ­odo
$("#b_nperiodo").on("click",function(e){
  $.ajax({
    type:"post",
    url:"m_inclusiones/a_vacaciones/a_fnueperiodo.php",
    beforeSend: function () {
      $("#r_nperiodo").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_nperiodo").html(a);
      $("#b_gnperiodo").show();
    }
  });
});
//fin funcion llamar formulario nuevo perÃ­odo
//funcion validar nuevo perÃ­odo
$( "#f_nperiodo").validate({
 rules: {
   atrab: "required",
   },
 messages: {
   atrab: "Ingrese el aÃ±o trabajado.",
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
   var datos = $("#f_nperiodo").serializeArray();
   datos.push({name: "NomForm", value: "f_nperiodo"});
   $.ajax({
      type: "POST",
      url: "m_inclusiones/a_vacaciones/a_gnueper.php",
      dataType: "html",
      data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
      beforeSend: function () {
         $("#b_gnperiodo").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
         $("#b_gnperiodo").addClass("disabled");
      },
      success: function(data){
         $("#b_gnperiodo").hide();
         $("#b_gnperiodo").html("Guardar");
         $("#b_gnperiodo").removeClass("disabled");
         $("#b_cnperiodo").html("Cerrar");
         $("#r_nperiodo").html(data);
         $("#r_nperiodo").slideDown();
      }
   });
 }
} );
//fin funciÃ³n validar nuevo perÃ­odo

//function seleccionar periodo
$(".select2per").select2({
  placeholder: 'Selecione perÃ­odo',
  ajax: {
    url: 'm_inclusiones/a_vacaciones/a_selperiodo.php',
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
//fin function seleccionar periodo

// Recibir datos para reporte de Record de Vacaciones
$("#f_rreva").submit(function(e){
 e.preventDefault();
 var datos = $("#f_rreva").serializeArray();
 datos.push({name: "NomForm", value: "f_rreva"});
 $.ajax({
       data:  datos,
       url:   "m_inclusiones/a_vacaciones/a_rreva.php",
       type:  "post",
       beforeSend: function () {
         $("#b_breva").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_breva").html("Buscar");
         $("#r_reva").html(response);
       }
   });
});
// Fin Recibir datos para reporte de Record de Vacaciones
// Recibir datos para reporte de Vacaciones por Regimen
$("#f_rvare").submit(function(e){
 e.preventDefault();
 var datos = $("#f_rvare").serializeArray();
 datos.push({name: "NomForm", value: "f_rvare"});
 $.ajax({
       data:  datos,
       url:   "m_inclusiones/a_vacaciones/a_rvare.php",
       type:  "post",
       beforeSend: function () {
         $("#b_bvare").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_bvare").html("Buscar");
         $("#r_vare").html(response);
       }
   });
});
// Fin Recibir datos para reporte de Vacaciones por Regimen
// Recibir datos para reporte de EjecuciÃ³n Vacaciones
$("#f_rejva").submit(function(e){
 e.preventDefault();
 var datos = $("#f_rejva").serializeArray();
 datos.push({name: "NomForm", value: "f_rejva"});
 $.ajax({
       data:  datos,
       url:   "m_inclusiones/a_vacaciones/a_rejva.php",
       type:  "post",
       beforeSend: function () {
         $("#b_bejva").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_bejva").html("Buscar");
         $("#r_ejva").html(response);
       }
   });
});
// Fin Recibir datos para reporte de EjecuciÃ³n Vacaciones
// Recibir datos para reporte de Programación de Vacaciones
$("#f_rprovac").submit(function(e){
 e.preventDefault();
 var datos = $("#f_rprovac").serializeArray();
 datos.push({name: "NomForm", value: "f_rprovac"});
 $.ajax({
       data:  datos,
       url:   "m_inclusiones/a_vacaciones/a_rprovac.php",
       type:  "post",
       beforeSend: function () {
         $("#b_bprova").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_bprova").html("Buscar");
         $("#r_rprova").html(response);
       }
   });
});
// Fin Recibir datos para reporte de Programación de Vacaciones

$(' #fecha').datepicker({
  format: "dd/mm/yyyy",
  language: "es",
  autoclose: true,
  todayHighlight: true,
})

$("#meseje").datepicker({
  autoclose: true,
  format: "mm/yyyy",
  language: "es",
  minViewMode: "months",
  maxViewMode: "months",
  startDate: '01/2000',
  startView: "month" //does not work
})

$('.selectpicker').selectpicker()
// datepickers reporte por meses
$("#mesini").datepicker({
  autoclose: true,
  format: "mm/yyyy",
  language: "es",
  minViewMode: "months",
  maxViewMode: "months",
  startDate: '01/2000',
  startView: "month" //does not work
}).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#mesfin').datepicker('setStartDate', minDate);
});

$("#mesfin").datepicker({
  autoclose: true,
  format: "mm/yyyy",
  language: "es",
  minViewMode: "months",
  maxViewMode: "months",
  startDate: '01/2000',
  startView: "month" //does not work
}).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#mesini').datepicker('setEndDate', maxDate);
})

// fin datepickers reporte por meses
// Recibir datos para EjecuciÃ³n Vacaciones
$("#f_ejva").submit(function(e){
 e.preventDefault();
 var datos = $("#f_ejva").serializeArray();
 datos.push({name: "NomForm", value: "f_ejva"});
 $.ajax({
       data:  datos,
       url:   "m_inclusiones/a_vacaciones/a_ejva.php",
       type:  "post",
       beforeSend: function () {
         $("#b_bejva").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_bejva").html("Buscar");
         $("#r_ejva").html(response);
       }
   });
});
// Fin Recibir datos para EjecuciÃ³n Vacaciones
// FunciÃ³n ejecutar vacaciones
function ejevac(idvac, nom){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_vacaciones/a_fejevac.php",
 data: { idvac : idvac, nom  : nom},
 beforeSend: function () {
   $("#r_ejvacaciones").html("<img src='m_images/cargando.gif'>");
   $("#b_siejvacaciones").hide();
   $("#b_noejvacaciones").html("Cerrar");
 },
 success:function(a){
   $("#b_siejvacaciones").show();
   $("#b_noejvacaciones").html("No");
   $("#r_ejvacaciones").html(a);
 }
});
};
//fin funciÃ³n ejecutar vacaciones
//funciÃ³n enviar vacaciones a ejecutar
$("#f_ejvacaciones").submit(function(e){
  e.preventDefault();
  var datos = $("#f_ejvacaciones").serializeArray();
  datos.push({name: "NomForm", value: "f_ejvacaciones"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_vacaciones/a_gejevac.php",
        type:  "post",
        beforeSend: function () {
          $("#r_ejvacaciones").html("<img scr='m_images/cargando.gif'>");
          $("#b_siejvacaciones").hide();
        },
        success:  function (response) {
          $("#r_ejvacaciones").html(response);
          $("#b_noejvacaciones").html("Cerrar");
        }
    });
});
//fin funciÃ³n enviar vacaciones a ejecutar
//funcion actualizar lista de vacaciones por ejecutar
$('#m_ejvacaciones').on('hidden.bs.modal', function () {
  var datos = $("#f_ejva").serializeArray();
  datos.push({name: "NomForm", value: "f_ejva"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_vacaciones/a_ejva.php",
        type:  "post",
        beforeSend: function () {
          $("#b_bejva").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {
          $("#b_bejva").html("Buscar");
          $("#r_ejva").html(response);
        }
    });
})
//fin funcion actualizar lista de vacaciones por ejecutar

// Recibir datos para validar clave de editar vacaciones
function validare(){
  var datos = $("#f_perme").serializeArray();
   $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_vacaciones/a_vperm.php",
        type:  "post",
        dataType: "json",
        beforeSend: function () {
          $("#b_gclave").html("<i class='fa fa-spinner fa-spin'></i> Validando");
        },
        success:  function (response) {
          if (response.exito) {
            var perm = $("#perm").val();
            var idvac = $("#idvac").val();
            var idav = $("#idav").val();
            var fav = $("#fav").val();
            edivac(perm, idvac, idav, fav);
          }else{
            $("#r_evacaciones").html(response.mensaje);
          }

        }
    });
}
// Fin Recibir datos para validar clave de editar vacaciones

// Recibir datos para validar clave de Cancelar vacaciones
function validarc(){
  var datos = $("#f_permc").serializeArray();
   $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_vacaciones/a_vperm.php",
        type:  "post",
        dataType: "json",
        beforeSend: function () {
          $("#b_gclave").html("<i class='fa fa-spinner fa-spin'></i> Validando");
        },
        success:  function (response) {
          if (response.exito) {
            var perm = $("#perm").val();
            var idvac = $("#idvac").val();
            canvac(perm, idvac);
          }else{
            $("#r_cvacaciones").html(response.mensaje);
          }

        }
    });
}
// Fin Recibir datos para validar clave de Cancelar vacaciones

//----

// funciÃ³n programacion de vacaciones
function provac(idec, pervac, fii, ffi, fff){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_vacaciones/a_fnuepro.php",
 data: { idec : idec, pervac : pervac, fii : fii, ffi : ffi, fff : fff},
 beforeSend: function () {
   $("#r_provacaciones").html("<img src='m_images/cargando.gif'>");
   $("#b_gpvac").hide();
 },
 success:function(a){
   $("#b_gpvac").show();
   $("#r_provacaciones").html(a);
 }
});
};
//fin programacion de vacaciones
//funcion validar programacion de vacaciones
$( "#f_provacaciones").validate( {
 rules: {
   peva:"required",
   inivac:"required",
   finvac:"required",
  },
 messages: {
   peva:"Seleccione el periodo vacacional",
   inivac:"Seleccione el inicio de las vacaciones",
   finvac:"Seleccione el final de las vacaciones",
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
   var datos = $("#f_provacaciones").serializeArray();
   datos.push({name: "NomForm", value: "f_provacaciones"});
   $.ajax({
      type: "POST",
      url: "m_inclusiones/a_vacaciones/a_gprovac.php",
      dataType: "html",
      data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
      beforeSend: function () {
        $("#b_gpvac").hide();
        $("#r_provacaciones").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
      },
      success: function(data){
         $("#r_provacaciones").html(data);
         $("#r_provacaciones").slideDown();
      }
   });
 }
} );
//fin funciÃ³n validar programacion de vacaciones
//funcion actualizar lista de vacaciones
$('#m_programarvacaciones, #m_editarprogramacion').on('hidden.bs.modal', function () {
  var idper = $('#idper').val();
  var pervac = $('#pervac').val();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_vacaciones/a_reva.php",
     dataType: "html",
     data: {idper : idper, pervac : pervac},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#reva").html("<i class='fa fa-spinner fa-spin'></i> Actualizando");
     },
     success: function(data){

        $("#reva").html(data);
        $("#reva").slideDown();
     }
  });
})
//fin funcion actualizar lista de vacaciones
// funciÃ³n editar programacion de vacaciones
function edipro(idvac, fii, ffi, fff){
$.ajax({
type: "post",
url: "m_inclusiones/a_vacaciones/a_fedipro.php",
data: { idvac : idvac, fii : fii, ffi : ffi, fff : fff},
beforeSend: function () {
  $("#r_ediprogramacion").html("<img src='m_images/cargando.gif'>");
  $("#b_gepro").hide();
},
success:function(a){
  $("#b_gepro").show();
  $("#r_ediprogramacion").html(a);
}
});
};
//fin editar programacion de vacaciones
//funcion validar editar programacion de vacaciones
$( "#f_ediprogramacion" ).validate( {
  rules: {
    inivac:"required",
    finvac:"required",
   },
  messages: {
    inivac:"Seleccione el inicio de las vacaciones",
    finvac:"Seleccione el final de las vacaciones",
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
   var datos = $("#f_ediprogramacion").serializeArray();
   datos.push({name: "NomForm", value: "f_ediprogramacion"});
   $.ajax({
      type: "POST",
      url: "m_inclusiones/a_vacaciones/a_gedipro.php",
      dataType: "html",
      data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
      beforeSend: function () {
         $("#b_gepro").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
         $("#b_gepro").addClass("disabled");
      },
      success: function(data){
         $("#b_gepro").hide();
         $("#b_gepro").html("Guardar");
         $("#b_gepro").removeClass("disabled");
         $("#r_ediprogramacion").html(data);
         $("#r_ediprogramacion").slideDown();
      }
   });
 }
} );
//fin funciÃ³n validar editar programacion de vacaciones
// funciÃ³n programacion de vacaciones
function provacc(idec, pervac, fii, ffi, nd){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_vacaciones/a_fnueproc.php",
 data: { idec : idec, pervac : pervac, fii : fii, ffi : ffi, nd : nd},
 beforeSend: function () {
   $("#r_provacaciones").html("<img src='m_images/cargando.gif'>");
   $("#b_gpvac").hide();
 },
 success:function(a){
   $("#b_gpvac").show();
   $("#r_provacaciones").html(a);
 }
});
};
//fin programacion de vacaciones
// funciÃ³n editar programacion de vacaciones
function ediproc(idvac, fii, ffi, fff, dias){
$.ajax({
type: "post",
url: "m_inclusiones/a_vacaciones/a_fediproc.php",
data: { idvac : idvac, fii : fii, ffi : ffi, fff : fff, dias : dias},
beforeSend: function () {
  $("#r_ediprogramacion").html("<img src='m_images/cargando.gif'>");
  $("#b_gepro").hide();
},
success:function(a){
  $("#b_gepro").show();
  $("#r_ediprogramacion").html(a);
}
});
};
//fin editar programacion de vacaciones
//funcion actualizar lista de vacaciones
$('#m_editarprogramacionc, #m_programarvacacionesc, #m_envprovacc').on('hidden.bs.modal', function () {
  //var datos = $('#f_vacper').serializeArray()
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_vacaciones/a_provacaciones.php",
     dataType: "html",
     //data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#r_provacacionesc").html("<img src='m_images/cargando.gif'>");
     },
     success: function(data){
        $("#r_provacacionesc").html(data);
        $("#r_provacacionesc").slideDown();
     }
  });
})
//fin funcion actualizar lista de vacaciones
// funciÃ³n editar programacion de vacaciones
function envprovacc(idcoo){
$.ajax({
type: "post",
url: "m_inclusiones/a_vacaciones/a_envprovacc.php",
data: { idcoo : idcoo},
dataType: "html",
beforeSend: function () {
  $("#r_envprovacc").html("<img src='m_images/cargando.gif'>");
},
success:function(a){
  $("#r_envprovacc").html(a);
}
});
};
//fin editar programacion de vacaciones
//Select2 para buscar dependencia.
$(".select2depact").select2({
  placeholder: 'Selecione una dependencia',
  ajax: {
    url: 'm_inclusiones/a_general/a_seldependenciat.php',
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
//Fin Select2 para buscar dependencia.

// función aprobar programacion de vacaciones
function aprovacf(){
$.ajax({
type: "post",
url: "m_inclusiones/a_vacaciones/a_faprovac.php",
dataType: "html",
beforeSend: function () {
  $("#r_aprovac").html("<img src='m_images/cargando.gif'>");
},
success:function(a){
  $("#r_aprovac").html(a);
  $("#b_gaprovac").show();
}
});
};
//fin aprobar programacion de vacaciones
//DataTable Aprobación de Vacaciones
$('#dtvare').DataTable({
  "order": [[1,"asc"]]
});
//Fin DataTable Aprobación de Vacaciones

$('#b_gaprovac').click(function(){
  var doc=$("#doc").val();
  $.ajax({
  type: "post",
  url: "m_inclusiones/a_vacaciones/a_gaprovac.php",
  data: { doc : doc},
  dataType: "html",
  beforeSend: function () {
    $("#r_aprovac").html("<img src='m_images/cargando.gif'>");
    $("#b_gaprovac").hide();
  },
  success:function(a){
    $("#r_aprovac").html(a);
  }
  });
})
//funcion actualizar lista de programación de vacaciones
$('#maprobar').on('hidden.bs.modal', function () {
   window.location.reload(true);
})
//fin funcion actualizar lista de programación de vacaciones
//funcion buscar vacaciones por resolución
$("#b_bvacres").click(function(){
  var doc=$("#doc").val();
  $.ajax({
  type: "post",
  url: "m_inclusiones/a_vacaciones/a_rvacres.php",
  data: { doc : doc},
  dataType: "html",
  beforeSend: function () {
    $("#r_vacres").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_vacres").html(a);
  }
  });
})
//Fin funcion buscar vacaciones por resolución
// Exportar vacaciones por resolución
$("#b_exvacres").click(function(){
  var doc=$("#doc").val();
  if (doc==null) {
    alert("No seleccionó ninguna resolución");
  }else {
     window.location.href = "m_exportar/e_exvacres.php?doc="+doc;
  }
})

// Fin exportar vacaciones por resolución
