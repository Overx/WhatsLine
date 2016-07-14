$(function(){

	// MASKED
    // ----------------------------------- 

    $('[data-masked]').inputmask();

	/** LOGIN ***************************************************************************************************/
	$(document).on('submit', '#j_login', function(){
		var options = { 
	        url: 	baseUrl() + 'login',  
	        type: 	'post', 
	        beforeSubmit:  function(){
	        	loadSpinners('#j_painel');
	        }, 
	        success:       function(e){
	        	removeSpinners('#j_painel');
	        	
	        	if(e === 'sucesso')
	        	{
	        		$('#noty').empty().html('<div role="alert" class="alert alert-success">Aguarde... iremos redirecioná-lo!</div>');
	        		$(location).attr('href', baseUrl() + 'checkout');
	        	}
	        	else if(e === 'error')
	        	{
	        		$('#noty').empty().html('<div role="alert" class="alert alert-danger">Ops! Ocorreu um erro! Verifique suas credenciais</div>');
	        	}
	        	
	        	//$("#debug").html(e);
	        }  
	    }; 
 
    	$(this).ajaxSubmit(options); 
    	return false;
	});

	$(document).on('submit', '#j_registrar', function(){
		var options = { 
	        url: 	baseUrl() + 'register/user',  
	        type: 	'get', 
	        beforeSubmit:  function(){
	        	loadSpinners('#j_painel');
	        }, 
	        success:       function(e){
	        	removeSpinners('#j_painel');
	        
	        	if(e === 'sucesso')
	        	{
	        		noty_success("Sua conta foi criada com sucesso!", true);
	        		$(location).attr('href', baseUrl() + 'checkout');

	        	}else if(e === 'camposvazio'){
	        		noty_default("Desculpe! Você deve preencher todos os campos");
	        	}else if(e === 'existecpf'){
	        		noty_default("Já existe um CPF semelhante cadastrado em nosso banco de dados!");
	        	}else if(e === 'existeemail'){
	        		noty_default("Já existe um E-mail semelhante cadastrado em nosso banco de dados!");
	        	}else if(e === 'senhanaoconfere'){
	        		noty_default("Senha digitada não confere!");
	        	}else if(e === 'aceitartermos'){
	        		noty_default("Você precisa aceitar todos os termos!");
	        	}else if(e === 'erro'){
	        		noty_error("Ocorreu um erro ao cadastrar!");
	        	}
	        	
	        	//$("#debug").html(e);
	        },
            error: function(jqXHR, textStatus, errorThrown) {
                noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
                removeSpinners('#j_painel');
                console.log(jqXHR, textStatus, errorThrown);
            }  
	    }; 
 
    	$(this).ajaxSubmit(options); 

		return false;
	});



});