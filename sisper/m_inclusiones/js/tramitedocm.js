// FUNCION BUSCAR DOCUMENTO EN UN AÑO
function bdoc(doc, ano){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/bdocxano.php",
    data: {doc : doc , ano : ano},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep1").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
    },
    success:function(a){      
      $("#r_rep1").html(a);      
    }
  });
}
// FIN FUNCION BUSCAR DOCUMENTO EN UN AÑO
//BOTON LLAMA A LA FUNCIÓN DOCUMENTO EN UN AÑO
$("#b_bdoc").click(function(){
  var doc=$("#numseg").val();
  var ano=$("#sano").val();
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
      $("#r_rep2").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
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
      $("#r_rep3").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
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
function bdpen(mp, est, vig){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/bdocpenxmp.php",
    data: {mp : mp, est : est, vig : vig},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep4").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
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
  var est=$("#estp").val();
  var vig=$("#vigp").val();

    bdpen(mp, est, vig);
  
})
// FIN BOTON LLAMA A LA FUNCIÓN DOCUMENTOS PENDIENTES POR MESA DE PARTES


// FUNCION BUSCAR DOCUMENTO POR DATOS
function bdocd(ndoc, ano, tip, per, dext, dint){
  
  $.ajax({
    type: "post",
    url: "m_inclusiones/a_tdocumentario/bdocxdat.php",
    data: {ndoc : ndoc , ano : ano , tip : tip, per : per, dext : dext , dint : dint},
    dataType: "html",
    beforeSend: function () {
      $("#r_rep5").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
    },
    success:function(a){      
      $("#r_rep5").html(a);      
    }
  });
}
// FIN FUNCION BUSCAR DOCUMENTO POR DATOS
//BOTON LLAMA A LA FUNCIÓN DOCUMENTO POR DATOS
$("#b_bdocb").click(function(){
  var ndoc=$("#numdoc").val();
  var ano=$("#dano").val();
  var tip=$("#tip").val();
  var per=$("#per1").val();
  var dext=$("#dext").val();
  var dint=$("#per1").val();
  
  bdocd(ndoc, ano, tip, per, dext, dint);
    
})
// FIN BOTON LLAMA A LA FUNCIÓN DOCUMENTO POR DATOS

$("#per1").select2({
  placeholder: 'Selecione un Personal',
  ajax: {
    url: 'm_inclusiones/a_general/a_selpersonal.php',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
      return {
        results: data
      };
    },
    cache: true
  },
  minimumInputLength: 2
})