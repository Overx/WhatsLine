(function(window, document, $, undefined){

	/* Busca por nome e telefone */
	$(document).on('keyup', '#j_search', function(){
		var search_term = $(this).val();
		console.log(search_term);
		if( search_term === '')
		{
			ReadContactsChat();
		}else{
			$('#search_results').empty();

			$.get(baseUrl() + 'cliente/search/userlist', { search_term: search_term }, function(data){
				$.each(data, function(key, value) {
	            	$('#search_results').append('<a data-id="'+value.con_number+'" href="" class="j_contatcs_selected"><li id="angle-item" class="level-1"><img src="'+baseUrl()+'/app/img/user/02.jpg" alt="" width="32" height="32" class="img-thumbnail img-circle"><span>'+value.con_name+'</span> </li></a>');                       
	            });
				
				//console.log(data);
			});		
		}		
	});

	/* Scrolll Bottom */
	function scrollBottom()
    {
        var d = $('#j_message_send');
            d.scrollTop(d.prop("scrollHeight"));
    }

	ReadContactsChat();

	/* Lendo contatos */
	function ReadContactsChat()
	{
		$('#search_results').empty();

		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/read/contacts/',
			type: 'get',
			dataType: 'json',
			beforeSubmit: function(){
				$('#j_load_contacts').addClass('whirl traditional');
			},
			success: function(data){
				//scrollBottom();
				window.setTimeout(function () {
					$('#j_load_contacts').removeClass('whirl traditional');

					//<div class="label label-success pull-right" style="margin-top: 7px;">10</div>
					if(data.length > 0){
						$.each(data, function(key, value) {
							var label;
							if(value.total > 0){
								label = '<div class="label label-success pull-right" style="margin-top: 7px;">'+value.total+'</div>';
							}else{
								label = '';
							}

			            	$('#search_results').append('<a data-id="'+value.con_number+'" href="" class="j_contatcs_selected"><li id="angle-item" class="level-1"><img src="'+baseUrl()+'/app/img/user/02.jpg" alt="" width="32" height="32" class="img-thumbnail img-circle"><span>'+value.con_name+'</span> '+label+' </li></a>');                       
			            });
					}
						
				}, 1000);
			},
            error: function(jqXHR, textStatus, errorThrown) {
                $('#j_load_contacts').removeClass('whirl traditional');
                console.log(textStatus, errorThrown);
            }
		});
	}

	$(document).on('click', '.j_contatcs_selected', function(){
		var IdPage = $(this).attr("data-id");
		$('.j_send_message').attr("id", IdPage);
		ReadMessages(IdPage); // Lendo mensagens
		return false;
	});


	//ReadMessages(IdPage); // Lendo mensagens
    $('#j_message_send').empty();
	
	function ReadMessages(IdPage)
    {
    	$('#j_message_send').empty();

        $(this).ajaxSubmit({
            url: baseUrl() + 'cliente/read/message/chat/' + IdPage,
            method: "get", 
            dataType: 'json',
            beforeSubmit: function(){
				$('#j_load_messages').addClass('whirl traditional');
			},
            success: function(data){  
            	window.setTimeout(function () {
					$('#j_load_messages').removeClass('whirl traditional');
	            	  
	            	//console.log(data);
	            	$.each(data, function(key, value) {
		                if(value.message_type !== null){
		            		var content;

		                	if(value.message_type === 'message'){
		                		content = value.message_content;
		                	}

		                    if(value.message_from === ''){
		                        $('#j_message_send').append('<div class="message right"><div class="message-text">'+content+'</div><img src="'+baseUrl()+'/app/img/user/02.jpg" class="user-picture" alt=""></div>');
		                    }else{
		                        $('#j_message_send').append('<div class="message left"><div class="message-text">'+content+'</div><img src="'+baseUrl()+'/app/img/user/02.jpg" class="user-picture" alt=""></div>');
		                    }  
		            	}  
		            });

		            $("#j_message_send").animate({ scrollTop: $('#j_message_send').prop("scrollHeight")}, 1000);
     			}, 1000);
            }        
        });
    }

    //Listen(true);

    /* Listen */
	function Listen(bool)
    {
    	if(bool === true){
	        $.ajax({
	            url: baseUrl() + 'cliente/checkMessages',
	            cache: false,
	            dataType: "html",
	            timeout: 8000,
	            method: "post"
	        }).done(function(data) { // on success, you can get the parameter as "data".
	        	console.log('Listem');
	        }).always(function() { //if DONE is used, the service is stopped in case of failure of connection.
	            setTimeout(function() {
	                Listen(true)
	            }, 8000);
	        });
	    }
    }


    /* Enviar menssage */
    $(document).keypress(function(e) {
    	var id 		= $('.j_send_message').attr("id");
    	var value 	= $('.j_send_message').val();
	    if(e.which == 13){
	    	if(id !== ''){
	    		if(value !== ''){
	    			$(this).ajaxSubmit({
			            url: baseUrl() + 'cliente/send/message/chat/',
			            method: "get", 
			            data: {number: id, message: value},
			            beforeSubmit: function(){
							$('#j_load_composing').addClass('whirl traditional');
						},
			            success: function(e){  
			            	$('#j_load_composing').removeClass('whirl traditional');

			            	if(e === 'sucesso'){
			            		$('.j_send_message').val("");
			            		ReadMessages(id);
			            	}else if(e === 'camposvazio'){
			            		noty_default("Desculpe! o campo não pode ficar vazio");
			            	}
			            },
						error: function(jqXHR, textStatus, errorThrown) {
							$('#j_load_composing').removeClass('whirl traditional');
							noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
				           	console.log(jqXHR, textStatus, errorThrown);
				        }        
			        });
	    		}else{
	    			noty_default("Você precisa escrever algo antes de enviar!");
	    		}
	    	}else{
	    		noty_default("Você precisa selecionar um contato para enviar");
	    	}
	    }
	});











	    

})(window, document, window.jQuery);