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

//funciones directorio personal
//funcion validar formulario buscar telefono personal
$( "#f_btelper" ).validate( {
    rules: {
      per: "required"
    },
    messages: {
      fec: "Elija un personal."
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
      var datos = $("#f_btelper").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_directorio/a_btelper.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_btelper").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
            $("#b_btelper").addClass("disabled");
         },
         success: function(data){
            $("#b_btelper").html("Buscar");
            $("#b_btelper").removeClass("disabled");
            $(".r_telefono").html(data);
            $(".r_telefono").slideDown();
         }
      });
    }
  } );
//funcion validar formulario buscar telefono personal
//funcion validar formulario buscar correo personal
$( "#f_bcorper" ).validate( {
    rules: {
      per: "required"
    },
    messages: {
      fec: "Elija un personal."
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
      var datos = $("#f_bcorper").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_directorio/a_bcorper.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_bcorper").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
            $("#b_bcorper").addClass("disabled");
         },
         success: function(data){
            $("#b_bcorper").html("Buscar");
            $("#b_bcorper").removeClass("disabled");
            $(".r_correo").html(data);
            $(".r_correo").slideDown();
         }
      });
    }
  } );
//funcion validar formulario buscar correo personal
//funciones nuevo teléfono
function nuetel(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_directorio/a_fnuetel.php",
    data: { id : id },
    beforeSend: function () {
      $("#r_nuetel").html("<img src='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_nuetel").html(a);
      $("#b_gnuetel").show();
    }
  });
};
//fin funciones nuevo teléfono
//funcion validar formulario nuevo telefono personal
$( "#f_nuetel" ).validate( {
    rules: {
      tiptel: "required",
      num:{required:true,minlength:4}
    },
    messages: {
      fec: "Elija un tipo de telefono.",
      num:{required:"Ingrese el número.",minlength:"Mínimo 4 caracteres."}
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
      var datos = $("#f_nuetel").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_directorio/a_gnuetel.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnuetel").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gnuetel").addClass("disabled");
         },
         success: function(data){
            $("#b_gnuetel").hide();
            $("#b_gnuetel").html("Guardar");
            $("#b_gnuetel").removeClass("disabled");
            $("#r_nuetel").html(data);
            $("#r_nuetel").slideDown();
         }
      });
    }
  } );
//funcion validar formulario nuevo telefono personal
//funciones nuevo teléfono
function editel(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_directorio/a_feditel.php",
    data: { id : id },
    beforeSend: function () {
      $("#r_editel").html("<img src='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_editel").html(a);
      $("#b_geditel").show();
    }
  });
};
//fin funciones nuevo teléfono
//funcion validar formulario nuevo telefono personal
$( "#f_editel" ).validate( {
    rules: {
      tiptel: "required",
      num:{required:true,minlength:4}
    },
    messages: {
      fec: "Elija un tipo de telefono.",
      num:{required:"Ingrese el número.",minlength:"Mínimo 4 caracteres."}
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
      var datos = $("#f_editel").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_directorio/a_geditel.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_geditel").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_geditel").addClass("disabled");
         },
         success: function(data){
            $("#b_geditel").hide();
            $("#b_geditel").html("Guardar");
            $("#b_geditel").removeClass("disabled");
            $("#r_editel").html(data);
            $("#r_editel").slideDown();
         }
      });
    }
  } );
//funcion validar formulario nuevo telefono personal
//funciones nuevo teléfono
function elitel(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_directorio/a_felitel.php",
    data: { id : id },
    beforeSend: function () {
      $("#r_elitel").html("<img src='m_images/cargando.gif'>");
      $("#b_sielitel").hide();
      $("#b_noelitel").html("Cerrar");
    },
    success:function(a){
      $("#r_elitel").html(a);
      $("#b_sielitel").removeClass("disabled");
      $("#b_sielitel").html("Sí");
      $("#b_sielitel").show();
      $("#b_noelitel").html("No");
    }
  });
};
//fin funciones nuevo teléfono
//funcion eliminar teléfono
$("#f_elitel").submit(function(e){
  e.preventDefault();
  var datos = $("#f_elitel").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_directorio/a_elitel.php",
        type:  "post",
        beforeSend: function () {
          $("#b_sielitel").html("<i class='fa fa-spinner fa-spin'></i> Eliminando");
          $("#b_sielitel").addClass("disabled");
          $("#b_noelitel").hide();
        },
        success:  function (response) {
          $("#b_sielitel").hide();
          $("#b_noelitel").html("Cerrar");
          $("#b_noelitel").show();
          $("#r_elitel").html(response);
        }
    });
});
//fin funcion eliminar teléfono
//funciones editar correo
function edicor(id,tc){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_directorio/a_fedicor.php",
    data: { id : id, tc : tc },
    beforeSend: function () {
      $("#r_edicor").html("<img src='m_images/cargando.gif'>");
      $("#b_gedicor").hide();
    },
    success:function(a){
      $("#b_gedicor").show();
      $("#r_edicor").html(a);
    }
  });
};
//fin funciones editar correo
//funcion validar formulario nuevo telefono personal
$( "#f_edicor" ).validate( {
    rules: {
      cor:{required:true,email:true}
    },
    messages: {
      cor:{required:"Ingrese el correo"}
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
      var datos = $("#f_edicor").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_directorio/a_gedicor.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedicor").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gedicor").addClass("disabled");
         },
         success: function(data){
            $("#b_gedicor").hide();
            $("#b_gedicor").html("Guardar");
            $("#b_gedicor").removeClass("disabled");
            $("#r_edicor").html(data);
            $("#r_edicor").slideDown();
         }
      });
    }
  } );
//funcion validar formulario nuevo telefono personal

$('#m_nuetel, #m_editel, #m_elitel').on('hidden.bs.modal', function () {
      var per = $("#per").val();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_directorio/a_btelper.php",
         dataType: "html",
         data: {per: per},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_btelper").html("<i class='fa fa-spinner fa-spin'></i> Actualizando");
            $("#b_btelper").addClass("disabled");
         },
         success: function(data){
            $("#b_btelper").html("Buscar");
            $("#b_btelper").removeClass("disabled");
            $(".r_telefono").html(data);
            $(".r_telefono").slideDown();
         }
      });
});

$('#m_edicor').on('hidden.bs.modal', function () {
      var per1 = $("#per1").val();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_directorio/a_bcorper.php",
         dataType: "html",
         data: {per1: per1},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_btelper").html("<i class='fa fa-spinner fa-spin'></i> Actualizando");
            $("#b_btelper").addClass("disabled");
         },
         success: function(data){
            $("#b_btelper").html("Buscar");
            $("#b_btelper").removeClass("disabled");
            $(".r_correo").html(data);
            $(".r_correo").slideDown();
         }
      });
});

$(".select2peract").select2({
  placeholder: 'Selecione a un personal',
  ajax: {
    url: 'm_inclusiones/a_general/a_selpersonal.php',
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
});

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
  minimumInputLength: 4
});