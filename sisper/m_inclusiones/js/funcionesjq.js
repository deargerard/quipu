//func. mantenimiento dependencia
function detdependencia(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_detdependencia.php",
  data: { idd : id },
  beforeSend: function () {
      $("#r_detdependencia").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_detdependencia").html(a);
  }
});
};
function edidependencia(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edidependencia.php",
  data: { idd : id },
  beforeSend: function () {
    $("#r_edidependencia").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edidependencia").html(a);
    $("#b_gedidependencia").show();
  }
});
};
function desdependencia(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_desdependencia.php",
  data: { idd : id },
  beforeSend: function () {
    $("#r_desdependencia").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_desdependencia").html(a);
    $("#b_gdesdependencia").show();
  }
});
};
$("#f_desdependencia").submit(function(e){
  e.preventDefault();
  var datos = $("#f_desdependencia").serializeArray();
  datos.push({name: "NomForm", value: "f_desdependencia"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/ajax/a_gdesdependencia.php",
        type:  "post",
        beforeSend: function () {
          $("#r_desdependencia").html("<img scr='m_images/cargando.gif'>");
          $("#b_gdesdependencia").hide();
        },
        success:  function (response) {
          $("#r_desdependencia").html(response);
        }
    });
});
$("#b_nuedependencia").on("click",function(e){
  $.ajax({
    type:"post",
    url:"m_inclusiones/ajax/a_nuedependencia.php",
    beforeSend: function () {
      $("#r_nuedependencia").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_nuedependencia").html(a);
      $("#b_gnuedependencia").show();
    }
  });
});

$('#m_nuedependencia').on('hidden.bs.modal', function () {
 document.location.reload();
})

$('#m_edidependencia').on('hidden.bs.modal', function () {
 document.location.reload();
})

$('#m_desdependencia').on('hidden.bs.modal', function () {
 document.location.reload();
})

//fin func. mantenimiento dependencia
//funciones acceso
$("#f_ediaccesos").submit(function(e){
  e.preventDefault();
  var datos = $("#f_ediaccesos").serializeArray();
  datos.push({name: "NomForm", value: "f_ediaccesos"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/ajax/a_gediaccesos.php",
        type:  "post",
        beforeSend: function () {
          $("#b_gediaccesos").hide();
          $("#r_accpersonal").html("<img scr='m_images/cargando.gif'>");
        },
        success:  function (response) {
          $("#r_accpersonal").html(response);
        }
    });
});
function camcontrasena(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_camcontrasena.php",
  data: {idd:id},
  beforeSend: function () {
    $("#r_camcontrasena").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_camcontrasena").html(a);
    $("#b_gcamcontrasena").show();
  }
});
};
function ediaccesos(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_ediaccesos.php",
  data: {ide:id},
  beforeSend: function () {
    $("#r_ediaccesos").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_ediaccesos").html(a);
    $("#b_gediaccesos").show();
  }
});
};
//$('#m_ediaccesos').on('hidden.bs.modal', function () {
// document.location.reload();
//})
//fin funciones acceso
//funciones perfil
function camfoto(doc){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_forcamfoto.php",
  data: {doc:doc},
  beforeSend: function () {
    $("#r_ediaccesos").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_camfoto").html(a);
    $("#b_camfoto").show();
  }
});
};
$('#m_camfoto').on('hidden.bs.modal', function () {
 document.location.reload();
})
  //funciones agregar telefono
function agrtelefono(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_agrtelefono.php",
  data: {ide:id},
  beforeSend: function () {
    $("#r_agrtelefono").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_agrtelefono").html(a);
    $("#b_gagrtelefono").show();
  }
});
};
 //validar agregar teléfono
$("#f_agrtelefono").validate({
  rules: {
    tiptel: "required",
    num: {required:true, minlength:4},
  },
  messages: {
    tiptel: "Elija el tipo de teléfono.",
    num: {required:"Ingrese el número de teléfono.",minlength:"Mínimo 4 caracteres"}
  },
  errorElement: "em",
  errorPlacement: function(error, element){
    // Add the `help-block` class to the error element
    error.addClass("help-block");

    if(element.prop("type") === "checkbox"){
      error.insertAfter(element.parent("label"));
    }else if(element.prop("type") === "radio"){
      error.insertAfter(element.parent("label"));
    }
    else{
      error.insertAfter(element);
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents(".valida").addClass("has-error").removeClass("has-success");
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents(".valida").addClass("has-success").removeClass("has-error");
  },
  submitHandler: function(form){
    var datos = $("#f_agrtelefono").serializeArray();
    datos.push({name: "NomForm", value: "f_agrtelefono"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/ajax/a_gagrtelefono.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_gagrtelefono").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
          $("#b_gagrtelefono").addClass("disabled");
        },
       success: function(data){
          $("#b_gagrtelefono").hide();
          $("#b_gagrtelefono").html("Guardar");
          $("#b_gagrtelefono").removeClass("disabled");
          $("#r_agrtelefono").html(data);
          $("#r_agrtelefono").slideDown();
       }
    });
  }
});
//fin validar agregar teléfono
$('#m_agrtelefono').on('hidden.bs.modal', function () {
 $("#dcontacto").load("m_inclusiones/ajax/a_rdcontacto.php");
})
  //fin funciones agregar telefono
  //funciones editar telefono
function editelefono(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_editelefono.php",
  data: {idt:id},
  beforeSend: function () {
    $("#r_editelefono").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_editelefono").html(a);
    $("#b_geditelefono").show();
  }
});
};
 //validar agregar teléfono
$("#f_editelefono").validate({
  rules: {
    tiptel: "required",
    num: {required:true, minlength:4},
  },
  messages: {
    tiptel: "Elija el tipo de teléfono.",
    num: {required:"Ingrese el número de teléfono.",minlength:"Mínimo 4 caracteres"}
  },
  errorElement: "em",
  errorPlacement: function(error, element){
    // Add the `help-block` class to the error element
    error.addClass("help-block");

    if(element.prop("type") === "checkbox"){
      error.insertAfter(element.parent("label"));
    }else if(element.prop("type") === "radio"){
      error.insertAfter(element.parent("label"));
    }
    else{
      error.insertAfter(element);
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents(".valida").addClass("has-error").removeClass("has-success");
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents(".valida").addClass("has-success").removeClass("has-error");
  },
  submitHandler: function(form){
    var datos = $("#f_editelefono").serializeArray();
    datos.push({name: "NomForm", value: "f_editelefono"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/ajax/a_geditelefono.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_geditelefono").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
          $("#b_geditelefono").addClass("disabled");
       },
       success: function(data){
          $("#b_geditelefono").hide();
          $("#b_geditelefono").html("Guardar");
          $("#b_geditelefono").removeClass("disabled");
          $("#r_editelefono").html(data);
          $("#r_editelefono").slideDown();
       }
    });
  }
});
//fin validar agregar teléfono
$('#m_editelefono').on('hidden.bs.modal', function () {
 $("#dcontacto").load("m_inclusiones/ajax/a_rdcontacto.php");
})
  //fin funciones editar telefono
  //funciones eliminar telefono
function elitelefonop(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_elitelefono.php",
  data: {idt:id},
  beforeSend: function () {
    $("#r_elitelefono").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_elitelefono").html(a);
    $("#b_gelitelefono").show();
  }
});
};
$("#f_elitelefonop").submit(function(e){
  e.preventDefault();
  var datos = $("#f_elitelefonop").serializeArray();
  datos.push({name: "NomForm", value: "f_elitelefonop"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/ajax/a_gelitelefono.php",
        type:  "post",
        beforeSend: function () {
          $("#b_gelitelefono").hide();
          $("#r_elitelefono").html("<img scr='m_images/cargando.gif'>");
        },
        success:  function (response) {
          $("#r_elitelefono").html(response);
        }
    });
});
$('#m_elitelefono').on('hidden.bs.modal', function () {
 $("#dcontacto").load("m_inclusiones/ajax/a_rdcontacto.php");
})
  //fin funciones eliminar telefono
