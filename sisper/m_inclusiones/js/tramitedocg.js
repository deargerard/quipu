//bandeja

$("#smpar").select2({
  placeholder: 'Selecione una Mesa de Partes',
  ajax: {
    url: 'm_inclusiones/a_general/a_selmpartes.php',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
      return {
        results: data
      };
    },
    cache: true
  },
  minimumInputLength: 2
})

$('#b_lim3').click(function() {
  $('#smpar').select2('val', '');
});
$('#b_lim4').click(function() {
  $('#sper').select2('val', '');
});
$('#b_lim9').click(function() {
  $('#sper1').select2('val', '');
});

$("#sper, #sper1").select2({
  placeholder: 'Selecione un Personal',
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
  minimumInputLength: 2
})



function li_ban1(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_ban1.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban1").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban1").html(a);
      }
    });
}
function li_ban2(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_ban2.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban2").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban2").html(a);
      }
    });
}
function li_ban3(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_ban3.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban3").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban3").html(a);
      }
    });
}
function li_ban4(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_ban4.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban4").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban4").html(a);
      }
    });
}
function li_ban5(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_ban5.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban5").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban5").html(a);
      }
    });
}
function li_ban6(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_ban6.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban6").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban6").html(a);
      }
    });
}
function li_ban7(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_ban7.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban7").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban7").html(a);
      }
    });
}
function li_ban8(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_ban8.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban8").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban8").html(a);
      }
    });
}
function li_ban9(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_ban9.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban9").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban9").html(a);
      }
    });
}
function f_bandeja(acc,v1,v2){
    $("#m_tamano").removeClass('modal-lg');
    switch(acc) {
        case 'agrdoc':
          var mt="<span class='text-muted'><i class='fa fa-file-text-o text-yellow'></i> Agregar Documento</span>";
          $(".modal-dialog").addClass('modal-lg');
          break;
        case 'edidoc':
          var mt="<span class='text-muted'><i class='fa fa-pencil text-yellow'></i> Editar Documento</span>";
          $(".modal-dialog").addClass('modal-lg');
          break;
        case 'elidoc':
          var mt="<span class='text-muted'><i class='fa fa-trash text-yellow'></i> Eliminar Documento</span>";
          break;
        case 'detdoc':
          var mt="<span class='text-muted'><i class='fa fa-file-text text-yellow'></i> Detalle Documento</span>";
          $(".modal-dialog").addClass('modal-lg');
          break;
        case 'revdoc':
          var mt="<span class='text-muted'><i class='fa fa-reply text-yellow'></i> Revertir Documento</span>";
          break;
        case 'rutdoc':
          var mt="<span class='text-muted'><i class='fa fa-retweet text-yellow'></i> Seguimiento Documento</span>";
          $(".modal-dialog").addClass('modal-lg');
          break;
        case 'detest':
          var mt="<span class='text-muted'><i class='fa fa-tags text-yellow'></i> Detalle Estado</span>";
          break;
        case 'repdoc':
          var mt="<span class='text-muted'><i class='fa fa-motorcycle text-yellow'></i> Reportar Notificación</span>";
          break;
        case 'atedoc':
          var mt="<span class='text-muted'><i class='fa fa-laptop text-yellow'></i> Atender Documento</span>";
          break;
        case 'arcdoc':
          var mt="<span class='text-muted'><i class='fa fa-folder-open text-yellow'></i> Archivar Documento</span>";
          break;
        case 'gengui':
          var mt="<span class='text-muted'><i class='fa fa-stack-overflow text-yellow'></i> Generar Guía</span>";
          $(".modal-dialog").addClass('modal-lg');
          break;
        case 'lisgui':
          var mt="<span class='text-muted'><i class='fa fa-stack-overflow text-yellow'></i> Listar Guía</span>";
          $(".modal-dialog").addClass('modal-lg');
          break;
        case 'dermpp':
          var mt="<span class='text-muted'><i class='fa fa-share text-yellow'></i> Derivar a Mesa de Partes con Proveído</span>";
          break;
        case 'cammp':
          var mt="<span class='text-muted'><i class='fa fa-random text-yellow'></i> Cambiar MP</span>";
          break;
        case 'gencar':
          var mt="<span class='text-muted'><i class='fa fa-files-o text-yellow'></i> Generar Cargo</span>";
          break;
    }
    $(".modal-title").html(mt);
    $("#m_modal").modal("show");
  
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/f_bandeja.php",
      data: {acc: acc, v1: v1, v2: v2},
      dataType: "html",
      beforeSend: function () {
        $("#f_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
        $("#b_guardar").addClass("hidden");
      },
      success:function(a){
        $("#f_modal").html(a);
        if(acc!='detdoc' && acc!='rutdoc' && acc!='detest' && acc!='lisgui' && acc!='gencar'){
          $("#b_guardar").removeClass("hidden");
        }
      }
    });
}

