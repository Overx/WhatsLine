(function(window, document, $, undefined){
	var IdPage = $('.j_atualizar_mensagem').attr('id');
    /**
    * Enviar nova mensagem
    *
    */
	$(document).on('click', '#send-message-button', function(){
		var message = $(this).parent().parent().find('#send-message-input').val();
		var number  = $(this).attr("data-number");

		$.ajax({
			url: baseUrl() + 'cliente/send/message/simple/',
			type: 'get',
			data: { number: number, message: message },
			success: function(e){				
				if(e === 'sucesso'){
                   $('#send-message-input').val(" ");
                    ReadMessages(IdPage); // Lendo mensagens                   
				}
			},
            error: function(jqXHR, textStatus, errorThrown) {
                noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
                $('#j_load').removeClass('whirl traditional');
                console.log(jqXHR, textStatus, errorThrown);
            }
		}); 
		return false;
	});

 

    $(document).on('click', '.j_atualizar_mensagem', function(){
        ReadMessages($(this).attr('id'));
        return false;
    });

   
    ReadMessages(IdPage); // Lendo mensagens
	Listen(true); // Verificando se há novas mensagens

    function ReadMessages(IdPage)
    {

        $('#j_message_send').empty();

        $(this).ajaxSubmit({
            url: baseUrl() + 'cliente/read/message/username/' + IdPage,
            method: "get", 
            dataType: 'json',
            success: function(data){  

                $("#j_message_send").animate({ scrollTop: $('#j_message_send').prop("scrollHeight")}, 1000);  

                $.each(data.messages, function(key, value) {

                    if(value.message_from === ''){
                        $('#j_message_send').append('<div class="message right"><div class="message-text">'+value.message_content+'</div><img src="'+baseUrl()+'/app/img/user/02.jpg" class="user-picture" alt=""></div>');
                    }else{
                        $('#j_message_send').append('<div class="message left"><div class="message-text">'+value.message_content+'</div><img src="'+baseUrl()+'/app/img/user/02.jpg" class="user-picture" alt=""></div>');
                    }                    
                });  

                      
            },
            error: function(jqXHR, textStatus, errorThrown) {
                noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
                $('#j_load').removeClass('whirl traditional');
                console.log(jqXHR, textStatus, errorThrown);
            }          
        });
    }


    /**
    * Enviar nova mensagem
    *
    */
	function Listen(initial)
    {
        $.ajax({
            url: baseUrl() + 'cliente/checkMessages',
            cache: false,
            dataType: "html",
            timeout: 4000,
            method: "post"
        }).done(function(data) { // on success, you can get the parameter as "data".
            console.log(data);
            //write debug info
            //if(data)
            //{
            //    var foo = $("#debug").text();
            //    $("#debug").text(foo + data);
            //}		    
        }).always(function() { //if DONE is used, the service is stopped in case of failure of connection.
            setTimeout(function() {
                Listen(false)
            }, 1000);
        });

    }

})(window, document, window.jQuery);