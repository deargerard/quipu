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

});
//marco

// Buscar ASIGNACIONES AUTOMATICAMENTE 

function basignaciones(mb){
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tesoreria/b_asignaciones.php",
    data: {fecb : mb},
    dataType: "html",
    beforeSend: function () {
      $("#resultado").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){
      $("#resultado").html(a);
    }
  });
}

// Fin Buscar ASIGNACIONES AUTOMATICAMENTE

// FUNCIÓN BUSCAR ASIGNACIONES

$('#b_basig').click(function(){
  var mb=$('#fecb').val();
  basignaciones(mb);
})

// FIN FUNCIÓN BUSCAR ASIGNACIONES

function fo_asignaciones(acc, v1, v2){
  
  switch(acc) {
    case 'agrren':
        var mt="<i class='fa fa-plus text-gray'></i> Agregar rendición";
        break;
    case 'ediren':
        var mt="<i class='fa fa-pencil text-gray'></i> Editar rendición";
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
      $("#b_guardar").hide();
    },
    success:function(a){
      $("#f_modal").html(a);
      $("#b_guardar").show();
    }
  });
}

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
      $("#b_guardar").hide();
    },
    success:function(a){
      if(a.e){
        $("#f_modal").html(a.m);
        var mb=$('#fecb').val();
      basignaciones(mb);
      }else{
      $("#d_frespuesta").html(a.m);
      $("#b_guardar").show();
      }
    }
  });
})