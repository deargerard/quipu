//fecha intranet
$('#fec').datepicker({
  format: "dd/mm/yyyy",
  language: "es",
  autoclose: true,
  todayHighlight: true,
  endDate: new Date()
});
$("#mesano, #mesanoc").datepicker({
  autoclose: true,
  format: "mm/yyyy",
  language: "es",
  minViewMode: "months",
  maxViewMode: "months",
  startDate: '01/2000',
  //endDate: new Date(),
  startView: "month" //does not work
});
$("#anop, #anodl").datepicker({
  autoclose: true,
  format: "yyyy",
  language: "es",
  minViewMode: "years",
  maxViewMode: "years",
  startDate: '2000',
  endDate: new Date(),
  startView: "year" //does not work
});
//fin fecha intranet
//funcion validar formulario buscar asistencia diaria
$( "#f_badiaria" ).validate( {
    rules: {
      fec: {required:true, datePE:true}
    },
    messages: {
      fec: {required:"Ingrese la fecha"}
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
            $(".d_adiaria").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
         },
         success: function(data){
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
      mesano: {required:true,minlength:7},
      emp: {required:true}
    },
    messages: {
      mesano: {required:"Seleccione un mes/año"},
      emp: {required:"Seleccione un personal"}
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
            $(".d_aempleado").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
         },
         success: function(data){
            $(".d_aempleado").html(data);
            $(".d_aempleado").slideDown();
         }
      });
    }
  } );
//funcion validar formulario buscar asistencia empleado

$("#vig").attr('autocomplete', 'off');

$("#vig").keyup(function(){
  var vig=$("#vig").val();
  if(vig.length>=3){
    $.ajax({
      type: "POST",
      url:"m_inclusiones/a_asistencia/bvigilante.php",
      dataType:"html",
      data:{vig: vig},
      beforeSend: function(){
        $(".d_vigilante").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
      },
      success: function(e){
        $(".d_vigilante").html(e);
        $(".d_vigilante").slideDown();
      }
    });
  }
});

function actvigilante(){
  var vig=$("#vig").val();
  if(vig.length>=3){
    $.ajax({
      type: "POST",
      url:"m_inclusiones/a_asistencia/bvigilante.php",
      dataType:"html",
      data:{vig: vig},
      beforeSend: function(){
        $(".d_vigilante").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
      },
      success: function(e){
        $(".d_vigilante").html(e);
        $(".d_vigilante").slideDown();
      }
    });
  }
}

$("#b_fvigilante").click(function(){
  $.ajax({
    url:"m_inclusiones/a_asistencia/fnvigilante.php",
    dataType:"html",
    beforeSend: function(){
      $("#f_nvigilante").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
      $("#b_gnvigilante").hide();
    },
    success: function(e){
      $("#b_gnvigilante").show();
      $("#f_nvigilante").html(e);
      $("#f_nvigilante").slideDown();
    }
  });
});

$( "#f_nvigilante" ).validate( {
    rules: {
      ape: {required:true, minlength:3},
      nom: {required:true, minlength:3},
      dni: {required:true, minlength:8}
    },
    messages: {
      ape: {required:"Ingrese apellidos"},
      nom: {required:"Ingrese nombres"},
      dni: {required:"Ingrese DNI"}
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
      var datos = $("#f_nvigilante").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_asistencia/nvigilante.php",
         dataType: "json",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#f_nvigilante").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
            $("#b_gnvigilante").hide();
         },
         success: function(e){
            $("#f_nvigilante").html(e.mensaje);
            $("#f_nvigilante").slideDown();
         }
      });
    }
  } );

function edivig(id){
  $.ajax({
    type: "POST",
    url: "m_inclusiones/a_asistencia/fevigilante.php",
    dataType: "html",
    data: {id: id},
    beforeSend: function(){
      $("#f_evigilante").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
      $("#b_gevigilante").hide();
    },
    success: function(e){
      $("#f_evigilante").html(e);
      $("#f_evigilante").slideDown();
      $("#b_gevigilante").show();
    }
  });
}

$( "#f_evigilante" ).validate( {
    rules: {
      ape: {required:true, minlength:3},
      nom: {required:true, minlength:3},
      dni: {required:true, minlength:8}
    },
    messages: {
      ape: {required:"Ingrese apellidos"},
      nom: {required:"Ingrese nombres"},
      dni: {required:"Ingrese DNI"}
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
      var datos = $("#f_evigilante").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_asistencia/evigilante.php",
         dataType: "json",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#f_evigilante").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
            $("#b_gevigilante").hide();
         },
         success: function(e){
            $("#f_evigilante").html(e.mensaje);
            $("#f_evigilante").slideDown();
            if(e.exito){
              actvigilante();
            }
         }
      });
    }
  } );

