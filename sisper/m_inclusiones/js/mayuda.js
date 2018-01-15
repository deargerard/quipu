function amatenciones(){
	$.ajax({
		method: "post",
		url: "m_inclusiones/a_mayuda/a_matenciones.php",
		dataType: "html",
		beforeSend: function(){
			$(".r_matenciones").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
		},
		success: function(a){
			$(".r_matenciones").html(a);
		}
	})
};
function amatencionesma(){
	$.ajax({
		method: "post",
		url: "m_inclusiones/a_mayuda/a_matencionesma.php",
		dataType: "html",
		beforeSend: function(){
			$(".r_matencionesma").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
		},
		success: function(a){
			$(".r_matencionesma").html(a);
		}
	})
};
$("#b_natencion").click(function(){
	$.ajax({
		url: "m_inclusiones/a_mayuda/a_fnatencion.php",
		dataType: "html",
		beforeSend: function(){
			$("#f_natencion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
		},
		success: function(a){
			$("#f_natencion").html(a);
			$("#ocu").hide();
			$("#b_gnatencion").show();
		}
	})
});
$("#f_natencion").submit(function(e){
	e.preventDefault(e);
	var datos = $("#f_natencion").serializeArray();
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_gnatencion.php",
		dataType: "json",
		data: datos,
		beforeSend: function(){
			$("#resultado").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
			$("#b_gnatencion").hide();
		},
		success: function(e){
			if (e.exito) {
				$("#f_natencion").html(e.mensaje);
				$("#b_gnatencion").hide();
				amatenciones();
				amatencionesma();
			}else{
				$("#resultado").html(e.mensaje);
				$("#b_gnatencion").show();
			}
		}
	});
});
function eatencion(id){
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_featencion.php",
		dataType: "html",
		data: {id: id},
		beforeSend: function(){
			$("#f_eatencion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
		},
		success: function(a){
			$("#f_eatencion").html(a);
			$("#b_geatencion").show();
		}
	})
};
$("#f_eatencion").submit(function(e){
	e.preventDefault(e);
	var datos = $("#f_eatencion").serializeArray();
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_geatencion.php",
		dataType: "json",
		data: datos,
		beforeSend: function(){
			$("#resultado").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
			$("#b_geatencion").hide();
		},
		success: function(e){
			if (e.exito) {
				$("#f_eatencion").html(e.mensaje);
				$("#b_geatencion").hide();
				amatenciones();
			}else{
				$("#resultado").html(e.mensaje);
				$("#b_geatencion").show();
			}
		}
	});
});
function ratencion(id){
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_fratencion.php",
		dataType: "html",
		data: {id: id},
		beforeSend: function(){
			$("#f_ratencion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
		},
		success: function(a){
			$("#f_ratencion").html(a);
			$("#b_gratencion").show();
		}
	})
};
$("#f_ratencion").submit(function(e){
	e.preventDefault(e);
	var datos = $("#f_ratencion").serializeArray();
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_gratencion.php",
		dataType: "json",
		data: datos,
		beforeSend: function(){
			$("#resultado").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
			$("#b_gratencion").hide();
		},
		success: function(e){
			if (e.exito) {
				$("#f_ratencion").html(e.mensaje);
				$("#b_gratencion").hide();
				amatenciones();
			}else{
				$("#resultado").html(e.mensaje);
				$("#b_gratencion").show();
			}
		}
	});
});
function reatencion(id){
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_freatencion.php",
		dataType: "html",
		data: {id: id},
		beforeSend: function(){
			$("#f_reatencion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
		},
		success: function(a){
			$("#f_reatencion").html(a);
			$("#b_greatencion").show();
		}
	})
};
$("#f_reatencion").submit(function(e){
	e.preventDefault(e);
	var datos = $("#f_reatencion").serializeArray();
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_greatencion.php",
		dataType: "json",
		data: datos,
		beforeSend: function(){
			$("#resultado").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
			$("#b_greatencion").hide();
		},
		success: function(e){
			if (e.exito) {
				$("#f_reatencion").html(e.mensaje);
				$("#b_greatencion").hide();
				amatenciones();
				amatencionesma();
			}else{
				$("#resultado").html(e.mensaje);
				$("#b_greatencion").show();
			}
		}
	});
});
function caatencion(id){
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_fcaatencion.php",
		dataType: "html",
		data: {id: id},
		beforeSend: function(){
			$("#f_caatencion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
		},
		success: function(a){
			$("#f_caatencion").html(a);
			$("#b_gcaatencion").show();
		}
	})
};
$("#f_caatencion").submit(function(e){
	e.preventDefault(e);
	var datos = $("#f_caatencion").serializeArray();
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_gcaatencion.php",
		dataType: "json",
		data: datos,
		beforeSend: function(){
			$("#resultado").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
			$("#b_gcaatencion").hide();
		},
		success: function(e){
			if (e.exito) {
				$("#f_caatencion").html(e.mensaje);
				$("#b_gcaatencion").hide();
				amatenciones();
				amatencionesma();
			}else{
				$("#resultado").html(e.mensaje);
				$("#b_gcaatencion").show();
			}
		}
	});
});
function iatencion(id){
	$.ajax({
		type: "post",
		url: "m_inclusiones/a_mayuda/a_iatencion.php",
		dataType: "html",
		data: {id: id},
		beforeSend: function(){
			$("#r_iatencion").html("<p class='text-center'><img src='m_images/loader.gif'></p>");
		},
		success: function(a){
			$("#r_iatencion").html(a);
		}
	})
};

$("#mesini").datepicker({
  autoclose: true,
  format: "dd/mm/yyyy",
  language: "es",
}).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    $('#mesfin').datepicker('setStartDate', minDate);
});

$("#mesfin").datepicker({
  autoclose: true,
  format: "dd/mm/yyyy",
  language: "es",
}).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#mesini').datepicker('setEndDate', maxDate);
})
// fin datepickers reporte por meses

//funcion buscar atenciones por meses y solucionador
$("#b_bama").click(function(){
  var mesini=$("#mesini").val();
	var mesfin=$("#mesfin").val();
	var soluc=$("#soluc").val();
  $.ajax({
  type: "post",
  url: "m_inclusiones/a_mayuda/a_ratencionma.php",
  data: { mesini : mesini, mesfin : mesfin, soluc : soluc },
  dataType: "html",
  beforeSend: function () {
    $("#r_ama").html("<img src='m_images/cargando.gif'>");
  },
  success:function(a){
    $("#r_ama").html(a);
  }
  });
})
//Fin funcion buscar vacaciones por resolución
// Exportar atenciones
$("#b_eama").click(function(){
	var mesini=$("#mesini").val();
	var mesfin=$("#mesfin").val();
	var soluc=$("#soluc").val();
  if (mesini==null & mesfin==null) {
    alert("Todos los campos son obligatorios");
  }else {
     window.location.href = "m_exportar/e_exatenciones.php?mesini="+mesini+"&mesfin="+mesfin+"&soluc="+soluc;
  }
})
// Fin exportar atenciones
