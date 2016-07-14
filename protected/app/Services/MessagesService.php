<?php

namespace App\Services;

require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/Registration.php'));
require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/whatsprot.class.php'));
require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/vCard.php'));

use Carbon\Carbon;
use App\Models\User;
use App\Models\Settings;
use App\Models\Message;
use App\Models\Contacts;
use App\Models\vCard;


class MessagesService 
{

	private $debug       = false;
    private $username;
    private $identity    = "identity";
    private $nickname;
    private $company;
    private $imageCover;
    
    private $messages    = array();
    private $wp_id       = array();
    private $login;
    private $password;    
    private $whatsapp;
    private $connected;
    private $vCard;
    private $sleep      = 60;
    private $status;
    private $profilepic;

    /**
    * 
    *
    */
    public function __construct()
    {    
        if(!empty($this->settings())):        
            $this->nickname     = $this->settings()->set_name;
            $this->login        = $this->settings()->set_number;
            $this->password     = $this->settings()->set_password;
            $this->imageCover   = $this->settings()->set_avatar;

            
        endif; # Verifica se existe configurações  
    }

    /**
    * Settings
    * Lendo configurações
    *
    * @return
    */
    public function settings()
    {
        $settings = Settings::ReadSettingsSingle();

        if(!empty($settings)):
            return $settings;
        else:
            return '';
        endif; 
    }

    /**
     * Connect to Whatsapp.
     *
     * Create a connection to the whatsapp servers
     * using the supplied password.
     *
     * @return bool
     */
    private function connectToWhatsApp()
    {
        $this->whatsapp = new \WhatsProt($this->login, $this->nickname, $this->debug);
       
        $this->whatsapp->eventManager()->bind('onConnect',              [$this, 'onConnect']);
        $this->whatsapp->eventManager()->bind('onDisconnect',           [$this, 'onDisconnect']);
        $this->whatsapp->eventManager()->bind('onGetImage',             [$this, 'onGetImage']);        
        $this->whatsapp->eventManager()->bind('onGetProfilePicture',    [$this, 'onGetProfilePicture']);
        $this->whatsapp->eventManager()->bind("onPresenceAvailable",    [$this, "onPresenceAvailable"]);
        $this->whatsapp->eventManager()->bind("onPresenceUnavailable",  [$this, "onPresenceUnavailable"]);
        $this->whatsapp->eventManager()->bind('onGetMessage',           [$this, 'processReceivedMessage']);
        $this->whatsapp->eventManager()->bind("onGetStatus",            [$this, "onGetStatus"]);
        $this->whatsapp->eventManager()->bind("onPing",                 [$this, "onPing"]);
        $this->whatsapp->eventManager()->bind("onSendPong",             [$this, "onSendPong"]);
               
        if ($this->connected == false): 
            $this->whatsapp->connect(); // Connect to WhatsApp network      
            $this->whatsapp->loginWithPassword($this->password); 
            $this->whatsapp->pollMessage();

            $this->whatsapp->sendClientConfig();
            $this->whatsapp->sendGetServerProperties();
            $this->whatsapp->sendActiveStatus();

            if(!empty($this->imageCover)):
                $this->whatsapp->sendSetProfilePicture("./uploads/" . $this->imageCover);
            endif;

            return true;
        else:
            return false;
        endif;        
    }


    /**
    *
    *
    *
    * @return
    */
    function onGetImage($mynumber, $from, $id, $type, $t, $name, $size, $url, $file, $mimetype, $filehash, $width, $height, $preview)
    {
        //save thumbnail
        $previewuri = \URL::to('/') . "/uploads/media/thumb_" . $file;
        $fp = @fopen($previewuri, "w");
        if ($fp) {
            fwrite($fp, $preview);
            fclose($fp);
        }

        //download and save original
        $data = file_get_contents($url);
        $fulluri = \URL::to('/') . "/uploads/media/" . $file;
        $fp = @fopen($fulluri, "w");
        if ($fp) {
            fwrite($fp, $data);
            fclose($fp);
        }
    }


    /**
    *
    *
    *
    * @return
    */
    public function onGetProfilePicture($from, $target, $type, $data)
    {
        if ($type == "preview") {
            $filename = \URL::to('/') . "/uploads/pictures/preview_" . $target . ".jpg";
        } else {
            $filename = \URL::to('/') . "/uploads/pictures/" . $target . ".jpg";
        }
        $fp = @fopen($filename, "w");
        if ($fp) {
            fwrite($fp, $data);
            fclose($fp);
        }
       
        $this->profilepic = $filename; 
    }

