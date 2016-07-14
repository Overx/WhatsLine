<?php

namespace App\Services;

require_once(base_path('vendor' . DIRECTORY_SEPARATOR . 'whatsapp/chat-api/src/whatsprot.class.php'));

use Carbon\Carbon;
use App\Models\User;
use App\Models\Settings;
use App\Models\Contacts;
use App\Models\Groups;

class GroupsService
{

	private $debug       = false;
    private $username;
    private $identity    = "identity";
    private $nickname;
    private $company;
    private $imageCover;
        
    // Messages
    private $messages    = array();

    // Login
    private $wp_id       = array();
    private $login;
    private $password;    
    private $whatsapp;
    private $groups;
    private $groupsList;

    // Status
    private $connected;
    private $status;
    

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
            //$this->debug        = $this->settings()->set_debug;
             
            if($this->connected == false):
                $this->connectToWhatsApp();
            endif; 
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
        $this->whatsapp = new \WhatsProt($this->login, $this->nickname, $this->debug);
        $this->whatsapp->eventManager()->bind('onConnect',              [$this, 'onConnect']);
        $this->whatsapp->eventManager()->bind('onGetError',             [$this, 'onGetError']);
        $this->whatsapp->eventManager()->bind('onDisconnect',           [$this, 'onDisconnect']);
        $this->whatsapp->eventManager()->bind("onPresenceAvailable",    [$this, "onPresenceAvailable"]);
        $this->whatsapp->eventManager()->bind("onPresenceUnavailable",  [$this, "onPresenceUnavailable"]);
        $this->whatsapp->eventManager()->bind("onGetStatus",            [$this, "onGetStatus"]);
        $this->whatsapp->eventManager()->bind("onPing",                 [$this, "onPing"]);
        $this->whatsapp->eventManager()->bind("onSendPong",             [$this, "onSendPong"]);
        $this->whatsapp->eventManager()->bind("onGetGroups",            [$this, "onGetGroups"]);
        $this->whatsapp->eventManager()->bind("onGetGroupV2Info",       [$this, "onGetGroupV2Info"]);
        $this->whatsapp->eventManager()->bind("onGetProfilePicture",    [$this, "onGetProfilePicture"]);
        
        if ($this->connected == false): 
            $this->whatsapp->connect(); // Connect to WhatsApp network      
            $this->whatsapp->loginWithPassword($this->password); 

            $this->whatsapp->sendClientConfig();
            $this->whatsapp->sendGetServerProperties();
            $this->whatsapp->sendGetBroadcastLists();
            $this->whatsapp->sendGetGroups();

                                  

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
    public function onGetProfilePicture( $mynumber, $from, $type, $data )
    {

    }

    /**
    *
    *
    *
    * @return
    */
    public function onGetGroups( $mynumber, $groupList )
    {      
        $this->groups = $groupList;

        // Verificar se o Grupo existe, caso não exista, salve.
    }

    /**
    *
    *
    *
    * @return
    */
    public function getGroupChat()
    {

    }

    /**
     * Sets flag when there is a connection with WhatsAPP servers.
     *
     * @return void
     */
    public function onGetGroupV2Info( $mynumber, $group_id, $creator, $creation, $subject, $participants, $admins, $fromGetGroup )
    {
        $this->groupsList['mynumber']       = $mynumber;
        $this->groupsList['group_id']       = $group_id;
        $this->groupsList['creator']        = explode("@", $creator)[0];
        $this->groupsList['subject']        = $subject;
        $this->groupsList['participants']   = $participants;
        $this->groupsList['admins']         = $admins;
        $this->groupsList['fromGetGroup']   = $fromGetGroup;

        if(count($participants) > 0):
            foreach($participants as $p):
                $number = explode("@", $p)[0];

                $dados  = [
                    'gpp_group_id'  => $group_id,
                    'gpp_number'    => $number
                ];

                $part = \DB::table('group_participants')->where('gpp_group_id', $group_id)->where('gpp_number', $number)->first();
                if(empty($part)):
                    \DB::table('group_participants')->insert($dados);
                endif;
            endforeach;
        endif;
    }

    /**
    *
    *
    *
    * @return
    */
    public function getListGroups()
    {
        return Groups::getListGroups();
    }


