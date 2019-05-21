function f_bandeja(acc,v1,v2){
    $("#m_tamano").removeClass('modal-lg');
    switch(acc) {
        case 'agrdoc':
            var mt="<span class='text-muted'><i class='fa fa-plus text-orange'></i> Agregar Documento</span>";
            $(".modal-dialog").addClass('modal-lg');
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
        $("#b_guardar").removeClass("hidden");
      }
    });
}

function li_bandeja(){
    $.ajax({
      type: "post",
      url: "m_inclusiones/a_tdocumentario/li_bandeja.php",
      dataType: "html",
      beforeSend: function () {
        $("#r_ban1").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
      },
      success:function(a){
        $("#r_ban1").html(a);
      }
    });
}