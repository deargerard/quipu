$(document).ready(function(){
  $('#fecb').datepicker({
      format: 'mm/yyyy',
      autoclose: true,
      minViewMode: 1,
      maxViewMode: 2,
      todayHighlight: true
  });
});
// Buscar Comisiones de Servicios
$("#f_comser").submit(function(e){
 e.preventDefault();
 var datos = $("#f_comser").serializeArray();
 datos.push({name: "NomForm", value: "f_comser"});
 $.ajax({
       data:  datos,
       url:   "m_inclusiones/a_comservicios/a_comservicios.php",
       type:  "post",
       beforeSend: function () {
         $("#b_bcomser").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_bcomser").html("Buscar");
         $("#r_comser").html(response);
       }
   });
});
// Fin Buscar Comisiones de Servicios
//funcion actualizar comisiones de servicio
function actcomisiones(){
  var datos = $("#f_comser").serializeArray();
  datos.push({name: "NomForm", value: "f_comser"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_comservicios/a_comservicios.php",
        type:  "post",
        beforeSend: function () {
          $("#b_bcomser").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        },
        success:  function (response) {
          $("#b_bcomser").html("Buscar");
          $("#r_comser").html(response);
        }
    });
}
//Fin Función actualizar comisiones de servicio
//funcion actualizar encargaturas
function actencargaturas(idcs){
  $.ajax({
        data:  {idcs : idcs},
        url:   "m_inclusiones/a_comservicios/a_encargaturas.php",
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
// función registro de Comisión de Servicios
function nuecomser(ide){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_comservicios/a_fnuecomser.php",
 data: { ide : ide},
 beforeSend: function () {
   $("#f_ncomservicios").html("<img src='m_images/cargando.gif'>");
   $("#b_gncomser").hide();
 },
 success:function(a){
   $("#b_gncomser").show();
   $("#f_ncomservicios").html(a);
 }
});
};
//fin registro de Comisión de Servicios
//funcion validar datos de comisión de servicios
$( "#f_ncomservicios").validate( {
 rules: {
   ide:"required",
   inicom:"required",
   fincom:"required",
   desc:"required",
   doc:"required",
  },
 messages: {
   ide:"Debe seleccionar un trabajador para agregar la comisión de servicios",
   inicom:"Seleccione el inicio de la comisión de servicios",
   fincom:"Seleccione el final de la comisión de servicios",
   desc:"Escriba una descripción para la comisión de servicios",
   doc:"Seleccione el documento de aprobación de la comisión de servicios",
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
   var datos = $("#f_ncomservicios").serializeArray();
   datos.push({name: "NomForm", value: "f_ncomservicios"});
   $.ajax({
      type: "POST",
      url: "m_inclusiones/a_comservicios/a_gnuecomser.php",
      dataType:"json",
      data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
      beforeSend: function () {
         $("#b_gncomser").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
         $("#b_gncomser").addClass("disabled");
      },
      success: function(data){
         $("#b_gncomser").hide();
         $("#b_gncomser").html("Guardar");
         $("#b_gncomser").removeClass("disabled");
         $("#f_ncomservicios").slideDown();
         $("#f_ncomservicios").html(data.msg);
         if (data.e) {
           actcomisiones();
           $("#m_ncomservicios").modal('hide');
           $("#m_dcomservicios").modal('show');
           detcomser(data.idcs);
         }
      }
   });
 }
} );
//fin función validar datos de comisión de servicios
// función editar comisión de servicios
function edicomser(idcs){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_comservicios/a_fedicomser.php",
    data: { idcs  : idcs},
    beforeSend: function () {
      $("#f_ecomservicios").html("<img src='m_images/cargando.gif'>");
      $("#b_gecomser").hide();
    },
      success:function(a){
        $("#b_gecomser").show();
        $("#f_ecomservicios").html(a);
    }
  });
};
//fin editar comisión de servicios
//funcion validar editar comisión de servicios
$( "#f_ecomservicios" ).validate( {
  rules: {
    idcs:"required",
    inicom:"required",
    fincom:"required",
    desc:"required",
    doc:"required",
   },
  messages: {
    idcs:"Debe seleccionar una comisión de servicios",
    inicom:"Seleccione el inicio de la comisión de servicios",
    fincom:"Seleccione el final de la comisión de servicios",
    desc:"Escriba una descripción para la comisión de servicios",
    doc:"Seleccione el documento de aprobación de la comisión de servicios",
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
   var datos = $("#f_ecomservicios").serializeArray();
   datos.push({name: "NomForm", value: "f_ecomservicios"});
   $.ajax({
      type: "POST",
      url: "m_inclusiones/a_comservicios/a_gedicomser.php",
      dataType: "json",
      data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
      beforeSend: function () {
         $("#b_gecomser").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
         $("#b_gecomser").addClass("disabled");
      },
      success: function(data){
         $("#b_gecomser").hide();
         $("#b_gecomser").html("Guardar");
         $("#b_gecomser").removeClass("disabled");
         $("#f_ecomservicios").html(data.msg);
         $("#f_ecomservicios").slideDown();
         if (data.e) {
           actcomisiones();
         }
      }
   });
 }
} );
//fin función validar editar comisión de servicios
// función llamar formulario cancelar comisión de servicios
function cancomser(idcs){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_comservicios/a_fcancomser.php",
 data: { idcs : idcs},
 beforeSend: function () {
   $("#f_ccomservicios").html("<img src='m_images/cargando.gif'>");
   $("#b_siccomser").hide();
   $("#b_noccomser").html("Cerrar");
 },
 success:function(a){
   $("#b_siccomser").show();
   $("#b_noccomser").html("No");
   $("#f_ccomservicios").html(a);
 }
});
};
//fin función llamar formulario cancelar comisión de servicios
//función cancelar comisión de servicios
$("#f_ccomservicios").submit(function(e){
  e.preventDefault();
  var datos = $("#f_ccomservicios").serializeArray();
  datos.push({name: "NomForm", value: "f_ccomservicios"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_comservicios/a_gcancomser.php",
        type:  "post",
        beforeSend: function () {
          $("#f_ccomservicios").html("<img scr='m_images/cargando.gif'>");
          $("#b_siccomser").hide();
        },
        success:  function (data) {
          $("#f_ccomservicios").html(data.msg);
          $("#b_noccomser").html("Cerrar");
          if (data.e) {
            actcomisiones();

          }
        }
    });
});
//fin función cancelar comisión de servicios
// función llamar formulario detalle comisión de servicios
function detcomser(idcs){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_comservicios/a_fdetcomser.php",
 dataType: "html",
 data: { idcs : idcs},
   beforeSend: function(){
     $("#f_dcomservicios").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
   },
   success: function(a){
     $("#f_dcomservicios").html(a);
   }
});
};
//fin función llamar formulario detalle comisión de servicios
//funcion llamar formulario Encargatura
function nueenca(idcs){
  $.ajax({
    type:"post",
    url:"m_inclusiones/a_comservicios/a_fnueenc.php",
    dataType: "html",
    data: { idcs : idcs},
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
    idcs:"required",
    inienc:"required",
    finenc:"required",
    enc:"required",
    tip:"required",
   },
  messages: {
    idcs:"Debe seleccionar una comisión de servicios",
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
      url: "m_inclusiones/a_comservicios/a_gnueenc.php",
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
           actencargaturas(data.idcs);

         }
      }
   });
 }
} );
//fin función validar Encargatura

