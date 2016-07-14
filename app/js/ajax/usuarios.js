(function(window, document, $, undefined){
	/* CARREGANDO ENDEREÇO PELO CEP ************************************************/
	$("#cep").change(function(){
      var cep_code = $(this).val();
      if( cep_code.length <= 0 ) return;
      $.get("http://apps.widenet.com.br/busca-cep/api/cep.json", { code: cep_code },
         function(result){
            if( result.status!=1 ){
               noty_error("Cep não encontrado!");
               return;
            }
            $("input#cep").empty().val( result.code );
            $("input#estado").empty().val( result.state );
            $("input#cidade").empty().val( result.city );
            $("input#bairro").empty().val( result.district );
            $("input#endereco").empty().val( result.address );
            $("input#estado").empty().val( result.state );
         });
   });

	$(document).on('submit', '#j_novo_usuario', function(){
		var options = { 
	        url: 	baseUrl() + 'admin/registrar-usuario',  
	        type: 	'post', 
	        beforeSubmit:  function(){
	        	loadSpinners('#j_painel');
	        }, 
	        success:       function(e){
	        	removeSpinners('#j_painel');
	       
	        	if(e === 'sucesso')
	        	{
	        		noty_success("Novo usuário criado com sucesso!", true);
	        	}else if(e === 'camposvazio'){
	        		noty_default("Desculpe! Você deve preencher todos os campos");
	        	}else if(e === 'existecpf'){
	        		noty_default("Já existe um CPF semelhante cadastrado em nosso banco de dados!");
	        	}else if(e === 'existeemail'){
	        		noty_default("Já existe um E-mail semelhante cadastrado em nosso banco de dados!");
	        	}else if(e === 'cpfinvalido'){
	        		noty_default("O CPF digitado é invalido. Verifique!");
	        	}else if(e === 'senhanaoconfere'){
	        		noty_default("Senha digitada não confere!");
	        	}else if(e === 'aceitartermos'){
	        		noty_default("Você precisa aceitar todos os termos!");
	        	}else if(e === 'erro'){
	        		noty_error("Ocorreu um erro ao cadastrar!");
	        	}
	        	
	        	//$("#debug").html(e);
	        }  
	    }; 
 
    	$(this).ajaxSubmit(options); 

		return false;
	});

	$(document).on('submit', '#j_editar_usuario', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'admin/update-profile',
			type: 'post',
			success: function(e){	
			
				if(e === 'sucesso'){
					noty_success("Usuário atualizado com sucesso.", true, 2000);					
				}else if(e === 'camposvazio'){
					noty_default("Desculpe! os campos não podem ficar vazio");
				}else if(e === 'existecpf'){
	        		noty_default("Já existe um CPF semelhante cadastrado em nosso banco de dados!");
	        	}		
	        	
				//$("#debug").html(e);			
			}
		});
		return false;		
	});

	

	// EXCLUINDO USUÁRIO ************************************************************************************/
	$(document).on('click', '.j_excluir', function(){
		$('.j_excluir_user').attr("id", $(this).attr("id"));

		$("#excluirUsuario").modal("show");
		return false;
	});

	$(document).on('click', '.j_excluir_user', function(){
		var id = $(this).attr("id");	
		$.ajax({
			url: baseUrl() + 'admin/delete-user/' + id,
			type: 'get',
			success: function(e){
				if(e === 'sucesso'){
					noty_success("Usuário deletado com sucesso.", true, 2000);					
				}else if(e === 'ultimousuario'){
					noty_default("Desculpe! Você não pode deletar o ultimo usuário");
				}
			}
		});
		return false;
	});

	// MUDANDO STATUS DO USUÁRIO SE VAI PARA O SITE OU NÃO **************************************************/
	$(document).on('change', '#chk-mark', function() {
		var id = $(this).attr('data-id');
		var returnVal;

        if($(this).is(":checked")) {
            returnVal = 1;	            
        }else{
        	returnVal = 0;	
        }   

        $.ajax({
			url: baseUrl() + 'admin/status/user/' + returnVal + '/' + id,
			type: 'get',
			success: function(e){					
				if(e === 'sucesso'){
					noty_success("Esse usuário foi ativo para o site", true, 2000);					
				}
			}
		});
		return false;	          
    }); // FIM


		
})(window, document, window.jQuery);