$('#f_modal').submit(function(e){
  e.preventDefault();
  var datos = $(this).serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
    data: datos,
    dataType: "json",
    beforeSend: function(){
      $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      if(a.e){
        $("#f_modal").html(a.m);
        li_ban2();
        li_ban5();
        li_ban6();
        li_ban9();
      }else{
        $("#d_frespuesta").html(a.m);
        $("#b_guardar").removeClass("hidden");
      }
    }
  });
})

function g_crecar(idd){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
    data: {acc: 'crecar', v1: idd, v2: 0},
    dataType: "json",
    beforeSend: function(){
      $("#b_crecar").button('loading');
    },
    success:function(a){
      if(a.e){
        $("#f_modal").html(a.m);
        li_ban2();
      }else{
        $("#d_rcc").html(a.m);
        $("#b_crecar").button('reset');
      }
    }
  });
}


/*function g_rec(v1, v2, mp){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
      data: {acc: 'recdoc', v1: v1, v2: v2, mp: mp},
      dataType: "json",
      success:function(a){
        if(a.e){
          alertify.success(a.m);
          li_ban1();
          li_ban2();
          li_ban3();
          li_ban4();
          li_ban5();
          li_ban6();
          li_ban7();
          li_ban8();
          li_ban9();
        }else{
          alertify.error(a.m);
        }
      }
    });
}*/

/*
function g_dermpa(v1, v2){
  var v3=$('#smpar').val();
  if(v3!=null){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
      data: {acc: 'dermpa', v1: v1, v2: v2, v3: v3},
      dataType: "json",
      success:function(a){
        if(a.e){
          alertify.success(a.m);
          li_ban3();
        }else{
          alertify.error(a.m);
        }
      }
    });
  }else{
    alert('Elija la mesa de partes a donde derivará el documento.');
  }
}
*/

function g_dernot(v1, v2){
  var v3=$('#sper').val();
  if(v3!=null){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
      data: {acc: 'dernot', v1: v1, v2: v2, v3: v3},
      dataType: "json",
      success:function(a){
        if(a.e){
          alertify.success(a.m);
          li_ban4();
        }else{
          alertify.error(a.m);
        }
      }
    });
  }else{
    alert('Elija el personal a quien derivará notificación.');
  }
}

function g_derper(v1, v2){
  var v3=$('#sper1').val();
  if(v3!=null){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/g_bandeja.php",
      data: {acc: 'derper1', v1: v1, v2: v2, v3: v3},
      dataType: "json",
      success:function(a){
        if(a.e){
          alertify.success(a.m);
          li_ban9();
        }else{
          alertify.error(a.m);
        }
      }
    });
  }else{
    alert('Elija el personal a quien derivará.');
  }
}

function guiapdf(guia){
  window.open("m_exportar/guiapdf.php?guia="+guia, '_blank');
}
//mesa de partes
function li_mpartes(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_mpartes.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_mpar1").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_mpar1").html(a);
      }
    });
}

function li_rmpartes(idmp){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_rmpartes.php",
      data: {v1: idmp},
      dataType: "html",
      beforeSend: function () {
        $("#li_rmpartes").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#li_rmpartes").html(a);
      }
    });
}

