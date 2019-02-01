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
      cuspp:{required:true,minlength:6},
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
      pad: "required",
      sig: {required:true, minlength:3},
      jef: "required",
      coo: "required",
      disfis: "required"
    },
    messages: {
      den: {required:"Ingrese denominación de la dependencia.",minlength:"Mínimo 5 caracteres."},
      pad: "Elija una Dependencia Superior.",
      sig: {required:"Ingrese siglas de la dependencia.",minlength:"Mínimo 3 caracteres."},
      jef: "Elija un responsable de la dependencia.",
      coo: "Elija una coordinación",
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
      pad: "required",
      sig: {required:true, minlength:3},
      jef: "required",
      coo: "required",
      disfis: "required"
    },
    messages: {
      den: {required:"Ingrese denominación de la dependencia.",minlength:"Mínimo 5 caracteres."},
      pad: "Elija una Dependencia Superior.",
      sig: {required:"Ingrese siglas de la dependencia.",minlength:"Mínimo 3 caracteres."},
      jef: "Elija un responsable de la dependencia.",
      coo: "Elija una coordinación",
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

  //TESORERÍA
  //GERARDO

$(document).ready(function(){
  $('#fecb').datepicker({
      format: 'mm/yyyy',
      language: 'es',
      autoclose: true,
      minViewMode: 1,
      maxViewMode: 2,
      todayHighlight: true
  });

  var mai=$('#fecb').val();
  lrendiciones(mai);

  var mav=$("#fecb").val();
  lviaticos(mav);

});

function lrendiciones(ma){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/li_rendiciones.php",
    data: {fecb : ma},
    dataType: "html",
    beforeSend: function () {
      $("#resultado").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#resultado").html(a);
    }
  });
}

$('#b_buscar').click(function(){
  var ma=$('#fecb').val();
  lrendiciones(ma);
})

function fo_rendiciones(acc, v1, v2){
  $("#m_tamaño").removeClass("modal-lg");
  switch(acc) {
    case 'agrren':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar rendición";
        break;
    case 'ediren':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar rendición";
        break;
    case 'agrdoc':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar documento rendición";
        $("#m_tamaño").addClass("modal-lg");
        break;
    case 'edidoc':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar documento rendición";
        $("#m_tamaño").addClass("modal-lg");
        break;
    case 'elidoc':
        var mt="<i class='fa fa-pencil text-gray'></i> Eliminar documento rendición";
        break;
    case 'estdoc':
        var mt="<i class='fa fa-pencil text-gray'></i> Estado rendición";
        break;
    case 'libvia':
        var mt="<i class='fa fa-external-link text-gray'></i> Liberar víatico";
        break;
    case 'movdoc':
        var mt="<i class='fa fa-retweet text-gray'></i> Mover documento";
        break;
    case 'ordvia':
        var mt="<i class='fa fa-sort-numeric-asc text-gray'></i> Orden víatico";
        break;
  }
  $(".m_titulo").html(mt);
  $("#m_modal").modal("show");

  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/fo_rendiciones.php",
    data: {acc: acc, v1: v1, v2: v2},
    dataType: "html",
    beforeSend: function () {
      $("#f_rendiciones").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      $("#f_rendiciones").html(a);
      $("#b_guardar").removeClass("hidden");
    }
  });
}

$('#f_rendiciones').submit(function(e){
  e.preventDefault();
  var datos = $("#f_rendiciones").serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/gu_rendiciones.php",
    data: datos,
    dataType: "json",
    beforeSend: function () {
      $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      if(a.e){
        $("#f_rendiciones").html(a.m);
        //console.log(datos);
        if(datos[0].value=="agrren" || datos[0].value=="ediren"){
          var ma=$('#ma').val();
          lrendiciones(ma);
        }else if(datos[0].value=="agrdoc" || datos[0].value=="edidoc" || datos[0].value=="elidoc" || datos[0].value=="estren" || datos[0].value=="libvia" || datos[0].value=="movdoc" || datos[0].value=="ordvia"){
          var ir=$('#ir').val();
          ldocrendiciones(ir);
        }
        $("#b_guardar").addClass("hidden");
      }else{
        $("#d_frespuesta").html(a.m);
        $("#b_guardar").removeClass("hidden");
      }
    }
  });
})

function ldocrendiciones(idr){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/li_docrendiciones.php",
    data: {idr : idr},
    dataType: "html",
    beforeSend: function () {
      $("#resultado").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#resultado").html(a);
    }
  });
}

function fo_rendiciones1(acc, v1, v2){
  
  switch(acc) {
    case 'agrpro':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar proveedor";
        break;
  }
  $(".m1_titulo").html(mt);
  $("#m1_modal").modal("show");

  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/fo_rendiciones.php",
    data: {acc: acc, v1: v1, v2: v2},
    dataType: "html",
    beforeSend: function () {
      $("#f1_rendiciones").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b1_guardar").hide();
    },
    success:function(a){
      $("#f1_rendiciones").html(a);
      $("#b1_guardar").show();
    }
  });
}

$('#f1_rendiciones').submit(function(e){
  e.preventDefault();
  var datos = $("#f1_rendiciones").serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/gu_rendiciones.php",
    data: datos,
    dataType: "json",
    beforeSend: function () {
      $("#d1_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b1_guardar").hide();
    },
    success:function(a){
      if(a.e){
        $("#f1_rendiciones").html(a.m);
      }else{
      $("#d1_frespuesta").html(a.m);
      $("#b1_guardar").show();
      }
    }
  });
})

