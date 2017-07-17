function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function getActualFullDate() {
    var d = new Date();
    var day = addZero(d.getDate());
    var month = addZero(d.getMonth()+1);
    var year = addZero(d.getFullYear());
    var h = addZero(d.getHours());
    var m = addZero(d.getMinutes());
    var s = addZero(d.getSeconds());
    return day + ". " + month + ". " + year + " (" + h + ":" + m + ")";
}
function getActualHour() {
    var d = new Date();
    var h = addZero(d.getHours());
    var m = addZero(d.getMinutes());
    var s = addZero(d.getSeconds());
    return h + ":" + m + ":" + s;
}

function restardias(dias) {
    var d = new Date();
    d.setDate(d.getDate() + dias);
    var day = addZero(d.getDate());
    var month = addZero(d.getMonth()+1);
    var year = addZero(d.getFullYear());
    return day + "/" + month + "/" + year;
}
function fechaactual() {
    var d = new Date();
    var day = addZero(d.getDate());
    var month = addZero(d.getMonth()+1);
    var year = addZero(d.getFullYear());
    return day + "/" + month + "/" + year;
}


$("#b_fnoticia").click(function(){
  $.ajax({
    type:"post",
    url:"m_inclusiones/a_intranet/fnnoticia.php",
    beforeSend: function () {
      $("#d_nnoticia").html("<p class='text-center'><img scr='m_images/loader.gif'></p>");
    },
    success:function(a){
      $("#d_nnoticia").html(a);
      $("#b_gnnoticia").show();
    }
  });
});
//funcion validar formulario noticia
$( "#f_nnoticia" ).validate( {
    rules: {
      fec: {required:true, datePE:true},
      tit: {required:true, minlength:5}
    },
    messages: {
      fec: {required:"Ingrese una fecha"},
      tit: {required:"Ingrese la descripción"}
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
      var datos = $("#f_nnoticia").serializeArray();
      var con = $('#summernote').summernote('code');
      datos.push({name: "con", value: con});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/nnoticia.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gnnoticia").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gnnoticia").addClass("disabled");
         },
         success: function(data){
            $("#b_gnnoticia").hide();
            $("#b_gnnoticia").html("Guardar");
            $("#b_gnnoticia").removeClass("disabled");
            $("#d_nnoticia").html(data);
            $("#d_nnoticia").slideDown();
         }
      });
    }
  } );
//funcion validar formulario noticia
//funcion cargar formulario editar noticia
function edinot(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fenoticia.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_enoticia").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_genoticia").hide();
            },
            success:  function (response) {
                    $("#d_enoticia").html(response);
                    $("#b_genoticia").show();
            }
    });
};
//fin funcion cargar formulario editar noticia

//funcion validar formulario editar noticia
$( "#f_enoticia" ).validate( {
    rules: {
      fec: {required:true, datePE:true},
      tit: {required:true, minlength:5}
    },
    messages: {
      fec: {required:"Ingrese una fecha"},
      tit: {required:"Ingrese el titular"}
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
      var datos = $("#f_enoticia").serializeArray();
      var con = $('#summernotee').summernote('code');
      datos.push({name: "con", value: con});
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/enoticia.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_genoticia").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_genoticia").addClass("disabled");
         },
         success: function(data){
            $("#b_genoticia").hide();
            $("#b_genoticia").html("Guardar");
            $("#b_genoticia").removeClass("disabled");
            $("#d_enoticia").html(data);
            $("#d_enoticia").slideDown();
         }
      });
    }
  } );
//funcion validar formulario editar noticia

//actualizar noticias
$('#m_nnoticia').on('hidden.bs.modal', function () {
    $.ajax({
            data:  {"fecha1" : restardias(-10), "fecha2" : fechaactual()},
            url:   'm_inclusiones/a_intranet/bnoticia.php',
            type:  'post',
            beforeSend: function () {
                    $(".d_noticia").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    console.log(restardias(-10));
                    console.log(fechaactual());
            },
            success:  function (response) {
                    $(".d_noticia").html(response);
            }
    });
});
$('#m_enoticia,#m_inoticia,#m_esnoticia').on('hidden.bs.modal', function () {
    var f1 = $("#fecha1").val();
    var f2 = $("#fecha2").val();
    if(f1=="" || f2==""){
      f1 = restardias(-10);
      f2 = fechaactual();
    }
    $.ajax({
            data:  {"fecha1" : f1, "fecha2" : f2},
            url:   'm_inclusiones/a_intranet/bnoticia.php',
            type:  'post',
            beforeSend: function () {
                    $(".d_noticia").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    console.log(f1);
                    console.log(f2);
            },
            success:  function (response) {
                    $(".d_noticia").html(response);
            }
    });
});
//fin actualizar noticias

//funcion validar formulario buscar noticias
$( "#f_bnoticia" ).validate( {
    rules: {
      fecha1: {required:true, datePE:true},
      fecha2: {required:true, datePE:true}
    },
    messages: {
      fecha1: {required:"Ingrese la fecha inicial"},
      fecha2: {required:"Ingrese la fecha final"}
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
      var datos = $("#f_bnoticia").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/bnoticia.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_bnoticia").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
            $("#b_bnoticia").addClass("disabled");
         },
         success: function(data){
            $("#b_bnoticia").html("Buscar");
            $("#b_bnoticia").removeClass("disabled");
            $(".d_noticia").html(data);
            $(".d_noticia").slideDown();
         }
      });
    }
  } );
