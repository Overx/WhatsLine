<?php 

get('/', 						'WebSiteController@index');
get('/login', 					'WebSiteController@getLogin');
get('/register', 				'WebSiteController@getRegister');
get('/logout', 					'WebSiteController@getLogout');

// Post
post('/login', 					'WebSiteController@setLogin');
get('/register/user', 			'WebSiteController@setRegister');

// Pagamento
get('checkout',  				'WebSiteController@getCheckout');
get('/shop-cart/{plan}/{price}','WebsiteController@getShopCart'); # Carrinho de compra
get('/send/payment',			'WebsiteController@getSendPayment');

get('/cronMessage', 			'WebSiteController@getcronMessage'); # Carregando mensgaem
get('/checkBlocked', 			'WebSiteController@getCheckNumber'); # Verificar se está bloqueado