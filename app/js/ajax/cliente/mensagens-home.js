(function(window, document, $, undefined){
	
	$(function(){
		/**
		* Excluir Mensagens
		* Função para excluir todas as mensagens
		*/
		$(document).on('click', '.j_delete_accept_messages', function(){
			$.ajax({
				url: baseUrl() + 'cliente/excluir/mensagens/',
				type: 'get',
				success: function(e){
					if(e === 'sucesso')
					{
						noty_success("Todas as mensagens foram excluidas com sucesso!", true);
					}else{
						noty_erro("Desculpe! Ocorreu um erro no sistema fale com o administrador");
					}
				}
			});
			return false;
		});



		
		/*
		Listen();

		function Listen()
	    {
	        $.ajax({
	            url: baseUrl() + 'cliente/read/graph/message',
	            cache: false,
	            timeout: 70000,
	            dataType: "json",
	            method: "get"            
	        }).done(function(e) { 
	        	$("#j_graph_messages").html('<canvas data-classyloader="" data-percentage="'+e.total+'" data-speed="20" data-font-size="40px" data-diameter="80" data-line-color="#048904" data-remaining-line-color="rgba(200,200,200,0.4)" data-line-width="10" data-rounded-line="true" class="center-block"></canvas>');
				$(".text-dark").html(e.done + ' de ' + e.all);
				console.log(e);

				var $scroller       = $(window),
	        	inViewFlagClass = 'js-is-in-view'; 

	    		$('[data-classyloader]').each(initClassyLoader);
	        }).always(function() { 
	            setTimeout(function() {
	                Listen(false)
	            }, 1000);
	        });
	    }
	    */


	
		Listen();

		function Listen()
	    {
	        $.ajax({
	            url: baseUrl() + 'cliente/read/graph/message',
	            cache: false,
	            dataType: "json",
	            timeout: 70000,
	            method: "get",
		        beforeSend: function() {
			       $('#j_load').addClass('whirl line grow ');
			    }            
	        }).done(function(e) { 
	        	$('#j_load').removeClass('whirl line grow ');

				$("#j_graph_messages").html('<canvas data-classyloader="" data-percentage="'+e.total+'" data-speed="20" data-font-size="40px" data-diameter="80" data-line-color="#048904" data-remaining-line-color="rgba(200,200,200,0.4)" data-line-width="10" data-rounded-line="true" class="center-block"></canvas>');
				$(".text-dark").html(e.done + ' de ' + e.all);
				//console.log(e);

				var $scroller       = $(window),
	        	inViewFlagClass = 'js-is-in-view'; 

	    		$('[data-classyloader]').each(initClassyLoader);

	    		function initClassyLoader() {
	    
			      var $element = $(this),
			          options  = $element.data();
			      
			      // At lease we need a data-percentage attribute
			      if(options) {
			        if( options.triggerInView ) {

			          $scroller.scroll(function() {
			            checkLoaderInVIew($element, options);
			          });
			          // if the element starts already in view
			          checkLoaderInVIew($element, options);
			        }
			        else
			          startLoader($element, options);
			      }
			    }

			    function checkLoaderInVIew(element, options) {
			      var offset = -20;
			      if( ! element.hasClass(inViewFlagClass) &&
			          $.Utils.isInView(element, {topoffset: offset}) ) {
			        startLoader(element, options);
			      }
			    }
			    
			    function startLoader(element, options) {
			      element.ClassyLoader(options).addClass(inViewFlagClass);
			    }

	        }).always(function() { 
	        	$('#j_load').removeClass('whirl line grow ');

	            setTimeout(function() {
	                Listen(false)
	            }, 9000);
	        });
	    }
	   








		
	    
	    



	});    





})(window, document, window.jQuery);