$("#i_acpersona").autocomplete({
        source: "m_inclusiones/ajax/a_spersonal.php",
        minLength: 4,
        select: function(ev,ui){
          $("#i_acpersona").val(ui.item.value);
          return false;
        }
});
$("#fb_persona").submit(function(e){
	e.preventDefault();
	$.ajax({
        data:  $("#fb_persona").serialize(),
        url:   "m_inclusiones/ajax/a_bpersona.php",
        type:  "post",
        beforeSend: function () {
            $("#dmb_persona").html("<img scr='m_images/cargando.gif'>");
        },
        success:  function (response) {
            $("#dmb_persona").html(response);
        }
    });
});
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
//validar nuevo personal
  $("#f_nuepersonal").validate({
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
      tipdoc: "required",
      numdoc: {required:true,minlength:8,remote:{url:"m_inclusiones/ajax/a_vdocumento.php",type:"get"}},
      libmil:{required:false, minlength:8},
      aut:{required:false,minlength:15},
      ruc:{required:false,minlength:11},
      corper:{required:true,email:true},
      numcue:{required:false,minlength:10},
      entcts:{required:false,minlength:3},
      grusan:"required",
      grains:"required",
      nivins:"required",
      esp:"required",
      ins:"required",
      penins:"required",
      cuspp:{required:true,minlength:12},
      fecafi:{required:true, datePE:true},
      conviv:"required",
      dir:"required",
      urb:{required:false,minlength:6},
      depubi:"required",
      proubi:"required",
      disubi:"required",
      tiptel:"required",
      numtel:{required:true,minlength:9}
    },
    messages: {
      apepat: "Ingrese apellido paterno.",
      apemat: "Ingrese apellido materno.",
      nom: "Ingrese nombres.",
      fecnac:{required:"Ingrese fecha de nacimiento.",datePE:"Ingrese una fecha válida."},
      nac: "Ingrese nacionalidad.",
      depnac:"Elija departamento.",
      pronac:"Elija provincia.",
      disnac:"Elija distrito.",
      estciv:"Elija estado civil.",
      tipdoc:"Elija tipo de documento de identidad",
      numdoc:{required:"Ingrese el número del documento elegido.",minlength:"Mínimo 8 caracteres",remote:"En número del documento ingresado ya existe."},
      libmil:{minlength:"Mínimo 8 caracteres."},
      aut:{minlength:"El autogenerado contiene 15 caracteres."},
      ruc:{minlength:"El RUC contiene 11 caracteres."},
      numcue:{minlength:"Mínimo 10 caracteres."},
      entcts:{minlength:"Mínimo 3 caracteres."},
      grusan:"Elija grupo sanguineo.",
      grains:"Elija grado de instrucción.",
      nivins:"Elija nivel.",
      esp:"Ingrese especialidad o NINGUNA  en caso no tenga.",
      ins:"Ingrese institución.",
      penins:"Elija la institución a la que está afiliado.",
      cuspp:{required:"Ingrese el código CUSPP",minlength:"Mínimo 12 caracteres."},
      fecafi:{required:"Ingrese fecha de afiliación.",datePE:"Ingrese una fecha válida."},
      conviv:"Elija la condición de la vivienda.",
      dir:"Ingrese la dirección.",
      urb:{minlength:"Mínimo 6 caracteres."},
      depubi:"Elija departamento.",
      proubi:"Elija provincia.",
      disubi:"Elija distrito.",
      tiptel:"Elija tipo de teléfono.",
      numtel:{required:"Ingrese el número de teléfono.",minlength:"Mínimo 9 caracteres."}
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
      var datos = $("#f_nuepersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_nuepersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gnuepersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnuepersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gnuepersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gnuepersonal").hide();
            $("#b_gnuepersonal").html("Guardar");
            $("#b_gnuepersonal").removeClass("disabled");
            $("#b_rnuepersonal").hide();
            $("#r_nuepersonal").html(data);
            $("#r_nuepersonal").slideDown();
         }
      });
    }
  });
