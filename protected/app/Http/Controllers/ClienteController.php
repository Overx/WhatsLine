<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\LayoutRepository;

//Services
use App\Services\ClienteService;
use App\Services\MessagesService;
use App\Services\RegisterService;
use App\Services\ChatService;
use App\Services\GroupsService;

class ClienteController extends Controller
{
   

    /** ADMIN ***************************************************************************************/

    /**
    * VIEW HOME
    * Mostrando a view para home
    *
    * @return View
    */
    public function index()
    {
        $style      = LayoutRepository::renderStyle()->tables;

        $script     = LayoutRepository::renderScript()->tables;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/home.js');
        
                
        $dados      = array(
            'style'         => $style,
            'script'        => $script,
            'contatos'      => ClienteService::ListContacts(),
            'mensagens'     => ClienteService::ReadAllMessages()
        );        
        return view('cliente.home.index', $dados);
    }

    /**
    * Chat
    * Abre a view de chat
    *
    * @return View
    */
    public function getChat()
    {
        $style      = LayoutRepository::renderStyle()->tables;

        $script     = LayoutRepository::renderScript()->tables;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/chat.js');
        
                
        $dados      = array(
            'style'         => $style,
            'script'        => $script
        );        
        return view('cliente.chat.index', $dados);
    }
    
    /**
    * Get Search
    * Buscar contato
    *
    * @return
    */
    public function getSearch()
    {
        $search = \Input::get('search_term');
        $chat   = new ChatService();
        return $chat->getSearch($search);
    }

    /**
    * Get Read Contacts Chat
    * Lendo contatos
    *
    * @return
    */
    public function getReadContactsChat()
    {
        $chatContacts = new ChatService();
        return $chatContacts->getReadContactsChat();
    }

    /**
    * Get Message Chat
    * Lendo mensagens de um contato
    *
    * @param [id] int
    * @return
    */
    public function getMessageChat($id)
    {
        $chat   = new ChatService();
        return $chat->getMessageChat($id);
    }

    /**
    * Send Simple Message
    * Enviando uma simples mensagens
    * 
    * @param [number]
    * @return
    */
    public function sendSimpleMessage()
    {
        $number    = \Input::get('number');
        $message   = \Input::get('message');

        $messages       = new MessagesService();
        $SimpleMessage  = $messages->SendSimpleMessage($number, $message);        
        return $SimpleMessage;
    }

    /**
    * VIEW AGENDA
    * Mostrando a view Agenda
    *
    * @return View
    */
    public function getAgenda()
    {
        $style      = LayoutRepository::renderStyle()->tables;
        $style     .= LayoutRepository::renderStyle()->form;

        $script     = LayoutRepository::renderScript()->tables;
        $script    .= LayoutRepository::renderScript()->form;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/agenda.js');
                
        $dados      = array(
            'style'         => $style,
            'script'        => $script,
            'contatos'      => ClienteService::ListContacts()
        );        
        return view('cliente.agenda.index', $dados);
    }


    /**
    * ADD CONTACT
    * Metodo para adicionar novo contato na agenda
    *
    * @return View
    */
    public function addContact()
    {   
        $dados = \Input::all();
        return ClienteService::addContact($dados);
    }

    /**
    *
    *
    *
    */
    public function uploadCsv()
    {
        $file = \Input::file("file");
        return ClienteService::uploadCsv($file);
    }

    /**
    * READ CONTACT
    * Metodo para realizar leitura de contato pelo id
    *
    * @return [array]
    */
    public function readContact($id)
    {
        $id = base64_decode($id);
        return ClienteService::readContact($id);
    }

    /**
    * UPDATE CONTACT
    * Metodo para realizar leitura de contato pelo id
    *
    * @return [array]
    */
    public function updateContact()
    {   
        $id     = \Input::get('id_editar');
        $dados  = \Input::except('id_editar');
        if(!empty($id)):
            return ClienteService::updateContact($id, $dados);
        endif;        
    }

    /**
    * DELETE CONTACT
    * Metodo para realizar leitura de contato pelo id
    *
    * @return [Notificação]
    */
    public function deleteContact($id)
    {
        if(!empty($id)):
            return ClienteService::deleteContact($id);
        endif; 
    }




    /* CAMPANHAS ****************************************************************************/

    /**
     *
     *
     *
     * @return View
    */
    public function getCampaigns()
    {
        $style   = LayoutRepository::renderStyle()->tables;

        $script  = LayoutRepository::renderScript()->tables;
        $script .= LayoutRepository::createScript('app/js/ajax/cliente/campanhas.js');

        $dados      = array(
            'style'   => $style,
            'script'  => $script
        );        

        return view('cliente.campanhas.index', $dados);
    }

