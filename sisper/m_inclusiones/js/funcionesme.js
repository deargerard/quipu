$("#p_personal").on("click",function(e){
	$.ajax({
		type:"post",
		url:"m_vistas/p_personal.php",
		beforeSend: function () {
                $("#ConPage").html("<img scr='m_images/cargando.gif'>");
        },
		success:function(a){
			$("#ConPage").html(a);
			$("#p_personal").addClass("active");
		}
	});
});

/*******/
$('#cumples').slimScroll({
    height: '330px'
});
