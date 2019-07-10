// FUNCION BUSCAR DOCUMENTOS
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
// FIN FUNCION BUSCAR DOCUMENTOS
//BOTON LLAMA A LA FUNCIÓN DOCUMENTOS
$("#b_bdoc").click(function(){
  var doc=$("#numdoc").val();
  var ano=$("#dano").val();
  if (doc==null && ano==null){
    alert("Debe elegir numero de documento y año");
  }else {
    bdoc(doc, ano);
  }
})
// FIN BOTON LLAMA A LA FUNCIÓN DOCUMENTOS