    /**
    *
    *
    *
    * @return
    */
    private function vCardBuild()
    {
        $vcard = vCard::where('user_id', \Auth::user()->id)->first();
        if(!empty($vcard)):
            $this->company = $vcard->vcard_display_name;
            $data  = array(
                "display_name"          => $vcard->vcard_display_name,
                "company"               => $vcard->vcard_company,
                "office_tel"            => $vcard->vcard_office_tel,
                "cell_tel"              => $vcard->vcard_home_tel,
                "email1"                => $vcard->vcard_email1,
                "url"                   => $vcard->vcard_url,
                "photo"                 => \URL::to('/uploads/' . $vcard->vcard_photo),
                "note"                  => $vcard->vcard_note,
                "work_extended_address" => $vcard->vcard_work_extended_address,
                "work_city"             => $vcard->vcard_work_city,
                "work_state"            => $vcard->vcard_work_state,
                "work_postal_code"      => $vcard->vcard_work_postal_code
            );

            $this->vCard = new \vCard();
            $this->vCard->set("data", $data);
            $this->vCard->build();
        else:
            return 'vazio';
        endif;
    }

    /**
    *
    *
    *
    * @return
    */
    public function cronMessage()
    {
        if($this->connected == false):
            $this->connectToWhatsApp();        
        endif; 

        $message = Message::where('message_status', 'send')->get();        
        
        $n = 0; 
        $s = 0; 

        if (is_array($message) || is_object($message)):
            foreach($message as $msg):

                if($n <= 10):
                   
                    $id     = $msg['message_id']; # id
                    $type   = $msg['message_type']; # Tipo
                    $number = $msg['message_to'];
                    $wp_id  = '';
                    $message= $msg['message_content'];
                    $midia  = $msg['message_midia'];

                    if($this->whatsapp->pollMessage() && $type !== ''):

                        echo '<br/>';
                        echo 'Numero: ' . $number;
                        echo '<br/>';
                        echo 'Tipó: ' . $type;
                        echo '<br/>';

                        $this->whatsapp->SendPresenceSubscription($number); # Manipulação de presença (online/offline/digitação/visto pela última vez)

                        if(!empty($type)):
                            switch (trim($type)):
                                case 'message':
                                    $this->timeSleep($number); # sleep
                                    $wp_id = $this->whatsapp->sendMessage($number, $message, $force_plain = true);
                                break; # Message simple
                                case 'image':
                                    $this->timeSleep($number); # sleep
                                    $wp_id = $this->whatsapp->sendMessageImage($number, $midia, $force_plain = true);
                                break; # Message Image
                                case 'audio':
                                    $this->timeSleep($number); # sleep
                                    $wp_id = $this->whatsapp->sendMessageAudio($number, $midia, $force_plain = true);
                                break; # Message Audio
                                case 'video':
                                    $this->timeSleep($number); # sleep
                                    $wp_id = $this->whatsapp->sendMessageVideo($number, $midia, $force_plain = true);
                                break; # Message Vídeo
                                case 'vcard':
                                    sleep(rand(1, 2));   
                                    $this->vCardBuild();
                                    $company  = $this->company;
                                    $wp_id = $this->whatsapp->sendVcard($number, "{$company}", $this->vCard->show());
                                    sleep(1);
                                break; # Location 
                                case 'locationname':                            
                                    $this->whatsapp->sendBroadcastPlace($target, $userlong, $userlat, $locationname, null);
                                break; # Location                    
                            endswitch;
                        endif;
                        $this->whatsapp->pollMessage();

                        // Atualizando as informações
                        if(!empty($wp_id)):
                            $dados = [
                                'message_id_send'   => $wp_id,
                                'message_status'    => 'done'
                            ];
                            if(Message::where('message_id', $id)->update($dados)): # Salvando mensagem
                                echo '<br/>';
                                echo 'Atualizado: ' . $wp_id;
                                echo '<br/>';
                            endif;
                        endif;
                    endif;   
                else:
                    // passou de 10 mensagem desconecta
                    $this->whatsapp->disconnect(); # Desconecta 
                    sleep($this->sleep + $s); # Sleep
                    $s  = ($s + 30); # Adicionar +30
                    $n  = 0; # Limpa para começar do zero 

                    continue;
                endif;
            $n++;      
            endforeach;
        endif;    
    }

