(function(window, document, $, undefined){
	
	//$("#j_contato_tel").inputmask('(99) 9999-9999');
	//$("#j_contato_cel").inputmask('(99) 9999-9999');

	$('#j_contato_tel').mask("(99) 9999-9999?9").ready(function(event) {
	    var target, phone, element;
	    target 	= (event.currentTarget) ? event.currentTarget : event.srcElement;
	    if(target !== undefined){

		    phone 	= target.value.replace(/\D/g, '');
		    element = $(target);
		    element.unmask();
		    if(phone.length > 10) {
		        element.mask("(99) 99999-999?9");
		    } else {
		        element.mask("(99) 9999-9999?9");  
		    }
		}
	});

	$('#j_contato_cel').mask("(99) 9999-9999?9").ready(function(event) {
	    var target, phone, element;
	    target 	= (event.currentTarget) ? event.currentTarget : event.srcElement;
	    if(target !== undefined){

		    phone 	= target.value.replace(/\D/g, '');
		    element = $(target);
		    element.unmask();
		    if(phone.length > 10) {
		        element.mask("(99) 99999-999?9");
		    } else {
		        element.mask("(99) 9999-9999?9");  
		    }
		}
	});



	/**
	* Upload de CSV
	*
	*/
	$(document).on('submit', '#j_upload', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/agenda/uploadCsv',
			type: 'post',
			beforeSubmit: function(){
				$('#j_contato_editar').addClass('whirl traditional');
			},
			uploadProgress: function(evento, posicao, total, completo){
				$('#progresso').html('<div class="progress-xs"><div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="'+completo+'" aria-valuemin="0" aria-valuemax="100" style="width: '+completo+'%;"><span class="sr-only">'+completo+'% Completo</span></div></div>');
			},
			success: function(e){  
			
				window.setTimeout(function () {
					$('#j_contato_editar').removeClass('whirl traditional');
					
					if(e === 'sucesso')
					{
						noty_success("Contatos enviado com sucesso!", true);
					}else if(e === 'invalido'){
						noty_default("Formato do arquivo não é valido!");
					}
					
					//$('#debug').html(e);   
				}, 1000);
					
				//$('#debug').html(e);        
           },
           error: function(jqXHR, textStatus, errorThrown) {
				noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
				$('#j_contato_editar').removeClass('whirl traditional');
	           	console.log(textStatus, errorThrown);
	        }
       });
		return false;
    });
	

	$(document).on('submit', '#j_novoContato', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/agenda/addContact',
			type: 'get',
			beforeSubmit: function(){
				$('#j_load').addClass('whirl traditional');
			},
			success: function(e){  
			
				window.setTimeout(function () {
					$('#j_load').removeClass('whirl traditional');
					if(e === 'sucesso')
					{
						noty_success("Contato criado com sucesso!", true);
					}else if(e === 'camposvazio'){
						noty_default("Você deve preencher todos os campos");
					}else if(e === 'jaexistenumero'){
						noty_default("Já existe um contato com esse numero.");
					}else if(e === 'noexiste'){
						noty_default("Esse numerõ não é valido!");
					}
				}, 1000);
					
				//$('#debug').html(e);        
           },
			error: function(jqXHR, textStatus, errorThrown) {
				noty_error("Ocorreu um erro.");
				$('#j_load').removeClass('whirl traditional');
	           	console.log(textStatus, errorThrown);
	        }
       });
		return false;
    });



    $(document).on('click', '.j_edt_contato', function(){
		var id = $(this).attr("id");

		$('#con_name').val('');
		$('#con_email').val('');
		$('#con_number').val('');

		$(this).ajaxSubmit({
    		url: baseUrl() + 'cliente/agenda/readContact/' + id,
    		type: 'get',
    		beforeSubmit: function(){
				$('#j_contato_editar_load').addClass('whirl traditional');
			},
    		success: function(e){ 
    			window.setTimeout(function () {  
    				$('#j_contato_editar_load').removeClass('whirl traditional'); 
					$('#con_name').val(e.con_name);                        
					$('#con_email').val(e.con_email);   
					$('.con_number').val(e.con_number); 
					$('#j_id_editar').val(e.con_id);   
				}, 1000);                         
    		}
    	});

    	$("#editarContato").modal();
    	return false;
    });

	$(document).on('submit', '#j_editarContato', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/agenda/updateContact',
			type: 'get',
			success: function(e){  
				if(e === 'sucesso')
				{
					noty_success("Contato atualizado com sucesso!", true);
				}else if(e === 'camposvazio'){
					noty_default("Você deve preencher todos os campos");
				}else{
                   // $('#debug').html(e); 
                }        
           }
        });
		return false;
	});



	$(document).on('click', '.j_del_contato', function(){
		$('.j_excluir_accept').attr("id", $(this).attr("id"));		
    	$("#excluidoContato").modal();
    	return false;
	});

	$(document).on('click', '.j_excluir_accept', function(){
		var id = $(this).attr("id");

    	$(this).ajaxSubmit({
    		url: baseUrl() + 'cliente/agenda/deleteContact/' + id,
    		type: 'get',
    		beforeSubmit: function(){
				$('#j_contato_del_load').addClass('whirl traditional');
			},
    		success: function(e){ 
    			window.setTimeout(function () {  
    				$('#j_contato_del_load').removeClass('whirl traditional');   			
					
    				if(e === 'sucesso')
					{
						noty_success("Contato excluido com sucesso!", true);
					}else if(e === 'camposvazio'){
						noty_default("Você deve preencher todos os campos");
					}
				}, 1000);                         
    		}
    	});
    	return false;
	});
	    

})(window, document, window.jQuery);