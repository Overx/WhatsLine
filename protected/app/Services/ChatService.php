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

class ChatService 
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
        $this->whatsapp->eventManager()->bind('onConnect',              [$this, 'connected']);
        $this->whatsapp->eventManager()->bind('onGetMessage',           [$this, 'processReceivedMessage']);
        $this->whatsapp->eventManager()->bind('onGetImage',             [$this, 'onGetImage']);        
        $this->whatsapp->eventManager()->bind('onGetProfilePicture',    [$this, 'onGetProfilePicture']);
        
        if ($this->connected == false): 
            $this->whatsapp->connect(); // Connect to WhatsApp network      
            $this->whatsapp->loginWithPassword($this->password); 

            if(!empty($this->imageCover)):
                $this->whatsapp->sendSetProfilePicture("./uploads/" . $this->imageCover);
            endif;

            return true;
        endif;

        return false;
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
                $messages_dados['user_id']              = \Auth::user()->id;    

                Message::create($messages_dados);
            endforeach;

            return 'carregada';
        endif;
    }

    /**
    *
    *
    *
    */
    public function checkMessages()
    {
    	
    }

    /** CHAT ***************************************************************/

    /**
    *
    *
    * @return []
    */
    public function getSearch($search)
    {
        if(!empty($search)):
            $contacts = Contacts::where('user_id', \Auth::user()->id)
            ->where('con_name', 'LIKE', "%$search%")
            ->orWhere('con_number', 'LIKE', "%$search%")
            ->get();
            
            return \Response::json($contacts);
        endif;
    }

    /**
    *
    *
    * @return []
    */
    public function getReadContactsChat()
    {
        $user_id = \Auth::user()->id;

        $contacts = Contacts::where('user_id', $user_id)->get();
        if(count($contacts) > 0):
            foreach($contacts as $con):
                $con->total = 0;
                $con->total = Message::where('user_id', $user_id)->where('message_from', $con->con_number)->count();
            endforeach;

            return \Response::json($contacts);
        endif;
    }

    /**
    *
    *
    * @return []
    */
    public function getMessageChat($id)
    {
        $user_id = \Auth::user()->id;

        $messages = Message::where('user_id', $user_id)
                    ->where('message_to', $id)
                    ->orWhere('message_from', $id)
                    ->get();

        if(!empty($messages)):
            return \Response::json($messages);
        endif;
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
        if (!empty($this->whatsapp) && $this->connected) {
            $this->whatsapp->disconnect();
        }
    }









}