    /**
    *
    *
    */
    private function timeSleep($number)
    {
        sleep(rand(1, 3)); # Sleep
        $this->whatsapp->sendMessageComposing($number); # Composing
        sleep(rand(1, 3)); # Sleep
        $this->whatsapp->sendMessagePaused($number); # Pause
    }

    /** 
     * Contacts Sync
     * 
     * @return void
     */
    public function contactsSync($contacts)
    {
        $numbers = [];
        foreach ($contacts as $number) {
            $this->whatsapp->sendPresenceSubscription($number);
            $number     = "+$number";
            $numbers[]  = $number;
        }
        
        $this->whatsapp->sendGetStatuses($numbers);
        $this->whatsapp->sendSync([$numbers]);
    }


    /**
     * Enviar Messagem
     * Envia mensagens para usuarios
     *
     * @param $type Tipo de Mensagem [message], ['image'], [audio], [video]
     * @return 
     */
    public function setSendMessage($file, $dados, $target)
    {
        if($this->connected == false):
            $this->connectToWhatsApp();        
        endif; 

        $type       = '';
        $message    = '';
        $filepath   = '';

        /* Todos contatos */
        if(!empty($dados['all_con']) and $dados['all_con'] == 'on'):
            $con = Contacts::where('user_id', \Auth::user()->id)->get(['con_number']);
            if(count($con) > 0):
                foreach ($con as $key => $value):
                    $target[] = $value->con_number;
                endforeach;
            endif;
            unset($dados['all_con']);
        endif;

        /* Tipo de mensagem */
        if(!empty($dados['message_type'])):
            $type = $dados['message_type']; # Tipo de mensagem
        endif;

        switch (trim($type)):
            case 'image':
                /* Upload de imagem */
                if (!empty($file)):
                    if($file->getSize() >= 10048576 * 4):
                        return 'arquivogrande';
                    else:
                        $upload = new \App\Library\UploadHelpers();
                        if ($upload->ImageUpload($file)):
                            $filepath = \URL::to('/') . '/' . 'uploads/' .$upload->NomeArquivo(); 
                        endif;      
                    endif;               
                endif;
            break; # Message Image
            case 'audio':
                /* Upload audio */
                if ($file->isValid()):
                    if($file->getSize() >= 1048576 * 2):
                        return 'arquivogrande';
                    else:
                        $file_ex = $file->getClientOriginalExtension();
                        if (!in_array($file_ex, array('mp3'))):
                            return 'formatoinvalido';
                        else:
                            $destinationPath        = 'uploads/videos/';
                            $filename               = $file->getClientOriginalName();
                            $file->move($destinationPath,$filename);
                            $filepath =  \URL::to('/') . '/' . $destinationPath.$filename;
                        endif;
                    endif;  
                else:
                    return 'erroupload';             
                endif;
            break; # Message Audio
            case 'video':
                // Upload Vídeo
                if ($file->isValid()):
                    if($file->getSize() >= 10048576 * 4):
                        return 'arquivogrande';
                    else:
                        $file_ex = $file->getClientOriginalExtension();

                        if (!in_array($file_ex, array('mp4'))):                             
                            return 'formatoinvalido';
                        else:
                            $destinationPath        = 'uploads/videos/';
                            $filename               = $file->getClientOriginalName();                               
                            $file->move($destinationPath,$filename);
                            $filepath = \URL::to('/') . '/' . $destinationPath.$filename;
                        endif;
                    endif;  
                else:
                    return 'erroupload';             
                endif;
            break; # Message Vídeo            
        endswitch;
        /* End Tipo de mensagem */

        /* Mensagem */
        if(!empty($dados['message_content'])):
            $message = $dados['message_content']; # Tipo de mensagem
        endif;
        /* End Mensagem */

        /* Salvando Message */       
        if(count($target) > 0):
            foreach($target as $number):
                $dados = [
                    'user_id'           => \Auth::user()->id,
                    'message_name'      => \Auth::user()->name,
                    'message_to'        => $number,
                    'message_type'      => $dados['message_type'],
                    'message_data'      => date("Y-m-d H:i:s"),
                    'message_content'   => (!empty($message) ? $message : ""),
                    'message_status'    => 'send',
                    'message_midia'     => $filepath     
                ];
                
                Message::create($dados); # Salvando mensagem
            endforeach; 

            return 'sucesso'; 
        else:
            return 'error';
        endif;  



    }

