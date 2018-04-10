$("#doc").focus();
$("#doc").keypress(function(e){
    if(e.which==13){
        $("#ori").focus();
    }
});
$("#fec").datepicker({
	format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
    todayHighlight: true
});

$("#b_regasi").click(function(){
	var datos = $("#f_regasi").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/a_gregasi.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_regasi").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_regasi").hide();
		},
		success: function(e){
			$("#r_regasi").html(e.mensaje);
			$("#b_regasi").show();
			if(e.exito){
				$("#doc").val("");
				$("#ori").val("");
				$("#des").val("");
				$("#doc").focus();
				adocumentos();
			}
		}
	});
});

function eddocumento(res, iddoc){
	$.ajax({
		method: "POST",
		url: "php/f_eddocumento.php",
		data: {res: res, iddoc: iddoc},
		dataType: 'html',
		beforeSend: function(){
			$("#b_eddocumento").hide();
			$("#f_eddocumento").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#b_eddocumento").show();
			$("#f_eddocumento").html(e);
		}
	});
}

$("#f_eddocumento").submit(function(e){
	e.preventDefault();
	var datos = $("#f_eddocumento").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/g_eddocumento.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_eddocumento").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_eddocumento").hide();
		},
		success: function(e){
			if(e.exito){
				$("#f_eddocumento").html(e.mensaje);
				if(e.lugar=='doc'){
					adocumentos();
				}else if(e.lugar=='res'){
					arresponsables();
				}else if(e.lugar=='asi'){
					arasignadores();
				}
			}else{
				$("#r_eddocumento").html(e.mensaje);
				$("#b_eddocumento").show();
			}
		}
	});
});

function eldocumento(res, iddoc){
	$.ajax({
		method: "POST",
		url: "php/f_eldocumento.php",
		data: {res: res, iddoc: iddoc},
		dataType: 'html',
		beforeSend: function(){
			$("#b_eldocumento").hide();
			$("#f_eldocumento").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#b_eldocumento").show();
			$("#f_eldocumento").html(e);
		}
	});
}

$("#f_eldocumento").submit(function(e){
	e.preventDefault();
	var datos = $("#f_eldocumento").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/g_eldocumento.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_eldocumento").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_eldocumento").hide();
		},
		success: function(e){
			if(e.exito){
				$("#f_eldocumento").html(e.mensaje);
				if(e.lugar=='doc'){
					adocumentos();
				}else if(e.lugar=='res'){
					arresponsables();
				}else if(e.lugar=='asi'){
					arasignadores();
				}
			}else{
				$("#r_eldocumento").html(e.mensaje);
				$("#b_eldocumento").show();
			}
		}
	});
});

function adocumentos(){
	$.ajax({
		method: "POST",
		url: "php/a_documentos.php",
		dataType: 'html',
		beforeSend: function(){
			$("#d_documento").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#d_documento").html(e);
		}
	});
}

function redocumento(iddoc){
	$.ajax({
		method: "POST",
		url: "php/f_redocumento.php",
		data: {iddoc: iddoc},
		dataType: 'html',
		beforeSend: function(){
			$("#b_redocumento").hide();
			$("#f_redocumento").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#b_redocumento").show();
			$("#f_redocumento").html(e);
		}
	});
}

$("#f_redocumento").submit(function(e){
	e.preventDefault();
	var datos = $("#f_redocumento").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/g_redocumento.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_redocumento").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_redocumento").hide();
		},
		success: function(e){
			if(e.exito){
				$("#f_redocumento").html(e.mensaje);
				amdocumentos();
			}else{
				$("#r_redocumento").html(e.mensaje);
				$("#b_redocumento").show();
			}
		}
	});
});

function amdocumentos(){
	$.ajax({
		method: "POST",
		url: "php/a_mdocumentos.php",
		dataType: 'html',
		beforeSend: function(){
			$("#d_mdocumento").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#d_mdocumento").html(e);
		}
	});
}

$('#feci').datepicker({
  format: "dd/mm/yyyy",
  language: "es",
  autoclose: true,
  todayHighlight: true,
})
.on('changeDate', function(e){
  var fechini = new Date(e.date.valueOf());
  $('#fecf').datepicker('setStartDate', fechini);
 });
 $(' #fecf').datepicker({
   format: "dd/mm/yyyy",
   language: "es",
   autoclose: true,
   todayHighlight: true,
})
 .on('changeDate', function(e){
   var fechfin = new Date(e.date.valueOf());
   $('#feci').datepicker('setEndDate', fechfin);
});

