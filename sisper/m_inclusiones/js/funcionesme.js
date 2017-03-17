$("#p_personal").on("click",function(e){
	$.ajax({
		type:"post",
		url:"m_vistas/p_personal.php",
		beforeSend: function () {
                $("#ConPage").html("<img scr='m_images/cargando.gif'>");
        },
		success:function(a){
			$("#ConPage").html(a);
			$("#p_personal").addClass("active");
		}
	});
});

/*******/
$('#cumples').slimScroll({
    height: '330px'
});
//funcion tooltip
$('#sptooltip').tooltip();
//fin funcion tooltip
//funcion llamar formulario nueva coordinación
$("#b_nuecoordinacion").on("click",function(e){
  $.ajax({
    type:"post",
    url:"m_inclusiones/ajax/a_nuecoordinacion.php",
    beforeSend: function () {
      $("#r_nuecoordinacion").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_nuecoordinacion").html(a);
      $("#b_gnuecoordinacion").show();
    }
  });
});
//funcion llamar formulario nueva coordinación
//funcion validar coordinación
$( "#f_nuecoordinacion" ).validate( {
    rules: {
      den:{required:true, minlength:5},
    },
    messages: {
      den: {required:"Ingrese la denominación de la coordinación.",minlength:"Mínimo 5 caracteres"},
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
      var datos = $("#f_nuecoordinacion").serializeArray();
      datos.push({name: "NomForm", value: "f_nuecoordinacion"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gnuecoordinacion.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnuecoordinacion").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gnuecoordinacion").addClass("disabled");
         },
         success: function(data){
            $("#b_gnuecoordinacion").hide();
            $("#b_gnuecoordinacion").html("Guardar");
            $("#b_gnuecoordinacion").removeClass("disabled");
            $("#r_nuecoordinacion").html(data);
            $("#r_nuecoordinacion").slideDown();
         }
      });
    }
  } );
//fin función validar coordinación
//funcion detalle coordinacion
function detcoordinacion(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/ajax/a_detcoordinacion.php",
    data: { idco : id },
    beforeSend: function () {
      $("#r_detcoordinacion").html("<img src='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_detcoordinacion").html(a);
    }
  });
};
//fin funcion detalle coordinacion
//función actualizar page coordinacion
$('#m_nuecoordinacion').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin función actualizar page coordinacion
//funciones editar coordinacion
function edicoordinacion(id){
	$.ajax({
	  type: "post",
	  url: "m_inclusiones/ajax/a_edicoordinacion.php",
	  data: { idco : id },
	  beforeSend: function () {
	    $("#r_edicoordinacion").html("<img src='m_images/cargando.gif'>");
	  },
	  success:function(a){
	    $("#r_edicoordinacion").html(a);
	    $("#b_gedicoordinacion").show();
	  }
	});
};
//fin funciones editar coordinacion
//funcion validar editar coordinación
$( "#f_edicoordinacion" ).validate( {
    rules: {
      den:{required:true, minlength:5},
    },
    messages: {
      den: {required:"Ingrese la denominación de la coordinación.",minlength:"Mínimo 5 caracteres"},
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
      var datos = $("#f_edicoordinacion").serializeArray();
      datos.push({name: "NomForm", value: "f_edicoordinacion"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedicoordinacion.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedicoordinacion").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedicoordinacion").addClass("disabled");
         },
         success: function(data){
            $("#b_gedicoordinacion").hide();
            $("#b_gedicoordinacion").html("Guardar");
            $("#b_gedicoordinacion").removeClass("disabled");
            $("#r_edicoordinacion").html(data);
            $("#r_edicoordinacion").slideDown();
         }
      });
    }
  } );
