<?php

namespace App\Services;


// SEO
use Arcanedev\SeoHelper\Entities\Title;
use Arcanedev\SeoHelper\Entities\Description;
use Arcanedev\SeoHelper\Entities\Keywords;
use Arcanedev\SeoHelper\Entities\MiscTags;
use Arcanedev\SeoHelper\Entities\Webmasters;
use Arcanedev\SeoHelper\Entities\Analytics;


class SeoService
{

	public static function title($titulo)
	{
		// Title
		$title = new Title;
		$title->set($titulo);

		return $title;
	}

	public static function description($descricao)
	{
		// Description
		$description = new Description;
		$description->set($descricao);

		return $description;
	}

	public static function Keywords()
	{
		// Keywords
		$keywords = new Keywords;
		$keywords->set('lainexti, linexti, Agência de Marketing em BH, Agência de Marketing em Belo Horizonte, Marketing. Desenvolvimento de Softwares, criação de aplicativos para celular');

		return $keywords;
	}

	public static function webmasters()
	{
		// webmasters
		$webmasters = Webmasters::make([
		    'google'    => 'google-site-verification-code'
		]);

		return $webmasters;
	}

	
	public static function analytics()
	{
		// analytics
		$analytics = new Analytics;
		$analytics->setGoogle('UA-54327924-1');

		return $analytics;
	}
  

	
}