//funcion validar formulario buscar noticias

//funcion cargar formulario imagen noticia
function imanot(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/finoticia.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_inoticia").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_ginoticia").hide();
            },
            success:  function (response) {
                    $("#d_inoticia").html(response);
                    $("#b_ginoticia").show();
            }
    });
};
//fin funcion cargar formulario imagen noticia

//funcion validar imagen noticia
$( "#f_inoticia" ).validate( {
    rules: {
      img:{required:true, accept: "jpg,jpeg,png"}
    },
    messages: {
      img:{required:"Seleccione una imagen.", accept: "Sólo imagenes png y jpg."}
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
      var formData = new FormData($("#f_inoticia")[0]);
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/ninoticia.php",
         dataType: "html",
         data: formData,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         contentType: false,
         processData: false,
         beforeSend: function () {
            $("#b_ginoticia").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_ginoticia").addClass("disabled");
         },
         success: function(data){
            $("#b_ginoticia").hide();
            $("#b_ginoticia").html("Guardar");
            $("#b_ginoticia").removeClass("disabled");
            $("#d_inoticia").html(data);
            $("#d_inoticia").slideDown();
         }
      });
    }
  } );
//fin funcion validar imagen noticia

//cargar formulario estado noticia
function estnot(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fesnoticia.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_esnoticia").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_siesnoticia").hide();
            },
            success:  function (response) {
                    $("#d_esnoticia").html(response);
                    $("#b_siesnoticia").show();
                    $("#b_noesnoticia").html("No");
            }
    });
};
//fin cargar formulario estado noticia
//cambiar estado noticia
$("#f_esnoticia").submit(function(e){
  e.preventDefault();
  var datos = $("#f_esnoticia").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/esnoticia.php",
        type:  "post",
        beforeSend: function () {
          $("#b_noesnoticia").hide();
          $("#b_siesnoticia").html("<i class='fa fa-spinner fa-spin'></i> Desactivando");
          $("#b_siesnoticia").addClass("disabled");
        },
        success:  function (response) {
          $("#b_siesnoticia").hide();
          $("#b_siesnoticia").html("Si");
          $("#b_siesnoticia").removeClass("disabled");
          $("#b_noesnoticia").html("Cerrar");
          $("#b_noesnoticia").show();
          $("#d_esnoticia").html(response);
        }
    });
});
//cambiar estado noticia


$("#b_fcomunicado").click(function(){
  $.ajax({
    type:"post",
    url:"m_inclusiones/a_intranet/fncomunicado.php",
    beforeSend: function () {
      $("#d_ncomunicado").html("<p class='text-center'><img scr='m_images/loader.gif'></p>");
    },
    success:function(a){
      $("#d_ncomunicado").html(a);
      $("#b_gncomunicado").show();
    }
  });
});
//fecha intranet
$('#fech1,#fech2,#fecha1,#fecha2').datepicker({
  format: "dd/mm/yyyy",
  language: "es",
  autoclose: true,
  todayHighlight: true
});
//fin fecha intranet
$('#dtcomunicado,#dtboletin,#dtcategoria').DataTable();
//funcion validar formulario comunicado
$( "#f_ncomunicado" ).validate( {
    rules: {
      fec: {required:true, datePE:true},
      des: {required:true, minlength:5},
      con: {required:true, minlength:5}
    },
    messages: {
      fec: {required:"Ingrese una fecha"},
      des: {required:"Ingrese la descripción"},
      con: {required:"Ingrese el contenido"}
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
      var datos = $("#f_ncomunicado").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/ncomunicado.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gncomunicado").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gncomunicado").addClass("disabled");
         },
         success: function(data){
            $("#b_gncomunicado").hide();
            $("#b_gncomunicado").html("Guardar");
            $("#b_gncomunicado").removeClass("disabled");
            $("#d_ncomunicado").html(data);
            $("#d_ncomunicado").slideDown();
         }
      });
    }
  } );
//funcion validar formulario comunicado
//actualizar comunicados
$('#m_ncomunicado,#m_ecomunicado,#m_acomunicado,#m_dcomunicado,#m_aadjunto,#m_qadjunto').on('hidden.bs.modal', function () {
    $.ajax({
            data:  {"fech1" : restardias(-10), "fech2" : fechaactual()},
            url:   'm_inclusiones/a_intranet/bcomunicado.php',
            type:  'post',
            beforeSend: function () {
                    $(".d_comunicado").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    console.log(fechaactual());
                    console.log(restardias(-10));
            },
            success:  function (response) {
                    $(".d_comunicado").html(response);
            }
    });
});
//fin actualizar comunicados
//funcion cargar formulario adjuntar editar comunicado
function edicom(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fecomunicado.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_ecomunicado").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_gecomunicado").hide();
            },
            success:  function (response) {
                    $("#d_ecomunicado").html(response);
                    $("#b_gecomunicado").show();
            }
    });
};
//fin funcion cargar formulario adjuntar editar comunicado

