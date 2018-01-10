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
			$("#b_gnuetel").hide();
		},
		success: function(e){
			if (e.exito) {
				$("#f_natencion").html(e.mensaje);
			}else{
				$("#resultado").html(e.mensaje);
				$("#b_gnuetel").show();
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
}