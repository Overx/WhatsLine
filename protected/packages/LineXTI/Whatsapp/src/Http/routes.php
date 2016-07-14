<?php 
Route::group(['prefix' => 'admin'], function(){
	Route::get('whatsapp', 					'LineXTI\Whatsapp\Http\Controllers\WhatsappController@index');
	Route::get('whatsapp/nova/mensagem', 	'LineXTI\Whatsapp\Http\Controllers\WhatsappController@setNewMessage');
});