//funcion validar formulario comunicado
$( "#f_ecomunicado" ).validate( {
    rules: {
      fec: {required:true, datePE:true},
      des: {required:true, minlength:5},
      con: {required:true, minlength:5}
    },
    messages: {
      fec: {required:"Ingrese una fecha"},
      des: {required:"Ingrese la descripción"},
      con: {required:"Ingrese el contenido"}
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
      var datos = $("#f_ecomunicado").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/ecomunicado.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gecomunicado").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gecomunicado").addClass("disabled");
         },
         success: function(data){
            $("#b_gecomunicado").hide();
            $("#b_gecomunicado").html("Guardar");
            $("#b_gecomunicado").removeClass("disabled");
            $("#d_ecomunicado").html(data);
            $("#d_ecomunicado").slideDown();
         }
      });
    }
  } );
//funcion validar formulario comunicado

//funcion cargar formulario adjuntar a comunicado
function agradj(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/faadjunto.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_aadjunto").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_gaadjunto").hide();
            },
            success:  function (response) {
                    $("#d_aadjunto").html(response);
                    $("#b_gaadjunto").show();
            }
    });
};
//fin funcion cargar formulario adjuntar a comunicado
//funcion validar formulario agregar adjunto
$( "#f_aadjunto" ).validate( {
    rules: {
      adj: {required:true}
    },
    messages: {
      adj: {required:"Agregue el archivo que desee adjuntar."},
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
      var formData = new FormData($("#f_aadjunto")[0]);
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/gaadjunto.php",
         dataType: "html",
         data: formData,
         contentType: false,
         processData: false,
         beforeSend: function () {
            $("#b_gaadjunto").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gaadjunto").addClass("disabled");
         },
         success: function(data){
            $("#b_gaadjunto").hide();
            $("#b_gaadjunto").html("Guardar");
            $("#b_gaadjunto").removeClass("disabled");
            $("#d_aadjunto").html(data);
            $("#d_aadjunto").slideDown();
         }
      });
    }
  } );
//funcion validar formulario agregar adjunto
//funcion cargar formulario quitar adjunto
function quiadj(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fqadjunto.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_qadjunto").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_siqadjunto").hide();
            },
            success:  function (response) {
                    $("#d_qadjunto").html(response);
                    $("#b_siqadjunto").show();
                    $("#b_noqadjunto").html("No");
            }
    });
};
//fin funcion cargar formulario quitar adjunto
//funcion quitar adjunto
$("#f_qadjunto").submit(function(e){
  e.preventDefault();
  var datos = $("#f_qadjunto").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/qadjunto.php",
        type:  "post",
        beforeSend: function () {
          $("#b_noqadjunto").hide();
          $("#b_siqadjunto").html("<i class='fa fa-spinner fa-spin'></i> Eliminando");
          $("#b_siqadjunto").addClass("disabled");
        },
        success:  function (response) {
          $("#b_siqadjunto").hide();
          $("#b_siqadjunto").html("Si");
          $("#b_siqadjunto").removeClass("disabled");
          $("#b_noqadjunto").html("Cerrar");
          $("#b_noqadjunto").show();
          $("#d_qadjunto").html(response);
        }
    });
});
//funcion quitar adjunto
//funcion cargar formulario desactivar comunicado
function descom(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fdcomunicado.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_dcomunicado").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_sidcomunicado").hide();
            },
            success:  function (response) {
                    $("#d_dcomunicado").html(response);
                    $("#b_sidcomunicado").show();
                    $("#b_nodcomunicado").html("No");
            }
    });
};
//fin funcion cargar formulario desactivar comunicado
//funcion desactivar comunicado
$("#f_dcomunicado").submit(function(e){
  e.preventDefault();
  var datos = $("#f_dcomunicado").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/dcomunicado.php",
        type:  "post",
        beforeSend: function () {
          $("#b_nodcomunicado").hide();
          $("#b_sidcomunicado").html("<i class='fa fa-spinner fa-spin'></i> Desactivando");
          $("#b_sidcomunicado").addClass("disabled");
        },
        success:  function (response) {
          $("#b_sidcomunicado").hide();
          $("#b_sidcomunicado").html("Si");
          $("#b_sidcomunicado").removeClass("disabled");
          $("#b_nodcomunicado").html("Cerrar");
          $("#b_nodcomunicado").show();
          $("#d_dcomunicado").html(response);
        }
    });
});
//funcion desactivar comunicado
//funcion cargar formulario desactivar comunicado
function actcom(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/facomunicado.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_acomunicado").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_siacomunicado").hide();
            },
            success:  function (response) {
                    $("#d_acomunicado").html(response);
                    $("#b_siacomunicado").show();
                    $("#b_noacomunicado").html("No");
            }
    });
};
//fin funcion cargar formulario desactivar comunicado
//funcion activar comunicado
$("#f_acomunicado").submit(function(e){
  e.preventDefault();
  var datos = $("#f_acomunicado").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/acomunicado.php",
        type:  "post",
        beforeSend: function () {
          $("#b_noacomunicado").hide();
          $("#b_siacomunicado").html("<i class='fa fa-spinner fa-spin'></i> Desactivando");
          $("#b_siacomunicado").addClass("disabled");
        },
        success:  function (response) {
          $("#b_siacomunicado").hide();
          $("#b_siacomunicado").html("Si");
          $("#b_siacomunicado").removeClass("disabled");
          $("#b_noacomunicado").html("Cerrar");
          $("#b_noacomunicado").show();
          $("#d_acomunicado").html(response);
        }
    });
});
//funcion activar comunicado
//funcion validar formulario buscar comunicado
$( "#f_bcomunicado" ).validate( {
    rules: {
      fech1: {required:true, datePE:true},
      fech2: {required:true, datePE:true}
    },
    messages: {
      fech1: {required:"Ingrese la fecha inicial"},
      fech2: {required:"Ingrese la fecha final"}
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
      var datos = $("#f_bcomunicado").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/bcomunicado.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_bcomunicado").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
            $("#b_bcomunicado").addClass("disabled");
         },
         success: function(data){
            $("#b_bcomunicado").html("Buscar");
            $("#b_bcomunicado").removeClass("disabled");
            $(".d_comunicado").html(data);
            $(".d_comunicado").slideDown();
         }
      });
    }
  } );