function detcargo(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/ajax/a_detcargo.php",
    data: { idc : id },
    beforeSend: function () {
      $("#r_detdependencia").html("<img src='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_detcargo").html(a);
    }
  });
};
//funciones editar perfil personal
function edidatpersonales(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edidatpersonales.php",
  data: { idp : id },
  beforeSend: function () {
    $("#r_edidatpersonales").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edidatpersonales").html(a);
    $("#b_gedidatpersonales").show();
  }
});
};
//validar formulario editar datos personales
$( "#f_edidatpersonales" ).validate( {
  rules: {
    apepat: "required",
    apemat: "required",
    nom: "required",
    fecnac:{required:true, datePE:true},
    nac: "required",
    depnac: "required",
    pronac: "required",
    disnac: "required",
    estciv: "required",
    libmil:{required:false, minlength:2},
    aut:{required:false,minlength:15},
    ruc:{required:false,minlength:11},
    corins:{required:false,email:true},
    corper:{required:true,email:true},
    numcue:{required:false,minlength:10},
    entcts:{required:false,minlength:3},
    grusan:"required"
  },
  messages: {
    apepat: "Ingrese apellido paterno.",
    apemat: "Ingrese apellido materno.",
    nom: "Ingrese nombres.",
    fecnac: {required:"Ingrese fecha de nacimiento.",datePE:"Ingrese una fecha valida."},
    nac: "Ingrese nacionalidad.",
    depnac:"Elija departamento.",
    pronac:"Elija provincia.",
    disnac:"Elija distrito.",
    estciv:"Elija estado civil.",
    libmil:{minlength:"Mínimo 8 caracteres."},
    aut:{minlength:"El autogenerado contiene 15 caracteres."},
    ruc:{minlength:"El RUC contiene 11 caracteres."},
    numcue:{minlength:"Mínimo 10 caracteres."},
    entcts:{minlength:"Mínimo 3 caracteres."},
    grusan:"Elija grupo sanguineo."
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
    var datos = $("#f_edidatpersonales").serializeArray();
    datos.push({name: "NomForm", value: "f_edidatpersonales"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/ajax/a_gedidatpersonales.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_gedidatpersonales").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
          $("#b_gedidatpersonales").addClass("disabled");
       },
       success: function(data){
          $("#b_gedidatpersonales").hide();
          $("#b_gedidatpersonales").html("Guardar");
          $("#b_gedidatpersonales").removeClass("disabled");
          $("#r_edidatpersonales").html(data);
          $("#r_edidatpersonales").slideDown();
       }
    });
  }
});
$('#m_edidatpersonales').on('hidden.bs.modal', function () {
 $("#datose").load("m_inclusiones/ajax/a_rdatos.php");
 $("#nomcare").load("m_inclusiones/ajax/a_rnomcar.php");
})
//validar formulario editar datos personales
//funciones actualizar selects
function cprovincia(val){
  $('#pronac').html('<option value="">Cargando...</option>');
  $.ajax({
    url: 'm_inclusiones/ajax/a_scarga.php',
    data: 'iddep='+val,
    success: function(resp){
      $('#pronac').html(resp)
    }
   });
   $('#disnac').html('<option value="">DISTRITO</option>')
}
function cdistrito(val){
  $('#disnac').html('<option value="">Cargando...</option>');
  $.ajax({
    url: 'm_inclusiones/ajax/a_scarga.php',
    data: 'idpro='+val,
    success: function(resp){
      $('#disnac').html(resp)
    }
   });
}
function cnivel(val){
  $('#nivins').html('<option value="">Cargando...</option>');
  $.ajax({
    url: 'm_inclusiones/ajax/a_scarga.php',
    data: 'gi='+val,
    success: function(resp){
      $('#nivins').html(resp)
    }
   });
}
function cprovinciad(val){
  $('#proubi').html('<option value="">Cargando...</option>');
  $.ajax({
    url: 'm_inclusiones/ajax/a_scarga.php',
    data: 'iddep='+val,
    success: function(resp){
      $('#proubi').html(resp)
    }
   });
   $('#disubi').html('<option value="">DISTRITO</option>')
}
function cdistritod(val){
  $('#disubi').html('<option value="">Cargando...</option>');
  $.ajax({
    url: 'm_inclusiones/ajax/a_scarga.php',
    data: 'idpro='+val,
    success: function(resp){
      $('#disubi').html(resp)
    }
   });
}
//fin funciones actualizar selects
//fin funciones editar perfil personal
//funciones editar grado de instrucción
function edigrainstruccion(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edigrainstruccion.php",
  data: { idp : id },
  beforeSend: function () {
    $("#r_edigrainstruccion").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edigrainstruccion").html(a);
    $("#b_gedigrainstruccion").show();
  }
});
};
//funcion validar editar grado de instrucción
$( "#f_edigrainstruccion" ).validate( {
    rules: {
      grains:"required",
      nivins:"required",
      esp:"required",
      ins:"required"
    },
    messages: {
      grains:"Elija grado de instrucción.",
      nivins:"Elija nivel.",
      esp:"Ingrese especialidad o NINGUNA  en caso no tenga.",
      ins:"Ingrese institución."
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
      var datos = $("#f_edigrainstruccion").serializeArray();
      datos.push({name: "NomForm", value: "f_edigrainstruccion"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedigrainstruccion.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedigrainstruccion").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedigrainstruccion").addClass("disabled");
         },
         success: function(data){
            $("#b_gedigrainstruccion").hide();
            $("#b_gedigrainstruccion").html("Guardar");
            $("#b_gedigrainstruccion").removeClass("disabled");
            $("#r_edigrainstruccion").html(data);
            $("#r_edigrainstruccion").slideDown();
         }
      });
    }
  });
$('#m_edigrainstruccion').on('hidden.bs.modal', function () {
 $("#datose").load("m_inclusiones/ajax/a_rdatos.php");
})
//fin funcion validar editar grado de instrucción
//fin funciones editar grado de instrucción
//funciones editar sistema de pension
function edisispension(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edisispension.php",
  data: { idp : id },
  beforeSend: function () {
    $("#r_edisispension").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edisispension").html(a);
    $("#b_gedisispension").show();
  }
});
};
//funcion validar editar grado de instrucción
$( "#f_edisispension" ).validate( {
    rules: {
      penins:"required",
      cuspp:{required:true,minlength:7},
      fecafi:{required:false, datePE:true}
    },
    messages: {
      penins:"Elija la institución a la que está afiliado.",
      cuspp:{required:"Ingrese el código CUSPP o NINGUNO si se encuentra en la ONP",minlength:"Mínimo 7 caracteres."},
      fecafi:{datePE:"Ingrese una fecha valida."}
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
      var datos = $("#f_edisispension").serializeArray();
      datos.push({name: "NomForm", value: "f_edisispension"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedisispension.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedisispension").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedisispension").addClass("disabled");
         },
         success: function(data){
            $("#b_gedisispension").hide();
            $("#b_gedisispension").html("Guardar");
            $("#b_gedisispension").removeClass("disabled");
            $("#r_edisispension").html(data);
            $("#r_edisispension").slideDown();
         }
      });
    }
  });
$('#m_edisispension').on('hidden.bs.modal', function () {
 $("#datose").load("m_inclusiones/ajax/a_rdatos.php");
})
//fin funcion validar editar grado de instrucción
//fin funciones editar sistema de pension
//funciones editar domiclio
function edidomicilio(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edidomicilio.php",
  data: { idp : id },
  beforeSend: function () {
    $("#r_edidomicilio").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edidomicilio").html(a);
    $("#b_gedidomicilio").show();
  }
});
};
//funcion validar editar grado de instrucción
$( "#f_edidomicilio" ).validate( {
    rules: {
      conviv:"required",
      dir:"required",
      urb:{required:false,minlength:6},
      depubi:"required",
      proubi:"required",
      disubi:"required"
    },
    messages: {
      conviv:"Elija la condición de la vivienda.",
      dir:"Ingrese la dirección.",
      urb:{minlength:"Mínimo 6 caracteres."},
      depubi:"Elija departamento.",
      proubi:"Elija provincia.",
      disubi:"Elija distrito."
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
      var datos = $("#f_edidomicilio").serializeArray();
      datos.push({name: "NomForm", value: "f_edidomicilio"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedidomicilio.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedidomicilio").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedidomicilio").addClass("disabled");
         },
         success: function(data){
            $("#b_gedidomicilio").hide();
            $("#b_gedidomicilio").html("Guardar");
            $("#b_gedidomicilio").removeClass("disabled");
            $("#r_edidomicilio").html(data);
            $("#r_edidomicilio").slideDown();
         }
      });
    }
  });
$('#m_edidomicilio').on('hidden.bs.modal', function () {
 $("#datose").load("m_inclusiones/ajax/a_rdatos.php");
})
//fin funcion validar editar domicilio
//fin funciones editar sistema de pension
//funciones Agregar cargo
function agrcarpersonal(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/ajax/a_agrcarpersonal.php",
    data: { idp : id },
    beforeSend: function () {
      $("#r_agrcarpersonal").html("<img src='m_images/cargando.gif'>");
      $("#b_gagrcarpersonal").hide();
    },
    success:function(a){
      $("#r_agrcarpersonal").html(a);
      $("#b_gagrcarpersonal").show();
    }
  });
};
function ccargo(val){
  $('#car').html('<option value="">Cargando...</option>');
  $.ajax({
    url: 'm_inclusiones/ajax/a_scarga.php',
    data: 'idslab='+val,
    success: function(resp){
      $('#car').html(resp)
    }
   });
}
//funcion validar agregar cargo de personal
$( "#f_agrcarpersonal" ).validate( {
    rules: {
      sislab: "required",
      car: "required",
      dep: "required",
      tiping: "required",
      numcon: {required:false, minlength:5},
      concar: "required",
      conlab: "required",
      rol: {required:false, minlength:5},
      fecasu:{required:true, datePE:true},
      fecjur:{required:false, datePE:true},
      fecven:{required:false, datePE:true},
      rem: "required",
      numres: {required:false, minlength:3},
      numcont: {required:false, minlength:3},
      mot: {required:false, minlength:5}
    },
    messages: {
      sislab: "Elija el sistema laboral.",
      car: "Elija el cargo.",
      dep: "Elija la dependencia donde sera asignad@.",
      tiping: "Elija la modalidad de acceso al cargo.",
      numcon: {minlength:"Mínimo 5 caracteres, escriba NO REGISTRA de ser el caso."},
      concar: "Elija la condición del cargo.",
      conlab: "Elija la condición laboral.",
      rol: {minlength:"Mínimo 5 caracteres."},
      fecasu: {required:"Ingrese fecha que asume cargo.",datePE:"Ingrese una fecha valida."},
      fecjur: {datePE:"Ingrese una fecha valida."},
      fecven: {datePE:"Ingrese una fecha valida."},
      rem: "Elija a quien reemplaza.",
      numres: {minlength:"Mínimo 3 caracteres."},
      numcont: {minlength:"Mínimo 3 caracteres."},
      mot:{minlength:"Mínimo 5 caracteres."}
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
      var datos = $("#f_agrcarpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_agrcarpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gagrcarpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#l_agrcarpersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gagrcarpersonal").hide();
         },
         success: function(data){
            $("#l_agrcarpersonal").html("");
            $("#r_agrcarpersonal").html(data)
            $("#r_agrcarpersonal").slideDown();
         }
      });
    }
  } );
