<?php 

	function csv_to_array($filename='', $delimiter=',')
    {
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;
     
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
                    

	function roundNumber($num)
	{
		if($num > 0 && $num <= 10)
		{
			return 10;
		}elseif($num >= 10 && $num <= 20)
		{
			return 20;
		}elseif($num >= 20 && $num <= 30)
		{
			return 30;
		}elseif($num >= 30 && $num <= 40)
		{
			return 40;
		}elseif($num >= 40 && $num <= 50)
		{
			return 50;
		}elseif($num >= 50 && $num <= 60)
		{
			return 60;
		}elseif($num >= 60 && $num <= 70)
		{
			return 70;
		}elseif($num >= 70 && $num <= 80)
		{
			return 80;
		}elseif($num >= 80&& $num <= 90)
		{
			return 90;
		}elseif($num >= 90 && $num <= 100)
		{
			return 100;
		}
	}

	function layoutBase($value)
	{
	    return \URL::to('assets/' . $value);
	}

	function urlBase($value)
	{
		return \URL::to($value);
	}

	function nivelStatus($value)
	{
		switch ($value) {
			case '0':
				return 'Validando';
				break;

			case '1':
				return 'Cliente';
				break;
			
			case '2':
				return 'Moderador(a)';
				break;

			case '3':
				return 'Advogado(a)';
				break;

			case '4':
				return 'Administrador(a)';
				break;
		}
	}

	function acento_para_html($texto){
		$comacento = array('Á','á','Â','â','À','à','Ã','ã','É','é','Ê','ê','È','è','Ó','ó','Ô','ô','Ò','ò','Õ','õ','Í','í','Î','î','Ì','ì','Ú','ú','Û','û','Ù','ù','Ç','ç',' ');
		$acentohtml   = array('&Aacute;','&aacute;','&Acirc;','&acirc;','&Agrave;','&agrave;','&Atilde;','&atilde;','&Eacute;','&eacute;','&Ecirc;','&ecirc;','&Egrave;','&egrave;','&Oacute;','&oacute;','&Ocirc;','&ocirc;','&Ograve;','&ograve;','&Otilde;','&otilde;','&Iacute;','&iacute;','&Icirc;','&icirc;','&Igrave;','&igrave;','&Uacute;','&uacute;','&Ucirc;','&ucirc;','&Ugrave;','&ugrave;','&Ccedil;','&ccedil;', '&nbsp;');
		return str_replace($acentohtml, $comacento, $texto);
	}

	function validaCPF($cpf = null) {
 
	    $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
		// Valida tamanho
		if (strlen($cpf) != 11)
			return false;
		// Calcula e confere primeiro dígito verificador
		for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
			$soma += $cpf{$i} * $j;
		$resto = $soma % 11;
		if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
			return false;
		// Calcula e confere segundo dígito verificador
		for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
			$soma += $cpf{$i} * $j;
		$resto = $soma % 11;
		return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
	}

	/**
	 * Perfect function to serialize and unserialize
	 *
	 */
	if (!function_exists('perfectSerialize')) {
	    function perfectSerialize($string) {
	        return base64_encode(serialize($string));
	    }
	}

	if (!function_exists('perfectUnserialize')) {
	    function perfectUnserialize($string) {

	        if (base64_decode($string, true) == true) {

	            return unserialize(base64_decode($string));
	        } else {
	            return @unserialize($string);
	        }
	    }
	}

	if (!function_exists('sanitizeText')) {
	    function sanitizeText($string, $limit = false) {

	        if (!is_string($string)) return $string;
	        $string = lawedContent($string);//great one
	        $string = trim($string);
	        $string = str_replace('<','&#60;',$string);
	        $string = str_replace('>','&#62;',$string);
	        $string = str_replace("'",'&#39;',$string);
	        $string = htmlspecialchars($string);
	        $string = str_replace('\\r\\n','<br>',$string);
	        $string = str_replace('\\n\\n','<br>',$string);
	        $string = stripslashes($string);
	        $string = str_replace('&amp;#','&#',$string);

	        if ($limit) {
	            $string = substr($string, 0, $limit);
	        }
	        return $string;
	    }
	}

	function parseVimeo($link)
	{
	    $link = str_replace('http://www.','', $link);
	    $link = str_replace('http://','', $link);
	    $link = str_replace('https://','', $link);
	    $link = str_replace('www.','', $link);
	    //$link = str_replace('https://wwww.','', $link);

	    //echo $link;

	    if(preg_match('#vimeo.com\/[a-zA-Z0-9\-\_]#', $link))
	    {
	        if (preg_match('#player.vimeo#', $link)) return 'http://'.$link;

	        //return true;
	        $link = str_replace('vimeo.com/','vimeo.com/video/',$link);
	        $link = 'http://player.'.$link;

	        return $link;
	    }
	    return false;
	}

	function parseYouTube($link)
	{
	    if(preg_match("#embed#", $link)) return $link;

	    //this take care of youtube link like this http://youtu.be/awerqwouioqw
	    if(preg_match('#http://#', $link))
	    {
	        if(preg_match('#http://youtu.be#', $link))
	        {
	            $link = str_replace('http://youtu.be', 'http://www.youtu.be', $link);

	        }elseif( preg_match('#http://youtube.com#', $link))
	        {
	            $link = str_replace('http://youtube.com', 'http://www.youtube.com', $link);
	        }

	        if(preg_match("#http:\/\/youtu.be\/[a-zA-Z0-9\-\_\.]+#", $link, $matchs))
	        {
	            return 'http://www.youtube.com/embed/'.str_replace("http://youtu.be/",'', $link);
	        }

	        //this take care of youtube http://youtube.com/watch?v=dfkjsdfhsdjk
	        if(preg_match("#http:\/\/www.youtube.com\/watch\?v\=[a-zA-Z0-9\-\_\.]+#", $link, $matchs))
	        {
	            return 'http://www.youtube.com/embed/'.str_replace("http://www.youtube.com/watch?v=",'', $link);
	        }

	    }elseif(preg_match('#https://#', $link))
	    {
	        if(preg_match('#https://youtu.be#', $link))
	        {
	            $link = str_replace('https://youtu.be', 'https://www.youtu.be', $link);

	        }elseif( preg_match('#https://youtube.com#', $link))
	        {
	            $link = str_replace('https://youtube.com', 'https://www.youtube.com', $link);
	        }

	        if(preg_match("#https:\/\/www.youtu.be\/[a-zA-Z0-9\-\_\.]+#", $link, $matchs))
	        {
	            return 'https://www.youtube.com/embed/'.str_replace("https://www.youtu.be/",'', $link);
	        }

	        //this take care of youtube http://youtube.com/watch?v=dfkjsdfhsdjk
	        if(preg_match("#https:\/\/www.youtube.com\/watch\?v\=[a-zA-Z0-9\-\_\.]+#", $link, $matchs))
	        {

	            return 'https://www.youtube.com/embed/'.str_replace("https://www.youtube.com/watch?v=",'', $link);
	        }
	    }

	    return false;
	}

	/**
    * VIDEO ID
    * Pega o ID da URL
    **/
    function VideoID($url){

        if(strpos($url, "vimeo.com")){
            if(strpos($url, 'vimeo.com/')){
                $val = strrpos($url, 'vimeo.com/')+10;
                $str = substr($url, $val);
                return $str;
               //return '<iframe src="https://player.vimeo.com/video/'.$str.'" width="854" height="480" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            } 
        }else if(strpos($url, "youtube.com")){
            if(strpos($url, '?v=')){
                $val = strrpos($url, '?v=')+3;
                $str = substr($url, $val);
                return $str;
               //return '<iframe width="854" height="480" src="https://www.youtube.com/embed/'.$str.'" frameborder="0" allowfullscreen></iframe>';
            } 
        }
    }