//funcion validar formulario buscar comunicado
function vcomunicado(id){
$.ajax({
  type: "post",
  url: "m_inclusiones/a_intranet/vcomunicado.php",
  data: { idc : id },
  beforeSend: function () {
    $(".d_rcomunicado").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
  },
  success:function(a){
    $(".d_rcomunicado").html(a);
  }
});
}

//funcion validar formulario buscar boletin
$( "#f_bboletin" ).validate( {
    rules: {
      ano: {required:true}
    },
    messages: {
      ano: {required:"Elija un año"}
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
      var datos = $("#f_bboletin").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/bboletin.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_bboletin").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
            $("#b_bboletin").addClass("disabled");
         },
         success: function(data){
            $("#b_bboletin").html("Buscar");
            $("#b_bboletin").removeClass("disabled");
            $(".d_boletin").html(data);
            $(".d_boletin").slideDown();
         }
      });
    }
  } );
//funcion validar formulario buscar boletin
//funcion validar formulario boletin
$( "#f_nboletin" ).validate( {
    rules: {
      des: {required:true, minlength:5},
      fecb: {required:true, datePE:true},
      bol: {required:true, accept:"pdf"}
    },
    messages: {
      des: {required:"Ingrese la descripción del boletín"},
      bol: {required:"Seleccione un boletín", accept: "Sólo archivos pdf"}
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
      var formData = new FormData($("#f_nboletin")[0]);
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/nboletin.php",
         dataType: "html",
         data: formData,
         contentType: false,
         processData: false,
         beforeSend: function () {
            $("#b_gnboletin").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gnboletin").addClass("disabled");
         },
         success: function(data){
            $("#b_gnboletin").hide();
            $("#b_gnboletin").html("Guardar");
            $("#b_gnboletin").removeClass("disabled");
            $("#d_nboletin").html(data);
            $("#d_nboletin").slideDown();
         }
      });
    }
  } );
//funcion validar formulario boletin
//cargar formulario nuevo boletin
$("#b_fboletin").click(function(){
  $.ajax({
    type:"post",
    url:"m_inclusiones/a_intranet/fnboletin.php",
    beforeSend: function () {
      $("#d_nboletin").html("<p class='text-center'><img scr='m_images/loader.gif'></p>");
    },
    success:function(a){
      $("#d_nboletin").html(a);
      $("#b_gnboletin").show();
    }
  });
});
//fin cargar formulario nuevo boletin
//funcion cargar formulario editar boletín
function edibol(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/feboletin.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_eboletin").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_geboletin").hide();
            },
            success:  function (response) {
                    $("#d_eboletin").html(response);
                    $("#b_geboletin").show();
            }
    });
};
//fin funcion cargar formulario editar boletín
//funcion validar formulario editar boletin
$( "#f_eboletin" ).validate( {
    rules: {
      des: {required:true, minlength:5},
      fecb: {required:true, datePE:true},
    },
    messages: {
      des: {required:"Ingrese la descripción del boletín"},
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
      var datos = $("#f_eboletin").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/eboletin.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_geboletin").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_geboletin").addClass("disabled");
         },
         success: function(data){
            $("#b_geboletin").hide();
            $("#b_geboletin").html("Guardar");
            $("#b_geboletin").removeClass("disabled");
            $("#d_eboletin").html(data);
            $("#d_eboletin").slideDown();
         }
      });
    }
  } );
//funcion validar formulario editar boletin
//funcion validar cambiar boletin
$( "#f_cboletin" ).validate( {
    rules: {
      bol: {required:true, accept:"pdf"}
    },
    messages: {
      bol: {required:"Seleccione un boletín", accept: "Sólo archivos pdf"}
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
      var formData = new FormData($("#f_cboletin")[0]);
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/cboletin.php",
         dataType: "html",
         data: formData,
         contentType: false,
         processData: false,
         beforeSend: function () {
            $("#b_gcboletin").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gcboletin").addClass("disabled");
         },
         success: function(data){
            $("#b_gcboletin").hide();
            $("#b_gcboletin").html("Guardar");
            $("#b_gcboletin").removeClass("disabled");
            $("#d_cboletin").html(data);
            $("#d_cboletin").slideDown();
         }
      });
    }
  } );
