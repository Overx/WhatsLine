(function(window, document, $, undefined){

	$('#j_number').mask("(99) 9999-9999?9").ready(function(event) {
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

	$('#j_add_new_number').mask("(99) 9999-9999?9").ready(function(event) {
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
	
	$("#j_contato_cel").inputmask('(99) 9999-9999');

	/* Update informações */
	$(document).on('submit', '#j_add_number', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/save/settings',
			type: 'get',
			success: function(e){
				if(e === 'sucesso'){
					noty_success("Numero cadastrado com sucesso!", true, 2000);					
				}else if(e === 'camposvazio'){
					noty_default("Desculpe! os campos não podem ficar vazio");
				}else if(e === 'quantidademaxima'){
					noty_error("Você atingiu a quantidade Máxima de numeros! Atualize os existentes");
				}				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
	           	console.log(jqXHR, textStatus, errorThrown);
	        }
		});
		return false;
	});

	/* Update informações */
	$(document).on('submit', '#j_update_dados', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/update/settings',
			type: 'post',
			success: function(e){
				if(e === 'sucesso'){
					noty_success("Configurações atualizadas com sucesso!", true, 2000);					
				}else if(e === 'camposvazio'){
					noty_default("Desculpe! os campos não podem ficar vazio");
				}else if(e === 'arquivogrande'){
	        		noty_default("Esse arquivo é muito grande, pegue um menor, desculpe!");
	        	}				
				//$("#debug").html(e);				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
	           	console.log(jqXHR, textStatus, errorThrown);
	        }
		});
		return false;
	});

	/* Update vCard */
	$(document).on('submit', '#j_update_vcard', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/update/vcard',
			type: 'post',
			success: function(e){
				if(e === 'sucesso'){
					noty_success("vCard Atualizado com sucesso!", true, 2000);					
				}else if(e === 'arquivogrande'){
					noty_default("Arquivo muito grande demais...");
				}
				//$("#debug").html(e);				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
	           	console.log(jqXHR, textStatus, errorThrown);
	        }
		});
		return false;
	});

	/* Registrar numero */
	$(document).on('submit', '#j_register_number', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/register/number',
			type: 'get',
			success: function(e){
				if(e === 'sucesso'){
					noty_success("Numero registrado com sucesso!", true, 2000);					
				}else if(e === 'aguardandocodigo'){
					noty_default("Código enviado para seu celular, aguardando o código para finalizar...");
				}
				//$("#debug").html(e);				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				noty_error("Ocorreu um erro no servidor, verifique o numero digitado.");
				$('#j_contato_editar').removeClass('whirl traditional');
	           	console.log(textStatus, errorThrown);
	        }
		});
		return false;
	});


	/* Alterar Status */
	$(document).on('click', '.j_change_status', function(){
		var id = $(this).attr("id");
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/active/settings/' + id,
			type: 'get',
			success: function(e){
				if(e === 'sucesso'){
					noty_success("Numero Ativado com sucesso!", true, 2000);					
				}			
			},
			error: function(jqXHR, textStatus, errorThrown) {
				noty_error("Ocorreu um erro no servidor, verifique o numero digitado.");
				$('#j_contato_editar').removeClass('whirl traditional');
	           	console.log(textStatus, errorThrown);
	        }
		});
		return false;
	});



	CheckNumber();
	function CheckNumber()
	{
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/check/number',
			type: 'get',
			beforeSubmit: function(){
				$('#j_load').addClass('whirl traditional');
			},
			success: function(e){
				window.setTimeout(function () {					
					$('#j_load').removeClass('whirl traditional');

					if(e === 'blocked'){

						$("#j_contato_cel").css({
							"background-color": "red", 
							color: "white"
						});
						$("#j_triangle").css({ color: "red"});
						$("#j_button_number").attr("data-content", "Esse numero foi bloqueado!");
					}

				}, 1000);				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
				$('#j_load').removeClass('whirl traditional');
	           	console.log(jqXHR, textStatus, errorThrown);
	        }
		});
		return false;
	}


})(window, document, window.jQuery);