<?php
namespace App\Library;

// Portfolio
use LineXTI\Portfolio\Models\Portfolios;
use LineXTI\Portfolio\Models\PortfolioCategorias;
use App\Models\Configuracoes;

class CoreHelpers{

    private static $Data;
    private static $Format;

	public static function Ativate($url, $valor) {
        $ativate = '';

        if (is_array($url)):

            $ativate = (in_array(\Request::path(), $url)  ? $valor : '');
        else:
            $ativate = (\Request::path() == $url ? $valor : '');
        endif;
        return $ativate;
    }

    public static function ReadCategory()
    {
        return \App\Models\Categorias::all();
    }

    public static function getOpt()
    {
        return Configuracoes::where('config_id', 1)->first();
    }
    
    public static function ReadPosts($pg)
    {
        return \App\Models\Posts::where('post_status', 'sim')
            ->orderBy('post_id', 'desc')
            ->paginate($pg);
    }

    public static function CountPostForCategory($slugCategory)
    {
        return \App\Models\Posts::where('post_status', 'sim')
            ->leftJoin('categorias', 'posts.post_categoria_id', '=', 'categorias.cat_id')
            ->orderBy('post_id', 'desc')
            ->where('cat_slug', $slugCategory)
            ->get();
    }

    public static function readPortfolios($pg)
    {
        return Portfolios::where('port_status', 'sim')
        ->leftJoin('portfolio_categorias', 'portfolios.port_categoria', '=', 'portfolio_categorias.potctg_id')
        ->leftjoin('users', 'portfolios.port_cliente', '=', 'users.id')
        ->paginate($pg);
    }

    public static function ContarMensagensExcluidas()
    {
        return \App\Models\ContatosEmail::where('contato_status', 0)->get();
    }

    public static function ContarMensagens()
    {
        return \App\Models\ContatosEmail::where('contato_status', 1)->get();
    }

    /**
     * <b>Imagem Upload:</b> Ao executar este HELPER, ele automaticamente verifica a existencia da imagem na pasta
     * uploads. Se existir retorna a imagem redimensionada!
     * @return HTML = imagem redimencionada!
     */
    public static function Image($ImageUrl, $ImageDesc, $ImageW = null, $ImageH = null, $class = null) {

        self::$Data = 'uploads/' . $ImageUrl;

        if (file_exists(self::$Data) && !is_dir(self::$Data)):
            $patch  = \URL::to('/');
            $imagem = self::$Data;
            return "<img src=\"{$patch}/tim.php?src={$patch}/{$imagem}&w={$ImageW}&h={$ImageH}\" alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\" class=\"{$class}\"/>";
        else:
            return false;
        endif;
    }

    public static function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
		// Caracteres de cada tipo
    	$lmin 	= 'abcdefghijklmnopqrstuvwxyz';
    	$lmai 	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$num 	= '1234567890';
    	$simb 	= '!@#$%*-';
		// Variáveis internas
    	$retorno 	= '';
    	$caracteres = '';
		// Agrupamos todos os caracteres que poderão ser utilizados
    	$caracteres .= $lmin;
    	if ($maiusculas) $caracteres .= $lmai;
    	if ($numeros) $caracteres .= $num;
    	if ($simbolos) $caracteres .= $simb;
		// Calculamos o total de caracteres possíveis
    	$len = strlen($caracteres);
    	for ($n = 1; $n <= $tamanho; $n++) {
			// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
    		$rand = mt_rand(1, $len);
			// Concatenamos um dos caracteres na variável $retorno
    		$retorno .= $caracteres[$rand-1];
    	}
    	return $retorno;
    }


}