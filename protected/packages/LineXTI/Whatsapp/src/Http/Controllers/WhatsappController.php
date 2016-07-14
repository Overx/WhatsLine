<?php 
namespace LineXTI\Whatsapp\Http\Controllers;


use LineXTI\Whatsapp\Services\WhatsappService;
use LineXTI\Whatsapp\Services\GoogleContactsService;

use App\Http\Controllers\Controller;
use App\Repositories\LayoutRepository;


class WhatsappController extends Controller
{
    
	public function index()
	{	

        // Renderizando Layout
        $style      = LayoutRepository::renderStyle()->tables;
        $style     .= LayoutRepository::renderStyle()->chosen;
        $style     .= LayoutRepository::renderStyle()->form;

        $script     = LayoutRepository::renderScript()->tables;
        $script    .= LayoutRepository::renderScript()->chosen;
        $script    .= LayoutRepository::renderScript()->form;
        $script    .= LayoutRepository::createScript(\URL::to("\\protected\\packages\\LineXTI\\Whatsapp\\src\\Assets\\js\\whatsapp.js"));          	

        // Verifica se existe sessão do whatsapp, se não existe, chama o metodo para criar. 
        
        // $whatsapp->NumberRegistration('553173185801', '123456');
        $whatsapp = new WhatsappService;
        //$whatsapp->checkMessage();
        $whatsapp->SendMessage('message', ['553173041139'], 'com o nove');
        //$whatsapp->sendPresenceSubscription('553173117979'); // Novo usuario

        //$whatsapp->getContact();
        
		$dados = array(
			'style'     => $style,
            'script'    => $script
		);

		return view('whatsapp::index')->with($dados);
	}

	

}