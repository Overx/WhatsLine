(function(window, document, $, undefined){
	
	$('#datetimepicker1').datetimepicker({
      icons: {
          time: 'fa fa-clock-o',
          date: 'fa fa-calendar',
          up: 'fa fa-chevron-up',
          down: 'fa fa-chevron-down',
          previous: 'fa fa-chevron-left',
          next: 'fa fa-chevron-right',
          today: 'fa fa-crosshairs',
          clear: 'fa fa-trash'
        },
        format: 'DD/MM/YYYY HH:mm:ss'
    });

    $('.chosen-select').chosen();


    $('#j_type_message').on('change', function (e) {
	    var optionSelected = $("option:selected", this);
	    var valueSelected  = this.value;
	    if(valueSelected === 'locationname')
	    {
	    	$("#j_message").hide();
	    	$("#j_midia").hide();
	    	$("#j_location").fadeIn();
	    	$('#vcard').hide();
	    }else if(valueSelected === 'image' || valueSelected === 'audio' || valueSelected === 'video'){
	    	$("#j_location").hide();
	    	$("#j_message").hide();
	    	$('#vcard').hide();
	    	$("#j_midia").fadeIn();
	    }else if(valueSelected === 'message'){
	    	$("#j_location").hide();
	    	$("#j_message").hide();
	    	$("#j_midia").hide();
	    	$('#vcard').hide();
	    	$("#j_message").show();
	    }else if(valueSelected === 'vcard'){
	    	$("#j_location").hide();
	    	$("#j_message").hide();
	    	$("#j_midia").hide();
	    	$("#j_message").hide();
	    	$("#vcard").fadeIn();
	    	readVCard();
	    }
	});

	function readVCard()
	{
		$('#vcard').empty();
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/read/vcard',
			type: 'get',
			dataType: 'json',
			beforeSubmit: function(){
				$('#j_load').addClass('whirl traditional');
			},
			success: function(e){
				window.setTimeout(function () {					
					$('#j_load').removeClass('whirl traditional');
					$('#vcard').html('<div class="row row-table"><div class="col-xs-6 text-center"><img src="'+ baseUrl() +'/uploads/'+e.vcard_photo+'" alt="Image" class="img-circle thumb96"></div><div class="col-xs-6"><h3 class="mt0">'+e.vcard_company+'</h3><ul class="list-unstyled"><li class="mb-sm"><em class="fa fa-map-marker fa-fw"></em>'+e.vcard_work_extended_address+'</li><li class="mb-sm"><em class="fa fa-whatsapp fa-fw"></em>'+e.vcard_cell_tel+'</li><li class="mb-sm"><em class="fa fa-envelope fa-fw"></em>'+e.vcard_email1+'</li></ul></div></div>');
					//console.log(e);
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

	$('#j_select_contact').on('change', function (e) {
		if($(this).is(':checked'))
        {
        	$("#j_contact").attr("disabled", "disabled").trigger("chosen:updated");
        }else{
        	$("#j_contact").removeAttr("disabled").trigger("chosen:updated");
        }	
	});

	/**
	* Nova Mensagem
	* Envio de nova mensagem
	*
	* @return
	*/
	$(document).on('submit', '#j_nova_mensagem', function(){
		$(this).ajaxSubmit({
			url: baseUrl() + 'cliente/enviar/nova/mensagem',
			type: 'post',			
			beforeSubmit: function(){
				$('#j_load').addClass('whirl traditional');
			},
			uploadProgress: function(evento, posicao, total, completo){
				$('#progresso').html('<div class="progress-xs"><div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="'+completo+'" aria-valuemin="0" aria-valuemax="100" style="width: '+completo+'%;"><span class="sr-only">'+completo+'% Completo</span></div></div>');
			},
			success: function(e){
				window.setTimeout(function () {
					
					$('#j_load').removeClass('whirl traditional');
					
					if(e === 'sucesso'){
						noty_success("Mensagem carregada com sucesso!", true);
					}else if(e === 'erroupload'){
						noty_default("Desculpe! Ocorreu um erro ao enviar seu arquivo, verifique o tamanho permitido ou o formato!");
					}else if(e === 'formatoinvalido'){
						noty_default("Desculpe! Você está enviando um arquivo de formato invalido!");
					}
					
					
					//$("#debug").html(e);
				}, 1000);				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				noty_error("Ocorreu um erro no servidor, tente novamente mais tarde.");
				$('#j_load').removeClass('whirl traditional');
	           	console.log(jqXHR, textStatus, errorThrown);
	        }
		});
		return false;
	}); 
	










})(window, document, window.jQuery);