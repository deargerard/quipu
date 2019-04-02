function anuncio(id){
  	//$('#emodal').modal('show');
  	$.ajax({
		type: "post",
		url: "ajax/a_vcomunicado.php",
		data: { idc : id },
		beforeSend: function () {
		  $("#resultado").html("<img scr='images/cargando.gif'>");
		},
		success:function(a){
		  $("#resultado").html(a);
		}
	});
}
function noticia(id){
  	//$('#emodal').modal('show');
  	$.ajax({
		type: "post",
		url: "ajax/a_vnoticia.php",
		data: { idn : id },
		beforeSend: function () {
		  $("#resultado").html("<img scr='images/cargando.gif'>");
		},
		success:function(a){
		  $("#resultado").html(a);
		}
	});
}

function documentos(id){
  	//$('#emodal').modal('show');
  	$.ajax({
		type: "post",
		url: "ajax/a_vdocumentos.php",
		data: { idd : id },
		beforeSend: function () {
		  $("#resultado").html("<img scr='images/cargando.gif'>");
		},
		success:function(a){
		  $("#resultado").html(a);
		}
	});
}

function cumpleanos(id){
  	//$('#emodal').modal('show');
  	$.ajax({
		type: "post",
		url: "ajax/a_vcumpleanos.php",
		data: { idm : id },
		beforeSend: function () {
		  $("#resultado").html("<img scr='images/cargando.gif'>");
		},
		success:function(a){
		  $("#resultado").html(a);
		}
	});
}

//buscar personal directorio
$(".select2peract").select2({
  theme: 'bootstrap4',
  placeholder: 'Selecione una persona',
  ajax: {
    url: 'sisper/m_inclusiones/a_general/a_selpersonal.php',
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
.on("change", function(e){
  var per = $("#per").val();
  $.ajax({
    type: "post",
    url: "ajax/a_bdirectorio.php",
    data: { id : per, tip : 1 },
    beforeSend: function () {
      $("#r_directorio").html("<img src='images/cargando.gif'>");
    },
    success:function(a){
      $("#r_directorio").html(a);
    }
  });
});
//fin buscar personal directorio

//buscar personal dependencia
$(".select2depact").select2({
  theme: 'bootstrap4',
  placeholder: 'Selecione una dependencia',
  ajax: {
    url: 'sisper/m_inclusiones/a_general/a_seldependencia.php',
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
.on("change", function(e){
  var per = $("#dep").val();
  $.ajax({
    type: "post",
    url: "ajax/a_bdirectorio.php",
    data: { id : per, tip : 2 },
    beforeSend: function () {
      $("#r_directorio").html("<img src='images/cargando.gif'>");
    },
    success:function(a){
      $("#r_directorio").html(a);
    }
  });
});
//fin buscar personal dependencia