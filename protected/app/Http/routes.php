<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

include_once('Routes/website.php'); # Rotas do site


/*
* Autenticação
* Niveis de autenticação de usuário
* Nivel: 3 - Administrador(a)
* Nivel: 2 - Cliente Premium
* Nivel: 1 - Cliente Basico 
* Nivel: 0 - Validando 
*/
Route::group( ['middleware' => ['auth', 'nivelUser:3|4'], 'prefix' => 'admin'], function(){
	include_once('Routes/admin.php');	
});

Route::group( ['middleware' => ['auth', 'nivelUser:1|2|3|4'], 'prefix' => 'cliente'], function(){
	include_once('Routes/cliente.php');
});

Route::get('get/cron', function(){
    return 'php '.base_path('artisan').' cron:run';
});




