// FUNCION BUSCAR DOCUMENTO EN UN AÑO
function bdoc(doc, ano){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/bdocxano.php",
    data: {doc : doc , ano : ano},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep1").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){      
      $("#r_rep1").html(a);      
    }
  });
}
// FIN FUNCION BUSCAR DOCUMENTO EN UN AÑO
//BOTON LLAMA A LA FUNCIÓN DOCUMENTO EN UN AÑO
$("#b_bdoc").click(function(){
  var doc=$("#numdoc").val();
  var ano=$("#dano").val();
  if (doc==null && ano==null){
    alert("Debe elegir numero de documento y año");
  }else {
    bdoc(doc, ano);
  }
})
// FIN BOTON LLAMA A LA FUNCIÓN DOCUMENTO EN UN AÑO

// FUNCION BUSCAR GUIAS
function bgui(gui, ano, mp){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/bguixanoxmp.php",
    data: {gui : gui , ano : ano, mp : mp},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep2").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){      
      $("#r_rep2").html(a);      
    }
  });
}
// FIN FUNCION BUSCAR GUIAS
//BOTON LLAMA A LA FUNCIÓN GUIAS
$("#b_bguia").click(function(){
  var gui=$("#numgui").val();
  var ano=$("#gano").val();
  var mp=$("#mpar").val();

  if (gui==null && ano==null && mp==null){
    alert("Debe elegir numero de guía, año y mesa de partes");
  }else {
    bgui(gui, ano, mp);
  }
})
// FIN BOTON LLAMA A LA FUNCIÓN GUIAS

// FUNCION BUSCAR DOCUMENTOS POR TRABAJADOR
function bperdoc(per, est, vig, fini, ffin){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/bdocxestxfec.php",
    data: {per : per , est : est, vig : vig, fini : fini, ffin : ffin},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep3").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){      
      $("#r_rep3").html(a);      
    }
  });
}
// FIN FUNCION BUSCAR DOCUMENTOS POR TRABAJADOR
//BOTON LLAMA A LA FUNCIÓN DOCUMENTOS POR TRABAJADOR
$("#b_bperdoc").click(function(){
  var per=$("#per").val();
  var est=$("#est").val();
  var vig=$("#vig").val();
  var fini=$("#des").val();
  var ffin=$("#has").val();

    bperdoc(per, est, vig, fini, ffin);
  
})
// FIN BOTON LLAMA A LA FUNCIÓN DOCUMENTOS POR TRABAJADOR

// FUNCION BUSCAR DOCUMENTOS PENDIENTES POR MESA DE PARTES
function bdpen(mp, vig){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/bdocpenxmp.php",
    data: {mp : mp, vig : vig},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep4").html("<img scr='m_images/cargando.gif'>");
    },
    success:function(a){      
      $("#r_rep4").html(a);      
    }
  });
}
// FIN FUNCION BUSCAR DOCUMENTOS PENDIENTES POR MESA DE PARTES
//BOTON LLAMA A LA FUNCIÓN DOCUMENTOS PENDIENTES POR MESA DE PARTES
$("#b_bdpen").click(function(){
  var mp=$("#mparp").val();
  var vig=$("#vigp").val(); 

    bdpen(mp, vig);
  
})
// FIN BOTON LLAMA A LA FUNCIÓN DOCUMENTOS PENDIENTES POR MESA DE PARTES