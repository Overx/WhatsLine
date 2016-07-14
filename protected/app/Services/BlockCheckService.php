<?php

namespace App\Services;

require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/Registration.php'));
require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/whatsprot.class.php'));


use App\Models\User;
use App\Models\Settings;

class BlockCheckService 
{

	private $debug       = false;
    private $username;
    private $identity    = "identity";
    private $nickname;
    private $imageCover;
    
    private $messages    = array();
    private $wp_id       = array();
    private $login;
    private $password;    
    private $whatsapp;
    private $return;

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
                   
            $this->connectToWhatsApp();
        endif;
    }

    /**
    * Settings
    * Method 
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
        $this->whatsapp = new \Registration($this->login, $this->debug);
        $this->return   = $this->whatsapp->checkCredentials();
        
        $this->whatsapp->eventManager()->bind('onCredentialsBad',       [$this, 'onCredentialsBad']);
        $this->whatsapp->eventManager()->bind('onCredentialsGood',      [$this, 'onCredentialsGood']);
    }

    /**
    *
    *
    *
    * @return 
    */
    public function CheckNumberPhone()
    {
        return (!empty($this->return) ? $this->return : '');
    }

    /**
    *
    *
    *
    * @return 
    */
    public function onCredentialsBad($mynumber, $status, $reason)
    {
        if ($reason == 'blocked') {
            echo "\n\nYour number is blocked \n";
        }
        if ($reason == 'incorrect') {
            echo "\n\nWrong identity. \n";
        }
    }

    /**
    *
    *
    *
    * @return 
    */
    public function onCredentialsGood($mynumber, $login, $password, $type, $expiration, $kind, $price, $cost, $currency, $price_expiration)
    {
        echo "\n\nYour number $mynumber with the following password $password is not blocked \n";
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