$('#m_agrcarpersonal').on('hidden.bs.modal', function () {
 $("#cargoe").load("m_inclusiones/ajax/a_rcargo.php");
 $("#nomcare").load("m_inclusiones/ajax/a_rnomcar.php");
})
//fin funcion validar agregar cargo de personal
//fin funciones Agregar cargo
//funciones Editar cargo
function edicarpersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edicarpersonal.php",
  data: { idc : id },
  beforeSend: function () {
    $("#r_agrcarpersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edicarpersonal").html(a);
    $("#b_gedicarpersonal").show();
  }
});
};
//funcion validar agregar cargo de personal
$( "#f_edicarpersonal" ).validate( {
    rules: {
      sislab: "required",
      car: "required",
      dep: "required",
      tiping: "required",
      numcon: {required:false, minlength:5},
      concar: "required",
      conlab: "required",
      rol: {required:false, minlength:5},
      fecasu:{required:true, datePE:true},
      fecjur:{required:false, datePE:true},
      fecven:{required:false, datePE:true},
      rem: "required",
      numres: {required:false, minlength:3},
      numcont: {required:false, minlength:2},
      mot: {required:false, minlength:5}
    },
    messages: {
      sislab: "Elija el sistema laboral.",
      car: "Elija el cargo.",
      dep: "Elija la dependencia.",
      tiping: "Elija el tipo de ingreso.",
      numcon: {minlength:"Mínimo 5 caracteres, escriba SUPLENCIA o NO REGISTRA de ser el caso."},
      concar: "Elija la condición del cargo.",
      conlab: "Elija la condición laboral.",
      rol: {minlength:"Mínimo 5 caracteres."},
      fecasu: {required:"Ingrese fecha que asume cargo.",datePE:"Ingrese una fecha valida."},
      fecjur: {datePE:"Ingrese una fecha valida."},
      fecven: {datePE:"Ingrese una fecha valida."},
      rem: "Elija a quien reemplaza.",
      numres: {minlength:"Mínimo 3 caracteres."},
      numcont: {minlength:"Mínimo 2 caracteres."},
      mot:{minlength:"Mínimo 5 caracteres."}
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
      var datos = $("#f_edicarpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_edicarpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedicarpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedicarpersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedicarpersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gedicarpersonal").hide();
            $("#b_gedicarpersonal").html("Guardar");
            $("#b_gedicarpersonal").removeClass("disabled");
            $("#r_edicarpersonal").html(data);
            $("#r_edicarpersonal").slideDown();
         }
      });
    }
  } );
$('#m_edicarpersonal').on('hidden.bs.modal', function () {
  $("#cargoe").load("m_inclusiones/ajax/a_rcargo.php");
  $("#nomcare").load("m_inclusiones/ajax/a_rnomcar.php");
})
//fin funcion validar agregar cargo de personal
//fin funciones Editar cargo
//funciones reservar cargo
function rescarpersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_rescarpersonal.php",
  data: { idec : id },
  beforeSend: function () {
    $("#r_rescarpersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_rescarpersonal").html(a);
    $("#b_grescarpersonal").show();
  }
});
};
//funcion validar reservar cargo de personal
$( "#f_rescarpersonal" ).validate( {
    rules: {
      ini:{required:true, datePE:true},
      fin:{required:false, datePE:true},
      mot:{required:true, minlength:5},
      numres:{required:true, minlength:5},
      numdoc:{required:false, minlength:5}
    },
    messages: {
      ini: {required:"Ingrese fecha de inicio de reserva.",datePE:"Ingrese una fecha valida."},
      fin: {datePE:"Ingrese una fecha valida."},
      mot: {required:"Ingrese motivo de la reserva.",minlength:"Mínimo 5 caracteres"},
      numres: {required:"Ingrese número de resolución.",minlength:"Mínimo 5 caracteres."},
      numdoc: {minlength:"Mínimo 5 caracteres."}
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
      var datos = $("#f_rescarpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_rescarpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_grescarpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         success: function(data){
            $("#b_grescarpersonal").hide();
            $("#r_rescarpersonal").html(data);
            $("#r_rescarpersonal").slideDown();
         }
      });
    }
  } );
$('#m_rescarpersonal').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin funcion validar reservar cargo de personal
//fin funciones reservar cargo
//funciones reservar cargo
//funcion cesar cargo
function cescarpersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_cescarpersonal.php",
  data: { idec : id },
  beforeSend: function () {
    $("#r_cescarpersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_cescarpersonal").html(a);
    $("#b_gcescarpersonal").show();
  }
});
};
//funcion validar cesar cargo de personal
$( "#f_cescarpersonal" ).validate( {
    rules: {
      fecces:{required:true, datePE:true},
      mot:{required:true, minlength:5},
      numres:{required:true, minlength:5},
      numdoc:{required:false, minlength:5}
    },
    messages: {
      fecces: {required:"Ingrese fecha de inicio de reserva.",datePE:"Ingrese una fecha valida."},
      mot: {required:"Ingrese motivo de la reserva.",minlength:"Mínimo 5 caracteres"},
      numres: {required:"Ingrese número de resolución.",minlength:"Mínimo 5 caracteres."},
      numdoc: {minlength:"Mínimo 5 caracteres."}
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
      var datos = $("#f_cescarpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_cescarpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gcescarpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         success: function(data){
            $("#b_gcescarpersonal").hide();
            $("#r_cescarpersonal").html(data);
            $("#r_cescarpersonal").slideDown();
         }
      });
    }
  } );
$('#m_cescarpersonal').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin funcion validar reservar cargo de personal
//fin funciones reservar cargo
//funciones estados cargo personal
function estcarpersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_estcarpersonal.php",
  data: { idec : id },
  beforeSend: function () {
    $("#r_estcarpersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_estcarpersonal").html(a);
  }
});
};
//funciones estados cargo personal
//funciones detalle desplazamiento
function detdesplazamiento(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_detdesplazamiento.php",
  data: { idcd : id },
  beforeSend: function () {
    $("#r_detdesplazamiento").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_detdesplazamiento").html(a);
  }
});
};
//fin funciones detalle desplazamiento
//funciones detalle estado cargo
function detestcargo(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_detestcargo.php",
  data: { idec : id },
  beforeSend: function () {
    $("#r_detestcargo").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_detestcargo").html(a);
  }
});
};
//fin funciones detalle estado cargo
//funcion nuevo desplazamiento
function nuedesplazamiento(id){
  $.ajax({
    type: "post",
    url: "m_inclusiones/ajax/a_nuedesplazamiento.php",
    data: { idec : id },
    beforeSend: function () {
      $("#r_nuedesplazamiento").html("<img src='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_nuedesplazamiento").html(a);
      $("#b_gnuedesplazamiento").show();
    }
  });
};
//funcion validar nuevo desplazamiento
$( "#f_nuedesplazamiento" ).validate( {
    rules: {
      dep:"required",
      tipdes:"required",
      ini:{required:true, datePE:true},
      fven:{required:false, datePE:true},
      numres:{required:true, minlength:5},
      mot:{required:true, minlength:5},
      ofi:{required:false}
    },
    messages: {
      dep:"Elija una dependencia.",
      tipdes:"Elija un tipo de desplazamiento.",
      ini: {required:"Ingrese fecha de inicio del desplazamiento.",datePE:"Ingrese una fecha válida."},
      fven: {datePE:"Ingrese una fecha válida."},
      numres: {required:"Ingrese número de documento que autoriza el desplazamiento.",minlength:"Mínimo 5 caracteres."},
      mot: {required:"Ingrese motivo del desplazamiento.",minlength:"Mínimo 5 caracteres"}
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
      var datos = $("#f_nuedesplazamiento").serializeArray();
      datos.push({name: "NomForm", value: "f_nuedesplazamiento"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gnuedesplazamiento.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnuedesplazamiento").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gnuedesplazamiento").addClass("disabled");
         },
         success: function(data){
            $("#b_gnuedesplazamiento").hide();
            $("#b_gnuedesplazamiento").html("Guardar");
            $("#b_gnuedesplazamiento").removeClass("disabled");
            $("#r_nuedesplazamiento").html(data);
            $("#r_nuedesplazamiento").slideDown();
         }
      });
    }
  } );