    /**
     *
     *
     *
     * @return View
    */
    public function getNewCampaigns()
    {
        $style      = LayoutRepository::renderStyle()->chosen;
        $style     .= LayoutRepository::renderStyle()->form;

        $script     = LayoutRepository::renderScript()->chosen;
        $script    .= LayoutRepository::renderScript()->form;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/campanhas.js');

        $dados      = array(
            'style'   => $style,
            'script'  => $script
        );        

        return view('cliente.campanhas.new', $dados);
    }


    /* VIDEOS  ******************************************************************************/

    /**
    *
    *
    *
    */
    public function getVideos()
    {
        $style          = LayoutRepository::renderStyle()->tables;

        $script         = LayoutRepository::renderScript()->tables;
        $script        .= LayoutRepository::createScript('app/js/ajax/cliente/campanhas.js');

        $dados      = array(
            'style'         => $style,
            'script'        => $script
        );        

        return view('cliente.videos.index', $dados);
    }



    /* MESSAGE ******************************************************************************/


    /**
    * READ USER WITH MESSAGE
    * Busca todas as mensagens
    *
    * @return [array]
    */
    public function getUserMessage()
    {
        return ClienteService::ListMessages();
    }


    /**
    * GET MESSAGE
    * Busca todas as mensagens
    *
    * @return View
    */
    public function getMessages()
    {
        $style          = LayoutRepository::renderStyle()->tables;

        $script         = LayoutRepository::renderScript()->tables;
        $script        .= LayoutRepository::createScript('app/js/ajax/cliente/mensagens-home.js');

        $listMessages   = ClienteService::ListMessages(8);
             
        $dados      = array(
            'style'         => $style,
            'script'        => $script,
            'messages'      => $listMessages
        );        
        return view('cliente.mensagens.index', $dados);
    } 

    /**
    * New Message | Nova mensagem
    * Methodo para abrir a view de nova mensagem 
    * @return View
    */
    public function newMessage()
    {
        $style      = LayoutRepository::renderStyle()->chosen;
        $style     .= LayoutRepository::renderStyle()->form;

        $script     = LayoutRepository::renderScript()->chosen;
        $script    .= LayoutRepository::renderScript()->form;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/mensagens.js');
                
        $dados      = array(
            'style'         => $style,
            'script'        => $script,
            'contatos'      => ClienteService::ListContacts()
        );        
        return view('cliente.mensagens.nova-mensagem', $dados);
    } 

    /**
    * View Contact
    * Mostra a view que exibe a pagina single de contatos
    * @return View
    */
    public function getViewContact($id)
    {
        $id         = base64_decode($id);
        $style      = LayoutRepository::renderStyle()->tables;

        $script     = LayoutRepository::renderScript()->tables;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/contact.js');

                
        $dados      = array(
            'style'         => $style,
            'script'        => $script,
            'contacts'      => ClienteService::ReadMessagesConctact($id)
        );        
        return view('cliente.mensagens.contact', $dados);
    }

    /**
    * Read Message
    * Metodo para ler mensagem
    *
    * @return Response
    */
    public function getReadMessageUserName($id)
    {
        return \Response::json(ClienteService::ReadMessagesConctact($id));
    }

    /**
    * Send New Message | Enviando nova mensagem
    * Metodo para enviar novas mensagens 
    *
    * @return Response
    */
    public function sendNewMenssage()
    {
        $file       = \Input::file('file'); # Envio de arquivo
        $contatcs   = \Input::get('con_contatcs'); # Contatos
        $dados      = \Input::except('_token', '_', 'file', 'con_contatcs'); # Dados
        
        $messages = new MessagesService();
        return $messages->setSendMessage($file, $dados, $contatcs);
    }


    /**
    * Delete All Messages | Deletando todas mensagens
    * Metodo para excluir todas as mensagens do banco de dados
    *
    * @return Response
    */
    public function getDeleteMessages()
    {
        return ClienteService::deleteMessages();
    }

    /**
    *
    *
    *
    */
    public function getCheckMessage()
    {
        $messages = new MessagesService();
        return $messages->checkMessages();
    }

    /**
    *
    *
    *
    *
    */
    public function getReadGraphMessages()
    {
        $messages = new MessagesService();
        return $messages->getReadGraphMessages();
    }



    /* CONFIGURAÇÕES ******************************************************************************/
    

    /**
    *
    *
    * @return View
    */
    public function getSettings()
    {
        $style      = LayoutRepository::renderStyle()->chosen;
        $style     .= LayoutRepository::renderStyle()->form;

        $script     = LayoutRepository::renderScript()->chosen;
        $script    .= LayoutRepository::renderScript()->form;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/settings.js');
        
        $settings       = ClienteService::readSettings();
        $Allsettings    = ClienteService::readAllSettings();
        $vcard          = ClienteService::readvCard();

        $dados      = array(
            'style'         => $style,
            'script'        => $script,
            'settings'      => $settings,
            'allsetgs'      => $Allsettings,
            'vcard'         => $vcard
        );        
        return view('cliente.settings.index', $dados);
    }