//funcion validar cambiar boletin

//funcion cargar formulario adjuntar editar boletin
function cambol(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fcboletin.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_cboletin").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_gcboletin").hide();
            },
            success:  function (response) {
                    $("#d_cboletin").html(response);
                    $("#b_gcboletin").show();
            }
    });
};
//fin funcion cargar formulario adjuntar editar boletin
//funcion cargar formulario desactivar boletin
function desbol(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fdboletin.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_dboletin").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_sidboletin").hide();
            },
            success:  function (response) {
                    $("#d_dboletin").html(response);
                    $("#b_sidboletin").show();
                    $("#b_nodboletin").html("No");
            }
    });
};
//fin funcion cargar formulario desactivar boletin
//funcion desactivar boletin
$("#f_dboletin").submit(function(e){
  e.preventDefault();
  var datos = $("#f_dboletin").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/dboletin.php",
        type:  "post",
        beforeSend: function () {
          $("#b_nodboletin").hide();
          $("#b_sidboletin").html("<i class='fa fa-spinner fa-spin'></i> Desactivando");
          $("#b_sidboletin").addClass("disabled");
        },
        success:  function (response) {
          $("#b_sidboletin").hide();
          $("#b_sidboletin").html("Si");
          $("#b_sidboletin").removeClass("disabled");
          $("#b_nodboletin").html("Cerrar");
          $("#b_nodboletin").show();
          $("#d_dboletin").html(response);
        }
    });
});
//funcion desactivar boletin
//funcion cargar formulario activar boletin
function actbol(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/faboletin.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_aboletin").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_siaboletin").hide();
            },
            success:  function (response) {
                    $("#d_aboletin").html(response);
                    $("#b_siaboletin").show();
                    $("#b_noaboletin").html("No");
            }
    });
};
//fin funcion cargar formulario activar boletin
//funcion activar boletin
$("#f_aboletin").submit(function(e){
  e.preventDefault();
  var datos = $("#f_aboletin").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/aboletin.php",
        type:  "post",
        beforeSend: function () {
          $("#b_noaboletin").hide();
          $("#b_siaboletin").html("<i class='fa fa-spinner fa-spin'></i> activando");
          $("#b_siaboletin").addClass("disabled");
        },
        success:  function (response) {
          $("#b_siaboletin").hide();
          $("#b_siaboletin").html("Si");
          $("#b_siaboletin").removeClass("disabled");
          $("#b_noaboletin").html("Cerrar");
          $("#b_noaboletin").show();
          $("#d_aboletin").html(response);
        }
    });
});
//funcion activar boletin

//actualizar comunicados
$('#m_nboletin,#m_cboletin,#m_aboletin,#m_dboletin,#m_eboletin').on('hidden.bs.modal', function () {
    var d = new Date();
    var year = d.getFullYear();
    $.ajax({
            data:  {"ano" : year},
            url:   'm_inclusiones/a_intranet/bboletin.php',
            type:  'post',
            beforeSend: function () {
                    $(".d_boletin").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
            },
            success:  function (response) {
                    $(".d_boletin").html(response);
            }
    });
});
//fin actualizar comunicados

//cargar formulario nueva catagoría documento
$("#b_fcategoria").click(function(){
  $.ajax({
    type:"post",
    url:"m_inclusiones/a_intranet/fncategoria.php",
    beforeSend: function () {
      $("#d_ncategoria").html("<p class='text-center'><img scr='m_images/loader.gif'></p>");
    },
    success:function(a){
      $("#d_ncategoria").html(a);
      $("#b_gncategoria").show();
    }
  });
});
//fin cargar formulario nueva catagoría documento

//funcion validar formulario nueva categoría
$( "#f_ncategoria" ).validate( {
    rules: {
      cat: {required:true, minlength:5}
    },
    messages: {
      cat: {required:"Ingrese la categoría"}
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
      var datos = $("#f_ncategoria").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/ncategoria.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gncategoria").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gncategoria").addClass("disabled");
         },
         success: function(data){
            $("#b_gncategoria").hide();
            $("#b_gncategoria").html("Guardar");
            $("#b_gncategoria").removeClass("disabled");
            $("#d_ncategoria").html(data);
            $("#d_ncategoria").slideDown();
         }
      });
    }
  } );
//funcion validar formulario nueva categoría

//funcion cargar formulario adjuntar editar boletin
function edicat(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fecategoria.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_ecategoria").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_gecategoria").hide();
            },
            success:  function (response) {
                    $("#d_ecategoria").html(response);
                    $("#b_gecategoria").show();
            }
    });
};
//fin funcion cargar formulario adjuntar editar boletin

//funcion validar formulario nueva categoría
$( "#f_ecategoria" ).validate( {
    rules: {
      cat: {required:true, minlength:5}
    },
    messages: {
      cat: {required:"Ingrese la categoría"}
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
      var datos = $("#f_ecategoria").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/ecategoria.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gecategoria").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gecategoria").addClass("disabled");
         },
         success: function(data){
            $("#b_gecategoria").hide();
            $("#b_gecategoria").html("Guardar");
            $("#b_gecategoria").removeClass("disabled");
            $("#d_ecategoria").html(data);
            $("#d_ecategoria").slideDown();
         }
      });
    }
  } );