    /**
     * Send Messages
     *
     * If an inbound message is detected, this method will
     * store the details so that it can be shown to the user
     * at a suitable time.
     *
     * @param string $type Type message
     * @param string $target Numbers Target
     * @param string $message Body messages
     * @param string $filepath Path Midia for messages 
     *
     * @return void
     */
    public function SendMessage($file, $dados, $target)
    { 
        if($this->connected == false):
            $this->connectToWhatsApp();        
        endif; 
   
        if(!empty($dados['all_con']) and $dados['all_con'] == 'on'):
			$con = Contacts::where('user_id', \Auth::user()->id)->get(['con_number']);
			if(count($con) > 0):
				foreach ($con as $key => $value):
					$target[] = $value->con_number;
				endforeach;
			endif;
			unset($dados['all_con']);
		endif;

		//$this->contactsSync($target); # Sincronizando os contatos

		if(!empty($dados['message_type'])):
			$type = $dados['message_type']; # Tipo de mensagem
		endif;

		if(!empty($dados['message_content'])):
			$message = $dados['message_content']; # Tipo de mensagem
		endif;

        if($this->whatsapp->pollMessage() && $type !== ''):
            if(!empty($type)):
                switch (trim($type)):
                    case 'message':
                    	$i = 0;
                        foreach($target as $number):
                            sleep(rand(5, 15));

                            $this->whatsapp->sendMessageComposing($number);
                            $this->whatsapp->sendMessagePaused($number);                                

                            $this->wp_id[$i]['message_number']  = $number;
                            $this->wp_id[$i]['message_id_send'] = $this->whatsapp->sendMessage($number, $message);

                        $i++; 
                        endforeach;
                        break; # Message simple
                    case 'image':
                    	// Upload de imagem
						if (!empty($file)):
							if($file->getSize() >= 10048576 * 4):
								return 'arquivogrande';
							else:
								$upload = new \App\Library\UploadHelpers();
				                if ($upload->ImageUpload($file)):
				                    $dados['message_midia'] = './uploads/' .$upload->NomeArquivo(); 
				                endif;		
							endif;               
				        endif;

				        $filepath = $dados['message_midia'];

                        $i = 0;
                        foreach($target as $number):
                            sleep(rand(5, 15));
                            $this->whatsapp->sendMessageComposing($number);                                
                            $this->whatsapp->sendMessagePaused($number);

                            $this->wp_id[$i]['message_number']  = $number;
                            $this->wp_id[$i]['message_id_send'] = $this->whatsapp->sendMessageImage($number, $filepath);
                        $i++;
                        endforeach;
                        break; # Message Image
                    case 'audio':
	                    // Upload audio
						if ($file->isValid()):
							if($file->getSize() >= 1048576 * 2):
								return 'arquivogrande';
							else:
								$file_ex = $file->getClientOriginalExtension();
								if (!in_array($file_ex, array('mp3'))):
									return 'formatoinvalido';
								else:
									$destinationPath 		= './uploads/videos/';
									$filename 				= $file->getClientOriginalName();
									$file->move($destinationPath,$filename);
									$dados['message_midia'] = $destinationPath.$filename;
								endif;
							endif;  
						else:
							return 'erroupload';             
				        endif;

				        $filepath = $dados['message_midia'];
				        $i = 0;
                        foreach($target as $number):
                            sleep(rand(5, 15));
                            $this->whatsapp->sendMessageComposing($number);                                
                            $this->whatsapp->sendMessagePaused($number);

                            $this->wp_id[$i]['message_number']  = $number;
                            $this->wp_id[$i]['message_id_send'] = $this->whatsapp->sendMessageAudio($number, $filepath);
                        $i++; 
                        endforeach;
                        break; # Message Audio
                    case 'video':
                    	// Upload Vídeo
						if ($file->isValid()):
							if($file->getSize() >= 10048576 * 4):
								return 'arquivogrande';
							else:
								$file_ex = $file->getClientOriginalExtension();

								if (!in_array($file_ex, array('mp4'))):								
									return 'formatoinvalido';
								else:
									$destinationPath 		= './uploads/videos/';
									$filename 				= $file->getClientOriginalName();								
									$file->move($destinationPath,$filename);
									$dados['message_midia'] = $destinationPath.$filename;
								endif;
							endif;  
						else:
							return 'erroupload';             
				        endif;

				        $filepath = $dados['message_midia'];
				        $i = 0;
                        foreach($target as $number):
                            sleep(rand(5, 15));
                            $this->whatsapp->sendMessageComposing($number);                                
                            $this->whatsapp->sendMessagePaused($number);
                            
                        	$this->wp_id[$i]['message_number']  = $number;
                            $this->wp_id[$i]['message_id_send'] = $this->whatsapp->sendMessageVideo($number, $filepath);
                        $i++; 
                        endforeach;
                        break; # Message Vídeo
                    case 'locationname':
                        $this->wp_id[]['message_number']  = $number;
                        $this->wp_id[]['message_id_send'] = $this->whatsapp->sendBroadcastPlace($target, $userlong, $userlat, $locationname, null);
                        break; # Location                    
                endswitch;
            endif;
            $this->whatsapp->pollMessage();
           

            // Gravando mensagem no banco de dados
            if(count($this->wp_id) > 0):
				foreach ($this->wp_id as $value):
					$dados['message_name'] 		= \Auth::user()->name;
            		$dados['user_id'] 			= \Auth::user()->id;
					$dados['message_id_send'] 	= $value['message_id_send']; # salvando id do numero
					$dados['message_to'] 		= $value['message_number']; # salvando os numeros
					$dados['message_type']		= $dados['message_type'];
					$dados['message_data'] 		= date("Y-m-d H:i:s");

					Message::create($dados); # Salvando mensagem
				endforeach;
			endif;

			if(count($this->messages) > 0):
				foreach($this->messages as $msg):
					$messages_dados['message_id_received']	= $msg['id'];
					$messages_dados['message_name']			= $msg['name'];
					$messages_dados['message_from'] 		= $msg['from'];
					$messages_dados['message_to'] 			= $msg['phone'];
					$messages_dados['message_content'] 		= $msg['data'];
					$messages_dados['message_times'] 		= $msg['time'];
                    $messages_dados['message_type']         = 'message';
					$messages_dados['user_id']		   		= \Auth::user()->id;	

					Message::create($messages_dados);
				endforeach;
			endif;

        	return 'sucesso'; # Returne Message
        else:
            return 'erro';
        endif;
    }

