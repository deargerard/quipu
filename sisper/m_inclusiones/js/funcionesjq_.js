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
       success: function(data){
          $("#b_gagrtelefono").hide();
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
       success: function(data){
          $("#b_geditelefono").hide();
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
  //funciones desactivar telefono
function destelefono(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_destelefono.php",
  data: {idt:id},
  beforeSend: function () {
    $("#r_editelefono").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_destelefono").html(a);
    $("#b_gdestelefono").show();
  }
});
};
$("#f_destelefono").submit(function(e){
  e.preventDefault();
  var datos = $("#f_destelefono").serializeArray();
  datos.push({name: "NomForm", value: "f_destelefono"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/ajax/a_gdestelefono.php",
        type:  "post",
        beforeSend: function () {
          $("#b_gdestelefono").hide();
          $("#r_destelefono").html("<img scr='m_images/cargando.gif'>");
        },
        success:  function (response) {
          $("#r_destelefono").html(response);
        }
    });
});
$('#m_destelefono').on('hidden.bs.modal', function () {
 $("#dcontacto").load("m_inclusiones/ajax/a_rdcontacto.php");
})
  //fin funciones desactivar telefono
  //funciones activar telefono
function acttelefono(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/ajax/a_acttelefono.php",
  data: {idt:id},
  beforeSend: function () {
    $("#r_acttelefono").html("<img scr='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_acttelefono").html(a);
    $("#b_gacttelefono").show();
  }
});
};
$("#f_acttelefono").submit(function(e){
  e.preventDefault();
  var datos = $("#f_acttelefono").serializeArray();
  datos.push({name: "NomForm", value: "f_acttelefono"});
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/ajax/a_gacttelefono.php",
        type:  "post",
        beforeSend: function () {
          $("#b_gacttelefono").hide();
          $("#r_acttelefono").html("<img scr='m_images/cargando.gif'>");
        },
        success:  function (response) {
          $("#r_acttelefono").html(response);
        }
    });
});
$('#m_acttelefono').on('hidden.bs.modal', function () {
 $("#dcontacto").load("m_inclusiones/ajax/a_rdcontacto.php");
})
  //fin funciones activar telefono
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
       success: function(data){
          $("#b_gedidatpersonales").hide();
          $("#r_edidatpersonales").html(data);
          $("#r_edidatpersonales").slideDown();
       }
    });
  }
});
$('#m_edidatpersonales').on('hidden.bs.modal', function () {
 $("#datose").load("m_inclusiones/ajax/a_rdatos.php");
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
         success: function(data){
            $("#b_gedigrainstruccion").hide();
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
      cuspp:{required:true,minlength:12}
    },
    messages: {
      penins:"Elija la institución a la que está afiliado.",
      cuspp:{required:"Ingrese el código CUSPP",minlength:"Mínimo 12 caracteres."}
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
         success: function(data){
            $("#b_gedisispension").hide();
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
         success: function(data){
            $("#b_gedidomicilio").hide();
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
      numcon: {minlength:"Mínimo 5 caracteres"},
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
         success: function(data){
            $("#b_gagrcarpersonal").hide();
            $("#r_agrcarpersonal").html(data);
            $("#r_agrcarpersonal").slideDown();
         }
      });
    }
  } );
$('#m_agrcarpersonal').on('hidden.bs.modal', function () {
 document.location.reload();
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
      numcon: {required:true, minlength:5},
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
      numcon: {required:"Ingrese el número de concurso o SUPLENCIA si es el caso.",minlength:"Mínimo 5 caracteres"},
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
         success: function(data){
            $("#b_gedicarpersonal").hide();
            $("#r_edicarpersonal").html(data);
            $("#r_edicarpersonal").slideDown();
         }
      });
    }
  } );
$('#m_edicarpersonal').on('hidden.bs.modal', function () {
 document.location.reload();
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
      fin:{required:false, datePE:true},
      numres:{required:true, minlength:5},
      mot:{required:true, minlength:5},
      ofi:{required:false}
    },
    messages: {
      dep:"Elija una dependencia.",
      tipdes:"Elija un tipo de desplazamiento.",
      ini: {required:"Ingrese fecha de inicio del desplazamiento.",datePE:"Ingrese una fecha válida."},
      fin: {datePE:"Ingrese una fecha válida."},
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
         success: function(data){
            $("#b_gnuedesplazamiento").hide();
            $("#r_nuedesplazamiento").html(data);
            $("#r_nuedesplazamiento").slideDown();
         }
      });
    }
  } );
