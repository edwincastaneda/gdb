<?php 

function host_url($f) { 
	$server = $_SERVER['SERVER_NAME'];
    echo "http://".$server ."/".$f."/"; 
} 

function filtroColumnas($columnas) { 
$retorna='<script type="text/javascript">
    function verificaSeleccion(){       
            ';
        for($i=0;$i<=$columnas;$i++){
        $retorna.='if($("#i'.$i.'").is(":checked")) {
                 $(".head-'.$i.'").show();
                 $(".column-'.$i.'").show(); 
              }else{
                 $(".head-'.$i.'").hide();
                 $(".column-'.$i.'").hide(); 
              }
              
              ';
        }
$retorna.="};    

 $(document).ready( function () {
            verificaSeleccion();
            ";
$retorna.="$('input:checkbox[id^=".Chr(34)."i".Chr(34)."]').click(function() {  
          verificaSeleccion(); 
            })
    })
$(document).on( 'click', '.pagination', function() {    
verificaSeleccion();
//alert('ddd');
});
</script>";

echo $retorna;
}


?>