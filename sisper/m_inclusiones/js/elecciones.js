function li_elecciones(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_elecciones/li_elecciones.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_eleccion").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_eleccion").html(a);
      }
    });
}

function li_eleccionesco(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_elecciones/li_eleccionesco.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_eleccionco").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_eleccionco").html(a);
      }
    });
}

function li_listas(id){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_elecciones/li_listas.php",
      data: {id: id},
      dataType: "html",
      beforeSend: function () {
        $("#d_listas").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#d_listas").html(a);
      }
    });
}

function f_eleccion(acc,v1,v2){
    $("#m_tamano").removeClass('modal-lg');
    switch(acc) {
        case 'agrele':
          var mt="<span class='text-muted'><i class='fa fa-hand-o-up text-yellow'></i> Registrar elección</span>";
          //$(".modal-dialog").addClass('modal-lg');
          break;
        case 'ediele':
          var mt="<span class='text-muted'><i class='fa fa-edit text-yellow'></i> Editar elección</span>";
          //$(".modal-dialog").addClass('modal-lg');
          break;
        case 'estele':
          var mt="<span class='text-muted'><i class='fa fa-toggle-on text-yellow'></i> Cambiar estado elección</span>";
          //$(".modal-dialog").addClass('modal-lg');
          break;
        case 'eliele':
          var mt="<span class='text-muted'><i class='fa fa-trash text-yellow'></i> Eliminar elección</span>";
          //$(".modal-dialog").addClass('modal-lg');
          break;
        case 'verlis':
          var mt="<span class='text-muted'><i class='fa fa-list-ol text-yellow'></i> Listas</span>";
          $("#m_tamano").addClass('modal-lg');
          break;
    }
    $(".titulo").html(mt);
    $("#m_modal").modal("show");
  
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_elecciones/f_releccion.php",
      data: {acc: acc, v1: v1, v2: v2},
      dataType: "html",
      beforeSend: function () {
        $("#f_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
        $("#b_guardar").addClass("hidden");
      },
      success:function(a){
        $("#f_modal").html(a);
        if(acc!='verlis'){
          $("#b_guardar").removeClass("hidden");
        }
        if(acc=='verlis'){
          li_listas(v1);
        }
      }
    });
}

$('#f_modal').submit(function(e){
  e.preventDefault();
  var datos = $(this).serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_elecciones/g_releccion.php",
    data: datos,
    dataType: "json",
    beforeSend: function(){
      $("#d_frespuesta").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardar").addClass("hidden");
    },
    success:function(a){
      if(a.e){

        $("#f_modal").html(a.m);
        
        if(datos[0]['value']=='agrele' || datos[0]['value']=='ediele' || datos[0]['value']=='estele' || datos[0]['value']=='eliele'){
          li_elecciones();
        }

      }else{
        $("#d_frespuesta").html(a.m);
        $("#b_guardar").removeClass("hidden");
      }
    }
  });
})

function f_eleccionp(acc,v1,v2){
    $("#m_tamanop").removeClass('modal-sm');
    switch(acc) {
        case 'agrlis':
          var mt="<span class='text-muted'><i class='fa fa-list-ol text-yellow'></i> Registrar lista</span>";
          //$(".modal-dialog").addClass('modal-lg');
          break;
        case 'edilis':
          var mt="<span class='text-muted'><i class='fa fa-edit text-yellow'></i> Editar lista</span>";
          //$(".modal-dialog").addClass('modal-lg');
          break;
        case 'elilis':
          var mt="<span class='text-muted'><i class='fa fa-trash text-yellow'></i> Eliminar lista</span>";
          //$(".modal-dialog").addClass('modal-lg');
          break;
    }
    $(".titulop").html(mt);
    $("#m_modalp").modal("show");
  
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_elecciones/f_releccion.php",
      data: {acc: acc, v1: v1, v2: v2},
      dataType: "html",
      beforeSend: function () {
        $("#f_modalp").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
        $("#b_guardarp").addClass("hidden");
      },
      success:function(a){
        $("#f_modalp").html(a);
        if(acc!='agrlis1'){
          $("#b_guardarp").removeClass("hidden");
        }
        if(acc=='verlis'){
          li_listas(v1);
        }
      }
    });
}

$('#f_modalp').submit(function(e){
  e.preventDefault();
  var datos = $(this).serializeArray();
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_elecciones/g_releccion.php",
    data: datos,
    dataType: "json",
    beforeSend: function(){
      $("#d_frespuestap").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      $("#b_guardarp").addClass("hidden");
    },
    success:function(a){
      if(a.e){
        
        $("#f_modalp").html(a.m);

        console.log(datos[1]['value']);
        
        if(datos[0]['value']=='agrlis' || datos[0]['value']=='edilis' || datos[0]['value']=='elilis'){
          li_listas(datos[1]['value']);
        }

      }else{
        $("#d_frespuestap").html(a.m);
        $("#b_guardarp").removeClass("hidden");
      }
    }
  });
})

function f_eleccionco(acc,v1,v2){
    $("#m_tamano").removeClass('modal-lg');
    switch(acc) {
        case 'verres':
          var mt="<span class='text-muted'><i class='fa fa-pie-chart text-yellow'></i> Ver resultados</span>";
          $("#m_tamano").addClass('modal-lg');
          break;
    }
    $(".titulo").html(mt);
    $("#m_modal").modal("show");
  
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_elecciones/f_celeccion.php",
      data: {acc: acc, v1: v1, v2: v2},
      dataType: "html",
      beforeSend: function () {
        $("#f_modal").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
        $("#b_guardar").addClass("hidden");
      },
      success:function(a){
        $("#f_modal").html(a);
        if(acc!='verres'){
          $("#b_guardar").removeClass("hidden");
        }
        
      }
    });
}

function relecciones(id){
  window.open("m_exportar/relecciones.php?eleccion="+id, '_blank');
}