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
// función nueva programacion de vacaciones
function nuevac(idec, pervac, fii, ffi, fff){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_vacaciones/a_fnuevac.php",
 data: { idec : idec, pervac : pervac, fii : fii, ffi : ffi, fff : fff },
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
//fin nueva programacion de vacaciones
//funcion validar nueva programacion de vacaciones
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
   doc:"Seleccione el documento de aprobación de las vacaciones",
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
//fin función validar nueva programacion de vacaciones
// función editar programacion de vacaciones
function edivac(idvac, idav, fii, ffi, fff){
$.ajax({
type: "post",
url: "m_inclusiones/a_vacaciones/a_fedivac.php",
data: { idvac: idvac, idav: idav, fii : fii, ffi : ffi, fff : fff},
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
//fin editar programacion de vacaciones
//funcion validar editar programacion de vacaciones
$( "#f_evacaciones" ).validate( {
  rules: {
    inivac:"required",
    finvac:"required",
    doc:"required",
   },
  messages: {
    inivac:"Seleccione el inicio de las vacaciones",
    finvac:"Seleccione el final de las vacaciones",
    doc:"Seleccione el documento de aprobación de las vacaciones",
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
//fin función validar editar programacion de vacaciones
// función cancelar vacaciones
function canvac(idvac){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_vacaciones/a_fcanvac.php",
 data: { idvac : idvac},
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
//fin función cancelar vacaciones
//función enviar vacaciones a cancelar
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
//fin función enviar vacaciones a cancelar
//funcion actualizar lista de vacaciones
$('#m_nvacaciones, #m_evacaciones, #m_cvacaciones').on('hidden.bs.modal', function () {
  var per = $("#per").val();
  var pervac = $("#pervac").val();
  if ($("#can").is(':checked')){
    var can = 2;
  } else {
    var can = "";
  }
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_vacaciones/a_vacper.php",
     dataType: "html",
     data: {per: per, pervac: pervac, can: can},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
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
  console.log(can);
})
//fin funcion actualizar lista de vacaciones
//funcion llamar formulario nuevo período
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
//fin funcion llamar formulario nuevo período
//funcion validar nuevo período
$( "#f_nperiodo").validate({
 rules: {
   atrab: "required",
   },
 messages: {
   atrab: "Ingrese el año trabajado.",
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
         $("#r_nperiodo").html(data);
         $("#r_nperiodo").slideDown();
      }
   });
 }
} );
//fin función validar nuevo período
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
         $("#b_bvacper").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_breva").html("Buscar");
         $("#r_reva").html(response);
       }
   });
});
// Fin Recibir datos para reporte de Record de Vacaciones