//funcion nuevo desplazamiento
function edidesplazamiento(id, acc){
  if(acc=="edat"){
    $(".t_edesplazamiento").html("Editar Datos Desplazamiento");
    $("#m_edesplazamiento").addClass("modal-lg")
  }else if(acc=="eofi"){
    $(".t_edesplazamiento").html("Oficializar");
    $("#m_edesplazamiento").removeClass("modal-lg")
  }else if(acc=="efin"){
    $(".t_edesplazamiento").html("Editar Fecha Inicio");
    $("#m_edesplazamiento").removeClass("modal-lg")
  }else if(acc=="effi"){
    $(".t_edesplazamiento").html("Editar Fecha Fin");
    $("#m_edesplazamiento").removeClass("modal-lg")
  }
  $.ajax({
    type: "post",
    url: "m_inclusiones/ajax/a_edidesplazamiento.php",
    data: { id : id, acc : acc },
    dataType: "html",
    beforeSend: function () {
      $("#r_edidesplazamiento").html("<img src='m_images/cargando.gif'>");
      $("#b_gedidesplazamiento").hide();
    },
    success:function(a){
      $("#r_edidesplazamiento").html(a);
      $("#b_gedidesplazamiento").show();
    }
  });
};
//funcion validar nuevo desplazamiento
$("#f_edidesplazamiento").submit(function(e){
      e.preventDefault();
      var datos = $("#f_edidesplazamiento").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedidesplazamiento.php",
         dataType: "json",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#r_edesplazamiento").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedidesplazamiento").hide();
         },
         success: function(d){
          if(d.e){
            $("#r_edidesplazamiento").html(d.m);
          }else{
            $("#r_edesplazamiento").html(d.m);
            $("#b_gedidesplazamiento").show();
          }
         }
      });
});

$('#m_nuedesplazamiento').on('hidden.bs.modal', function () {
 $("#cargoe").load("m_inclusiones/ajax/a_rcargo.php");
 $("#nomcare").load("m_inclusiones/ajax/a_rnomcar.php");
})
//fin funcion nuevo desplazamiento
//funcion nuevo estado cargo
function nueestcargo(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_nueestcargo.php",
  data: { idec : id },
  beforeSend: function () {
    $("#r_nueestcargo").html("<img src='m_images/cargando.gif'>");
    $("#b_gnueestcargo").hide();
  },
  success:function(a){
    $("#r_nueestcargo").html(a);
    $("#b_gnueestcargo").show();
  }
});
};
//funcion validar nuevo estado cargo
$( "#f_nueestcargo" ).validate( {
    rules: {
      estcar:"required",
      ini:{required:true, datePE:true},
      fven:{required:false, datePE:true},
      numres:{required:true, minlength:5},
      mot:{required:true, minlength:5},
    },
    messages: {
      estcar:"Elija un nuevo estado.",
      ini: {required:"Ingrese fecha de inicio del nuevo estado.",datePE:"Ingrese una fecha válida."},
      fven: {datePE:"Ingrese una fecha válida."},
      numres: {required:"Ingrese número de documento que autoriza el nuevo estado.",minlength:"Mínimo 5 caracteres."},
      mot: {required:"Ingrese motivo del nuevo estado.",minlength:"Mínimo 5 caracteres"}
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
      var datos = $("#f_nueestcargo").serializeArray();
      datos.push({name: "NomForm", value: "f_nueestcargo"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gnueestcargo.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnueestcargo").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gnueestcargo").addClass("disabled");
         },
         success: function(data){
            $("#b_gnueestcargo").hide();
            $("#b_gnueestcargo").html("Guardar");
            $("#b_gnueestcargo").removeClass("disabled");
            $("#r_nueestcargo").html(data);
            $("#r_nueestcargo").slideDown();
         }
      });
    }
  } );

//funcion nuevo estado cargo
function ediestcargo(id, acc){
  switch(acc) {
    case "edidat":
        $(".teecargo").html("Edidar datos del estado");
        break;
    case "edifin":
        $(".teecargo").html("Edidar fecha inicio del estado");
        break;
    case "ediffi":
        $(".teecargo").html("Edidar fecha fin del estado");
        break;
    default:
        $(".teecargo").html("Edidar");
  }
  $.ajax({
    type: "post",
    url: "m_inclusiones/ajax/a_ediestcargo.php",
    data: { idec: id, acc: acc },
    beforeSend: function () {
      $("#r_ediestcargo").html("<img src='m_images/cargando.gif'>");
      $("#b_gediestcargo").hide();
    },
    success:function(a){
      $("#r_ediestcargo").html(a);
      $("#b_gediestcargo").show();
    }
  });
};
//funcion validar nuevo estado cargo

$("#f_ediestcargo").submit(function(e){
      e.preventDefault();
      var datos = $("#f_ediestcargo").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gediestcargo.php",
         dataType: "json",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#r_eecargo").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gediestcargo").hide("disabled");
         },
         success: function(d){
            if(d.e){
              $("#r_ediestcargo").html(d.m);
              $("#f_efvac").html(d.m);
              var iec=$("#iec").val();
              detcargo(iec);
            }else{
              $("#r_eecargo").html(d.m);
              $("#b_gediestcargo").show("disabled");
            }
         }
      });
});

$('#m_nueestcargo, #m_ediestcargo, #m_edidesplazamiento').on('hidden.bs.modal', function () {
 $("#cargoe").load("m_inclusiones/ajax/a_rcargo.php");
 $("#nomcare").load("m_inclusiones/ajax/a_rnomcar.php");
})

//fin funcion nuevo desplazamiento
//funcion editar movimiento
function edimovpersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edimovpersonal.php",
  data: { idmd : id },
  beforeSend: function () {
    $("#r_edimovpersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edimovpersonal").html(a);
    $("#b_edimovpersonal").show();
  }
});
};
//funcion validar editar movimiento personal
$( "#f_edimovpersonal" ).validate( {
    rules: {
      dep:"required",
      ini:{required:true, datePE:true},
      fin:{required:true, datePE:true},
      nummem:{required:false, minlength:5},
      numres:{required:false, minlength:5},
      mot:{required:true, minlength:5}
    },
    messages: {
      dep:"Elija una dependencia.",
      ini: {required:"Ingrese fecha de inicio del movimiento.",datePE:"Ingrese una fecha valida."},
      fin: {required:"Ingrese fecha de fin del movimiento.",datePE:"Ingrese una fecha valida."},
      nummem: {minlength:"Mínimo 5 caracteres."},
      numdoc: {minlength:"Mínimo 5 caracteres."},
      mot: {required:"Ingrese motivo del movimiento.",minlength:"Mínimo 5 caracteres"}
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
      var datos = $("#f_edimovpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_edimovpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedimovpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         success: function(data){
            $("#b_gedimovpersonal").hide();
            $("#r_edimovpersonal").html(data);
            $("#r_edimovpersonal").slideDown();
         }
      });
    }
  } );
$('#m_edimovpersonal').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin funcion editar movimiento
//funcion agregar pariente de personal
function agrparpersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_agrparpersonal.php",
  data: { idp : id },
  beforeSend: function () {
    $("#r_agrparpersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_agrparpersonal").html(a);
    $("#b_gagrparpersonal").show();
  }
});
};
//funcion validar editar movimiento personal
$( "#f_agrparpersonal" ).validate( {
    rules: {
      tippar:"required",
      apepat:{required:true, minlength:3},
      apemat:{required:true, minlength:3},
      nom:{required:true, minlength:3},
      sex:{required:false},
      estciv:"required",
      fecnac:{required:true, datePE:true},
      tipdoc:"required",
      numdoc:{required:true, minlength:8},
      ocu:{required:false, minlength:3},
      entlab:{required:false, minlength:3},
      telfij:{required:false, minlength:6},
      telmov:{required:false, minlength:6},
      eme:{required:false},
      viv:{required:false},
      cor:{required:false, email:true},
      grains:"required",
      nivins:"required",
      esp:{required:false, minlength:5},
      ins:{required:false, minlength:5}
    },
    messages: {
      tippar:"Elija el tipo de pariente.",
      apepat: {required:"Ingrese apellido paterno.",minlength:"Mínimo 3 caracteres."},
      apemat: {required:"Ingrese apellido materno.",minlength:"Mínimo 3 caracteres."},
      nom: {required:"Ingrese nombres.",minlength:"Mínimo 3 caracteres."},
      estciv:"Elija el estado civil.",
      fecnac: {required:"Ingrese fecha de nacimiento.",datePE:"Ingrese una fecha válida."},
      tipdoc:"Elija el tipo de documento.",
      numdoc: {required:"Ingrese el número del documento",minlength:"Mínimo 8 caracteres."},
      ocu: {required:"Ingrese la ocupación o NINGUNA de ser el caso",minlength:"Mínimo 3 caracteres."},
      entlab: {required:"Ingrese la entidad laboral o NINGUNA de ser el caso",minlength:"Mínimo 3 caracteres."},
      telfij: {minlength:"Mínimo 6 caracteres."},
      telmov: {minlength:"Mínimo 6 caracteres."},
      grains:"Elija el grado de instrucción.",
      nivins:"Elija el nivel de instrucción.",
      esp: {required:"Ingrese la especialidad o NINGUNA de ser el caso.",minlength:"Mínimo 5 caracteres."},
      ins: {required:"Ingrese la institución o NINGUNA de ser el caso.",minlength:"Mínimo 5 caracteres."}
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
      var datos = $("#f_agrparpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_agrparpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gagrparpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gagrparpersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gagrparpersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gagrparpersonal").hide();
            $("#b_gagrparpersonal").html("Guardar");
            $("#b_gagrparpersonal").removeClass("disabled");
            $("#r_agrparpersonal").html(data);
            $("#r_agrparpersonal").slideDown();
         }
      });
    }
  } );
