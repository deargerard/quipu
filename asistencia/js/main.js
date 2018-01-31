

$("#login").validate({
    rules: {
      dni: {required:true, minlength:8},
      pas: {required:true, minlength:6},
    },
    messages: {
      dni: {required:"Ingrese su DNI.",minlength:"Mínimo 8 caracteres."},
      pas: {required:"Ingrese su contraseña.",minlength:"Mínimo 6 caracteres."},
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
      var datos = $("#login").serializeArray();
      datos.push({name: "NomForm", value: "logina"});
      $.ajax({
         type: "POST",
         url: "ajax/login.php",
         dataType: "json",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
          $("#blogin").html("<i class='fa fa-spinner fa-spin'></i>");
          $("#blogin").addClass("disabled");
         },
         success: function(data){
            if(data.exito){
              $("#d_login").addClass("alert alert-success");
              $("#d_login").css("text-align","center");
              $("#d_login").text(data.mensaje);
              $("#d_login").slideDown();
              $(location).attr("href","asistencia.php");
            }else{
              $("#d_login").hide();
              $("#d_login").addClass("alert alert-warning");
              $("#d_login").css("text-align","center");
              $("#d_login").text(data.mensaje);
              $("#d_login").slideDown();
              $("#blogin").html("<i class='fa fa-sign-in'></i> Ingresar");
              $("#blogin").removeClass("disabled");
            }
         }
      });
    }
});
 //validar registrar marcación
$("#fmarcacion").validate({
  rules: {
    cod: {required:true, minlength:8}
  },
  messages: {
    cod: {required:"Ingrese un código.",minlength:"Mínimo 8 caracteres"}
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
    var datos = $("#fmarcacion").serializeArray();
    datos.push({name: "NomForm", value: "marcacion"});
    $.ajax({
       type: "POST",
       url: "ajax/gmarcacion.php",
       dataType: "html",
       data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
       beforeSend: function () {
          $("#bmarcacion").html("<i class='fa fa-spinner fa-spin'></i> Registrando");
          $("#bmarcacion").addClass("disabled");
        },
       success: function(data){
          $("#bmarcacion").html("Registrar");
          $("#bmarcacion").removeClass("disabled");
          $("#resultado").html(data);
          $("#resultado").slideDown();
          $("#cod").val("");
       }
    });
  }
});
//fin validar registrar marcación
//funcion mostrar formulario cambiar contraseña
$("#b_contrasena").click(function(){
  $.post("ajax/fcontrasena.php", function(cont){
    $("#d_contrasena").html(cont);
  });
  $("#b_gcontrasena").show();
});
//funcion mostrar formulario cambiar contraseña
//validar cambiar contraseña
$("#f_contrasena").validate({
    rules: {
      con: {required:true, minlength:6},
      ncon: {required:true, minlength:6},
      rncon: {required:true, equalTo:"#ncon"}
    },
    messages: {
      con: {required:"Ingrese la contraseña actual.",minlength:"Mínimo 6 caracteres"},
      ncon: {required:"Ingrese la nueva contraseña.",minlength:"Mínimo 6 caracteres"},
      rncon: {required:"Repita la nueva contraseña.",equalTo:"No coinciden las contraseñas."}
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
      var datos = $("#f_contrasena").serializeArray();
      $.ajax({
         type: "POST",
         url: "ajax/gcontrasena.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gcontrasena").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gcontrasena").addClass("disabled");
         },
         success: function(data){
            $("#b_gcontrasena").html("Guardar");
            $("#b_gcontrasena").removeClass("disabled");
            $("#b_gcontrasena").hide();
            $("#d_contrasena").html(data);
            $("#d_contrasena").slideDown();
         }
      });
    }
});
//fin validar cambiar contraseña