$('#m_nuedesplazamiento').on('hidden.bs.modal', function () {
 document.location.reload();
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
      fin:{required:false, datePE:true},
      numres:{required:true, minlength:5},
      mot:{required:true, minlength:5},
    },
    messages: {
      estcar:"Elija un nuevo estado.",
      ini: {required:"Ingrese fecha de inicio del nuevo estado.",datePE:"Ingrese una fecha válida."},
      fin: {datePE:"Ingrese una fecha válida."},
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
         success: function(data){
            $("#b_gnueestcargo").hide();
            $("#r_nueestcargo").html(data);
            $("#r_nueestcargo").slideDown();
         }
      });
    }
  } );
$('#m_nueestcargo').on('hidden.bs.modal', function () {
 document.location.reload();
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
    $("#b_agrparpersonal").show();
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
         success: function(data){
            $("#b_gagrparpersonal").hide();
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
    $("#b_ediparpersonal").show();
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
         success: function(data){
            $("#b_gediparpersonal").hide();
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
         success: function(data){
            $("#b_gagrgrapersonal").hide();
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
         success: function(data){
            $("#b_gedigrapersonal").hide();
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
         success: function(data){
            $("#b_gagrcappersonal").hide();
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
         success: function(data){
            $("#b_gedicappersonal").hide();
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
      fecfin:{required:true, datePE:true},
      con:{required:true},
      motces:{required:true, minlength:5},
    },
    messages: {
      ins: {required:"Ingrese la institución que emite el certificado de trabajo.",minlength:"Mínimo 5 caracteres"},
      car: {required:"Ingrese el cargo que ocupo.",minlength:"Mínimo 5 caracteres"},
      fecini: {required:"Ingrese fecha de inicio de labores.",datePE:"Ingrese una fecha válida."},
      fecfin: {required:"Ingrese fecha de fin de labores.",datePE:"Ingrese una fecha válida."},
      con: {required:"Elija la condición laboral."},
      motces: {required:"Ingrese el motivo del cese.",minlength:"Mínimo 5 caracteres"},
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
         success: function(data){
            $("#b_gagrexppersonal").hide();
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
      fecfin:{required:true, datePE:true},
      con:{required:true},
      motces:{required:true, minlength:5},
    },
    messages: {
      ins: {required:"Ingrese la institución que emite el certificado de trabajo.",minlength:"Mínimo 5 caracteres"},
      car: {required:"Ingrese el cargo que ocupo.",minlength:"Mínimo 5 caracteres"},
      fecini: {required:"Ingrese fecha de inicio de labores.",datePE:"Ingrese una fecha válida."},
      fecfin: {required:"Ingrese fecha de fin de labores.",datePE:"Ingrese una fecha válida."},
      con: {required:"Elija la condición laboral."},
      motces: {required:"Ingrese el motivo del cese.",minlength:"Mínimo 5 caracteres"},
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
         success: function(data){
            $("#b_gediexppersonal").hide();
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
//funcion llamar formulario nuevo local
//funcion validar local
$( "#f_nuelocal" ).validate( {
    rules: {
      dir:{required:true, minlength:6},
      urb:{required:false, minlength:5},
      depubi:"required",
      proubi:"required",
      disubi:"required",
      tel:{required:false, minlength:9},
      obs:{required:false, minlength:5}
    },
    messages: {
      dir: {required:"Ingrese la dirección del local.",minlength:"Mínimo 6 caracteres"},
      urb: {minlength:"Mínimo 5 caracteres"},
      depubi:"Elija departamento",
      proubi:"Elija provincia",
      disubi:"Elija distrito",
      tel: {minlength:"Mínimo 9 caracteres"},
      obs: {minlength:"Mínimo 5 caracteres"}
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
         success: function(data){
            $("#b_gnuelocal").hide();
            $("#r_nuelocal").html(data);
            $("#r_nuelocal").slideDown();
         }
      });
    }
  } );
//fin función validar local
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
//funcion validar local
$( "#f_edilocal" ).validate( {
    rules: {
      dir:{required:true, minlength:6},
      urb:{required:false, minlength:5},
      depubi:"required",
      proubi:"required",
      disubi:"required",
      tel:{required:false, minlength:9},
      obs:{required:false, minlength:5}
    },
    messages: {
      dir: {required:"Ingrese la dirección del local.",minlength:"Mínimo 6 caracteres"},
      urb: {minlength:"Mínimo 5 caracteres"},
      depubi:"Elija departamento",
      proubi:"Elija provincia",
      disubi:"Elija distrito",
      tel: {minlength:"Mínimo 9 caracteres"},
      obs: {minlength:"Mínimo 5 caracteres"}
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
         success: function(data){
            $("#b_gedilocal").hide();
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