$('#m_agrparpersonal').on('hidden.bs.modal', function () {
  $("#parientese").load("m_inclusiones/ajax/a_rparientes.php");
})
//fin funcion agregar pariente de personal
//funcion editar pariente de personal
function ediparpersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_ediparpersonal.php",
  data: { idpa : id },
  beforeSend: function () {
    $("#r_ediparpersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_ediparpersonal").html(a);
    $("#b_gediparpersonal").show();
  }
});
};
//funcion validar editar movimiento personal
$( "#f_ediparpersonal" ).validate( {
    rules: {
      tippar:"required",
      apepat:{required:true, minlength:3},
      apemat:{required:true, minlength:3},
      nom:{required:true, minlength:3},
      sex:{required:false},
      estciv:"required",
      fecnac:{required:true, datePE:true},
      tipdoc:"required",
      numdoc:{required:true, minlength:8},
      ocu:{required:false, minlength:3},
      entlab:{required:false, minlength:3},
      telfij:{required:false, minlength:6},
      telmov:{required:false, minlength:6},
      eme:{required:false},
      viv:{required:false},
      cor:{required:false, email:true},
      grains:"required",
      nivins:"required",
      esp:{required:false, minlength:5},
      ins:{required:false, minlength:5}
    },
    messages: {
      tippar:"Elija el tipo de pariente.",
      apepat: {required:"Ingrese apellido paterno.",minlength:"Mínimo 3 caracteres."},
      apemat: {required:"Ingrese apellido materno.",minlength:"Mínimo 3 caracteres."},
      nom: {required:"Ingrese nombres.",minlength:"Mínimo 3 caracteres."},
      estciv:"Elija el estado civil.",
      fecnac: {required:"Ingrese fecha de nacimiento.",datePE:"Ingrese una fecha válida."},
      tipdoc:"Elija el tipo de documento.",
      numdoc: {required:"Ingrese el número del documento",minlength:"Mínimo 8 caracteres."},
      ocu: {required:"Ingrese la ocupación",minlength:"Mínimo 3 caracteres."},
      entlab: {required:"Ingrese la entidad laboral o NINGUNA de ser el caso",minlength:"Mínimo 3 caracteres."},
      telfij: {minlength:"Mínimo 6 caracteres."},
      telmov: {minlength:"Mínimo 6 caracteres."},
      grains:"Elija el grado de instrucción.",
      nivins:"Elija el nivel de instrucción.",
      esp: {required:"Ingrese la especialidad o NINGUNA de ser el caso.",minlength:"Mínimo 5 caracteres."},
      ins: {required:"Ingrese la institución.",minlength:"Mínimo 5 caracteres."}
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
      var datos = $("#f_ediparpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_ediparpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gediparpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gediparpersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gediparpersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gediparpersonal").hide();
            $("#b_gediparpersonal").html("Guardar");
            $("#b_gediparpersonal").removeClass("disabled");
            $("#r_ediparpersonal").html(data);
            $("#r_ediparpersonal").slideDown();
         }
      });
    }
  } );
$('#m_ediparpersonal').on('hidden.bs.modal', function () {
 $("#parientese").load("m_inclusiones/ajax/a_rparientes.php");
})
//fin funcion editar pariente de personal
//funciones detalle pariente personal
function detparpersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_detparpersonal.php",
  data: { idpa : id },
  beforeSend: function () {
    $("#r_detparpersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_detparpersonal").html(a);
  }
});
};
//fin funciones detalle pariente personal
//funcion agregar grado o titulo
function agrgrapersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_agrgrapersonal.php",
  data: { idp : id },
  beforeSend: function () {
    $("#r_agrgrapersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_agrgrapersonal").html(a);
    $("#b_gagrgrapersonal").show();
  }
});
};
//funcion validar grado o titulo personal
$( "#f_agrgrapersonal" ).validate( {
    rules: {
      niv:"required",
      den:{required:true, minlength:5},
      fecexp:{required:true, datePE:true},
      ins:{required:true, minlength:5},
      numcol:{required:false, minlength:3},
      feccol:{required:false, datePE:true},
      numdip:{required:false, minlength:3}
    },
    messages: {
      niv:"Elija un nivel.",
      den: {required:"Ingrese la denominacion del grado y/o título.",minlength:"Mínimo 5 caracteres"},
      fecexp: {required:"Ingrese fecha de expedición del diploma.",datePE:"Ingrese una fecha válida."},
      ins: {required:"Ingrese la institución que emite el diploma.",minlength:"Mínimo 5 caracteres"},
      numcol: {minlength:"Mínimo 3 caracteres."},
      feccol: {datePE:"Ingrese una fecha válida."},
      numdip: {required:"Ingrese el número de la diploma",minlength:"Mínimo 3 caracteres."}
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
      var datos = $("#f_agrgrapersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_agrgrapersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gagrgrapersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gagrgrapersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gagrgrapersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gagrgrapersonal").hide();
            $("#b_gagrgrapersonal").html("Guardar");
            $("#b_gagrgrapersonal").removeClass("disabled");
            $("#r_agrgrapersonal").html(data);
            $("#r_agrgrapersonal").slideDown();
         }
      });
    }
  } );
$('#m_agrgrapersonal').on('hidden.bs.modal', function () {
  $("#gradose").load("m_inclusiones/ajax/a_rgrados.php");
})
//fin funcion agregar grado o titulo
//funcion editar grado o titulo
function edigrapersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edigrapersonal.php",
  data: { idg : id },
  beforeSend: function () {
    $("#r_edigrapersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edigrapersonal").html(a);
    $("#b_gedigrapersonal").show();
  }
});
};
//funcion validar grado o titulo personal
$( "#f_edigrapersonal" ).validate( {
    rules: {
      niv:"required",
      den:{required:true, minlength:5},
      fecexp:{required:true, datePE:true},
      ins:{required:true, minlength:5},
      numcol:{required:false, minlength:3},
      feccol:{required:false, datePE:true},
      numdip:{required:false, minlength:3}
    },
    messages: {
      niv:"Elija un nivel.",
      den: {required:"Ingrese la denominacion del grado y/o título.",minlength:"Mínimo 5 caracteres"},
      fecexp: {required:"Ingrese fecha de expedición del diploma.",datePE:"Ingrese una fecha válida."},
      ins: {required:"Ingrese la institución que emite el diploma.",minlength:"Mínimo 5 caracteres"},
      numcol: {minlength:"Mínimo 3 caracteres."},
      feccol: {datePE:"Ingrese una fecha válida."},
      numdip: {required:"Ingrese el número de la diploma",minlength:"Mínimo 3 caracteres."}
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
      var datos = $("#f_edigrapersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_edigrapersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedigrapersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedigrapersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedigrapersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gedigrapersonal").hide();
            $("#b_gedigrapersonal").html("Guardar");
            $("#b_gedigrapersonal").removeClass("disabled");
            $("#r_edigrapersonal").html(data);
            $("#r_edigrapersonal").slideDown();
         }
      });
    }
  } );
$('#m_edigrapersonal').on('hidden.bs.modal', function () {
 $("#gradose").load("m_inclusiones/ajax/a_rgrados.php");
})
//fin funcion editar grado o titulo
//funciones detalle pariente personal
function detgrapersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_detgrapersonal.php",
  data: { idg : id },
  beforeSend: function () {
    $("#r_detgrapersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_detgrapersonal").html(a);
  }
});
};
//fin funciones detalle pariente personal
//funcion agregar capacitacion
function agrcappersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_agrcappersonal.php",
  data: { idp : id },
  beforeSend: function () {
    $("#r_agrcappersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_agrcappersonal").html(a);
    $("#b_gagrcappersonal").show();
  }
});
};
//funcion validar capacitación
$( "#f_agrcappersonal" ).validate( {
    rules: {
      den:{required:true, minlength:5},
      tip:"required",
      ins:{required:true, minlength:5},
      fecini:{required:true, datePE:true},
      fecfin:{required:true, datePE:true},
      dur:"required"
    },
    messages: {
      den: {required:"Ingrese la denominacion de la capacitación.",minlength:"Mínimo 5 caracteres"},
      tip:"Elija un tipo.",
      ins: {required:"Ingrese la institución que emite el certificado.",minlength:"Mínimo 5 caracteres"},
      fecini: {required:"Ingrese fecha de inicio de la capacitación.",datePE:"Ingrese una fecha válida."},
      fecfin: {required:"Ingrese fecha de fin de la capacitación.",datePE:"Ingrese una fecha válida."},
      dur:"Ingrese la duración en horas."
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
      var datos = $("#f_agrcappersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_agrcappersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gagrcappersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gagrcappersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gagrcappersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gagrcappersonal").hide();
            $("#b_gagrcappersonal").html("Guardar");
            $("#b_gagrcappersonal").removeClass("disabled");
            $("#r_agrcappersonal").html(data);
            $("#r_agrcappersonal").slideDown();
         }
      });
    }
  } );
$('#m_agrcappersonal').on('hidden.bs.modal', function () {
 $("#capacitacionese").load("m_inclusiones/ajax/a_rcapacitaciones.php");
})
//fin funcion agregar capacitación
//funcion editar capacitacion
function edicappersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edicappersonal.php",
  data: { idca : id },
  beforeSend: function () {
    $("#r_edicappersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edicappersonal").html(a);
    $("#b_gedicappersonal").show();
  }
});
};
//funcion validar capacitación
$( "#f_edicappersonal" ).validate( {
    rules: {
      den:{required:true, minlength:5},
      tip:"required",
      ins:{required:true, minlength:5},
      fecini:{required:true, datePE:true},
      fecfin:{required:true, datePE:true},
      dur:"required"
    },
    messages: {
      den: {required:"Ingrese la denominacion de la capacitación.",minlength:"Mínimo 5 caracteres"},
      tip:"Elija un tipo.",
      ins: {required:"Ingrese la institución que emite el certificado.",minlength:"Mínimo 5 caracteres"},
      fecini: {required:"Ingrese fecha de inicio de la capacitación.",datePE:"Ingrese una fecha válida."},
      fecfin: {required:"Ingrese fecha de fin de la capacitación.",datePE:"Ingrese una fecha válida."},
      dur:"Ingrese la duración en horas."
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
      var datos = $("#f_edicappersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_edicappersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedicappersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedicappersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedicappersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gedicappersonal").hide();
            $("#b_gedicappersonal").html("Guardar");
            $("#b_gedicappersonal").removeClass("disabled");
            $("#r_edicappersonal").html(data);
            $("#r_edicappersonal").slideDown();
         }
      });
    }
  } );