//cambiar contraseña
$("#f_camconpersonal").validate({
    rules: {
      actcon: {required:true, minlength:6},
      nuecon: {required:true, minlength:6},
      rnuecon: {required:true, equalTo:"#nuecon"}
    },
    messages: {
      actcon: {required:"Ingrese la actual contraseña.",minlength:"Mínimo 6 caracteres"},
      nuecon: {required:"Ingrese la nueva contraseña.",minlength:"Mínimo 6 caracteres"},
      rnuecon: {required:"Repita la nueva contraseña.",equalTo:"No coinciden las contraseñas."}
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
      var datos = $("#f_camconpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_camconpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gcamconpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gcamconpersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gcamconpersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gcamconpersonal").hide();
            $("#b_gcamconpersonal").html("Guardar");
            $("#b_gcamconpersonal").removeClass("disabled");
            $("#r_camconpersonal").html(data);
            $("#r_camconpersonal").slideDown();
            setTimeout(function(){
              window.location.href = "salir.php";
            }, 2000);
         }
      });
    }
});
//validar formulario cambiar contraseña
$("#f_camcontrasena").validate({
    rules: {
      nuecon: {required:true, minlength:6},
      rnuecon: {required:true, equalTo:"#nuecon"}
    },
    messages: {
      nuecon: {required:"Ingrese la nueva contraseña.",minlength:"Mínimo 6 caracteres"},
      rnuecon: {required:"Repita la nueva contraseña.",equalTo:"No coinciden las contraseñas."}
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
      var datos = $("#f_camcontrasena").serializeArray();
      datos.push({name: "NomForm", value: "f_camcontrasena"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gcamcontrasena.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gcamcontrasena").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gcamcontrasena").addClass("disabled");
         },
         success: function(data){
            $("#b_gcamcontrasena").hide();
            $("#b_gcamcontrasena").html("Guardar");
            $("#b_gcamcontrasena").removeClass("disabled");
            $("#r_gcamcontrasena").html(data);
            $("#r_gcamcontrasena").slideDown();
         }
      });
    }
  });
//validar formulario cargo personal
  $( "#f_carpersonal" ).validate( {
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
      var datos = $("#f_carpersonal").serializeArray();
      datos.push({name: "NomForm", value: "f_carpersonal"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gcarpersonal.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gcarpersonal").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gcarpersonal").addClass("disabled");
         },
         success: function(data){
            $("#b_gcarpersonal").hide();
            $("#b_gcarpersonal").html("Guardar");
            $("#b_gcarpersonal").removeClass("disabled");
            $("#b_rcarpersonal").hide();
            $("#r_carpersonal").html(data);
            $("#r_carpersonal").slideDown();
         }
      });
    }
  } );
  //validar mantenimiento dependencia
  $("#f_nuedependencia").validate({
    rules: {
      den: {required:true, minlength:5},
      sig: {required:true, minlength:3},
      loc: "required",
      disfis: "required"
    },
    messages: {
      den: {required:"Ingrese denominación de la dependencia.",minlength:"Mínimo 5 caracteres"},
      sig: {required:"Ingrese siglas de la dependencia.",minlength:"Mínimo 3 caracteres"},
      loc: "Elija el local.",
      disfis: "Elija el distrito fiscal al que pertenece."
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
      var datos = $("#f_nuedependencia").serializeArray();
      datos.push({name: "NomForm", value: "f_nuedependencia"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gnuedependencia.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnuedependencia").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gnuedependencia").addClass("disabled");
         },
         success: function(data){
            $("#b_gnuedependencia").hide();
            $("#b_gnuedependencia").html("Guardar");
            $("#b_gnuedependencia").removeClass("disabled");
            $("#r_nuedependencia").html(data);
            $("#r_nuedependencia").slideDown();
         }
      });
    }
  });

  $( "#f_edidependencia" ).validate( {
    rules: {
      den: {required:true, minlength:5},
      sig: {required:true, minlength:3},
      loc: "required",
      disfis: "required"
    },
    messages: {
      den: {required:"Ingrese denominación de la dependencia.",minlength:"Mínimo 5 caracteres"},
      sig: {required:"Ingrese siglas de la dependencia.",minlength:"Mínimo 3 caracteres"},
      loc: "Elija el local.",
      disfis: "Elija el distrito fiscal al que pertenece."
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
      var datos = $("#f_edidependencia").serializeArray();
      datos.push({name: "NomForm", value: "f_edidependencia"});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/ajax/a_gedidependencia.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedidependencia").html("<i class='fa fa-spinner fa-spin'></i> Enviando");
            $("#b_gedidependencia").addClass("disabled");
         },
         success: function(data){
            $("#b_gedidependencia").hide();
            $("#b_gedidependencia").html("Guardar");
            $("#b_gedidependencia").removeClass("disabled");
            $("#r_edidependencia").html(data);
            $("#r_edidependencia").slideDown();
         }
      });
    }
  } );
