(function(window, document, $, undefined){
	
	$(document).on('submit', '#j_nova_mensagem', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'admin/whatsapp/nova/mensagem',
			type: 'get',
			success: function(e){				
				$('#debug').html(e);				
			}
		});
		return false;
	}); // FIM CADASTRO

})(window, document, window.jQuery);