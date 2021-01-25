<?php
session_start();
include ("m_inclusiones/php/conexion_sp.php");
include ("m_inclusiones/php/funciones.php");
if(vacceso($cone,$_SESSION['identi'],$_SESSION['docide'],$_SESSION['nomusu'])){
  $tit="Inicio";
  include("m_estructura/e_up.php");
  include("m_vistas/dboard.php");
  include("m_estructura/e_down.php");
  $ce=mysqli_query($cone, "SELECT * FROM elecciones WHERE estado=1 AND (now() BETWEEN inicio AND fin);");
  if(mysqli_num_rows($ce)>0){
    while($re=mysqli_fetch_assoc($ce)){
       $id=$re['id'];
?>
		<script>
                  $('#f_elecciones<?php echo $id ?>').submit(function(e){
                    e.preventDefault();
                    var datos = $(this).serializeArray();
                    $.ajax({
                      type: "post",
                      url: "m_inclusiones/a_elecciones/g_votos.php",
                      data: datos,
                      dataType: "json",
                      beforeSend: function(){
                        $("#r_votos<?php echo $id ?>").html("<h4 class='text-center text-gray'><i class='fa fa-spinner fa-spin'></i></h4>");
                        $("#b_votar<?php echo $id ?>").addClass("hidden");
                      },
                      success:function(a){
                        if(a.e){
                          
                          $("#relecciones<?php echo $id ?>").html(a.m);          

                        }else{
                          $("#r_votos<?php echo $id ?>").html(a.m);
                          $("#b_votar<?php echo $id ?>").removeClass("hidden");
                        }
                      }
                    });
                  })
                </script>
<?php
     }
  }
  mysqli_free_result($ce);
  mysqli_close($cone);
}else{
  header('Location: index.php');
}
?>