    /**
    * Send Simple Message
    * Enviar mensagem simples
    *
    * @param [number] Numero de telefone
    * @return
    */
    public function SendSimpleMessage($number, $message)
    {
        if($this->connected == false):
            $this->connectToWhatsApp();        
        endif; 
       
    	if(empty($number) or empty($message)):
    		return 'camposvazio';
    	else:
	    	if($this->whatsapp->pollMessage()):

                $this->whatsapp->sendSync([$number]);

                sleep(rand(1, 3)); # Sleep
                $this->whatsapp->sendMessageComposing($number); # Composing
                sleep(rand(3, 5)); # Sleep
                $this->whatsapp->sendMessagePaused($number); # Pause
                sleep(1); # Sleep
                

	    		$id = $this->whatsapp->sendMessage($number, $message);
                $this->whatsapp->pollMessage();

                if(!empty($id)):
                    $dados                      = array();
                    $dados['message_name']      = \Auth::user()->name;
                    $dados['user_id']           = \Auth::user()->id;
                    $dados['message_id_send']   = $id; # salvando id do numero
                    $dados['message_to']        = $number; # salvando os numeros
                    $dados['message_type']      = 'message';
                    $dados['message_data']      = date("Y-m-d H:i:s");
                    $dados['message_content']   = $message;
                    $dados['message_status']    = 'done';

                    Message::create($dados); # Salvando mensagem
                    return 'sucesso';
                endif;	    		
	    	endif;
	    endif;
    }