$('#m_edicappersonal').on('hidden.bs.modal', function () {
 $("#capacitacionese").load("m_inclusiones/ajax/a_rcapacitaciones.php");
})
//fin funcion editar capacitación
//funciones detalle capacitación personal
function detcappersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_detcappersonal.php",
  data: { idca : id },
  beforeSend: function () {
    $("#r_detcappersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_detcappersonal").html(a);
  }
});
};
//fin funciones detalle capacitación personal
//funcion agregar experiencia laboral
function agrexppersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_agrexppersonal.php",
  data: { idp : id },
  beforeSend: function () {
    $("#r_agrexppersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_agrexppersonal").html(a);
    $("#b_gagrexppersonal").show();
  }
});
};
//funcion validar experiencia laboral
$( "#f_agrexppersonal" ).validate( {
    rules: {
      ins:{required:true, minlength:3},
      car:{required:true, minlength:5},
      fecini:{required:true, datePE:true},
      fecfin:{required:false, datePE:true},
      con:{required:true},
      motces:{required:false, minlength:5},
    },
    messages: {
      ins: {required:"Ingrese la institución que emite el certificado de trabajo.",minlength:"Mínimo 5 caracteres"},
      car: {required:"Ingrese el cargo que ocupo.",minlength:"Mínimo 5 caracteres"},
      fecini: {required:"Ingrese fecha de inicio de labores.",datePE:"Ingrese una fecha válida."},
      fecfin: {datePE:"Ingrese una fecha válida."},
      con: {required:"Elija la condición laboral."},
      motces: {minlength:"Mínimo 5 caracteres"},
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
      var datos = $("#f_agrexppersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_agrexppersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gagrexppersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gagrexppersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gagrexppersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gagrexppersonal").hide();
            $("#b_gagrexppersonal").html("Guardar");
            $("#b_gagrexppersonal").removeClass("disabled");
            $("#r_agrexppersonal").html(data);
            $("#r_agrexppersonal").slideDown();
         }
      });
    }
  } );
$('#m_agrexppersonal').on('hidden.bs.modal', function () {
 $("#experienciae").load("m_inclusiones/ajax/a_rexperiencia.php");
})
//fin funcion agregar experiencia laboral
//funcion editar experiencia laboral
function ediexppersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_ediexppersonal.php",
  data: { idex : id },
  beforeSend: function () {
    $("#r_ediexppersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_ediexppersonal").html(a);
    $("#b_gediexppersonal").show();
  }
});
};
//funcion validar editar experiencia laboral
$( "#f_ediexppersonal" ).validate( {
    rules: {
      ins:{required:true, minlength:3},
      car:{required:true, minlength:5},
      fecini:{required:true, datePE:true},
      fecfin:{required:false, datePE:true},
      con:{required:true},
      motces:{required:false, minlength:5},
    },
    messages: {
      ins: {required:"Ingrese la institución que emite el certificado de trabajo.",minlength:"Mínimo 5 caracteres"},
      car: {required:"Ingrese el cargo que ocupo.",minlength:"Mínimo 5 caracteres"},
      fecini: {required:"Ingrese fecha de inicio de labores.",datePE:"Ingrese una fecha válida."},
      fecfin: {datePE:"Ingrese una fecha válida."},
      con: {required:"Elija la condición laboral."},
      motces: {minlength:"Mínimo 5 caracteres"},
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
      var datos = $("#f_ediexppersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_ediexppersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gediexppersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gediexppersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gediexppersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gediexppersonal").hide();
            $("#b_gediexppersonal").html("Guardar");
            $("#b_gediexppersonal").removeClass("disabled");
            $("#r_ediexppersonal").html(data);
            $("#r_ediexppersonal").slideDown();
         }
      });
    }
  } );
$('#m_ediexppersonal').on('hidden.bs.modal', function () {
 $("#experienciae").load("m_inclusiones/ajax/a_rexperiencia.php");
})
//fin funcion editar experiencia personal
//funciones detalle capacitación personal
function detexppersonal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_detexppersonal.php",
  data: { idex : id },
  beforeSend: function () {
    $("#r_detexppersonal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_detexppersonal").html(a);
  }
});
};
//fin funciones detalle capacitación personal
//fin funciones perfil
//funciones mantenimiento local
//funcion detalle local
function detlocal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_detlocal.php",
  data: { idlo : id },
  beforeSend: function () {
    $("#r_detlocal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_detlocal").html(a);
  }
});
};
//fin funcion detalle local
//funcion llamar formulario nuevo local
$("#b_nuelocal").on("click",function(e){
  $.ajax({
    type:"post",
    url:"m_inclusiones/ajax/a_nuelocal.php",
    beforeSend: function () {
      $("#r_nuelocal").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_nuelocal").html(a);
      $("#b_gnuelocal").show();
    }
  });
});

$( "#f_nuelocal" ).validate( {
    rules: {
      ali:{required:true,minlength:5},
      dir:{required:true, minlength:6},
      urb:{required:false, minlength:5},
      depubi:"required",
      proubi:"required",
      disubi:"required",
      tel:{required:false, minlength:6},
      con:"required",
      pro:{required:false, minlength:5},
      atot:{required:false,number:true},
      acon:{required:false,number:true},
      mat:"required",
      npis:{required:false,number:true},
      malq:{required:false,number:true},
      mman:{required:false,number:true},
      san:"required",
      ftsan:{required:false, datePE:true},
      acons:{required:false,minlength:4},
      finsp:{required:false, datePE:true},
      upla:"required",
      urea:"required"
    },
    messages: {
      ali: {required:"Ingrese el alias del local.",minlength:"Mínimo 5 caracteres"},
      dir: {required:"Ingrese la dirección del local.",minlength:"Mínimo 6 caracteres"},
      urb: {minlength:"Mínimo 5 caracteres"},
      depubi:"Elija departamento",
      proubi:"Elija provincia",
      disubi:"Elija distrito",
      tel: {minlength:"Mínimo 6 caracteres"},
      con:"Elija condición",
      pro: {minlength:"Mínimo 5 caracteres"},
      atot:{number:"Sólo números decimales."},
      acon:{number:"Sólo números decimales."},
      mat:"Elija el material.",
      npis:{number:"Sólo números"},
      malq:{number:"Sólo números decimales."},
      mman:{number:"Sólo números decimales."},
      san:"Elija opción de saneado.",
      ftsan:{datePE:"Ingrese una fecha válida."},
      acons:{minlength:"Mínimo 4 caracteres."},
      finsp:{datePE:"Ingrese una fecha válida."},
      upla:"Elija tipo de uso planificado",
      urea:"Elija tipo de uso real"
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
      var datos = $("#f_nuelocal").serializeArray();
      datos.push({name: "NomForm", value: "f_nuelocal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gnuelocal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnuelocal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gnuelocal").addClass("disabled");
         },
         success: function(data){
            $("#b_gnuelocal").hide();
            $("#b_gnuelocal").html("Guardar");
            $("#b_gnuelocal").removeClass("disabled");
            $("#r_nuelocal").html(data);
            $("#r_nuelocal").slideDown();
         }
      });
    }
  } );
//función actualizar page local
$('#m_nuelocal').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin función actualizar page local
//funciones editar local
function edilocal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_edilocal.php",
  data: { idlo : id },
  beforeSend: function () {
    $("#r_edilocal").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_edilocal").html(a);
    $("#b_gedilocal").show();
  }
});
};
//funcion validar editar local
$( "#f_edilocal" ).validate( {
    rules: {
      ali:{required:true,minlength:5},
      dir:{required:true, minlength:6},
      urb:{required:false, minlength:5},
      depubi:"required",
      proubi:"required",
      disubi:"required",
      tel:{required:false, minlength:6},
      con:"required",
      pro:{required:false, minlength:5},
      atot:{required:false,number:true},
      acon:{required:false,number:true},
      mat:"required",
      npis:{required:false,number:true},
      malq:{required:false,number:true},
      mman:{required:false,number:true},
      san:"required",
      ftsan:{required:false, datePE:true},
      acons:{required:false,minlength:4},
      finsp:{required:false, datePE:true},
      upla:"required",
      urea:"required"
    },
    messages: {
      ali: {required:"Ingrese el alias del local.",minlength:"Mínimo 5 caracteres"},
      dir: {required:"Ingrese la dirección del local.",minlength:"Mínimo 6 caracteres"},
      urb: {minlength:"Mínimo 5 caracteres"},
      depubi:"Elija departamento",
      proubi:"Elija provincia",
      disubi:"Elija distrito",
      tel: {minlength:"Mínimo 6 caracteres"},
      con:"Elija condición",
      pro: {minlength:"Mínimo 5 caracteres"},
      atot:{number:"Sólo números decimales."},
      acon:{number:"Sólo números decimales."},
      mat:"Elija el material.",
      npis:{number:"Sólo números"},
      malq:{number:"Sólo números decimales."},
      mman:{number:"Sólo números decimales."},
      san:"Elija opción de saneado.",
      ftsan:{datePE:"Ingrese una fecha válida."},
      acons:{minlength:"Mínimo 4 caracteres."},
      finsp:{datePE:"Ingrese una fecha válida."},
      upla:"Elija tipo uso planificado",
      urea:"Elija tipo uso real"
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
      var datos = $("#f_edilocal").serializeArray();
      datos.push({name: "NomForm", value: "f_edilocal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedilocal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedilocal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedilocal").addClass("disabled");
         },
         success: function(data){
            $("#b_gedilocal").hide();
            $("#b_gedilocal").html("Guardar");
            $("#b_gedilocal").removeClass("disabled");
            $("#r_edilocal").html(data);
            $("#r_edilocal").slideDown();
         }
      });
    }
  } );
