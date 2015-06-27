$(document).ready(function(){

	//SELECT DE TIPO SERVIDOR
	$("#tipo").change(function(){
            if($("#tipo").val()!=1 && $("#tipo").val()!=3){
                    $("#facilitador").show();
            }else{
                    $("#facilitador").hide();
                    $('#id_facilitador').val('0');
                    $('#nombre_facilitador').val('');
            }
	});
	if($("#tipo").val()==1 || $("#tipo").val()==3){
		$("#facilitador").hide();
	}
	
	//MODAL DE FACILITADORES
	$(document).on( "click", "a.seleccionar_facilitador", function() {
	var datos_facilitador=$("input", this).val();
	var elem = datos_facilitador.split('|');
	$('#id_facilitador').val(elem[0]);
	$('#nombre_facilitador').val(elem[0]+" - "+elem[1]);
	$('#nombre_lider').val('');
	$('#id_lider').val('');
	$('#facilitadoresModal').modal('hide');
	getLideres();
	});
	
	//MODAL DE LIDERES
	$(document).on( "click", "#seleccionar_lider", function() {


	var selected = [];
	$('div#chkbox_lideres input[type=checkbox]').each(function() {
	   if ($(this).is(":checked")) {
		   selected.push($(this).attr('name'));
	   }
	   
	});
	var id_lider = [];
	var nombre_lider = [];
	for (var i=0; i<selected.length; i++) { 
		elem = selected[i].split('|');	
		id_lider.push(elem[0]);
		nombre_lider.push(elem[0]+" - "+elem[1]);
	}
	$('#id_lider').val(id_lider);
	//$('#nombre_lider').val(nombre_lider.toString().replace("," , ", "));
	$('#nombre_lider').val(nombre_lider.toString().replace(/,/g , ", "));
	
	
	$('#lideresModal').modal('hide');
	});
        
        //MODAL DE GRUPOS 
	$(document).on( "click", "a.seleccionar_grupo", function() {
            var datos_grupo=$("input", this).val();
            var elem = datos_grupo.split('|');
            $('#id_grupo').val(elem[0]);
            $('#anfitrion').val(elem[1]);
            $('#lider').val(elem[2]);
            $('#dia').val(elem[3]);
            $('#horario').val(elem[4]);
			$('#tipo').val(elem[5]);
            $('#gruposModalLoad').modal('hide');
			$('#gruposTodosModal').modal('hide');
            afterSelectGrupo();
	});
        afterSelectGrupo();
        
	//CARGAR TABLA DE LIDERES EN MODAL
	function getLideres(){
	$('#boton-select-lider').removeAttr('disabled');
            $.post( "../libs/catalogos/getLideres.php", { 
			id_facilitador: $("#id_facilitador").val(),
			selected: $("#id_lider").val()
			})
                .done(function( data ) {
                      $("#body-modal-lideres").html(data);
                      recargarDataTable();
                });
	}
        
        if($('#nombre_lider').val()!=""){
            $('#boton-select-lider').removeAttr('disabled');
            getLideres();
        }

	//SELECT DE GRUPO
        function afterSelectGrupo(){
            if($("#id_grupo").val()!=""){
                $(".info-grupo").show();
            }else{
                $(".info-grupo").hide();
            }
        }
	
	
	
	function recargarDataTable(){
	$('.datosModal').DataTable( {
        language: {
            url: '../libs/es_ES.txt'
        }
		} );
	}
	
	//CARGA MODAL DE GRUPOS
	$(document).on( "click", "#mostrar-modal-grupo", function() {
		$.post( "../libs/catalogos/getGrupos.php", { id_grupo: $(this).val()})
		.done(function( data ) {
			  $("#body-modal-grupos").html(data);
			  recargarDataTable();
		});
		$('#gruposModal').modal('show');
	});

	
	
});