    /**
     * Process inbound text messages.
     *
     * If an inbound message is detected, this method will
     * store the details so that it can be shown to the user
     * at a suitable time.
     *
     * @param string $phone The number that is receiving the message
     * @param string $from  The number that is sending the message
     * @param string $id    The unique ID for the message
     * @param string $type  Type of inbound message
     * @param string $time  Y-m-d H:m:s formatted string
     * @param string $name  The Name of sender (nick)
     * @param string $data  The actual message
     *
     * @return void
     */
    public function processReceivedMessage($phone, $from, $id, $type, $time, $name, $data)
    {
        $matches = null;
        $time = date('Y-m-d H:i:s', $time);
        if (preg_match('/\d*/', $from, $matches)) {
            $from = $matches[0];
        }
        $this->messages[] = ['phone' => $phone, 'from' => $from, 'id' => $id, 'type' => $type, 'time' => $time, 'name' => $name, 'data' => $data];

        if(!empty($this->whatsapp->pollMessage())):
            for($i = 0; $i < 2; $i++):
                while ($this->whatsapp->pollMessage());           
            endfor;

            if(count($this->messages) > 0):
                foreach($this->messages as $msg):
                    $messages_dados['message_id_received']  = $msg['id'];
                    $messages_dados['message_name']         = $msg['name'];
                    $messages_dados['message_from']         = $msg['from'];
                    $messages_dados['message_to']           = $msg['phone'];
                    $messages_dados['message_content']      = $msg['data'];
                    $messages_dados['message_times']        = $msg['time'];
                    $messages_dados['message_type']         = 'message';
                    $messages_dados['user_id']              = \Auth::user()->id;    

                    Message::create($messages_dados);
                endforeach;

                return 'carregada';
            endif;
        endif;  
        
    }

    /**
    * Check Messages
    * Verifica mensagem
    *
    * @return
    */
    public function checkMessages()
    {   

        if(!empty($this->whatsapp->pollMessage())):
            for($i = 0; $i < 2; $i++):
                while ($this->whatsapp->pollMessage());           
            endfor;

            if(count($this->messages) > 0):
                foreach($this->messages as $msg):
                    $messages_dados['message_id_received']  = $msg['id'];
                    $messages_dados['message_name']         = $msg['name'];
                    $messages_dados['message_from']         = $msg['from'];
                    $messages_dados['message_to']           = $msg['phone'];
                    $messages_dados['message_content']      = $msg['data'];
                    $messages_dados['message_times']        = $msg['time'];
                    $messages_dados['message_type']         = 'message';
                    $messages_dados['user_id']              = \Auth::user()->id;    

                    Message::create($messages_dados);
                endforeach;

                return 'carregada';
            endif;
        endif;  
    }

    /**
    * Get Read Graph Message
    * Lendo graph messages
    *
    * @return [json]
    */
    public function getReadGraphMessages()
    {
        $sall_messages  = Message::where('user_id', \Auth::user()->id)->where('message_status', 'done')->orWhere('message_status', 'send')->count(); # A Enviar
        $done_messages  = Message::where('user_id', \Auth::user()->id)->where('message_status', 'done')->count(); # Enviado
        $total_messages = (int)ceil(( $done_messages * 100 ) / $sall_messages); # Porcetagem

        $return = [
            'all'   => $sall_messages,
            'done'  => $done_messages,
            'total' => $total_messages
        ];

        return \Response::json($return);  
    }
  

    /**
     * Sets flag when there is a connection with WhatsAPP servers.
     *
     * @return void
     */
    public function onConnect($mynumber, $socket)
    {
        $this->status = 'connected';
        $this->connected = true;
    }

    /**
    *
    *
    *
    */
    public function onDisconnect($mynumber, $socket)
    {
        $this->status = 'disconnected';
        $this->connected = false;
    }

    /**
    *
    *
    *
    */
    public function onPresenceAvailable( $mynumber, $from ) 
    {

    }

    /**
    *
    *
    *
    */
    public function onPresenceUnavailable( $mynumber, $from, $last )
    {

    }

    /**
    *
    *
    *
    */
    public function onPing( $mynumber, $id )
    {

    }

    /**
    *
    *
    *
    */
    public function onGetStatus( $mynumber, $from, $requested, $id, $time, $data )
    {

    }


    /**
    *
    *
    *
    */
    public function onSendPong( $mynumber, $msgid )
    {

    }



    /**
     * Cleanly disconnect from Whatsapp.
     *
     * Ensure at end of script, if a connected had been made
     * to the whatsapp servers, that it is nicely terminated.
     *
     * @return void
     */
  
    public function __destruct()
    {
        if (!empty($this->whatsapp) && $this->connected) {
            $this->whatsapp->disconnect();
        }
    }









}