//fin función validar local
//función actualizar page local
$('#m_edilocal').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin función actualizar page local
//fin funciones editar local
//funciones desactivar local
function deslocal(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_deslocal.php",
  data: { idlo : id },
  beforeSend: function () {
    $("#r_deslocal").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_deslocal").html(a);
    $("#b_gdeslocal").show();
  }
});
};
$("#f_deslocal").submit(function(e){
  e.preventDefault();
  var datos = $("#f_deslocal").serializeArray();
  datos.push({name: "NomForm", value: "f_deslocal"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/ajax/a_gdeslocal.php",
        type:  "post",
        beforeSend: function () {
          $("#r_deslocal").html("<img scr='m_images/cargando.gif'>");
          $("#b_gdeslocal").hide();
        },
        success:  function (response) {
          $("#r_deslocal").html(response);
        }
    });
});
//función actualizar page local
$('#m_deslocal').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin función actualizar page local
//fin funciones desactivar local
//fin funciones mantenimiento local

//funciones mantenimiento ambiente
//funcion detalle Ambiente
function detambiente(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_detambiente.php",
  data: { idamb : id },
  beforeSend: function () {
    $("#r_detambiente").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_detambiente").html(a);
  }
});
};
//fin funcion detalle Ambiente

//funcion llamar formulario nuevo Ambiente
$("#b_nueambiente").on("click",function(e){
$.ajax({
  type:"post",
  url:"m_inclusiones/ajax/a_nueambiente.php",
  beforeSend: function () {
    $("#r_nueambiente").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_nueambiente").html(a);
    $("#b_gnueambiente").show();
  }
});
});
//Fin funcion llamar formulario nuevo Ambiente

//funcion validar nuevo ambiente
$( "#f_nueambiente" ).validate( {
  rules: {
    dep:"required",
    den:"required",
    loc:"required",
    pis:"required",
    ofi:{ required: true, minlength: 3},

  },
  messages: {
    dep:{required:"Seleccione la dependencia"},
    den:{required:"Elija una denominacion"},
    loc:{required:"Seleccione el local"},
    pis:{required:"Elija el Piso"},
    ofi:{required:"Escriba el número de oficina", minlength:"Mínimo 3 caracteres"},

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
    var datos = $("#f_nueambiente").serializeArray();
    datos.push({name: "NomForm", value: "f_nueambiente"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/ajax/a_gnueambiente.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_gnueambiente").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
          $("#b_gnueambiente").addClass("disabled");
       },
       success: function(data){
          $("#b_gnueambiente").hide();
          $("#b_gnueambiente").html("Guardar");
          $("#b_gnueambiente").removeClass("disabled");
          $("#r_nueambiente").html(data);
          $("#r_nueambiente").slideDown();
       }
    });
  }
} );
//fin función validar nuevo ambiente
//función actualizar page ambiente
$('#m_nueambiente').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin función actualizar page ambiente
//funciones editar ambiente
function ediambiente(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_ediambiente.php",
  data: { idamb : id },
  beforeSend: function () {
    $("#r_ediambiente").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_ediambiente").html(a);
    $("#b_gediambiente").show();
  }
});
};
//funcion validar editar ambiente
$( "#f_ediambiente" ).validate( {
  rules: {
    dep:"required",
    den:"required",
    loc:"required",
    pis:"required",
    ofi:{ required: true, minlength: 3},

  },
  messages: {
    dep:{required:"Seleccione la dependencia"},
    den:{required:"Elija una denominacion"},
    loc:{required:"Seleccione el local"},
    pis:{required:"Elija el Piso"},
    ofi:{required:"Escriba el número de oficina", minlength:"Mínimo 3 caracteres"},

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
      var datos = $("#f_ediambiente").serializeArray();
      datos.push({name: "NomForm", value: "f_ediambiente"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gediambiente.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gediambiente").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gediambiente").addClass("disabled");
         },
         success: function(data){
            $("#b_gediambiente").hide();
            $("#b_gediambiente").html("Guardar");
            $("#b_gediambiente").removeClass("disabled");
            $("#r_ediambiente").html(data);
            $("#r_ediambiente").slideDown();
         }
      });
    }
  } );
//fin función validar ambiente
//función actualizar page ambiente
$('#m_ediambiente').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin función actualizar page ambiente
//fin funciones editar ambiente
//funciones desactivar ambiente
function desambiente(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_desambiente.php",
  data: { idamb : id },
  beforeSend: function () {
    $("#r_desambiente").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_desambiente").html(a);
    $("#b_gdesambiente").show();
  }
});
};
$("#f_desambiente").submit(function(e){
  e.preventDefault();
  var datos = $("#f_desambiente").serializeArray();
  datos.push({name: "NomForm", value: "f_desambiente"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/ajax/a_gdesambiente.php",
        type:  "post",
        beforeSend: function () {
          $("#r_desambiente").html("<img scr='m_images/cargando.gif'>");
          $("#b_gdesambiente").hide();
        },
        success:  function (response) {
          $("#r_desambiente").html(response);
        }
    });
});
//función actualizar page ambiente
$('#m_desambiente').on('hidden.bs.modal', function () {
 document.location.reload();
})
//fin función actualizar page ambiente
//fin funciones desactivar ambiente
//fin funciones mantenimiento ambiente **********************

//funcion reporte personal
$("#f_reppersonal").validate({
  rules: {
    depen: "required",
    cargo: "required"
  },
  messages: {
    depen: "Elija una dependencia.",
    cargo: "Elija un cargo."
  },
  errorElement: "em",
  errorPlacement: function(error, element){
    // Add the `help-block` class to the error element
    error.addClass("help-block");

    if(element.prop("type") === "checkbox"){
      error.insertAfter(element.parent("label"));
    }else if(element.prop("type") === "radio"){
      error.insertAfter(element.parent("label"));
    }
    else{
      error.insertAfter(element);
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents(".valida").addClass("has-error").removeClass("has-success");
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents(".valida").addClass("has-success").removeClass("has-error");
  },
  submitHandler: function(form){
    var datos = $("#f_reppersonal").serializeArray();
    datos.push({name: "NomForm", value: "f_reppersonal"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/ajax/a_rperdependencia.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_rperdependencia").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
          $("#b_rperdependencia").addClass("disabled");
        },
       success: function(data){
          $("#b_rperdependencia").html("Buscar");
          $("#b_rperdependencia").removeClass("disabled");
          $("#r_rperdependencia").html(data);
       }
    });
  }
});
//fin funcion reporte personal

//funcion reporte cargos

$("#f_repcargos").validate({
  rules: {
    depen: "required",
    cargo: "required"
  },
  messages: {
    depen: "Elija una dependencia.",
    cargo: "Elija un cargo."
  },
  errorElement: "em",
  errorPlacement: function(error, element){
    // Add the `help-block` class to the error element
    error.addClass("help-block");

    if(element.prop("type") === "checkbox"){
      error.insertAfter(element.parent("label"));
    }else if(element.prop("type") === "radio"){
      error.insertAfter(element.parent("label"));
    }
    else{
      error.insertAfter(element);
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents(".valida").addClass("has-error").removeClass("has-success");
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents(".valida").addClass("has-success").removeClass("has-error");
  },
  submitHandler: function(form){
    var datos = $("#f_repcargos").serializeArray();
    datos.push({name: "NomForm", value: "f_repcargos"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/ajax/a_rcardependencia.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_rcargos").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
          $("#b_rcargos").addClass("disabled");
        },
       success: function(data){
          $("#b_rcargos").html("Buscar");
          $("#b_rcargos").removeClass("disabled");
          $("#r_rcargos").html(data);
       }
    });
  }
});
//fin funcion reporte cargos
//funcion reporte cargos