function convig(id){
  $.ajax({
    type: "POST",
    url: "m_inclusiones/a_asistencia/fccontrasena.php",
    dataType: "html",
    data: {id: id},
    beforeSend: function(){
      $("#f_ccontrasena").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
      $("#b_gccontrasena").hide();
    },
    success: function(e){
      $("#f_ccontrasena").html(e);
      $("#f_ccontrasena").slideDown();
      $("#b_gccontrasena").show();
    }
  });
}

$( "#f_ccontrasena" ).validate( {
    rules: {
      con: {required:true, minlength:6},
      ncon: {required:true, equalTo:"#con"}
    },
    messages: {
      con: {required:"Ingrese la nueva contraseña"},
      ncon: {required:"Repita la nueva contraseña"}
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
      var datos = $("#f_ccontrasena").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_asistencia/ccontrasena.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#f_ccontrasena").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
            $("#b_gccontrasena").hide();
         },
         success: function(e){
            $("#f_ccontrasena").html(e);
            $("#f_ccontrasena").slideDown();
         }
      });
    }
  } );

function estvig(id){
  $.ajax({
    type: "POST",
    url: "m_inclusiones/a_asistencia/festvigilante.php",
    dataType: "html",
    data: {id: id},
    beforeSend: function(){
      $("#f_estvigilante").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
      $("#b_sievigilante").hide();
    },
    success: function(e){
      $("#f_estvigilante").html(e);
      $("#f_estvigilante").slideDown();
      $("#b_sievigilante").show();
    }
  });
}

$("#f_estvigilante").submit(function(e){
  var datos = $("#f_estvigilante").serializeArray();
  $.ajax({
    type: "POST",
    url: "m_inclusiones/a_asistencia/estvigilante.php",
    dataType: "json",
    data: datos,
    beforeSend: function(){
      $("#f_estvigilante").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
      $("#b_sievigilante").hide();
    },
    success: function(e){
      $("#f_estvigilante").html(e.mensaje);
      $("#f_estvigilante").slideDown("slow");
      if(e.exito){
        actvigilante();
      }
    }
  });
  e.preventDefault();
});

$( "#f_bcaempleado" ).validate( {
    rules: {
      mesanoc: {required:true,minlength:7},
      empc: {required:true}
    },
    messages: {
      mesanoc: {required:"Seleccione un mes/año"},
      empc: {required:"Seleccione un personal"}
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
      var datos = $("#f_bcaempleado").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_asistencia/bcaempleado.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#d_caempleado").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
         },
         success: function(data){
            $("#d_caempleado").html(data);
            $("#d_caempleado").slideDown();
         }
      });
    }
  } );
function acasistencia(mesano, emp, car){
    $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/bcaempleado.php",
     dataType: "html",
     data: {mesanoc: mesano, per: emp, car: car},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_caempleado").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
     },
     success: function(data){
        $("#d_caempleado").html(data);
        $("#d_caempleado").slideDown();
     }
  });
}

function ghorario(tur, fec, emp){
  $.ajax({
    type: "POST",
    url: "m_inclusiones/a_asistencia/ghorario.php",
    dataType: "json",
    data: {tur:tur.value, fec:fec, emp:emp},
    success: function(d){
      if(d.e){
        alertify.success(d.m);
      }else{
        alertify.error(d.m);
      }
    }
  });
}

function amarcacion(per, mes, ano){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/famarcacion.php",
     dataType: "html",
     data: {per: per, mes: mes, ano: ano},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#f_amarcacion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gamarcacion").hide();
     },
     success: function(data){
        $("#f_amarcacion").html(data);
        $("#f_amarcacion").slideDown();
        $("#b_gamarcacion").show();
     }
  });
}

$("#f_amarcacion").submit(function(e){
  var datos = $("#f_amarcacion").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gamarcacion.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_amarcacion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gamarcacion").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_amarcacion").html(d.m);
        $("#f_amarcacion").slideDown();
        amarmen();
      }else{
        $("#d_amarcacion").html(d.m);
        $("#d_amarcacion").slideDown();
        $("#b_gamarcacion").show();
      }
     }
  });
  e.preventDefault();
});

function edimar(idm, mes, ano){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/femarcacion.php",
     dataType: "html",
     data: {idm: idm, mes: mes, ano: ano},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#f_emarcacion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gemarcacion").hide();
     },
     success: function(data){
        $("#f_emarcacion").html(data);
        $("#f_emarcacion").slideDown();
        $("#b_gemarcacion").show();
     }
  });
}

