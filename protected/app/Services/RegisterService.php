<?php

namespace App\Services;

require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/Registration.php'));
require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/whatsprot.class.php'));


use App\Models\User;
use App\Models\Settings;

class RegisterService 
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
    private $register;

    /**
    * 
    *
    */
    public function __construct()
    {        
    
        
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
        $this->register = new \Registration($this->login, $this->debug);
        $this->whatsapp = new \WhatsProt($this->login, $this->nickname, $this->debug);
        $this->whatsapp->eventManager()->bind('onCodeRegister',          [$this, 'onCodeRegister']);
        $this->whatsapp->eventManager()->bind('onCodeRegisterFailed',    [$this, 'onCodeRegisterFailed']);
        $this->whatsapp->eventManager()->bind('onCodeRequest',           [$this, 'onCodeRequest']);
        
        
    }

     /**
     * Sets flag when there is a connection with WhatsAPP servers.
     *
     * @return void
     */
    public function registerNumber($dados)
    {
        
        $this->login = preg_replace("/[^0-9]/", "", "55" . $dados['reg_number']); # Number
        $type        = $dados['reg_tipo'];
        $code        = (!empty($dados['reg_code']) ? $dados['reg_code'] : '');

        $this->connectToWhatsApp();

        if(!empty($type) && !empty($this->login)):       

            if(!empty($code)):
                $r = $this->register->codeRegister(trim($code)); 
            else:
                $this->register->codeRequest(trim($type));
                return 'aguardandocodigo';
            endif;

            if(!empty($r->status) && $r->status == 'ok'):
                // Create Session whatsapp with info user
                \Request::session()->put('whatsapp', $r);
                $this->login    = $r->login;
                $this->password = $r->pw;

                $auth = \Auth::user()->id;

                $data = [
                    'set_number'    => $r->login,
                    'set_password'  => $r->pw,
                    'user_id'       => $auth
                ];

                $verUser = Settings::where('user_id', $auth)->first();
                if(!empty($verUser)):
                    if(Settings::where('user_id', $auth)->update($data)):
                        return 'sucesso';
                    endif;
                else:
                    if(Settings::create($data)):
                        return 'sucesso';
                    endif;
                endif;
            endif;
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
    *
    *
    *
    * @return 
    */
    public function onCodeRegister( $mynumber, $login, $password, $type, $expiration, $kind, $price, $cost, $currency, $price_expiration )
    {

    }
    
    /**
    *
    *
    *
    * @return 
    */
    public function onCodeRegisterFailed( $mynumber, $status, $reason, $retry_after )
    {

    }
    
    /**
    *
    *
    *
    * @return 
    */
    public function onCodeRequest( $mynumber, $method, $length )
    {

    }









}