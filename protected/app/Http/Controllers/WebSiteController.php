<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Services
use App\Services\UserService;
use App\Services\BlockCheckService;
use App\Services\MessagesService;

// SEO
use App\Services\SeoService;
use Arcanedev\SeoHelper\Entities\OpenGraph\Graph;
use Arcanedev\SeoHelper\Entities\Twitter\Card;

class WebSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $script     = '
        <script src="'. layoutBase('js/views/view.home.js') .'"></script>
        ';

        // Graph
        $openGraph = new Graph;

        $openGraph->setType('website');
        $openGraph->setTitle('Whatsline');
        $openGraph->setDescription('Whatsline');
        $openGraph->setSiteName('Whatsline');
        $openGraph->setUrl(\URL::to('/'));
        $openGraph->setImage(\URL::to('uploads/capa.jpg'));

        $card = new Card;

        $card->setType('summary');
        $card->setSite('@linextibh');         // Or just 'Arcanedev'
        $card->setTitle('Whatsline');
        $card->setDescription('Whatsline');
        $card->addImage(\URL::to('uploads/capa.jpg'));


        // DADOS
        $dados          = array(
            'script'        => $script,
            'title'         => SeoService::title('Whatsline'),
            'description'   => SeoService::description('Whatsline'),
            'Keywords'      => SeoService::Keywords(),
            'webmasters'    => SeoService::webmasters(),
            'analytics'     => SeoService::analytics(),
            'openGraph'     => $openGraph,
            'card'          => $card,
        );

        return view('website.home.index', $dados);
    }

    /**
     * GET LOGIN
     * Metodo para exibir a view de Login
     * @return View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * SET LOGIN
     * Metodo para enviar dados de login
     * @return \Illuminate\Http\Response
     */
    public function setLogin()
    {
        $dados  = \Input::except('_token'); 
        return UserService::setLogin($dados);
    }

    /**
     * GET REGISTER
     * Metodo para exibir a view de registrar
     * @return View
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * SET REGISTER
     * Metodo para enviar dados de register
     * @return \Illuminate\Http\Response
     */
    public function setRegister()
    {
        $senhaA = \Input::get('rg_senha');
        $senhaB = \Input::get('rg_rep_senha');
        $termos = \Input::get('rg_concordo');

        $dados  = \Input::except('_token', 'rg_rep_senha', 'rg_concordo', 'rg_senha', '_');

        
        if(!empty($termos)):
            return UserService::setRegister($dados, $senhaA, $senhaB); 
        else: 
            return 'aceitartermos';
        endif;        
    }



    /**
    *
    *
    *
    */
    public function getShopCart($plan, $price)
    {
        $price = base64_decode($price);

        // Graph
        $openGraph = new Graph;

        $openGraph->setType('website');
        $openGraph->setTitle('FollowGram - Ganhe seguidores do Instagram');
        $openGraph->setDescription('Não ganhe apenas seguidores, ganhe fãs interessados em seu conteúdo. Confira!');
        $openGraph->setSiteName('FollowGram - Ganhe seguidores do Instagram');
        $openGraph->setUrl('http://www.followgram.com.br/');
        $openGraph->setImage(\URL::to('uploads/capa.jpg'));

        $card = new Card;

        $card->setType('summary');
        $card->setSite('@followgrambh');         // Or just 'Arcanedev'
        $card->setTitle('FollowGram - Ganhe seguidores do Instagram');
        $card->setDescription('');
        $card->addImage(\URL::to('uploads/capa.jpg'));

        $dados = [
            'title'         => SeoService::title("FollowGram - Ganhe seguidores do Instagram"),
            'description'   => SeoService::description("Não ganhe apenas seguidores, ganhe fãs interessados em seu conteúdo. Confira!"),
            'Keywords'      => SeoService::Keywords(),
            'webmasters'    => SeoService::webmasters(),
            'analytics'     => SeoService::analytics(),
            'openGraph'     => $openGraph,
            'card'          => $card,
            'plan'          => $plan,
            'price'         => $price
        ];
        return view('website.carrinho.index', $dados);
    }

    /**
    *
    *
    *
    */
    public function getSendPayment()
    {
        $input = \Input::all();

        return PaymentService::sendPayment($input);
    }

    /**
     * GET CHECKOUT
     * Metodo para exibir a view de pagamento
     * @return View
     */
    public function getCheckout()
    {
        if (\Auth::check()):
            if(\Auth::user()->nivel == 0 ):
                return view('auth.checkout');
            elseif(\Auth::user()->nivel == 1 || \Auth::user()->nivel == 2 ):
                return redirect()->to('cliente');
            elseif(\Auth::user()->nivel >= 3 ):
                return redirect()->to('admin');
            endif;
        endif;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getLogout()
    {
       \Auth::logout();
       return redirect()->to('login');
    }

    /**
    *
    *
    *
    */
    public function getCheckNumber()
    {
        $checkNumber = new BlockCheckService();
        dd($checkNumber->CheckNumberPhone());
    }

    /**
    *
    *
    *
    */
    public function getcronMessage()
    {
        $cronMessage = new MessagesService();
        return $cronMessage->cronMessage();
    }



}
