<?php

namespace App\Services;

use App\Repositories\WhatsRepository;

// Services
use App\Models\User;
use App\Models\Contacts;
use App\Models\Settings;
use App\Models\Message;
use App\Models\vCard;

// Services
use App\Services\WhatsappService;
use App\Services\BlockCheckService;

class ClienteService
{

	private static $messages = [];

	public function __construct()
	{

	}

	/**
	* Add Conctact | Adicionar Contato
	* Metodo para adicionar um novo contato
	* 
	* @param  Dados [array] 
	* @return Notificação
	*/
	public static function addContact($dados)
	{
		if(empty($dados['con_number']) or empty($dados['con_name'])):
			return 'camposvazio';
		else:
			$dados['con_number']  = preg_replace("/[^0-9]/", "", "55" . $dados['con_number']); # Number
			$dados['con_date']    = date("Y-m-d"); # Date

			if(Contacts::where('user_id', \Auth::user()->id)->where('con_number', $dados['con_number'])->first()):
				return 'jaexistenumero';
			else:
				$whatsapp = new WhatsappService;
				$numberCheck = $whatsapp->checkNumberPhone($dados['con_number']);
				if(!$numberCheck):
					return 'noexiste';
				else:
					if(Contacts::create($dados)):
						return 'sucesso';
					endif;
				endif;
			endif;
		endif;
	}

	/**
	*
	*
	* @return Response [ARRAY]
	*/
	public static function ListContacts()
	{
		$contacts =  Contacts::where('user_id', \Auth::user()->id)->get();
		if(count($contacts) > 0):
			return $contacts;
		else:
			return [];
		endif;
	}

	/**
	* Read Contact
	* Lendo o contato por ID
	*
	* @param [id]
	* @return Response [JSON]
	*/
	public static function readContact($id)
	{
		$contact   = Contacts::where('user_id', \Auth::user()->id)->where('con_id', $id)->first();		
		if(!empty($contact)):
			$contact['con_number'] = substr($contact['con_number'], 2);
			return \Response::json($contact);
		else:
			return [];
		endif;
	}

	/**
	* Update Contact
	* Atualiza o contato 
	*
	* @param [id] ID do contato
	* @param [dados] Array com os dados do contato
	* @return Notificação
	*/
	public static function updateContact($id, $dados)
	{
		if(empty($dados['con_number']) or empty($dados['con_name'])):
			return 'camposvazio';
		else:
			$dados['con_number']  = preg_replace("/[^0-9]/", "", "55" . $dados['con_number']); # Number
			
			if(Contacts::where('user_id', \Auth::user()->id)->where('con_id', $id)->update($dados)):
				return 'sucesso';
			endif;
		endif;
	}

	/**
	* Delete Contact
	* Deleta o contato pelo id
	*
	* @param [id] ID do contato
	* @return Notificação
	*/
	public static function deleteContact($id)
	{
		if(Contacts::where('user_id', \Auth::user()->id)->where('con_id', $id)->delete()):
			return 'sucesso';
		endif;
	}

	/**
	* Read Messages Contacts
	* Lendo as mensagens de um contato
	*
	* @param [id] ID do contato
	* @return Notificação
	*/
	public static function ReadMessagesConctact($id)
	{
		$contacts = Contacts::where('user_id', \Auth::user()->id)
							->where('con_id', $id)
							->first();

		$contacts->message = array();
		$message  = Message::where('user_id', \Auth::user()->id)
						   ->where('message_from', $contacts->con_number)
						   ->orWhere('message_to', $contacts->con_number)
						   ->get();

		if(count($message) > 0):
			$contacts->messages = $message;
		endif;

		return $contacts;
	}

	/**
	* List Messages
	* Listando as mensagens com paginação
	*
	* @param [pg] numero de paginas
	* @return Notificação
	*/
	public static function ListMessages($pg)
	{
		$user_id = \Auth::user()->id;
		$message = Message::where('user_id', $user_id)
					      ->where('message_status', 'done')
						  ->orWhere('message_status', 'send')
						  ->paginate($pg);

		if(count($message) > 0):
			return $message;
		endif;
	}


	/**
	* Read All Messages
	* Lendo todas as mensagens desse usuário logado
	*
	* @return [Array]
	*/
	public static function ReadAllMessages()
	{
		$message = Message::where('user_id', \Auth::user()->id)->get();
		if(count($message) > 0):			
			return $message;
		else:
			return [];
		endif;
	}

	/**
	*
	*
	* @return 
	*/
	public static function ViewContact($id)
	{
		return $id;
	}

	/**
	* Check Number
	* Verificar se o numero está bloqueado
	*
	* @return 
	*/
	public static function checkNumber()
	{
		$blockedCheck = new BlockCheckService;
		$check = $blockedCheck->CheckNumberPhone();
		if($check == "blocked"):
			return 'blocked';
		else:
			return 'erro';
		endif;
	}


	/**
	* Read vCard
	* Lendo um vcard
	*
	* @return
	*/
	public static function readvCard()
	{
		$id 	= \Auth::user()->id;
		$vcard 	= vCard::where('user_id', $id)->first();
		if(!empty($vcard)):			
			return $vcard;
		else:
			return '';
		endif;
	}

