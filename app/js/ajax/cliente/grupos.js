(function(window, document, $, undefined){

	$('.chosen-select').chosen();

	$(document).on('submit', '#j_add_group', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/add/group',
			type: 'post',
			success: function(e){				
				if(e === 'sucesso'){
					noty_success("Grupo criado com sucesso!", true);
				}else if(e === 'arquivogrande'){
					noty_default("Arquivo enviado é muito grande");
				}				
			}
		});
		return false;
	});


	$(document).on('click', '.j_delete', function(){
		var id = $(this).attr("id");

		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/delete/group/' + id,
			type: 'get',
			success: function(e){				
				alert(e);			
			}
		});
		return false;
	});
	
	/*
	var conn = new WebSocket('ws://localhost:8080');
	conn.onopen = function(e) {
    	console.log("Connection established! ");
	}

	conn.onmessage = function(e){
		console.log('Mensagem: ' + e.data);
	}

	$(document).on('click', '.send', function(){
		var data = '' + Math.random();
		conn.send(data);
		console.log('Mensagem: ' + data);
	});
	*/


})(window, document, window.jQuery);