//funcion validar formulario nueva categoría

//funcion cargar formulario desactivar boletin
function descat(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fdcategoria.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_dcategoria").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_sidcategoria").hide();
            },
            success:  function (response) {
                    $("#d_dcategoria").html(response);
                    $("#b_sidcategoria").show();
                    $("#b_nodcategoria").html("No");
            }
    });
};
//fin funcion cargar formulario desactivar boletin
//funcion desactivar boletin
$("#f_dcategoria").submit(function(e){
  e.preventDefault();
  var datos = $("#f_dcategoria").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/dcategoria.php",
        type:  "post",
        beforeSend: function () {
          $("#b_nodcategoria").hide();
          $("#b_sidcategoria").html("<i class='fa fa-spinner fa-spin'></i> Desactivando");
          $("#b_sidcategoria").addClass("disabled");
        },
        success:  function (response) {
          $("#b_sidcategoria").hide();
          $("#b_sidcategoria").html("Si");
          $("#b_sidcategoria").removeClass("disabled");
          $("#b_nodcategoria").html("Cerrar");
          $("#b_nodcategoria").show();
          $("#d_dcategoria").html(response);
        }
    });
});
//funcion desactivar boletin

//funcion cargar formulario activar boletin
function actcat(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/facategoria.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_acategoria").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_siacategoria").hide();
            },
            success:  function (response) {
                    $("#d_acategoria").html(response);
                    $("#b_siacategoria").show();
                    $("#b_noacategoria").html("No");
            }
    });
};
//fin funcion cargar formulario activar boletin
//funcion activar boletin
$("#f_acategoria").submit(function(e){
  e.preventDefault();
  var datos = $("#f_acategoria").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/acategoria.php",
        type:  "post",
        beforeSend: function () {
          $("#b_noacategoria").hide();
          $("#b_siacategoria").html("<i class='fa fa-spinner fa-spin'></i> Desactivando");
          $("#b_siacategoria").addClass("disabled");
        },
        success:  function (response) {
          $("#b_siacategoria").hide();
          $("#b_siacategoria").html("Si");
          $("#b_siacategoria").removeClass("disabled");
          $("#b_noacategoria").html("Cerrar");
          $("#b_noacategoria").show();
          $("#d_acategoria").html(response);
        }
    });
});
//funcion activar boletin

//actualizar categorias
$('#m_ncategoria,#m_ecategoria,#m_acategoria,#m_dcategoria').on('hidden.bs.modal', function () {
    $.ajax({
            url:   'm_inclusiones/a_intranet/bcategoria.php',
            type:  'post',
            beforeSend: function () {
                    $(".d_categoria").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
            },
            success:  function (response) {
                    $(".d_categoria").html(response);
            }
    });
});
//fin actualizar categorias

//cargar formulario nueva catagoría documento
$("#b_fdocumento").click(function(){
  $.ajax({
    type:"post",
    url:"m_inclusiones/a_intranet/fndocumento.php",
    beforeSend: function () {
      $("#d_ndocumento").html("<p class='text-center'><img scr='m_images/loader.gif'></p>");
    },
    success:function(a){
      $("#d_ndocumento").html(a);
      $("#b_gndocumento").show();
    }
  });
});
//fin cargar formulario nueva catagoría documento
//funcion validar nuevo documento
$( "#f_ndocumento" ).validate( {
    rules: {
      des: {required:true, minlength:5},
      cat: {required:true},
      doc: {required:true}
    },
    messages: {
      des: {required:"Ingrese la descripción."},
      cat: {required:"Elija una categoría."},
      doc: {required:"Seleccione un documento."}
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
      var formData = new FormData($("#f_ndocumento")[0]);
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/ndocumento.php",
         dataType: "html",
         data: formData,
         contentType: false,
         processData: false,
         beforeSend: function () {
            $("#b_gndocumento").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gndocumento").addClass("disabled");
         },
         success: function(data){
            $("#b_gndocumento").hide();
            $("#b_gndocumento").html("Guardar");
            $("#b_gndocumento").removeClass("disabled");
            $("#d_ndocumento").html(data);
            $("#d_ndocumento").slideDown();
         }
      });
    }
  } );
//funcion validar nuevo documento

//funcion validar formulario buscar boletin
$( "#f_bdocumento" ).validate( {
    rules: {
      cat: {required:true}
    },
    messages: {
      cat: {required:"Elija una categoria"}
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
      var datos = $("#f_bdocumento").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/bdocumento.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_bdocumento").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
            $("#b_bdocumento").addClass("disabled");
         },
         success: function(data){
            $("#b_bdocumento").html("Buscar");
            $("#b_bdocumento").removeClass("disabled");
            $(".d_documento").html(data);
            $(".d_documento").slideDown();
         }
      });
    }
  } );