// Función recibir datos para reporte de comsiones por trabajador
$("#f_rcomsertra").submit(function(e){
 e.preventDefault();
 var datos = $("#f_rcomsertra").serializeArray();
 datos.push({name: "NomForm", value: "f_rcomsertra"});
 $.ajax({
       data:  datos,
       url:   "m_inclusiones/a_comservicios/a_rcomsertra.php",
       type:  "post",
       beforeSend: function () {
         $("#b_bcomsertra").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_bcomsertra").html("Buscar");
         $("#r_comsertra").html(response);
       }
   });
});
// Fin función recibir datos para reporte de comsiones por trabajador

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
// Recibir datos para EjecuciÃ³n Vacaci

// Función Recibir datos para reporte comsiones por meses.
$("#f_rcomsermes").submit(function(e){
 e.preventDefault();
 var datos = $("#f_rcomsermes").serializeArray();
 datos.push({name: "NomForm", value: "f_rcomsermes"});
 $.ajax({
       data:  datos,
       url:   "m_inclusiones/a_comservicios/a_rcomsermes.php",
       type:  "post",
       beforeSend: function () {
         $("#b_bcomermes").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
       },
       success:  function (response) {
         $("#b_bcomermes").html("Buscar");
         $("#r_comsermes").html(response);
       }
   });
});
// Función Fin Recibir datos para reporte comsiones por meses.

//funcion buscar comisiones por resolución
$("#b_bcomserres").click(function(){
  var doc=$("#doc").val();
  $.ajax({
  type: "post",
  url: "m_inclusiones/a_comservicios/a_rcomserres.php",
  data: { doc : doc},
  dataType: "html",
  beforeSend: function () {
    $("#r_comserres").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_comserres").html(a);
  }
  });
})
//Fin funcion buscar comisiones por resolución


// Exportar comisiones por resolución
$("#b_ecomserres").click(function(){
  var doc=$("#doc").val();
  if (doc==null) {
    alert("No seleccionó ninguna resolución");
  }else {
     window.location.href = "m_exportar/e_excomserres.php?doc="+doc;
  }
})

// Fin exportar comisiones por resolución

// Exportar comisiones por mes
$("#b_ecomsermes").click(function(){
  var mesini=$("#mesini").val();
  var mesfin=$("#mesfin").val();
  var estcs=$("#estcs").val();
  if (mesini==null || mesfin==null || estcs==null) {
    alert("Error: Debe seleccionar al menos un valor en cada campo");
  }else {
     window.location.href = "m_exportar/e_excomsermes.php?mesini="+mesini+"&mesfin="+mesfin+"&estcs="+estcs;
  }
})

// Fin exportar comisiones por mes
