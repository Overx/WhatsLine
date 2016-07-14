<?php

get('/', 							'ClienteController@index'); 

// Agenda
get('agenda', 						'ClienteController@getAgenda');
get('agenda/addContact', 			'ClienteController@addContact');
get('agenda/readContact/{id}', 		'ClienteController@readContact');
get('agenda/updateContact', 		'ClienteController@updateContact');
get('agenda/deleteContact/{id}',	'ClienteController@deleteContact');

post('agenda/uploadCsv', 			'ClienteController@uploadCsv');

// Chat
get('chat', 						'ClienteController@getChat'); # Chat View
get('search/userlist', 			    'ClienteController@getSearch'); # Chat View
get('read/contacts', 		        'ClienteController@getReadContactsChat'); # Read Contacts
get('read/message/chat/{id}', 		'ClienteController@getMessageChat'); # Read Contacts
get('send/message/chat/',  			'ClienteController@sendSimpleMessage'); # Send Message

// Grupos
get('grupos', 						'ClienteController@getGroup'); # Grupo View
get('grupo/chat/{gid}', 			'ClienteController@getGroupChat'); # Grupo Chat
get('list/groups', 					'ClienteController@getListGroups'); # Grupo View
post('add/group', 					'ClienteController@setCreateGroup'); # Adicionar Grupo
get('delete/group/{id}', 			'ClienteController@getDeleteGroup'); # Delete Grupo

// Campanhas
get('campanhas', 					'ClienteController@getCampaigns'); # Campanhas
get('new/campaign', 				'ClienteController@getNewCampaigns'); 

// videos
get('videos', 						'ClienteController@getVideos'); # Videos


// Mensagem
get('mensagens', 					'ClienteController@getMessages'); # Mosta todas as mensagens
get('nova/mensagem', 				'ClienteController@newMessage'); # Nova mensagem
get('excluir/mensagens/', 			'ClienteController@getDeleteMessages'); # Nova mensagem

get('read/graph/message',			'ClienteController@getReadGraphMessages');

post('enviar/nova/mensagem', 		'ClienteController@sendNewMenssage'); # Enviando mensagem
get('checkMessages', 				'ClienteController@getCheckMessage'); # Verificar mensagem

get('view/{id}',					'ClienteController@getViewContact'); # Abre a view de contatos
get('send/message/simple/', 		'ClienteController@getSendSimpleMessage'); # Envia Mensagem Simples
get('read/message/username/{id}',	'ClienteController@getReadMessageUserName'); # Ler mensagem pelo ID

// Suporte
get('suporte', 						'ClienteController@getSupport'); # Ler mensagem pelo ID

// Configurações
get('configuracoes', 				'ClienteController@getSettings'); # Abre a view de configurações
get('save/settings', 			    'ClienteController@setAddSettings'); # adicionando configurações
get('active/settings/{id}', 		'ClienteController@setActiveSettings'); # Ativa as configurações
get('register/number', 				'ClienteController@setRegisterNumber'); # Registra o numero
post('update/settings', 			'ClienteController@setSettings'); # salvando configurações


post('update/vcard', 				'ClienteController@setvCard');
get('read/vcard',  					'ClienteController@readvCard');


get('check/number', 				'ClienteController@checkNumber');