//funcion validar formulario buscar boletin
//funcion cargar formulario editar documento
function edidoc(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fedocumento.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_edocumento").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_gedocumento").hide();
            },
            success:  function (response) {
                    $("#d_edocumento").html(response);
                    $("#b_gedocumento").show();
            }
    });
};
//fin funcion cargar formulario editar documento
//funcion validar editar documento
$( "#f_edocumento" ).validate( {
    rules: {
      des: {required:true, minlength:5},
      cat: {required:true},
    },
    messages: {
      des: {required:"Ingrese la descripción."},
      cat: {required:"Elija una categoría."},
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
      var datos = $("#f_edocumento").serializeArray();
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/edocumento.php",
         dataType: "html",
         data: datos,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         beforeSend: function () {
            $("#b_gedocumento").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gedocumento").addClass("disabled");
         },
         success: function(data){
            $("#b_gedocumento").hide();
            $("#b_gedocumento").html("Guardar");
            $("#b_gedocumento").removeClass("disabled");
            $("#d_edocumento").html(data);
            $("#d_edocumento").slideDown();
         }
      });
    }
  } );
//funcion validar editar documento
//funcion cargar formulario cambiar documento
function camdoc(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fcdocumento.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_cdocumento").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_gcdocumento").hide();
            },
            success:  function (response) {
                    $("#d_cdocumento").html(response);
                    $("#b_gcdocumento").show();
            }
    });
};
//fin funcion cargar formulario cambiar documento
//funcion validar nuevo documento
$( "#f_cdocumento" ).validate( {
    rules: {
      doc: {required:true}
    },
    messages: {
      doc: {required:"Seleccione un documento."}
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
      var formData = new FormData($("#f_cdocumento")[0]);
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/cdocumento.php",
         dataType: "html",
         data: formData,
         contentType: false,
         processData: false,
         beforeSend: function () {
            $("#b_gcdocumento").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gcdocumento").addClass("disabled");
         },
         success: function(data){
            $("#b_gcdocumento").hide();
            $("#b_gcdocumento").html("Guardar");
            $("#b_gcdocumento").removeClass("disabled");
            $("#d_cdocumento").html(data);
            $("#d_cdocumento").slideDown();
         }
      });
    }
  } );
//funcion validar nuevo documento
//funcion cargar formulario desactivar boletin
function desdoc(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fddocumento.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_ddocumento").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_siddocumento").hide();
            },
            success:  function (response) {
                    $("#d_ddocumento").html(response);
                    $("#b_siddocumento").show();
                    $("#b_noddocumento").html("No");
            }
    });
};
//fin funcion cargar formulario desactivar boletin
//funcion desactivar boletin
$("#f_ddocumento").submit(function(e){
  e.preventDefault();
  var datos = $("#f_ddocumento").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/ddocumento.php",
        type:  "post",
        beforeSend: function () {
          $("#b_noddocumento").hide();
          $("#b_siddocumento").html("<i class='fa fa-spinner fa-spin'></i> Desactivando");
          $("#b_siddocumento").addClass("disabled");
        },
        success:  function (response) {
          $("#b_siddocumento").hide();
          $("#b_siddocumento").html("Si");
          $("#b_siddocumento").removeClass("disabled");
          $("#b_noddocumento").html("Cerrar");
          $("#b_noddocumento").show();
          $("#d_ddocumento").html(response);
        }
    });
});
//funcion desactivar boletin
//funcion cargar formulario desactivar boletin
function actdoc(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fadocumento.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_adocumento").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_siadocumento").hide();
            },
            success:  function (response) {
                    $("#d_adocumento").html(response);
                    $("#b_siadocumento").show();
                    $("#b_noadocumento").html("No");
            }
    });
};
//fin funcion cargar formulario desactivar boletin
//funcion desactivar boletin
$("#f_adocumento").submit(function(e){
  e.preventDefault();
  var datos = $("#f_adocumento").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/adocumento.php",
        type:  "post",
        beforeSend: function () {
          $("#b_noadocumento").hide();
          $("#b_siadocumento").html("<i class='fa fa-spinner fa-spin'></i> Activando");
          $("#b_siadocumento").addClass("disabled");
        },
        success:  function (response) {
          $("#b_siadocumento").hide();
          $("#b_siadocumento").html("Si");
          $("#b_siadocumento").removeClass("disabled");
          $("#b_noadocumento").html("Cerrar");
          $("#b_noadocumento").show();
          $("#d_adocumento").html(response);
        }
    });
});
//funcion desactivar boletin
//cargar formulario nueva imagen
$("#b_fimagen").click(function(){
  $.ajax({
    type:"post",
    url:"m_inclusiones/a_intranet/fnimagen.php",
    beforeSend: function () {
      $("#d_nimagen").html("<p class='text-center'><img scr='m_images/loader.gif'></p>");
    },
    success:function(a){
      $("#d_nimagen").html(a);
      $("#b_gnimagen").show();
    }
  });
});
//fin cargar formulario nueva imagen
//funcion validar imagenes carousel principal
$( "#f_nimagen" ).validate( {
    rules: {
      img:{required:true, accept: "jpg,jpeg,png"}
    },
    messages: {
      img:{required:"Seleccione una imagen.", accept: "Sólo imagenes png y jpg."}
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
      var formData = new FormData($("#f_nimagen")[0]);
      $.ajax({
         type: "POST",
         url: "m_inclusiones/a_intranet/nimagen.php",
         dataType: "html",
         data: formData,   // I WANT TO ADD EXTRA DATA + SERIALIZE DATA
         contentType: false,
         processData: false,
         beforeSend: function () {
            $("#b_gnimagen").html("<i class='fa fa-spinner fa-spin'></i> Guardando");
            $("#b_gnimagen").addClass("disabled");
         },
         success: function(data){
            $("#b_gnimagen").hide();
            $("#b_gnimagen").html("Guardar");
            $("#b_gnimagen").removeClass("disabled");
            $("#d_nimagen").html(data);
            $("#d_nimagen").slideDown();
         }
      });
    }
  } );
