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


$("#dt_reportar,#dt_guia,#dt_gdoc").DataTable({
  dom: 'Bfrtip',
  buttons: [
    {
        extend: 'copy',
        text: '<i class="fa fa-copy"></i>',
        titleAttr: 'Copiar'
    },
    {
        extend: 'csv',
        text: '<i class="fa fa-file-text-o"></i>',
        titleAttr: 'CSV'
    },
    {
        extend: 'excel',
        text: '<i class="fa fa-file-excel-o"></i>',
        titleAttr: 'Excel'
    },
    {
        extend: 'pdf',
        text: '<i class="fa fa-file-pdf-o"></i>',
        titleAttr: 'PDF'
    },
    {
        extend: 'print',
        text: '<i class="fa fa-print"></i>',
        titleAttr: 'Imprimir'
    }
  ]
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

$("#b_geguia").click(function(){
	var datos = $("#f_geguia").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/g_geguia.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_geguia").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_geguia").hide();
		},
		success: function(e){
			$("#r_geguia").html(e.mensaje);
			$("#b_geguia").show();
			if(e.exito){
				$("#des").val("");
				aguia();
			}
		}
	});
});

function aguia(){
	$.ajax({
		method: "POST",
		url: "php/a_guia.php",
		dataType: 'html',
		beforeSend: function(){
			$("#d_guia").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#d_guia").html(e);
		}
	});
}

function edguia(idg){
	$.ajax({
		method: "POST",
		url: "php/f_edguia.php",
		data: {idg: idg},
		dataType: 'html',
		beforeSend: function(){
			$("#b_edguia").hide();
			$("#f_edguia").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#b_edguia").show();
			$("#f_edguia").html(e);
		}
	});
}

$("#f_edguia").submit(function(e){
	e.preventDefault();
	var datos = $("#f_edguia").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/g_edguia.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_edguia").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_edguia").hide();
		},
		success: function(e){
			if(e.exito){
				$("#f_edguia").html(e.mensaje);
				aguia();
			}else{
				$("#r_edguia").html(e.mensaje);
				$("#b_edguia").show();
			}
		}
	});
});

$("#b_indoc").click(function(){
	var datos = $("#f_indoc").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/g_indoc.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_indoc").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_indoc").hide();
		},
		success: function(e){
			$("#r_indoc").html(e.mensaje);
			$("#b_indoc").show();
			if(e.exito){
				$("#num").val("");
				$("#tip").val("");
				$("#ori").val("");
				$("#rem").val("");
				$("#des").val("");
				$("#dest").val("");
				//$("#dcar").prop("checked", false);
				var guia =$("#guia").val();
				adoc(guia);
			}
			$("#tip").focus().select();
		}
	});
});

function adoc(guia){
	$.ajax({
		method: "POST",
		url: "php/a_doc.php",
		data: {guia: guia},
		dataType: 'html',
		beforeSend: function(){
			$("#d_doc").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#d_doc").html(e);
		}
	});
}

function eddoc(idd){
	$.ajax({
		method: "POST",
		url: "php/f_eddoc.php",
		data: {idd: idd},
		dataType: 'html',
		beforeSend: function(){
			$("#b_eddoc").hide();
			$("#f_eddoc").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#b_eddoc").show();
			$("#f_eddoc").html(e);
		}
	});
}

$("#f_eddoc").submit(function(e){
	e.preventDefault();
	var datos = $("#f_eddoc").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/g_eddoc.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_eddoc").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_eddoc").hide();
		},
		success: function(e){
			if(e.exito){
				$("#f_eddoc").html(e.mensaje);
				var guia =$("#guia").val();
				adoc(guia);
			}else{
				$("#r_eddoc").html(e.mensaje);
				$("#b_eddoc").show();
			}
		}
	});
});

function dedoc(idd){
	$.ajax({
		method: "POST",
		url: "php/f_dedoc.php",
		data: {idd: idd},
		dataType: 'html',
		beforeSend: function(){
			$("#f_dedoc").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#f_dedoc").html(e);
		}
	});
}

function eldoc(idd){
	$.ajax({
		method: "POST",
		url: "php/f_eldoc.php",
		data: {idd: idd},
		dataType: 'html',
		beforeSend: function(){
			$("#f_eldoc").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#f_eldoc").html(e);
		}
	});
}

$("#f_eldoc").submit(function(e){
	e.preventDefault();
	var datos = $("#f_eldoc").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/g_eldoc.php",
		data: datos,
		dataType: 'json',
		beforeSend: function(){
			$("#r_eldoc").html('<i class="fa fa-spinner fa-spin"></i>');
			$("#b_eldoc").hide();
		},
		success: function(e){
			if(e.exito){
				$("#f_eldoc").html(e.mensaje);
				var guia =$("#guia").val();
				adoc(guia);
			}else{
				$("#r_eldoc").html(e.mensaje);
				$("#b_eldoc").show();
			}
		}
	});
});
$("#f_bdocumento").submit(function(e){
	e.preventDefault();
	var datos = $("#f_bdocumento").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/b_documento.php",
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
$("#f_bdoc").submit(function(e){
	e.preventDefault();
	var datos = $("#f_bdoc").serializeArray();
	$.ajax({
		method: "POST",
		url: "php/b_doc.php",
		data: datos,
		dataType: 'html',
		beforeSend: function(){
			$("#d_consultas").html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(e){
			$("#d_consultas").html(e);
		}
	});
});