    /**
    * Create Groups
    * Criando um grupo
    *
    * @return
    */
    public function createGroups($title, $participants, $all_con, $file)
    {
        $filepath = '';

        if(!empty($all_con) && $all_con == 'on'):
            $con = Contacts::where('user_id', \Auth::user()->id)->get(['con_number']);
            if(count($con) > 0):
                foreach ($con as $key => $value):
                    $participants[] = $value->con_number;
                endforeach;
            endif;
        endif;

        $group_id = $this->whatsapp->sendGroupsChatCreate($title, $participants);

        if(!empty($group_id)):
              

            $dados = [
                'user_id'       => \Auth::user()->id,
                'gp_group_id'   => $group_id,
                'gp_subject'    => $title,
                'gp_data'       => date("Y-m-d")
            ];

            $group = Groups::where('user_id', \Auth::user()->id)->where('gp_group_id', $group_id)->first();  
            if(!empty($group)):
                $id = $group->gp_id;

                if (!empty($file)):
                    if($file->getSize() >= 10048576 * 4):
                        return 'arquivogrande';
                    else:
                        $imagem = Groups::where("gp_id", $id)->where("gp_image", "!=", '')->first();
                        if (isset($imagem) && $imagem->gp_image != '' && \File::exists('uploads/' . $imagem->gp_image)) {
                            \File::delete('uploads/' . $imagem->gp_image);
                        }

                        $upload = new \App\Library\UploadHelpers();
                        if ($upload->ImageUpload($file)):
                            $filepath = \URL::to('/') . '/' . 'uploads/' .$upload->NomeArquivo();
                            $this->whatsapp->sendSetGroupPicture($group_id, $filepath); 
                        endif;      
                    endif;
                    $dados['gp_image'] = $filepath;              
                endif;

                if(Groups::where('user_id', \Auth::user()->id)->where('gp_id',  $id)->update($dados)):
                    return 'sucesso';
                endif;
            else:
                if (!empty($file)):
                    if($file->getSize() >= 10048576 * 4):
                        return 'arquivogrande';
                    else:

                        $upload = new \App\Library\UploadHelpers();
                        if ($upload->ImageUpload($file)):
                            $filepath = \URL::to('/') . '/' . 'uploads/' .$upload->NomeArquivo();
                            $this->whatsapp->sendSetGroupPicture($group_id, $filepath); 
                        endif;      
                    endif;
                    $dados['gp_image'] = $filepath;              
                endif;

                if(Groups::create($dados)):
                    return 'sucesso';
                endif;
            endif;        
        endif;
    }

    /**
    * Delete Groups
    * Deletando grupo
    *
    * @return
    */
    public function deleteGroup($groupId)
    {    
        if(!empty($groupId)):
            $imagem = Groups::where("gp_group_id", $groupId)->where("gp_image", "!=", '')->first();
            if (isset($imagem) && $imagem->gp_image != '' && \File::exists('uploads/' . $imagem->gp_image)) {
                \File::delete('uploads/' . $imagem->gp_image);
            }

            if(Groups::where('gp_group_id', $groupId)->delete()):
                $this->whatsapp->sendGroupsLeave($groupId);
                return 'sucesso';
            endif;            
        endif;
    }


    /**
    * Manage Groups
    * Gerenciar grupo, adicionando administrador
    *
    * @param [gid] Id do grupo
    * @param [participants] numero dos participantes
    * @return
    */
    public function addAdminGroups($gId, $participants)
    {
        if(!empty($gId) && !empty($participants)):
            $this->whatsapp->sendPromoteParticipants($gId, $participants);
        endif;
    }

    /**
    * Manage Groups
    * Gerenciar grupo, remover administrador
    *
    * @param [gid] Id do grupo
    * @param [participants] numero dos participantes
    * @return
    */
    public function removerAdminGroup($gId, $participants)
    {
        if(!empty($gId) && !empty($participants)):
            $this->whatsapp->sendDemoteParticipants($gId, $participants);
        endif;
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
    public function onGetError( $mynumber, $from, $id, $data )
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
    /*
    public function __destruct()
    {
        if (!empty($this->whatsapp) && $this->connected) {
            $this->whatsapp->disconnect();
        }
    }
    */









}