    /**
    *
    *
    *
    *
    * @return 
    */
    public function setActiveSettings($id)
    {
        $id = base64_decode($id);
        return ClienteService::setActiveSettings($id);
    }

    
    /**
    *
    *
    *
    *
    * @return 
    */
    public function setSettings()
    {
        $file  = \Input::file('img');
        $dados = \Input::except('img');

        return ClienteService::setConfiguracoes($dados, $file);
    }

    /**
    *
    *
    *
    *
    * @return View
    */
    public function setAddSettings()
    {
        $dados = \Input::all();

        return ClienteService::setAddConfiguracoes($dados);
    }


    /**
    *
    *
    * @return View
    */
    public function setvCard()
    {
        $file  = \Input::file('img');
        $dados = \Input::except('img');

        return ClienteService::setvCard($dados, $file);
    }

    /**
    *
    *
    *
    * @return View
    */
    public function readvCard()
    {
        $vcard = ClienteService::readvCard();
        if(!empty($vcard)):
            return \Response::json($vcard);
        else:
            return 'vazio';
        endif;
    }

    /**
    *
    *
    * @return View
    */
    public function checkNumber()
    {
        return ClienteService::checkNumber();
    }

    /**
    *
    *
    * @return View
    */
    public function setRegisterNumber()
    {
        $dados = \Input::all();
        $register = new RegisterService();
        return $register->registerNumber($dados);
    }


    /* END CONFIGURAÇÕES ******************************************************************************/

    /**
    *
    *
    * @return View
    */
    public function getSupport()
    {
        $style      = LayoutRepository::renderStyle()->chosen;
        $style     .= LayoutRepository::renderStyle()->form;

        $script     = LayoutRepository::renderScript()->chosen;
        $script    .= LayoutRepository::renderScript()->form;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/suporte.js');
                
        $dados      = array(
            'style'         => $style,
            'script'        => $script
        );        
        return view('cliente.suporte.index', $dados);
    }


    /* GRUPOS ******************************************************/

    /**
    * Get Group
    * Abre a view do grupo
    *
    * @return View
    */
    public function getGroup()
    {
        $style      = LayoutRepository::renderStyle()->chosen;
        $style     .= LayoutRepository::renderStyle()->form;

        $script     = LayoutRepository::renderScript()->chosen;
        $script    .= LayoutRepository::renderScript()->form;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/grupos.js');

        $groups     = new GroupsService();
        $listGroups = $groups->getListGroups();

                
        $dados      = array(
            'style'         => $style,
            'script'        => $script,
            'contatos'      => ClienteService::ListContacts(),
            'grupos'        => $listGroups
        );        
        return view('cliente.grupos.index', $dados);
    }


    /**
    *
    *
    *
    *
    */
    public function getGroupChat($gid)
    {
        $gid        = base64_decode($gid);
        
        $style      = LayoutRepository::renderStyle()->chosen;
        $style     .= LayoutRepository::renderStyle()->form;

        $script     = LayoutRepository::renderScript()->chosen;
        $script    .= LayoutRepository::renderScript()->form;
        $script    .= LayoutRepository::createScript('app/js/ajax/cliente/grupos.js');

        $groups = new GroupsService();
        $chatgp = $groups->getGroupChat($gid);

                
        $dados      = array(
            'style'         => $style,
            'script'        => $script
        );        
        return view('cliente.grupos.chat', $dados);
    }

   

    /**
    * Create Group
    * Criando um grupo
    *
    * @return
    */
    public function setCreateGroup()
    {
        $title          = \Input::get('gp_title');
        $participants   = \Input::get('gp_participants');
        $all_con        = \Input::get('all_con');
        $file           = \Input::file('img');


        $groups = new GroupsService();
        return $groups->createGroups($title, $participants, $all_con, $file);
    }

    /**
    * Delete Group
    * Deletando Grupo
    *
    * @return
    */
    public function getDeleteGroup($groupId)
    {
        $groups = new GroupsService();
        return $groups->deleteGroup($groupId);
    }

    /**
    * Add Admin Grupo
    * Adicionando administrador ao Grupo
    *
    * @return
    */
    public function getAddAdminGroups()
    {
        $gId = \Input::get('gId');
        $participants = \Input::get('participants');

        $groups = new GroupsService();
        return $groups->addAdminGroups($gId, $participants);
    }


    /**
    * Remove Admin Group
    * Remover administrador do grupo
    *
    * @return
    */
    public function getRemoverAdminGroup()
    {
        $gId = \Input::get('gId');
        $participants = \Input::get('participants');

        $groups = new GroupsService();
        return $groups->removerAdminGroup($gId, $participants);
    }





    
}