	/**
	* Set vCard
	* Enviando um vcard para o sistema
	*
	* @param [dados] Array
	* @param [file] Imagem 
	* @return Notification
	*/
	public static function setvCard($dados, $file)
	{
		$id 				= \Auth::user()->id;
		$dados['user_id'] 	= $id;

		// Upload de imagem
		if (!empty($file)):
			if($file->getSize() >= 1048576 * 2):
				return 'arquivogrande';
			else:
				// Verificando se existe
                $imagem = vCard::where("user_id", $id)->where("vcard_photo", "!=", '')->first();
                if (isset($imagem) && $imagem->vcard_photo != '' && \File::exists('uploads/' . $imagem->vcard_photo)) {
                    \File::delete('uploads/' . $imagem->vcard_photo);
                }

				$upload = new \App\Library\UploadHelpers();
                if ($upload->ImageUpload($file)):
                    $dados['vcard_photo'] = $upload->NomeArquivo(); // Criando o valor a ser enviado para o banco de dados com o nome e caminho do arquivo
                endif;		
			endif;               
        endif;

        if($ver = vCard::where('user_id', $id)->first()):
        	if(vCard::where('vcard_id', $ver->vcard_id)->update($dados)):
        		return 'sucesso';
        	endif;
        else:
        	if(vCard::create($dados)):
        		return 'sucesso';
        	endif;
        endif;
	}

	/**
	* Read CSV
	*
	* @return 
	*/
	public static function readCSV($path, $hasHeader = true, $encoding = "UTF-16") 
	{
	    $contents = file_get_contents($path);
	    $contents = iconv($encoding, "UTF-8", $contents);
	    $lines    = explode("\r\n", $contents);
	    $lines    = array_filter($lines, 'trim');
	    $rows     = array_map('str_getcsv', $lines);
	   
	    if($hasHeader) {
	        $headers  = array_shift($rows);
	       
	        foreach($rows as &$row) {
	            $data     = [];
	       
	            foreach($row as $idx => $value) {
	                $data[$headers[$idx]] = $value;
	            }
	           
	            $row = $data;
	        }
	       
	    }
	   
	    return $rows;
	}

	/**
	* Upload CSV
	*
	* @return 
	*/
	public static function uploadCsv($file)
	{

		$dados = [];

		if ($file->isValid()):

			$path   = $file->getRealPath();
			$reader = self::readCSV($path);

			$n = 0;
			foreach($reader as $r):
				

				if(!empty($r['Phone 1 - Value']) && !empty($r['Name'])):
					$phone = trim((!empty($r['Phone 1 - Value']) ? $r['Phone 1 - Value'] : ''));

					// Preparar numero //////////////////////////////////////////////////////////////////
					$region = substr($phone, 0, 2);

					if($region === "55" || $region === "+5"):
						$phone = preg_replace("/[^0-9]/", "", $phone); # Number
					else:
						$phone = preg_replace("/[^0-9]/", "", "55" . $phone); # Number
					endif;

					$dados[$n]['con_name']  	= trim((!empty($r['Name']) ? $r['Name'] : ''));
					$dados[$n]['con_number'] 	= $phone;
					$dados[$n]['con_email'] 	= trim((!empty($r['E-mail 1 - Value']) ? $r['E-mail 1 - Value'] : ''));
					$dados[$n]['con_date'] 		= date("Y-m-d");
					$dados[$n]['user_id']		= \Auth::user()->id;

					/*				
					$phone 				= (!empty($r['Phone 1 - Value']) ? $r['Phone 1 - Value'] : '');

					// Preparar numero //////////////////////////////////////////////////////////////////
					$region = substr($phone, 0, 2);

					if($region === "55" || $region === "+5"):
						$phone = preg_replace("/[^0-9]/", "", $phone); # Number
					else:
						$phone = preg_replace("/[^0-9]/", "", "55" . $phone); # Number
					endif;

					// Verificar Numero /////////////////////////////////////////////////////////////////
					/*
					$whatsapp = new WhatsappService;
					if($whatsapp->checkNumberPhone('+'+$phone)):						
						$dados[$n]['con_name']  	= (!empty($r['Name']) ? $r['Name'] : '');
						$dados[$n]['con_email'] 	= (!empty($r['E-mail 1 - Value']) ? $r['E-mail 1 - Value'] : '');
						$dados[$n]['con_number'] 	= $phone;
						$dados[$n]['con_date'] 		= date("Y-m-d");
						$dados[$n]['user_id']		= \Auth::user()->id;
					endif;
					*/
				endif;
			$n++;
			endforeach;

		else:
			return 'invalido';
		endif;

		$whatsapp = new WhatsappService;

		if(count($dados) > 0):
			foreach($dados as $d):
				$verContato = Contacts::where('con_number', $d['con_number'])->first();

				if($verContato == null):		
					sleep(rand(1, 2));			
					$numberCheck = $whatsapp->checkNumberPhone($d['con_number']);
					if($numberCheck):
						Contacts::create($d);
					endif;
				endif;
			endforeach;
		endif;

		return 'sucesso';	
	}


