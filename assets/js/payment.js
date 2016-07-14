(function(window, document, $, undefined){	
	$(function(){

		function baseUrl()
		{
			return $("#_baseURL").attr("data-url") + "/";
		}

		$(document).on('change', '#_tipop', function() {
			
			var optionSelected = $("option:selected", this);
    		var valueSelected = this.value;

    		if(valueSelected == "avista"){
    			$("#_email_field").fadeIn("slow");
    		}else if(valueSelected == "paypal"){
    			$("#_email_field").fadeOut("slow");
    		}
			return false;	          
	    }); // FIM
		
		$(document).on('change', '#_month', function() {
			$("#_total").empty();

			var optionSelected = $("option:selected", this);
    		var valueSelected = this.value;

    		// Pegar o valor 
    		var str   = $("#_valor").text();
    		var valor = str.replace(',','.');
    		var retorno;

    		if(valueSelected == 30){
    			retorno = valor;
    		}else if(valueSelected == 90){
    			retorno = (valor * 3);
    		}else if(valueSelected == 180){
    			retorno = (valor * 6);
    		}else if(valueSelected == 360){
    			retorno = (valor * 12);
    		}

    		$("#_total").text(Math.ceil(retorno) - 1);
			return false;	          
	    }); // FIM


		$(document).on('click', '#_submit', function(){
			var insid = $("#_insid").val();
			var plano = $("#_plano").val();
			var valor = $("#_total").text();
			var namec = $("#_full_name").val();
			var email = $("#_email").val();
			var tipop = $("#_tipop option:selected").val();
			var prazo = $("#_month option:selected").val();

			$.ajax({
				url: baseUrl() + 'send/payment',
				type: 'get',
				data: { insid: insid, plano: plano, tipop: tipop, valor: valor, prazo: prazo, namec: namec, email: email },
				dataType: 'json',
				beforeSend: function(){
					$('#_load').addClass('whirl traditional');
				},
				success: function(e){
					window.setTimeout(function () {					
						$('#_load').removeClass('whirl traditional');
						
						if(e.status === 'sucesso'){							
							if(e.type === 'paypal'){
								noty_success('Seu Pagamento está sendo processado... ');
								window.setTimeout(function () {	
									window.location.replace(e.url);
								}, 2000);
							}else if(e.type === 'contas'){
								noty_success('Detalhes sobre nossas contas foram enviadas para seu e-mail... ', true);
							}
						}else if(e.status === 'semlogin'){
							noty_default('Você precisa realizar login antes de realizar a compra! ');
						} 

						//$("#debug").html(e);
					}, 1000);				
				},
				error: function(jqXHR, textStatus, errorThrown) {
					noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
					$('#_load').removeClass('whirl traditional');
		           	console.log(jqXHR, textStatus, errorThrown);
		        }
			});
			return false;
		});

		/* */
		$(document).on('click', '#_login', function(){
			$.ajax({
				url: baseUrl() + 'instagram/login',
				type: 'get',				
				beforeSend: function(){
					$('#_login').addClass('whirl traditional');
				},
				success: function(e){
					window.setTimeout(function () {					
						$('#_login').removeClass('whirl traditional');
						
						$("#debug").html(e);
					}, 1000);				
				},
				error: function(jqXHR, textStatus, errorThrown) {
					noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
					$('#_login').removeClass('whirl traditional');
		           	console.log(jqXHR, textStatus, errorThrown);
		        }
			});
		});







	});
})(window, document, window.jQuery);