$('#fecia').datepicker({
  format: "dd/mm/yyyy",
  language: "es",
  autoclose: true,
  todayHighlight: true,
})
.on('changeDate', function(e){
  var fechini = new Date(e.date.valueOf());
  $('#fecfa').datepicker('setStartDate', fechini);
 });
 $(' #fecfa').datepicker({
   format: "dd/mm/yyyy",
   language: "es",
   autoclose: true,
   todayHighlight: true,
})
 .on('changeDate', function(e){
   var fechfin = new Date(e.date.valueOf());
   $('#fecia').datepicker('setEndDate', fechfin);
});

$("#f_rresponsables").submit(function(e){
	e.preventDefault();
	var datos = $("#f_rresponsables").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/b_responsables.php",
		data: datos,
		dataType: 'html',
		beforeSend: function(){
			$("#d_reportes").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#d_reportes").html(e);
		}
	});
});

function readocumento(res,iddoc){
	$.ajax({
		method: "POST",
		url: "php/f_readocumento.php",
		data: {res:res, iddoc: iddoc},
		dataType: 'html',
		beforeSend: function(){
			$("#b_readocumento").hide();
			$("#f_readocumento").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#b_readocumento").show();
			$("#f_readocumento").html(e);
		}
	});
}

$("#f_readocumento").submit(function(e){
	e.preventDefault();
	var datos = $("#f_readocumento").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/g_readocumento.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_readocumento").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_readocumento").hide();
		},
		success: function(e){
			if(e.exito){
				$("#f_readocumento").html(e.mensaje);
				if(e.lugar=='res'){
					arresponsables();
				}else if(e.lugar=='asi'){
					arasignadores();
				}
			}else{
				$("#r_readocumento").html(e.mensaje);
				$("#b_readocumento").show();
			}
		}
	});
});

function dedocumento(iddoc){
	$.ajax({
		method: "POST",
		url: "php/f_dedocumento.php",
		data: {iddoc: iddoc},
		dataType: 'html',
		beforeSend: function(){
			$("#r_dedocumento").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#r_dedocumento").html(e);
		}
	});
}

function arresponsables(){
	var datos = $("#f_rresponsables").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/b_responsables.php",
		data: datos,
		dataType: 'html',
		beforeSend: function(){
			$("#d_reportes").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#d_reportes").html(e);
		}
	});
}

function arasignadores(){
	var datos = $("#f_rasignadores").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/b_asignadores.php",
		data: datos,
		dataType: 'html',
		beforeSend: function(){
			$("#d_reportes").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#d_reportes").html(e);
		}
	});
}

$("#f_rasignadores").submit(function(e){
	e.preventDefault();
	var datos = $("#f_rasignadores").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/b_asignadores.php",
		data: datos,
		dataType: 'html',
		beforeSend: function(){
			$("#d_reportes").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#d_reportes").html(e);
		}
	});
});

$("#b_easignadores").click(function(){
	var pera=$("#pera").val();
	var esta=$("#esta").val();
	var fecia=$("#fecia").val();
	var fecfa=$("#fecfa").val();
	var tfeca=$('input:radio[name=tfeca]:checked').val();
  if (pera==null || esta==null || fecia==null || fecfa==null || tfeca==null) {
    alert("Todos los campos son obligatorios");
  }else {
     window.location.href = "php/e_asignadores.php?pera="+pera+"&esta="+esta+"&fecia="+fecia+"&fecfa="+fecfa+"&tfeca="+tfeca;
  }
});
$("#b_eresponsables").click(function(){
	var pera=$("#per").val();
	var esta=$("#est").val();
	var fecia=$("#feci").val();
	var fecfa=$("#fecf").val();
	var tfeca=$('input:radio[name=tfec]:checked').val();
  if (pera==null || esta==null || fecia==null || fecfa==null || tfeca==null) {
    alert("Todos los campos son obligatorios");
  }else {
     window.location.href = "php/e_responsables.php?pera="+pera+"&esta="+esta+"&fecia="+fecia+"&fecfa="+fecfa+"&tfeca="+tfeca;
  }
});

$("#f_contrasena").submit(function(e){
	e.preventDefault();
	var datos = $("#f_contrasena").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/c_contrasena.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_contrasena").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(d){
			if(d.e){
				$("#f_contrasena").html(d.m);
			}else{
				$("#r_contrasena").html(d.m);
			}
		}
	});
});