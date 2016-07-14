<?php

namespace App\Services;

require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/Registration.php'));
require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/whatsprot.class.php'));


use App\Models\User; # User
use App\Models\Settings; # Settings

class WhatsappService 
{
    private $debug              = false;
    private $username;
    private $identity           = "identity";
    private $nickname;
    private $login;
    private $password; 
    private $imageCover;
    
    private $messages           = array();
    private $wp_id              = array();
    private $contacts           = array();       
    private $whatsapp;
    private $connected;
    private $status;
    private $waGroupList        = array();
    private $input              = array();
    private $whatsappMessages   = array();
    private $verNumber;
    private $server             = array();

    /**
    * 
    *
    * @return
    */
    public function __construct()
    { 
        if(!empty($this->settings())):          
            $this->nickname     = $this->settings()->set_name; # Name
            $this->login        = $this->settings()->set_number; # Login
            $this->password     = $this->settings()->set_password; # Password
            $this->imageCover   = $this->settings()->set_avatar; # Image
        endif;   

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
        $this->whatsapp     = new \WhatsProt($this->login, $this->nickname, $this->debug);   
        // Eventos            
        $this->whatsapp->eventManager()->bind('onGetServerProperties', [$this, 'onGetServerProperties']);
        $this->whatsapp->eventManager()->bind('onGetSyncResult', [$this, 'onSyncResult']);
        $this->whatsapp->eventManager()->bind('onGetProfilePicture', [$this, 'onGetProfilePicture']);
        $this->whatsapp->eventManager()->bind('onGetMessage', [$this, 'processReceivedMessage']);
        $this->whatsapp->eventManager()->bind('onSendMessage', [$this, 'onSendMessage']);
        $this->whatsapp->eventManager()->bind('onPresenceAvailable', [$this, 'onPresenceAvailable']);
        $this->whatsapp->eventManager()->bind('onPresenceUnavailable', [$this, 'onPresenceUnavailable']);
        $this->whatsapp->eventManager()->bind('onConnect', [$this, 'connected']);
        $this->whatsapp->eventManager()->bind('onGetGroups', [$this, 'processGroupArray']);

        if ($this->connected == false): 
            $this->whatsapp->connect(); // Connect to WhatsApp network      
            $this->whatsapp->loginWithPassword($this->password); 

            $this->whatsapp->sendClientConfig();
            $this->whatsapp->sendGetServerProperties();
            $this->whatsapp->sendGetBroadcastLists();
            $this->whatsapp->sendGetClientConfig(); // Get client config [Done automatically by the API]
            $this->whatsapp->sendGetServerProperties(); // Get server properties
                                  

            return $this->whatsapp;
        else:
            return false;    
        endif;
            
    }

    /**
     * Check Message
     * Verifica se existe mensagem
     *
     * @return void
     */
    public function checkMessage()
    {
        while ( $this->whatsapp->pollMessage() );
        $data =  $this->whatsapp->getMessages();
        foreach ($data as $item):
            $from = explode("@", $item->getAttribute("from"));
            
            $dados['from'] = $from[0];
            $dados['name'] = $item->getAttribute("notify");
            
            if ($item->getAttribute("type") == "text") {
               $dados['text'] = $item->getChild("body")->getData();
            } else {
               $dados['media'] = $item->getChild("media")->getAttribute("url");
            }

            $this->whatsappMessages[] = $dados;
        endforeach;
    }

    /**
    * Check Number Phone
    * Verifica o numero de telefone
    *
    * @return
    */
    public function checkNumberPhone($number)
    {
        $this->connectToWhatsApp();        
        $this->whatsapp->sendSync([$number]);

        if($this->verNumber):
            return true;
        else:
            return false;
        endif;
    }

    /**
    * Get Server Properties
    * Lendo as propriedades
    *
    * @param $mynumber
    * @param $version
    * @param $props
    *
    * @return
    */
    public function onGetServerProperties( $mynumber, $version, $props )
    {
        $this->server = $props;
    }


    /**
     * Send Message
     * Recebe a mensagem envada pelo sistema
     *
     * @param $mynumber Numero que está enviando
     * @param $target Para quem estou enviando
     * @param $messageId ID da Mensagem
     * @param $node Mensagem
     * 
     * @return void
     */
    public function onSendMessage( $mynumber, $target, $messageId, $node )
    {

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
    }


    
    