//fin funcion validar imagenes carousel principal
//funcion cargar formulario eliminar imagen
function eliimg(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/feimagen.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_eimagen").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_sieimagen").hide();
            },
            success:  function (response) {
                    $("#d_eimagen").html(response);
                    $("#b_sieimagen").show();
                    $("#b_noeimagen").html("No");
            }
    });
};
//fin funcion cargar formulario eliminar imagen
//funcion eliminar imagen
$("#f_eimagen").submit(function(e){
  e.preventDefault();
  var datos = $("#f_eimagen").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/eimagen.php",
        type:  "post",
        beforeSend: function () {
          $("#b_noeimagen").hide();
          $("#b_sieimagen").html("<i class='fa fa-spinner fa-spin'></i> Eliminando");
          $("#b_sieimagen").addClass("disabled");
        },
        success:  function (response) {
          $("#b_sieimagen").hide();
          $("#b_sieimagen").html("Si");
          $("#b_sieimagen").removeClass("disabled");
          $("#b_noeimagen").html("Cerrar");
          $("#b_noeimagen").show();
          $("#d_eimagen").html(response);
        }
    });
});
//funcion eliminar imagen
//funcion cargar formulario desactivar imagen
function desimg(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/fdimagen.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_dimagen").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_sidimagen").hide();
            },
            success:  function (response) {
                    $("#d_dimagen").html(response);
                    $("#b_sidimagen").show();
                    $("#b_nodimagen").html("No");
            }
    });
};
//fin funcion cargar formulario desactivar imagen
//funcion desactivar imagen
$("#f_dimagen").submit(function(e){
  e.preventDefault();
  var datos = $("#f_dimagen").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/dimagen.php",
        type:  "post",
        beforeSend: function () {
          $("#b_nodimagen").hide();
          $("#b_sidimagen").html("<i class='fa fa-spinner fa-spin'></i> Desactivando");
          $("#b_sidimagen").addClass("disabled");
        },
        success:  function (response) {
          $("#b_sidimagen").hide();
          $("#b_sidimagen").html("Si");
          $("#b_sidimagen").removeClass("disabled");
          $("#b_nodimagen").html("Cerrar");
          $("#b_nodimagen").show();
          $("#d_dimagen").html(response);
        }
    });
});
//funcion desactivar imagen
//funcion cargar formulario activar imagen
function actimg(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/faimagen.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_aimagen").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
                    $("#b_siaimagen").hide();
            },
            success:  function (response) {
                    $("#d_aimagen").html(response);
                    $("#b_siaimagen").show();
                    $("#b_noaimagen").html("No");
            }
    });
};
//fin funcion cargar formulario activar imagen
//funcion activar imagen
$("#f_aimagen").submit(function(e){
  e.preventDefault();
  var datos = $("#f_aimagen").serializeArray();
  $.ajax({
        data:  datos,
        url:   "m_inclusiones/a_intranet/aimagen.php",
        type:  "post",
        beforeSend: function () {
          $("#b_noaimagen").hide();
          $("#b_siaimagen").html("<i class='fa fa-spinner fa-spin'></i> Activando");
          $("#b_siaimagen").addClass("disabled");
        },
        success:  function (response) {
          $("#b_siaimagen").hide();
          $("#b_siaimagen").html("Si");
          $("#b_siaimagen").removeClass("disabled");
          $("#b_noaimagen").html("Cerrar");
          $("#b_noaimagen").show();
          $("#d_aimagen").html(response);
        }
    });
});
//funcion activar imagen
//funcion cargar formulario activar imagen
function verimg(id){
    var parametros = {
            "id" : id
    };
    $.ajax({
            data:  parametros,
            url:   'm_inclusiones/a_intranet/vimagen.php',
            type:  'post',
            beforeSend: function () {
                    $("#d_vimagen").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
            },
            success:  function (response) {
                    $("#d_vimagen").html(response);
            }
    });
};
//fin funcion cargar formulario activar imagen
//actualizar categorias
$('#m_nimagen,#m_eimagen,#m_aimagen,#m_dimagen').on('hidden.bs.modal', function () {
    $.ajax({
            url:   'm_inclusiones/a_intranet/bimagen.php',
            type:  'post',
            beforeSend: function () {
                    $(".d_imagen").html("<p class='text-center'><img src='m_images/loader.gif'/></p>");
            },
            success:  function (response) {
                    $(".d_imagen").html(response);
            }
    });
});
//fin actualizar categorias