 $(document).ready(function(){
	$('#fecb').datepicker({
	    format: 'mm/yyyy',
	    autoclose: true,
	    minViewMode: 1,
	    maxViewMode: 2,
	    todayHighlight: true
	});

  $('#anob, #anobcv, #anobcp').datepicker({
      format: 'yyyy',
      autoclose: true,
      minViewMode: 2,
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
  $("#m_tamaño").removeClass("modal-lg");
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
    case 'agrcomp':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar comprobantes";
        $("#m_tamaño").addClass("modal-lg");
        break;
    case 'agrviat':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar viático";
        $("#m_tamaño").addClass("modal-lg");
        break;
    case 'libcomp':
        var mt="<i class='fa fa-external-link text-gray'></i> Liberar comprobante";
        break;
    case 'libviat':
        var mt="<i class='fa fa-external-link text-gray'></i> Liberar viático";
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
      if(acc=="agrcomp" || acc=="agrviat"){
        
      }else{
        $("#b_guardar").removeClass("hidden");
      }
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
        }else if (datos[0].value=="agrdent" || datos[0].value=="edident" || datos[0].value=="elident" || datos[0].value=="libcomp" || datos[0].value=="libviat") {
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

function comaent(idg, ide){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/gu_comaent.php",
    data: {idg: idg, ide: ide},
    dataType: "json",
    beforeSend: function () {
      $("#var"+idg).removeClass('hidden');
    },
    success:function(a){
      if(a.e){
        fo_entregas('agrcomp', ide, 0);
        ldocentregas(ide);
        alert(a.m);
      }else{
        alert(a.m);
        $("#var"+idg).addClass('hidden');
      }
    }
  });
}

function viaaent(idcs, ide){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/gu_viaaent.php",
    data: {idcs: idcs, ide: ide},
    dataType: "json",
    beforeSend: function () {
      $("#var"+idcs).removeClass('hidden');
    },
    success:function(a){
      if(a.e){
        fo_entregas('agrviat', ide, 0);
        ldocentregas(ide);
        alert(a.m);
      }else{
        alert(a.m);
        $("#var"+idcs).addClass('hidden');
      }
    }
  });
}
//función exportar Libro Auxiliar
$("#b_exla").click(function(){
  var fecb=$("#fecb").val();
  var fon=$("#fon").val();  
  if (fecb==null || fon==null){
    alert("Todos los campos son obligatorios");
  }else {
    window.location.href = "m_inclusiones/a_tesoreria/xls_libro_auxiliar.php?fecb="+fecb+"&fon="+fon;
  }
})
//fin función exportar Libro Auxiliar

//función exportar gastos por específica
$("#b_exge").click(function(){
  var anob=$("#anob").val();
  var esp=$("#esp").val();  
  if (fecb==null || fon==null){
    alert("Todos los campos son obligatorios");
  }else {
    window.location.href = "m_inclusiones/a_tesoreria/xls_gastos_especifica.php?anob="+anob+"&esp="+esp;
  }
})
//fin función exportar gastos por específica
// FUNCION BUSCAR PAGOS PENDIENTES
function b_bpagpen(fon){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/bpagpen.php",
    data: {fon : fon},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep3").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#r_rep3").html(a);      
    }
  });
}
// FIN FUNCION BUSCAR PAGOS PENDIENTES
//LLAMA A LA FUNCIÓN PAGOS PENDIENTES
$("#b_bpagpen").click(function(){
  var fon=$("#fon1").val();
  if (fon==null){
    alert("Debe elegir un fondo");
  }else {
    b_bpagpen(fon);
  }
})
// FIN LLAMA A LA FUNCIÓN PAGOS PENDIENTES

// FUNCION BUSCAR DOCUMENTOS REGISTRADOS
function b_bdocreg(anob){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/bdocreg.php",
    data: {anob : anob},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep4").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
    },
    success:function(a){      
      $("#r_rep4").html(a);      
    }
  });
}
// FIN FUNCION BUSCAR DOCUMENTOS REGISTRADOS
//LLAMA A LA FUNCIÓN DOCUMENTOS REGISTRADOS
$("#b_bdocreg").click(function(){
  var anob=$("#anobcp").val();
  if (anob==null){
    alert("Debe elegir un año");
  }else {
    b_bdocreg(anob);
  }
})
// FIN LLAMA A LA FUNCIÓN DOCUMENTOS REGISTRADOS

function fo_det(ent){
  $("#m_modal").modal("show");   
  $(".modal-title").html("<i class='fa fa-external-link text-gray'></i> Detalle de Pago de comprobante"); 

  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/fo_det.php",
    data: {ent: ent},
    dataType: "html",
    beforeSend: function () {
      $("#f_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      $("#f_modal").html(a);      
    }
  });
}

// FUNCION BUSCAR CONSUMO DE VIÁTICOS 
function b_convia(anob){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/bconvia.php",
    data: {anob : anob},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep5").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
    },
    success:function(a){      
      $("#r_rep5").html(a);      
    }
  });
}
// FIN FUNCION BUSCAR CONSUMO DE VIÁTICOS 
//LLAMA A LA FUNCIÓN CONSUMO DE VIÁTICOS 
$("#b_bconvia").click(function(){
  var anob=$("#anobcv").val();
  if (anob==null){
    alert("Debe elegir un año");
  }else {
    b_convia(anob);
  }
})
// FIN LLAMA A LA FUNCIÓN CONSUMO DE VIÁTICOS 