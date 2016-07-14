<?php 
namespace LineXTI\Whatsapp;

use Illuminate\Support\ServiceProvider;

class WhatsappServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('whatsapp', function($app) {
			return new Whatsapp;
		});
	}


	public function boot()
	{
		// Routes
		if (! $this->app->routesAreCached()) {
	        require __DIR__ . '/Http/routes.php';
	    }

	    // Views
	    $this->loadViewsFrom(__DIR__.'/Views', 'whatsapp');

	    // Migrations
	    $this->publishes([
	    	__DIR__ . '/Migrations/2015_08_30_000000_create_whatsapp_table.php' => base_path('database/migrations/2015_08_30_000000_create_whatsapp_table.php')
	    ]);

	    // Models
	    /*
	    $this->publishes([
	    	__DIR__ . '/Models/PortfolioCategorias.php' => base_path('app/Models/PortfolioCategorias.php'),
	    	__DIR__ . '/Models/Portfolios.php' => base_path('app/Models/Portfolios.php'),
	    ]);
	    */

		// Ajax
 		/*
 		$this->publishes([
	    	__DIR__ . '/Assets/js/portfolio.js' => \URL::to('app/js/ajax/portfolio.js')
	    ]);
		*/
	    // Condigurações
	    $this->mergeConfigFrom(
	        __DIR__.'/Config/whatsapp.php', 'whatsapp'
	    );
	}
}