//fin función validar editar coordinación
//función actualizar page coordinacion
$('#m_edicoordinacion, #m_descoordinacion, #m_actcoordinacion').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin función actualizar page coordinacion
//funciones desactivar local
function descoordinacion(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_descoordinacion.php",
  data: { idco : id },
  beforeSend: function () {
    $("#r_descoordinacion").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_descoordinacion").html(a);
    $("#b_gdescoordinacion").show();
  }
});
};
$("#f_descoordinacion").submit(function(e){
  e.preventDefault();
  var datos = $("#f_descoordinacion").serializeArray();
  datos.push({name: "NomForm", value: "f_descoordinacion"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/ajax/a_gdescoordinacion.php",
        type:  "post",
        beforeSend: function () {
          $("#r_descoordinacion").html("<img scr='m_images/cargando.gif'>");
          $("#b_gdescoordinacion").hide();
        },
        success:  function (response) {
          $("#r_descoordinacion").html(response);
        }
    });
});
//función actualizar page local
//funciones desactivar local
function actcoordinacion(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_actcoordinacion.php",
  data: { idco : id },
  beforeSend: function () {
    $("#r_actcoordinacion").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_actcoordinacion").html(a);
    $("#b_gactcoordinacion").show();
  }
});
};
$("#f_actcoordinacion").submit(function(e){
  e.preventDefault();
  var datos = $("#f_actcoordinacion").serializeArray();
  datos.push({name: "NomForm", value: "f_actcoordinacion"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/ajax/a_gactcoordinacion.php",
        type:  "post",
        beforeSend: function () {
          $("#r_actcoordinacion").html("<img scr='m_images/cargando.gif'>");
          $("#b_gactcoordinacion").hide();
        },
        success:  function (response) {
          $("#r_actcoordinacion").html(response);
        }
    });
});
//función actualizar page local
//funcion llamar formulario nueva coordinación
$("#b_asicoordinador").on("click",function(e){
  $.ajax({
    type:"post",
    url:"m_inclusiones/ajax/a_asicoordinador.php",
    beforeSend: function () {
      $("#r_asicoordinador").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_asicoordinador").html(a);
      $("#b_gasicoordinador").show();
    }
  });
});
//funcion llamar formulario nueva coordinación
//funcion validar coordinación
$( "#f_asicoordinador" ).validate( {
    rules: {
      coo: "required",
      cood: "required",
      con: "required",
      fecini:{required:true, datePE:true}
    },
    messages: {
      coo: "Seleccione una coordinación.",
      cood: "Seleccione un coordinador.",
      con: "Seleccione una condición.",
      fecini: {required:"Ingrese fecha que asume la coordinación.",datePE:"Ingrese una fecha valida."}
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
      var datos = $("#f_asicoordinador").serializeArray();
      datos.push({name: "NomForm", value: "f_asicoordinador"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gasicoordinador.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gasicoordinador").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gasicoordinador").addClass("disabled");
         },
         success: function(data){
            $("#b_gasicoordinador").hide();
            $("#b_gasicoordinador").html("Guardar");
            $("#b_gasicoordinador").removeClass("disabled");
            $("#r_asicoordinador").html(data);
            $("#r_asicoordinador").slideDown();
         }
      });
    }
  } );
//fin función validar coordinación
//funciones editar coordinacion
function edicoordinador(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/ajax/a_edicoordinador.php",
    data: { idco : id },
    beforeSend: function () {
      $("#r_edicoordinador").html("<img src='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_edicoordinador").html(a);
      $("#b_gedicoordinador").show();
    }
  });
};
//fin funciones editar coordinacion
//funcion validar coordinación
$( "#f_edicoordinador" ).validate( {
    rules: {
      coo: "required",
      cood: "required",
      con: "required",
      fecini:{required:true, datePE:true}
    },
    messages: {
      coo: "Seleccione una coordinación.",
      cood: "Seleccione un coordinador.",
      con: "Seleccione una condición.",
      fecini: {required:"Ingrese fecha que asume la coordinación.",datePE:"Ingrese una fecha valida."}
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
      var datos = $("#f_edicoordinador").serializeArray();
      datos.push({name: "NomForm", value: "f_edicoordinador"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedicoordinador.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedicoordinador").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedicoordinador").addClass("disabled");
         },
         success: function(data){
            $("#b_gedicoordinador").hide();
            $("#b_gedicoordinador").html("Guardar");
            $("#b_gedicoordinador").removeClass("disabled");
            $("#r_edicoordinador").html(data);
            $("#r_edicoordinador").slideDown();
         }
      });
    }
  } );
//fin función validar coordinación
$('#m_nuecoordinacion, #m_edicoordinacion, #m_asicoordinador, #m_edicoordinador').on('hidden.bs.modal', function () {
 document.location.reload();
})