$("#f_emarcacion").submit(function(e){
  var datos = $("#f_emarcacion").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gemarcacion.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_emarcacion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gemarcacion").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_emarcacion").html(d.m);
        $("#f_emarcacion").slideDown();
        amarmen();
      }else{
        $("#d_emarcacion").html(d.m);
        $("#d_emarcacion").slideDown();
        $("#b_gemarcacion").show();
      }
     }
  });
  e.preventDefault();
});

function amarmen(){
  var datos=$("#f_baempleado").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/baempleado.php",
     dataType: "html",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $(".d_aempleado").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
     },
     success: function(data){
        $(".d_aempleado").html(data);
        $(".d_aempleado").slideDown();
     }
  });
}

$("#f_bpermisos").submit(function(e){
  var datos=$("#f_bpermisos").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/bpermisos.php",
     dataType: "html",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $(".d_permisos").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
     },
     success: function(data){
        $(".d_permisos").html(data);
        $(".d_permisos").slideDown();
     }
  });
  e.preventDefault();
});

function apermiso(per, ano){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/fapermiso.php",
     dataType: "html",
     data: {per: per, ano: ano},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#f_apermiso").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gapermiso").hide();
     },
     success: function(data){
        $("#f_apermiso").html(data);
        $("#f_apermiso").slideDown();
        $("#b_gapermiso").show();
     }
  });
}

$("#f_apermiso").submit(function(e){
  var datos = $("#f_apermiso").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gapermiso.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_apermiso").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gapermiso").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_apermiso").html(d.m);
        $("#f_apermiso").slideDown();
        actper();
      }else{
        $("#d_apermiso").html(d.m);
        $("#d_apermiso").slideDown();
        $("#b_gapermiso").show();
      }
     }
  });
  e.preventDefault();
});

function ediper(idp,per){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/fepermiso.php",
     dataType: "html",
     data: {idp: idp, per: per},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#f_epermiso").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gepermiso").hide();
     },
     success: function(data){
        $("#f_epermiso").html(data);
        $("#f_epermiso").slideDown();
        $("#b_gepermiso").show();
     }
  });
}

$("#f_epermiso").submit(function(e){
  var datos = $("#f_epermiso").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gepermiso.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_epermiso").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gepermiso").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_epermiso").html(d.m);
        $("#f_epermiso").slideDown();
        actper();
      }else{
        $("#d_epermiso").html(d.m);
        $("#d_epermiso").slideDown();
        $("#b_gepermiso").show();
      }
     }
  });
  e.preventDefault();
});

function estper(idp){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/festpermiso.php",
     dataType: "html",
     data: {idp: idp},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#f_estpermiso").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_siepermiso").hide();
     },
     success: function(data){
        $("#f_estpermiso").html(data);
        $("#f_estpermiso").slideDown();
        $("#b_siepermiso").show();
     }
  });
}

$("#f_estpermiso").submit(function(e){
  var datos = $("#f_estpermiso").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gestpermiso.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_estpermiso").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_siepermiso").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_estpermiso").html(d.m);
        $("#f_estpermiso").slideDown();
        actper();
      }else{
        $("#d_estpermiso").html(d.m);
        $("#d_estpermiso").slideDown();
        $("#b_siepermiso").show();
      }
     }
  });
  e.preventDefault();
});

function detper(idp){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/dpermiso.php",
     dataType: "html",
     data: {idp: idp},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_dpermiso").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
     },
     success: function(data){
        $("#d_dpermiso").html(data);
        $("#d_dpermiso").slideDown();
     }
  });
}

function actper(){
  var datos=$("#f_bpermisos").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/bpermisos.php",
     dataType: "html",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $(".d_permisos").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
     },
     success: function(data){
        $(".d_permisos").html(data);
        $(".d_permisos").slideDown();
     }
  });
}

function acthor(){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/bhorarios.php",
     dataType: "html",
     beforeSend: function () {
        $(".d_horarios").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
     },
     success: function(data){
        $(".d_horarios").html(data);
        $(".d_horarios").slideDown();
     }
  });
}

function agrhor(){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/fahorario.php",
     dataType: "html",
     beforeSend: function () {
        $("#f_ahorario").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gahorario").hide();
     },
     success: function(data){
        $("#f_ahorario").html(data);
        $("#f_ahorario").slideDown();
        $("#b_gahorario").show();
     }
  });
}

$("#f_ahorario").submit(function(e){
  var datos = $("#f_ahorario").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gahorario.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_ahorario").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gahorario").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_ahorario").html(d.m);
        $("#f_ahorario").slideDown();
        acthor();
      }else{
        $("#d_ahorario").html(d.m);
        $("#d_ahorario").slideDown();
        $("#b_gahorario").show();
      }
     }
  });
  e.preventDefault();
});

