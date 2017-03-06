$('#misEnlaces').carousel({
	interval: 4000
});

$('#misEnlaces').on('slid.bs.carousel', function() {
	//alert("slid");
});

$('.pscroll').slimScroll({
    height: '220px'
});

$(".dropdown").hover(            
    function() {
        $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("400");
        $(this).toggleClass('open');        
    },
    function() {
        $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("400");
        $(this).toggleClass('open');       
    }
);

function vcomunicado(id){
$.ajax({
  type: "post",
  url: "ajax/a_vcomunicado.php",
  data: { idc : id },
  beforeSend: function () {
    $(".d_rcomunicado").html("<img scr='images/cargando.gif'>");
  },
  success:function(a){
    $(".d_rcomunicado").html(a);
  }
});
}