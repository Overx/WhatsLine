<?php

namespace LineXTI\Whatsapp\Services;

require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/Registration.php'));
require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/whatsprot.class.php'));


use App\Models\User;

class WhatsappService 
{
    private $debug       = false;
    private $username;
    private $identity    = "identity";
    private $nickname    = "LineXTI";
    
    private $messages    = array();
    private $wp_id       = array();
    private $contacts    = array();
    private $login       = "553173185801";
    private $password    = "RdUAtAAYRucOBkLWZ9e/54CVpsM=";    
    private $whatsapp;
    private $connected;
    private $status;
    private $waGroupList = array();
    private $input = array();
    private $whatsappMessages = array();

    /**
    * @var WhatsappRepository;
    */
    public function __construct()
    {        
        $this->connectToWhatsApp(); # Conecta ao Whatsapp


    }


    public function NumberRegistration($username, $code)
    { 
        echo '<pre>';
        // Create an instance of Registration.
        $w = new \Registration($username, $this->debug); $w->codeRequest('sms');
        $r = $w->codeRegister($code);  
        $r->user_id = \Auth::user()->id;   

        if(!empty($r->status) && $r->status == 'ok'):
            // Create Session whatsapp with info user
            \Request::session()->put('whatsapp', $r);
            $this->login    = $r->login;
            $this->password = $r->pw;
        endif;
        echo '</pre>';
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
        
        if (count($this->whatsapp) > 0) {   
            $this->whatsapp->connect(); // Connect to WhatsApp network
            $this->whatsapp->loginWithPassword($this->password); // logging in with the password we got!

            $this->whatsapp->sendGetPrivacyBlockedList(); // Get our privacy list [Done automatically by the API]
            $this->whatsapp->sendGetClientConfig(); // Get client config [Done automatically by the API]
            $this->whatsapp->sendGetServerProperties(); // Get server properties
            $this->whatsapp->sendGetGroups(); // Get groups (participating)
            $this->whatsapp->sendGetBroadcastLists(); // Get broadcasts lists

            // Eventos
            $this->whatsapp->eventManager()->bind('onGetSyncResult', [$this, 'onSyncResult']);
            $this->whatsapp->eventManager()->bind('onGetProfilePicture', [$this, 'onGetProfilePicture']);
            $this->whatsapp->eventManager()->bind('onGetMessage', [$this, 'processReceivedMessage']);

            $this->whatsapp->eventManager()->bind('onSendMessage', [$this, 'onSendMessage']);

            $this->whatsapp->eventManager()->bind('onConnect', [$this, 'connected']);
            $this->whatsapp->eventManager()->bind('onGetGroups', [$this, 'processGroupArray']);

            return true;
        }
        return false;
    }

     /**
     * CHECK MENSSAGE
     * Verifica se existe mensagem
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
     * SEND MENSAGEM
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
     * SYNC RESULT
     * Verifica se o numero já foi sincronizado
     * @param $result SyncResult
     */
    public function onSyncResult($result)
    {
        /*        
        foreach ($result->existing as $number) {
            echo "$number exists<br />";
        }
        */
        foreach ($result->nonExisting as $number) {
            $whatsapp->sendPresenceSubscription($number); # Sincroniza o numero
        }
    }
    
    /**
     * ENVIAR MENSAGEM
     * Envia mensagens para usuarios
     * @param $type Tipo de Mensagem [message], ['image'], [audio], [video]
     */
    public function SendMessage($type, $target, $message = null, $filepath = null)
    {  
        $this->connectToWhatsApp();
        $this->contactsSync($target); // Sincronizando os contatos

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


            return true;
        else:
            return false;
        endif;
    }

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
     * CONTACTS SYNC
     * Atualiza status do usuário
     * @return void
     */
    private function contactsSync($contacts)
    {
        return $this->whatsapp->sendSync($contacts);
    }


    /** 
     * UDPATE STATUS
     * Atualiza status do usuário
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
     * Process the event onGetGroupList and sets a formatted array of groups the user belongs to.
     *
     * @param string $phone      The phone number (jid ) of the user
     * @param array  $groupArray Array with details of all groups user eitehr belongs to or owns.
     *
     * @return array|bool
     */
    public function processGroupArray($phone, $groupArray)
    {
        $formattedGroups = [];

        if (!empty($groupArray)) {
            foreach ($groupArray as $group) {
                $formattedGroups[] = ['name' => 'GROUP: '.$group['subject'], 'id' => $group['id']];
            }

            $this->waGroupList = $formattedGroups;

            return true;
        }

        return false;
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

    public function createGroup()
    {
        $participants = array([]);
        $w->sendGroupsChatCreate("My new Group chat", $participants);
    }

    public function deleteGroup()
    {
        $w->sendGroupsLeave($groupId);
    }









}


  