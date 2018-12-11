$(document).ready(function(){
	$('#fecb').datepicker({
	    format: 'mm/yyyy',
	    autoclose: true,
	    minViewMode: 1,
	    maxViewMode: 2,
	    todayHighlight: true
	});

	var mai=$('#fecb').val();
	lrendiciones(mai);

	var mes=$('#fecb').val();
  	basignaciones(mes);

   	//inicio gerardo

  	//fin gerardo
  	//inicio marco
  	var tra=$('#tra').val();
    bentregas(tra);
  	//fin marco
});

//gerardo
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
	
	switch(acc) {
    case 'agrren':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar rendición";
        break;
    case 'ediren':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar rendición";
        break;
    case 'agrdoc':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar documento rendición";
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
	    $("#f_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
	    $("#b_guardar").addClass("hidden");
	  },
	  success:function(a){
	    $("#f_modal").html(a);
	    $("#b_guardar").removeClass("hidden");
	  }
	});
}

$('#f_modal').submit(function(e){
	e.preventDefault();
	var datos = $("#f_modal").serializeArray();
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
	  		$("#f_modal").html(a.m);
	  		var ma=$('#fecb').val();
			lrendiciones(ma);
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
//fin gerardo
//marco

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
      $("#f_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      $("#f_modal").html(a);
      $("#b_guardar").removeClass("hidden");
    }
  });
}

// FIN FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS DE ASIGNACIONES

// FUNCIÓN QUE LLAMA ARVHIVO GUARDAR ASIGNACIONES

$('#f_modal').submit(function(e){
  e.preventDefault();
  var datos = $("#f_modal").serializeArray();
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
        $("#f_modal").html(a.m);
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
//fin marco
//inicio gerardo
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
	  url: "m_inclusiones/a_tesoreria/fo_rendiciones1.php",
	  data: {acc: acc, v1: v1, v2: v2},
	  dataType: "html",
	  beforeSend: function () {
	    $("#f1_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
	    $("#b1_guardar").hide();
	  },
	  success:function(a){
	    $("#f1_modal").html(a);
	    $("#b1_guardar").show();
	  }
	});
}

$('#f1_modal').submit(function(e){
	e.preventDefault();
	var datos = $("#f_modal").serializeArray();
	$.ajax({
	  type: "post",
	  url: "m_inclusiones/a_tesoreria/gu_rendiciones1.php",
	  data: datos,
	  dataType: "json",
	  beforeSend: function () {
	    $("#d1_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
	    $("#b1_guardar").hide();
	  },
	  success:function(a){
	  	if(a.e){
	  		$("#f1_modal").html(a.m);
	  	}else{
			$("#d1_frespuesta").html(a.m);
			$("#b1_guardar").show();
	  	}
	  }
	});
})
//fin gerardo
//inicio marco

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
        var mt="<i class='fa fa-plus text-gray'></i> Agregar Entrega";
        break;
    case 'edient':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar Entrega";
        break;
    case 'elient':
        var mt="<i class='fa fa-times-circle text-gray'></i> Eliminar Entrega";
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
      $("#f_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      $("#f_modal").html(a);
      $("#b_guardar").removeClass("hidden");
    }
  });
}

// FIN FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS DE ENTREGAS

// FUNCIÓN QUE LLAMA ARVHIVO GUARDAR ENTREGAS

$('#f_modal').submit(function(e){
  e.preventDefault();
  var datos = $("#f_modal").serializeArray();
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
        $("#f_modal").html(a.m);
        var mb=$('#tra').val();
        bentregas(mb);
        $("#b_guardar").addClass("hidden");
      }else{
        $("#d_frespuesta").html(a.m);
        $("#b_guardar").removeClass("hidden");
      }
    }
  });
})
// FIN FUNCIÓN QUE LLAMA ARVHIBO GUARDAR ENTREGAS

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

// FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS DE DOCUMENTOS DE ENTREGAS
function fo_docentregas(acc, v1, v2){
  
  switch(acc) {
    case 'agrdent':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar Comprobante de Entrega";
        break;
    case 'edident':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar Comprobante de Entrega";
        break;
    case 'elident':
        var mt="<i class='fa fa-times-circle text-gray'></i> Eliminar Comprobante de Entrega";
        break;        
  }
  $(".modal-title").html(mt);
  $("#m_modal").modal("show");

  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/fo_docentregas.php",
    data: {acc: acc, v1 : v1, v2  : v2},
    dataType: "html",
    beforeSend: function () {
      $("#f_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      $("#f_modal").html(a);
      $("#b_guardar").removeClass("hidden");
    }
  });
}

// FIN FUNCIÓN QUE ENVÍA PARÁMETROS PARA FORMULARIOS DE DOCUMENTOS DE ENTREGAS

// FUNCIÓN QUE LLAMA ARVHIVO GUARDAR DOCUMENTOS DE ENTREGAS

$('#f_modal').submit(function(e){
  e.preventDefault();
  var datos=$("#f_modal").serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/gu_docentregas.php",
    data: datos,
    dataType: "json",
    beforeSend: function () {      
      $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      if(a.e){
        var ide=$('#ide').val();
        $("#f_modal").html(a.m);        
        ldocentregas(ide);
        $("#b_guardar").addClass("hidden");
      }else{
        $("#d_frespuesta").html(a.m);
        $("#b_guardar").removeClass("hidden");
      }
    }
  });
})
// FIN FUNCIÓN QUE LLAMA ARVHIBO GUARDAR DOCUMENTOS DE ENTREGAS

fo_rendir
// FUNCIÓN QUE ENVÍA PARÁMETROS PARA RENDICIÓN DE VIÁTICOS
function fo_docentregas(idc){  
  
  $(".modal-title").html('Agregar Rendición');
  $("#m_modal").modal("show");

  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/fo_rendir.php",
    data: {acc: acc, v1 : v1, v2  : v2},
    dataType: "html",
    beforeSend: function () {
      $("#f_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      $("#f_modal").html(a);
      $("#b_guardar").removeClass("hidden");
    }
  });
}

// FIN FUNCIÓN QUE ENVÍA PARÁMETROS PARA RENDICIÓN DE VIÁTICOS
//fin marco