function viaaren(idcs, idr){
  var ord = prompt("Ingrese el orden");
  if(ord!=null){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tesoreria/gu_viaaren.php",
      data: {idcs: idcs, idr: idr, ord: ord},
      dataType: "json",
      beforeSend: function () {
        $("#var"+idcs).removeClass('hidden');
      },
      success:function(a){
        if(a.e){
          alert(a.m);
          fo_rendiciones('agrdoc', idr, 2);
          ldocrendiciones(idr);
        }else{
          alert(a.m);
          $("#var"+idcs).addClass('hidden');
        }
      }
    });
  }else{
    alert("No ingreso el orden");
  }
}

//Viaticos........................................................................
function lviaticos(ma){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/li_viaticos.php",
    data: {fecb : ma},
    dataType: "html",
    beforeSend: function () {
      $("#l_viaticos").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#l_viaticos").html(a);
    }
  });
}

$('#f_lviaticos').submit(function(e){
  e.preventDefault();
  var ma=$('#fecb').val();
  lviaticos(ma);
})

function fo_viaticos(acc, v1, v2){
  $("#m_tamaño").removeClass("modal-lg");
  switch(acc) {
    case 'verpla':
        var mt="<i class='fa fa-file-text text-gray'></i> Conceptos planilla";
        $("#m_tamaño").addClass("modal-lg");
        break;
    case 'vercom':
        var mt="<i class='fa fa-file-text text-gray'></i> Comprobantes rendición";
        $("#m_tamaño").addClass("modal-lg");
        break;
  }
  $(".m_titulo").html(mt);
  $("#m_modal").modal("show");

  
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tesoreria/fo_viaticos.php",
      data: {acc: acc, v1: v1, v2: v2},
      dataType: "html",
      beforeSend: function () {
        $("#f_viaticos").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
        $("#b_guardar").addClass("hidden");
      },
      success:function(a){
        $("#f_viaticos").html(a);
        if(acc.substr(0, 3)!="ver"){
          $("#b_guardar").removeClass("hidden");
        }
      }
    });
}

$('#f_viaticos').submit(function(e){
  e.preventDefault();
  var datos = $("#f_rendiciones").serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/gu_rendiciones.php",
    data: datos,
    dataType: "json",
    beforeSend: function () {
      $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      if(a.e){
        $("#f_rendiciones").html(a.m);
        console.log(datos);
        if(datos[0].value=="agrren" || datos[0].value=="ediren"){
          var ma=$('#ma').val();
          lrendiciones(ma);
        }else if(datos[0].value=="agrdoc" || datos[0].value=="edidoc" || datos[0].value=="elidoc" || datos[0].value=="estren"){
          var ir=$('#ir').val();
          ldocrendiciones(ir);
        }
        $("#b_guardar").addClass("hidden");
      }else{
        $("#d_frespuesta").html(a.m);
        $("#b_guardar").removeClass("hidden");
      }
    }
  });
})
//viaticos pequeña
function fo_viaticos1(acc, v1, v2){
  switch(acc) {
    case 'agrcon':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar Concepto";
        break;
    case 'tipane':
        var mt="<i class='fa fa-folder-open text-gray'></i> Tipo Anexo";
        break;
    case 'edicon':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar Concepto";
        break;
    case 'elicon':
        var mt="<i class='fa fa-pencil text-gray'></i> Eliminar Concepto";
        break;
    case 'estren':
        var mt="<i class='fa fa-retweet text-gray'></i> Estado rendición";
        break;
    case 'numsiv':
        var mt="<i class='fa fa-slack text-gray'></i> SIVIA";
        break;
  }
  $(".m1_titulo").html(mt);
  $("#m1_modal").modal("show");

  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/fo_viaticos.php",
    data: {acc: acc, v1: v1, v2: v2},
    dataType: "html",
    beforeSend: function () {
      $("#f1_viaticos").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b1_guardar").addClass("hidden");
    },
    success:function(a){
      $("#f1_viaticos").html(a);
      if(acc.substr(0, 3)!="ver"){
        $("#b1_guardar").removeClass("hidden");
      }
    }
  });
}

$('#f1_viaticos').submit(function(e){
  e.preventDefault();
  var datos = $("#f1_viaticos").serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/gu_viaticos.php",
    data: datos,
    dataType: "json",
    beforeSend: function () {
      $("#d1_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b1_guardar").addClass("hidden");
    },
    success:function(a){
      if(a.e){
        $("#f1_viaticos").html(a.m);
        $("#b1_guardar").addClass("hidden");
        if(datos[0].value=="tipane" || datos[0].value=="agrcon" || datos[0].value=="edicon" || datos[0].value=="elicon" || datos[0].value=="numsiv"){
          fo_viaticos('verpla', datos[1].value, 0);
        }
        if(datos[0].value=="estren"){
          var mav=$("#mav").val();
          lviaticos(mav);
          fo_viaticos('vercom', datos[1].value, 0);
        }
      }else{
        $("#d1_frespuesta").html(a.m);
        $("#b1_guardar").removeClass("hidden");
      }
    }
  });
})

function l_planillav(v1){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/li_planillav.php",
    data: {v1: v1},
    dataType: "html",
    beforeSend: function () {
      $("#f_viaticos").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
    },
    success:function(a){
      $("#f_viaticos").html(a);
    }
  });
}