	/**
	* Delete Messages
	* Deletando todas as mensagens e respostas do banco de dados
	*
	* @return 
	*/
	public static function deleteMessages()
	{
		if(Message::where('user_id', \Auth::user()->id)->delete()):
			return 'sucesso';
		endif;
	}


	/**
	* Read Settings
	* Lendo as configurações
	*
	* @return Array
	*/
	public static function readSettings()
	{
		$dados = Settings::where('user_id', \Auth::user()->id)
						 ->where('set_status', 'active')
						 ->first();	
		$dados['set_number']  = substr($dados['set_number'], 2); # Number	
		return $dados;
	}

	/**
	* Read All Settings
	* Lendo todas as configurações
	*
	* @return Array
	*/
	public static function readAllSettings()
	{
		$dados = Settings::where('user_id', \Auth::user()->id)->get();	
		return $dados;
	}

	/**
	* Active Settings
	* Ativando configurações
	*
	* @return Noty
	*/
	public static function setActiveSettings($id)
	{
		$ver = Settings::where('user_id', \Auth::user()->id)
					->where('set_status', 'active')
					->first(); # Verificando se existe numero ativo	 
		if(!empty($ver)):
			Settings::where('set_id', $ver->set_id)->update(['set_status' => null]);
		endif;	

		if(Settings::where('set_id', $id)->update(['set_status' => 'active'])):
			return 'sucesso';
		endif;
	}

	/**
	* Set Configuraçoes
	* Salvando as configurações
	*
	* @param [dados] Array
	* @param [file] Arquivos
	* @return Notificação
	*/
	public static function setConfiguracoes($dados, $file)
	{
		$id = \Auth::user()->id;
		
		if(in_array("", $dados)):
			return 'camposvazio';
		else:
			$dados['set_number']  	= trim(preg_replace("/[^0-9]/", "", "55" . $dados['set_number'])); # Number
			$dados['set_password']	= trim($dados['set_password']);
			$dados['user_id']    	= \Auth::user()->id;
			$dados['set_debug']     = false;

			// Upload de imagem
			if (!empty($file)):
				if($file->getSize() >= 1048576 * 2):
					return 'arquivogrande';
				else:
					// Verificando se existe
                    $imagem = \App\Models\User::where("id", $id)->where("avatar", "!=", '')->first();
                    if (isset($imagem) && $imagem->avatar != '' && \File::exists('uploads/' . $imagem->avatar)) {
                        \File::delete('uploads/' . $imagem->avatar);
                    }

					$upload = new \App\Library\UploadHelpers();
	                if ($upload->ImageUpload($file)):
	                    $dados['set_avatar'] = $upload->NomeArquivo(); // Criando o valor a ser enviado para o banco de dados com o nome e caminho do arquivo
	                endif;		
				endif;               
	        endif;

	        // Atualizando no perfil
	        if(!empty($dados['set_avatar'])):
	        	User::where('id', $id)->update(['avatar' => $dados['set_avatar']]);
	        endif;
	        

	        if($ver = Settings::where('user_id', $id)->where('set_number', $dados['set_number'])->first()):
	        	if(Settings::where('set_id', $ver->set_id)->update($dados)):
	        		return 'sucesso';
	        	endif;
	        else:
	        	$dados['set_status'] = 'active';
	        	if(Settings::create($dados)):
	        		return 'sucesso';
	        	endif;
	        endif;
		endif;
	}


	/**
	* Set Configuraçoes
	* Salvando as configurações
	*
	* @param [dados] Array
	* @param [file] Arquivos
	* @return Notificação
	*/
	public static function setAddConfiguracoes($dados)
	{
		$id = \Auth::user()->id;
		
		if(in_array("", $dados)):
			return 'camposvazio';
		else:
			$dados['set_number']  	= trim(preg_replace("/[^0-9]/", "", "55" . $dados['set_number'])); # Number
			$dados['set_password']	= trim($dados['set_password']);
			$dados['user_id']    	= $id;
			$dados['set_debug']     = false;
			
	        if($ver = Settings::where('set_number', $dados['set_number'])->first()):
	        	return 'jaexiste';
	        else:
	        	// Verificando quantidades de numeros já cadastrados pelo perfil
	        	$verQtd = Settings::where('user_id', \Auth::user()->id)->get();
	        	if(count($verQtd) <= 0):
	        		$dados['set_status'] = 'active';
	        	endif; // Se for a primeira conta, já ativa

	        	if(count($verQtd) >= 4):
	        		return 'quantidademaxima';
	        	else:
	        		if(Settings::create($dados)):
		        		return 'sucesso';
		        	endif;
	        	endif;	        	
	        endif;
		endif;
	}


	/**
	*
	*
	* @return Notificação
	*/
	public static function setRegisterNumber($dados)
	{
		$auth = \Auth::user()->id;
		// Gravando
		if(!empty($dados['reg_number']) && !empty($dados['reg_password'])):
			$data = [
				'set_number' 	=> $dados['reg_number'],
				'set_password' 	=> $dados['reg_password'],
				'user_id'		=> $auth
			];

		endif;
	}




}