function f_mpartes(acc,v1,v2){
    $("#m_tamano").removeClass('modal-lg');
    switch(acc) {
        case 'agrmpar':
          var mt="<span class='text-muted'><i class='fa fa-archive text-yellow'></i> Agregar Mesa de Partes</span>";
          break;
        case 'edimpar':
          var mt="<span class='text-muted'><i class='fa fa-pencil text-yellow'></i> Editar Mesa de Partes</span>";
          break;
        case 'estmpar':
          var mt="<span class='text-muted'><i class='fa fa-toggle-on text-yellow'></i> Estado Mesa de Partes</span>";
          break;
        case 'resmpar':
          var mt="<span class='text-muted'><i class='fa fa-users text-yellow'></i> Responsables Mesa de Partes</span>";
          $("#m_tamano").addClass('modal-lg');
          break;
    }
    $(".titulo").html(mt);
    $("#m_modal").modal("show");
  
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/f_mpartes.php",
      data: {acc: acc, v1: v1, v2: v2},
      dataType: "html",
      beforeSend: function () {
        $("#f_mmodal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
        $("#b_guardar").addClass("hidden");
      },
      success:function(a){
        $("#f_mmodal").html(a);
        if(acc!='resmpar'){
          $("#b_guardar").removeClass("hidden");
        }
        if(acc=='resmpar'){
          li_rmpartes(v1);
        }
      }
    });
}

$('#f_mmodal').submit(function(e){
  e.preventDefault();
  var datos = $(this).serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/g_mpartes.php",
    data: datos,
    dataType: "json",
    beforeSend: function(){
      $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      if(a.e){
        $("#f_mmodal").html(a.m);
        li_mpartes();
      }else{
        $("#d_frespuesta").html(a.m);
        $("#b_guardar").removeClass("hidden");
      }
    }
  });
})



function f_mpartesp(acc,v1,v2){
    $("#m_tamanop").removeClass('modal-sm');
    switch(acc) {
        case 'agrres':
          var mt="<span class='text-muted'><i class='fa fa-user text-yellow'></i> Agregar Responsable</span>";
          $("#m_tamanop").addClass('modal-sm');
          break;
        case 'estres':
          var mt="<span class='text-muted'><i class='fa fa-toggle-on text-yellow'></i> Estado Responsable</span>";
          $("#m_tamanop").addClass('modal-sm');
          break;
    }
    $(".titulop").html(mt);
    $("#m_modalp").modal("show");
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/f_mpartes.php",
      data: {acc: acc, v1: v1, v2: v2},
      dataType: "html",
      beforeSend: function () {
        $("#f_mmodalp").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
        $("#b_guardarp").addClass("hidden");
      },
      success:function(a){
        $("#f_mmodalp").html(a);
        $("#b_guardarp").removeClass("hidden");
      }
    });
}

$('#f_mmodalp').submit(function(e){
  e.preventDefault();
  var datos = $(this).serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/g_mpartes.php",
    data: datos,
    dataType: "json",
    beforeSend: function(){
      $("#d_frespuestap").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardarp").addClass("hidden");
    },
    success:function(a){
      if(a.e){
        $("#f_mmodalp").html(a.m);
        $("#b_guardarp").addClass("hidden");
        if(a.i!=null){
          li_rmpartes(a.i);
        }
      }else{
        $("#d_frespuestap").html(a.m);
        $("#b_guardarp").removeClass("hidden");
      }
    }
  });
});

//consultas
$("#mpar, #mparp").select2({
  placeholder: 'Selecione una mesa de partes',
  ajax: {
    url: 'm_inclusiones/a_general/a_selmpartes.php',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
      return {
        results: data
      };
    },
    cache: true
  },
  minimumInputLength: 2
});
$("#d_dano,#d_gano").datepicker({
  format: 'yyyy',
  languaje: 'es',
  autoclose: true,
  minViewMode: 2,
  maxViewMode: 2,
  todayHighlight: true
});
$("#d_des,#d_has").datepicker({
  format: 'dd/mm/yyyy',
  languaje: 'es',
  autoclose: true,
  minViewMode: 0,
  maxViewMode: 2,
  todayHighlight: true
});
$("#per").select2({
  placeholder: 'Selecione un personal',
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
})