function esthor(idh){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/festhorario.php",
     dataType: "html",
     data: {idh: idh},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#f_esthorario").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_siehorario").hide();
     },
     success: function(data){
        $("#f_esthorario").html(data);
        $("#f_esthorario").slideDown();
        $("#b_siehorario").show();
     }
  });
}

$("#f_esthorario").submit(function(e){
  var datos = $("#f_esthorario").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gesthorario.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_esthorario").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_siehorario").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_esthorario").html(d.m);
        $("#f_esthorario").slideDown();
        acthor();
      }else{
        $("#d_esthorario").html(d.m);
        $("#d_esthorario").slideDown();
        $("#b_siehorario").show();
      }
     }
  });
  e.preventDefault();
});

function actdlib(){
  var datos=$("#f_bdlibres").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/bdlibres.php",
     dataType: "html",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $(".d_dlibres").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
     },
     success: function(data){
        $(".d_dlibres").html(data);
        $(".d_dlibres").slideDown();
     }
  });
}

$("#b_adlibre").click(function(){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/fadlibre.php",
     dataType: "html",
     beforeSend: function () {
        $("#f_adlibre").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gadlibre").hide();
     },
     success: function(data){
        $("#f_adlibre").html(data);
        $("#f_adlibre").slideDown();
        $("#b_gadlibre").show();
     }
  });
});

$("#f_adlibre").submit(function(e){
  var datos = $("#f_adlibre").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gadlibre.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_adlibre").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_gadlibre").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_adlibre").html(d.m);
        $("#f_adlibre").slideDown();
        actdlib();
      }else{
        $("#d_adlibre").html(d.m);
        $("#d_adlibre").slideDown();
        $("#b_gadlibre").show();
      }
     }
  });
  e.preventDefault();
});

function estdlib(iddl){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/festdlibre.php",
     dataType: "html",
     data: {iddl: iddl},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#f_estdlibre").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_siedlibre").hide();
     },
     success: function(data){
        $("#f_estdlibre").html(data);
        $("#f_estdlibre").slideDown();
        $("#b_siedlibre").show();
     }
  });
}

$("#f_estdlibre").submit(function(e){
  var datos = $("#f_estdlibre").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gestdlibre.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_estdlibre").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_siedlibre").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_estdlibre").html(d.m);
        $("#f_estdlibre").slideDown();
        actdlib();
      }else{
        $("#d_estdlibre").html(d.m);
        $("#d_estdlibre").slideDown();
        $("#b_siedlibre").show();
      }
     }
  });
  e.preventDefault();
});

function hormen(mes, ndias, idp){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/fahmensual.php",
     dataType: "html",
     data: {mes: mes, ndias: ndias, idp: idp},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#f_hmensual").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_ghmensual").hide();
     },
     success: function(data){
        $("#f_hmensual").html(data);
        $("#f_hmensual").slideDown();
        $("#b_ghmensual").show();
     }
  });
}

$("#f_hmensual").submit(function(e){
  var datos = $("#f_hmensual").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gahmensual.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#d_ahmensual").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_ghmensual").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_hmensual").html(d.m);
        $("#f_hmensual").slideDown();
        actdlib();
      }else{
        $("#d_ahmensual").html(d.m);
        $("#d_ahmensual").slideDown();
        $("#b_ghmensual").show();
      }
     }
  });
  e.preventDefault();
});

function elimar(idm, mar){
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/felmarcacion.php",
     dataType: "html",
     data: {idm: idm, mar: mar},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#f_elmarcacion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_sielmarcacion").hide();
     },
     success: function(data){
        $("#f_elmarcacion").html(data);
        $("#f_elmarcacion").slideDown();
        $("#b_sielmarcacion").show();
     }
  });
}

$("#f_elmarcacion").submit(function(e){
  var datos = $("#f_elmarcacion").serializeArray();
  $.ajax({
     type: "POST",
     url: "m_inclusiones/a_asistencia/gelmarcacion.php",
     dataType: "json",
     data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
     beforeSend: function () {
        $("#r_elmarcacion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
        $("#b_sielmarcacion").hide();
     },
     success: function(d){
      if(d.e){
        $("#f_elmarcacion").html(d.m);
        $("#f_elmarcacion").slideDown();
        amarmen();
      }else{
        $("#r_elmarcacion").html(d.m);
        $("#r_elmarcacion").slideDown();
        $("#b_sielmarcacion").show();
      }
     }
  });
  e.preventDefault();
});
