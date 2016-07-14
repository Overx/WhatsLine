// URL BASE
function baseUrl(){
	return $('#j_urlBase').attr('url-base');
}

// Carregando Spinners
function loadSpinners(id){
	$(id).addClass('whirl traditional');
}

// Remove Spinners
function removeSpinners(id){
	setInterval(function(){ $(id).removeClass('whirl traditional'); }, 2000);	
}

function telefoneCelular(v){
	v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
	v=v.replace(/^\d{2}(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
	v=v.replace(/(\d{5})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
	return v
}

function telefoneFixo(v){
	v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
	v=v.replace(/^\d{2}(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
	v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
	return v
}