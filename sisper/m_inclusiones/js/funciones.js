$("#f_login").validate({
    rules: {
      doc: {required:true, minlength:8},
      pas: {required:true, minlength:6},
    },
    messages: {
      doc: {required:"Ingrese su documento de identidad.",minlength:"Mínimo 8 caracteres."},
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
      var datos = $("#f_login").serializeArray();
      datos.push({name: "NomForm", value: "login"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_login.php",
         dataType: "json",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
          $("#flogin").html("<i class='fa fa-spinner fa-spin'></i>");
          $("#flogin").addClass("disabled");
         },
         success: function(data){
            if(data.exito){
              $("#a_login").hide();
              $("#a_login").addClass("alert alert-warning");
              $("#a_login").css("text-align","center");
              $("#a_login").text(data.mensaje);
              $("#a_login").slideDown();
              $(location).attr("href","m_inclusiones/php/cargando.php");
            }else{
              $("#a_login").hide();
              $("#a_login").addClass("alert alert-warning");
              $("#a_login").css("text-align","center");
              $("#a_login").text(data.mensaje);
              $("#a_login").slideDown();
              $("#flogin").html("<i class='fa fa-sign-in'></i> Ingresar");
              $("#flogin").removeClass("disabled");
            }
         }
      });
    }
});
$("#f_camcontra").validate({
    rules: {
      pas1: {required:true, minlength:6},
      pas2: {required:true, equalTo:"#pas1"},
    },
    messages: {
      pas1: {required:"Ingrese la nueva contraseña.",minlength:"Mínimo 6 caracteres."},
      pas2: {required:"Repita la nueva contraseña.",equalTo:"No coinciden las contraseñas."},
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
      var datos = $("#f_camcontra").serializeArray();
      datos.push({name: "NomForm", value: "f_camcontra"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gcamcontra.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         success: function(data){
          $(".login-box-body").html(data);
       }
      });
    }
});