    /**
     * ENVIAR MENSAGEM
     * Envia mensagens para usuarios
     *
     * @param $type Tipo de Mensagem [message], ['image'], [audio], [video]
     * @return 
     */
    /*
    public function SendMessage($type, $target, $message = null, $filepath = null)
    {  

        $this->connectToWhatsApp(); # Conectando ao whatsapp
        $this->contactsSync($target); # Sincronizando os contatos
        
        // Mudar a logo da LineXTI
        //$this->whatsapp->sendSetProfilePicture('https://scontent-gru2-1.xx.fbcdn.net/hphotos-xla1/v/t1.0-9/12523165_428159720717629_8468772225043721737_n.png?oh=9907d4304642d0ebcd30ac022a06102b&oe=573F7AA2');

        if(!in_array("", $target)):
            foreach ($target as $number):
                $this->whatsapp->sendMessageComposing($number); // Send composing
                $this->whatsapp->sendMessagePaused($number); // Send paused
            endforeach;
        endif;  

        if($this->whatsapp->pollMessage() && $type !== ''):
            if (!empty($type) && trim($type === 'message')) {
                $this->wp_id[] = $this->whatsapp->sendBroadcastMessage($target, $message);
            }
            if (!empty($type) && trim($type === 'image')) {
                $this->wp_id[] = $this->whatsapp->sendBroadcastImage($target, $filepath);
            }
            if (!empty($type) && trim($type === 'audio')) {
                $this->wp_id[] = $this->whatsapp->sendBroadcastAudio($target, $filepath);
            }
            if (!empty($type) && trim($type === 'video')) {
                $this->wp_id[] = $this->whatsapp->sendBroadcastVideo($target, $filepath);
            }
            if (!empty($type) && trim($type === 'locationname')) {
                //$this->whatsapp->sendBroadcastPlace($target, $this->inputs['userlong'], $this->inputs['userlat'], $this->inputs['locationname'], null);
            }

            return $this->messages;
        else:
            return false;
        endif;
    }
    */

    public function sendPresenceSubscription($to)
    {
        $this->connectToWhatsApp();
        $teste = $this->whatsapp->sendPresenceSubscription($to); // Novo usuario
        $w->sendPresenceUnsubscription($to); // Remover
    }



    public function onGetProfilePicture( $mynumber, $from, $type, $data )
    {

    }



    /** 
     * Contacts Sync
     * Atualiza status do usuário
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
        $this->whatsapp->sendSync($numbers);
    }

    /**
     * SYNC RESULT
     * Verifica se o numero já foi sincronizado
     *
     * @param $result SyncResult
     */
    public function onSyncResult($result)
    {               
        foreach ($result->existing as $number) {
            $this->verNumber = true;
            // "$number exists<br />";
            //$n = explode("@", $number);
            //$phone = $n[0];             
        }
        
        foreach ($result->nonExisting as $number) {
            $this->verNumber = false;
            //echo "$number does not exist<br />";            
            //$this->whatsapp->sendPresenceSubscription($number); # Sincroniza o numero
        }
    }

    /**
    * Presence Available
    *
    *
    * @param $username
    * @param $from
    */
    public function onPresenceAvailable($username, $from)
    {
        $dFrom = str_replace(['@s.whatsapp.net', '@g.us'], '', $from);
        //echo "<$dFrom is online>\n\n";
    }

     /**
    * Presence Available
    *
    *
    * @param $username
    * @param $from
    * @param $last
    */
    public function onPresenceUnavailable($username, $from, $last)
    {
        $dFrom = str_replace(['@s.whatsapp.net', '@g.us'], '', $from);
        //echo "<$dFrom is offline> Last seen: $last seconds\n\n";
    }


    /** 
     * Update Status
     * Atualiza status do usuário
     *
     * @return void
     */
    private function updateStatus()
    {
        if (isset($this->inputs['status']) && trim($this->inputs['status']) !== '') {
            $this->whatsapp->sendStatusUpdate($this->inputs['status']); 

            dd($this->inputs);          
        } else {
            // Erro
        }
    }

   

    /**
     * Sets flag when there is a connection with WhatsAPP servers.
     *
     * @return void
     */
    public function connected()
    {
        $this->connected = true;
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
        if (isset($this->whatsapp) && $this->connected) {
            $this->whatsapp->disconnect();
        }
    }


    /* GRUPOS ***********************************************/

    /**
    * Create Group
    * Criando um novo grupo
    *
    * @return
    */
    public function createGroup()
    {
        $participants = array([]);
        $w->sendGroupsChatCreate("My new Group chat", $participants);
    }

    /**
    * Delete Group
    * Deletando um grupo
    *
    * @return
    */
    public function deleteGroup()
    {
        $w->sendGroupsLeave($groupId);
    }



    

}




  