$("#f_ubipersonal").validate({
  rules: {
    dis: "required",
    carg: "required"
  },
  messages: {
    dis: "Elija un distrito.",
    carg: "Elija un cargo"
  },
  errorElement: "em",
  errorPlacement: function(error, element){
    // Add the `help-block` class to the error element
    error.addClass("help-block");

    if(element.prop("type") === "checkbox"){
      error.insertAfter(element.parent("label"));
    }else if(element.prop("type") === "radio"){
      error.insertAfter(element.parent("label"));
    }
    else{
      error.insertAfter(element);
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents(".valida").addClass("has-error").removeClass("has-success");
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents(".valida").addClass("has-success").removeClass("has-error");
  },
  submitHandler: function(form){
    var datos = $("#f_ubipersonal").serializeArray();
    datos.push({name: "NomForm", value: "f_ubipersonal"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/ajax/a_rubipersonal.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_rubipersonal").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
          $("#b_rubipersonal").addClass("disabled");
        },
       success: function(data){
          $("#b_rubipersonal").html("Buscar");
          $("#b_rubipersonal").removeClass("disabled");
          $("#r_rubipersonal").html(data);
       }
    });
  }
});
//fin funcion reporte cargos
//funcion reporte personal
$("#f_rephijos").validate({
  rules: {
    pers: "required"
  },
  messages: {
    pers: "Elija un personal."
  },
  errorElement: "em",
  errorPlacement: function(error, element){
    // Add the `help-block` class to the error element
    error.addClass("help-block");

    if(element.prop("type") === "checkbox"){
      error.insertAfter(element.parent("label"));
    }else if(element.prop("type") === "radio"){
      error.insertAfter(element.parent("label"));
    }
    else{
      error.insertAfter(element);
    }
  },
  highlight: function ( element, errorClass, validClass ) {
    $( element ).parents(".valida").addClass("has-error").removeClass("has-success");
  },
  unhighlight: function (element, errorClass, validClass) {
    $( element ).parents(".valida").addClass("has-success").removeClass("has-error");
  },
  submitHandler: function(form){
    var datos = $("#f_rephijos").serializeArray();
    datos.push({name: "NomForm", value: "f_rephijos"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/ajax/a_rperhijos.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_rhijos").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
          $("#b_rhijos").addClass("disabled");
        },
       success: function(data){
          $("#b_rhijos").html("Buscar");
          $("#b_rhijos").removeClass("disabled");
          $("#r_rhijos").html(data);
       }
    });
  }
});
//fin funcion reporte personal
$("#b_rvencimientos").on("click",function(e){
  $.ajax({
    type:"post",
    url:"m_inclusiones/ajax/a_rvencimientos.php",
    beforeSend: function () {
      $("#r_rvencimientos").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_rvencimientos").html(a);
    }
  });
});

//validar seleccionar dependencia para mostrar directorio
$("#f_bteldep").validate({
 rules: {
   dep: "required",
 },
 messages: {
   tiptel: "Elija la dependencia.",
 },
 errorElement: "em",
 errorPlacement: function(error, element){
   // Add the `help-block` class to the error element
   error.addClass("help-block");

   if(element.prop("type") === "checkbox"){
     error.insertAfter(element.parent("label"));
   }else if(element.prop("type") === "radio"){
     error.insertAfter(element.parent("label"));
   }
   else{
     error.insertAfter(element);
   }
 },
 highlight: function ( element, errorClass, validClass ) {
   $( element ).parents(".valida").addClass("has-error").removeClass("has-success");
 },
 unhighlight: function (element, errorClass, validClass) {
   $( element ).parents(".valida").addClass("has-success").removeClass("has-error");
 },
 submitHandler: function(form){
   var datos = $("#f_bteldep").serializeArray();
   datos.push({name: "NomForm", value: "f_bteldep"});
   $.ajax({
      type: "POST",
      url: "m_inclusiones/a_directorio/a_dirdep.php",
      dataType: "html",
      data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
      beforeSend: function () {
        $("#b_bteldep").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        $("#b_bteldep").addClass("disabled");
      },
      success: function(data){
         $("#b_bteldep").html("Buscar");
         $("#b_bteldep").removeClass("disabled");
         $(".r_telefono").html(data);
         $(".r_telefono").slideDown();
      }
   });
 }
});
//fin validar seleccionar dependencia para mostrar directorio
 // función nuevo telefono
function nueteld(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/a_directorio/a_fnueteld.php",
  data: { iddep : id },
  beforeSend: function () {
    $("#d_ntelefono").html("<img src='m_images/cargando.gif'>");
    $("#b_gntelefono").hide();
  },
  success:function(a){
    $("#b_gntelefono").show();
    $("#d_ntelefono").html(a);
  }
});
};
//fin nuevo telefono
//funcion validar nuevo telefono
$( "#f_ntelefono" ).validate( {
  rules: {
    tiptel:"required",
    num:{ required: true, minlength: 4},
    amb:"required"
  },
  messages: {
    tiptel:"Seleccione el tipo de teléfono",
    num:{required:"Escriba el número de teléfono", minlength:"Mínimo 4 caracteres"},
    amb:"Seleccione el ambiente"

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
    var datos = $("#f_ntelefono").serializeArray();
    datos.push({name: "NomForm", value: "f_ntelefono"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/a_directorio/a_gnueteld.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_gntelefono").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
          $("#b_gntelefono").addClass("disabled");
       },
       success: function(data){
          $("#b_gntelefono").hide();
          $("#b_gntelefono").html("Guardar");
          $("#b_gntelefono").removeClass("disabled");
          $("#d_ntelefono").html(data);
          $("#d_ntelefono").slideDown();
       }
    });
  }
} );
//fin función validar nuevo telefono
// función editar telefono
function editeld(id, iddep){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_directorio/a_fediteld.php",
 data: { idtd : id, iddep : iddep },
 beforeSend: function () {
   $("#d_etelefono").html("<img src='m_images/cargando.gif'>");
   $("#b_getelefono").hide();
 },
 success:function(a){
   $("#b_getelefono").show();
   $("#d_etelefono").html(a);
 }
});
};
//fin editar telefono
//funcion validar editar telefono
$( "#f_etelefono" ).validate( {
  rules: {
    amb:"required",
    tiptel:"required",
    num:{ required: true, minlength: 4},

  },
  messages: {
    amb:"Seleccione el ambiente",
    tiptel:"Seleccione el tipo de teléfono",
    num:{required:"Escriba el número de teléfono", minlength:"Mínimo 4 caracteres"},


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
    var datos = $("#f_etelefono").serializeArray();
    datos.push({name: "NomForm", value: "f_etelefono"});
    $.ajax({
       type: "POST",
       url: "m_inclusiones/a_directorio/a_gediteld.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#b_getelefono").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
          $("#b_getelefono").addClass("disabled");
       },
       success: function(data){
          $("#b_getelefono").hide();
          $("#b_getelefono").html("Guardar");
          $("#b_getelefono").removeClass("disabled");
          $("#d_etelefono").html(data);
          $("#d_etelefono").slideDown();
       }
    });
  }
} );
//fin función validar editar telefono

// función eliminar telefono
function eliteld(id, amb){
$.ajax({
 type: "post",
 url: "m_inclusiones/a_directorio/a_feliteld.php",
 data: { idtd : id, amb : amb },
 beforeSend: function () {
   $("#d_elitelefono").html("<img src='m_images/cargando.gif'>");
   $("#b_sielitelefono").hide();
   $("#b_noelitelefono").html("Cerrar");
 },
 success:function(a){
   $("#b_sielitelefono").show();
   $("#b_noelitelefono").html("No");
   $("#d_elitelefono").html(a);
 }
});
};
//fin función eliminar telefono
//funcion eliminar teléfono
$("#f_elitelefono").submit(function(e){
  e.preventDefault();
  var datos = $("#f_elitelefono").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_directorio/a_eliteld.php",
        type:  "post",
        beforeSend: function () {
          $("#b_sielitelefono").html("<i class='fa fa-spinner fa-spin'></i> Eliminando");
          $("#b_sielitelefono").addClass("disabled");
          $("#b_noelitelefono").hide();
        },
        success:  function (response) {
          $("#b_sielitelefono").hide();
          $("#b_noelitelefono").html("Cerrar");
          $("#b_noelitelefono").show();
          $("#d_elitelefono").html(response);
        }
    });
});
//fin funcion eliminar teléfono
//funcion actualizar lista de telefonos
$('#m_ntelefono, #m_editeld, #m_elitelefono').on('hidden.bs.modal', function () {
      var dep = $("#dep").val();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_directorio/a_dirdep.php",
         dataType: "html",
         data: {dep: dep},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_bteldep").html("<i class='fa fa-spinner fa-spin'></i> Actualizando");
            $("#b_bteldep").addClass("disabled");
         },
         success: function(data){
            $("#b_bteldep").html("Buscar");
            $("#b_bteldep").removeClass("disabled");
            $(".r_telefono").html(data);
            $(".r_telefono").slideDown();
         }
      });
})
//fin funcion actualizar lista de telefonos

    function edifv(idec){
      $('#m_fvac').modal('show');
        $.ajax({
           type: "POST",
           url: "m_inclusiones/ajax/a_edifvac.php",
           dataType: "html",
           data: {idec: idec},   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
           beforeSend: function () {
              $("#f_efvac").html("<i class='fa fa-spinner fa-spin text-center'></i>");
              $("#b_gefvac").hide();
           },
           success: function(d){
              $("#f_efvac").html(d);
           }
        });
    }

      $("#b_gefvac").on("click",function(){
          var datos = $("#f_efvac").serializeArray();
          $.ajax({
             type: "POST",
             url: "m_inclusiones/ajax/a_gedifvac.php",
             dataType: "json",
             data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
             beforeSend: function () {
                $("#r_fvac").html("<i class='fa fa-spinner fa-spin'></i>");
                $("#b_gefvac").hide();
             },
             success: function(d){
                if(d.e){
                  $("#f_efvac").html(d.m);
                  var iec=$("#iec").val();
                  detcargo(iec);
                  console.log(iec);
                }else{
                  $("#r_fvac").html(d.m);
                  $("#b_gefvac").show();
                }
             }
          });
      })
