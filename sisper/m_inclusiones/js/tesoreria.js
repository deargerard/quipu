$(document).ready(function(){
	$('#fecb').datepicker({
	    format: 'mm/yyyy',
	    autoclose: true,
	    minViewMode: 1,
	    maxViewMode: 2,
	    todayHighlight: true
	});

	var mes=$('#fecb').val();
  	basignaciones(mes);
  	var tra=$('#tra').val();
    bentregas(tra);
});

// FUNCIÓN BUSCAR ASIGNACIONES
function basignaciones(mb){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/b_asignaciones.php",
    data: {fecb : mb},
    dataType: "html",
    beforeSend: function () {
      $("#a_resultado").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#a_resultado").html(a);
    }
  });
}
// FIN FUNCIÓN BUSCAR ASIGNACIONES

// Buscar ASIGNACIONES 

$('#b_basig').click(function(){
  var mb=$('#fecb').val();
  basignaciones(mb);
})
// Fin Buscar ASIGNACIONES 

// FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS DE ASIGNACIONES
function fo_asignaciones(acc, v1, v2){
  
  switch(acc) {
    case 'agrasig':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar Asignación";
        break;
    case 'ediasig':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar Asignación";
        break;
    case 'eliasig':
        var mt="<i class='fa fa-times-circle text-gray'></i> Eliminar Asignación";
        break;    
  }
  $(".modal-title").html(mt);
  $("#m_modal").modal("show");

  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/fo_asignaciones.php",
    data: {acc: acc, v1: v1, v2: v2},
    dataType: "html",
    beforeSend: function () {
      $("#f_asignaciones").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      $("#f_asignaciones").html(a);
      $("#b_guardar").removeClass("hidden");
    }
  });
}

// FIN FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS DE ASIGNACIONES

// FUNCIÓN QUE LLAMA ARVHIVO GUARDAR ASIGNACIONES

$('#f_asignaciones').submit(function(e){
  e.preventDefault();
  var datos = $("#f_asignaciones").serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/gu_asignaciones.php",
    data: datos,
    dataType: "json",
    beforeSend: function () {
      $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      if(a.e){
        $("#f_asignaciones").html(a.m);
        var mb=$('#fecb').val();
        basignaciones(mb);
        $("#b_guardar").addClass("hidden");
      }else{
        $("#d_frespuesta").html(a.m);
        $("#b_guardar").removeClass("hidden");
      }
    }
  });
})
// FIN FUNCIÓN QUE LLAMA ARVHIBO GUARDAR ASIGNACIONES

// FUNCION BUSCAR ENTREGAS

function bentregas(tb){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/b_entregas.php",
    data: {tra : tb},
    dataType: "html",
    beforeSend: function () {
      $("#en_resultado").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#en_resultado").html(a);
    }
  });
}

// FIN FUNCION BUSCAR ENTREGAS
// FUNCIÓN CLICK BUSCAR ENTREGAS

$('#b_btra').click(function(){
  var tb=$('#tra').val();
  bentregas(tb);
})

// FIN FUNCIÓN CLICK BUSCAR ENTREGAS

// FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS DE ENTREGAS
function fo_entregas(acc, v1, v2){
  
  switch(acc) {
    case 'agrent':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar Adelanto";
        break;
    case 'edient':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar Adelanto";
        break;
    case 'elient':
        var mt="<i class='fa fa-times-circle text-gray'></i> Eliminar Adelanto";
        break;
    case 'agrdent':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar Comprobante";
        break;
    case 'edident':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar Comprobante";
        break;
    case 'elident':
        var mt="<i class='fa fa-times-circle text-gray'></i> Eliminar Comprobante";
        break;        
  }
  $(".modal-title").html(mt);
  $("#m_modal").modal("show");

  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/fo_entregas.php",
    data: {acc: acc, v1: v1, v2: v2},
    dataType: "html",
    beforeSend: function () {
      $("#f_entregas").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      $("#f_entregas").html(a);
      $("#b_guardar").removeClass("hidden");
    }
  });
}

// FIN FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS DE ENTREGAS

// FUNCIÓN QUE LLAMA VENTANA DE DOCUMENTOS DE ENTREGA
function ldocentregas(ide){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/li_docentregas.php",
    data: {ide : ide},
    dataType: "html",
    beforeSend: function () {
      $("#en_resultado").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#en_resultado").html(a);
    }
  });
}
// FIN FUNCIÓN QUE LLAMA VENTANA DE DOCUMENTOS DE ENTREGA

// FUNCIÓN QUE LLAMA ARVHIVO GUARDAR ENTREGAS

$('#f_entregas').submit(function(e){
  e.preventDefault();
  var datos = $("#f_entregas").serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/gu_entregas.php",
    data: datos,
    dataType: "json",
    beforeSend: function () {
      $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){

      if(a.e){
        $("#f_entregas").html(a.m);

        if (datos[0].value=="agrent"){          
          bentregas(datos[1].value);
          fo_entregas('agrdent',a.i,0);
        }else if (datos[0].value=="edient"){          
          bentregas(datos[1].value);
        }else if (datos[0].value=="elient") {
          bentregas('t');
        }else if (datos[0].value=="agrdent" || datos[0].value=="edident" || datos[0].value=="elident") {
          ldocentregas(datos[1].value);
        }
        
        $("#b_guardar").addClass("hidden");
      }else{
        $("#d_frespuesta").html(a.m);
        $("#b_guardar").removeClass("hidden");
      }
    }
  });
})
// FIN FUNCIÓN QUE LLAMA ARHIVO GUARDAR ENTREGAS