<?php

namespace App\Services;

// API
use Instagram;
use Carbon\Carbon;

// Models
use App\Models\User;
use App\Models\WhatsappTransaction;


class PaymentService
{

    private static $timeout = 20;
    private static $email;
    private static $name;

    public function __construct()
    {
       
    }


    /**
    * Get Transation
    * Lendo transações do usuário
    *
    * @return [array]
    */
    public static function getTransation()
    {
        $user = User::where('id', Auth::user()->id)
                ->join('whatsapp_transaction', 'users.id', '=', 'whatsapp_transaction.user_id')
                ->first();

        if(!empty($user)):
            return $user;            
        endif;
    }

    /**
    *
    *
    *
    *
    */
    public static function getTransations($search = null)
    {
        $user = User::join('whatsapp_transaction', 'users.id', '=', 'whatsapp_transaction.user_id')
                ->paginate(10);
    }

    /**
    *
    *
    *
    *
    */
    public static function sendPayment($input)
    {
        $plans  = '';
        
        if(!empty($input['insid'])):

            $insid = $input['insid'];
            $plano = $input['plano'];
            $tipop = $input['tipop'];
            $valor = $input['valor'];
            $prazo = $input['prazo'];
            $namec = $input['namec'];
            $email = $input['email'];

            if(!empty($plano)):
                switch ($plano):
                    case 'P101':
                        $plans = 'Plano Padrão';
                        break;
                    case 'P102':
                        $plans = 'Plano Econômico';
                        break;
                    case 'P103':
                        $plans = 'Plano corporativo';
                        break;
                endswitch;
            endif;
           
            $dados = [
                'user_id'           => $insid,
                'ins_tran_valor'    => $valor,
                'ins_tran_plan'     => $plano,
                'ins_tran_time'     => $prazo, 
                'ins_tran_name'     => (!empty($namec) ? $namec : ''),
                'ins_tran_email'    => (!empty($email) ? $email : ''),
                'ins_tran_data'     => date('Y-m-d H:i:s')
            ];

            if(!empty($email)):
                User::where('id', $insid)->update(['email' => $email]);
            endif;

            $ver = InstagramTransaction::where('user_id', $insid)->first();
            if(!empty($ver)):
                InstagramTransaction::where('user_id', $insid)->update($dados);
            else:
                InstagramTransaction::create($dados);
            endif;

            switch ($tipop):
                case 'avista':
                    # Enviar email com as contas
                    self::sendMailBanks($namec, $email, $valor);
                    return json_encode(['status' => 'sucesso', 'type' => 'contas', 'url' => '']);
                    break;
                case 'pagseguro':
                    # Pagamento por pagseguro
                    self::checkoutPagSeguro($insid, $plans, $valor);
                    return json_encode(['status' => 'sucesso', 'type' => 'pagseguro', 'url' => '']);
                    break;
                case 'paypal':
                    # Pagamento por paypal
                    $return = self::checkoutPaypal($insid, $plans, $valor);
                    return json_encode(['status' => 'sucesso', 'type' => 'paypal', 'url' => 'https://www.paypal.com/cgi-bin/webscr?'. $return]);
                    break;
            endswitch;
        else:
            return json_encode(['status' => 'semlogin', 'type' => 'contas', 'url' => '']);
        endif;
    }

    /**
    *
    *
    *
    */
    public static function sendMailBanks($namec, $email, $valor)
    {
        self::$email = $email;
        self::$name  = $namec;

        $data = array(
            'nome'    => $namec,
            'email'   => $email,
            'valor'   => "R$ " . $valor .",00",
        );

        \Mail::send('emails.bancos', $data, function ($message) {
            $message->from('contato@linexti.com.br', 'Followgram');
            $message->to(self::$email)->subject(self::$name);
        });
    }



    /**
    *
    *
    *
    */
    public static function checkoutPaypal($pid, $product, $price)
    {
        $urlPage = '';

        if(session()->has('cart_instagram')):
            $urlPage = session('cart_instagram')['return_url'];
        endif;

        $query   = [
            'currency_code' => 'BRL', # USD
            'business'      => 'RNJGDKC8WX62L',
            'cmd'           => '_cart',
            'upload'        => 1,
            'charset'       => 'utf8',
            'cpp_logo_image'=> \URL::to('assets/images/logo.png'),
            'custom'        => $pid,
            'shopping_url'  => $urlPage,
            'shopping_url'  => \URL::to('paypal/concluido'),
            'notify_url'    => \URL::to('paypal/callback'),
            'item_number_1' => 'PROD'. $pid,
            'item_name_1'   => $product,
            'quantity_1'    => 1,
            'amount_1'      => $price
        ];


        $query_string = http_build_query($query);
        return $query_string;
        //return Redirect::away('Location: https://www.paypal.com/cgi-bin/webscr?' . $query_string);
       // return header('Location: https://www.paypal.com/cgi-bin/webscr?' . $query_string); 
    }



    /**
    *
    *
    *
    */
    public static function notificationPost() {
        $postdata = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $valued    = self::clearStr($value);
            $postdata .= "&$key=$valued";
        }
        return self::validar($postdata);
    }

    /**
    *
    *
    *
    */
    private static function clearStr($str) {
        if (!get_magic_quotes_gpc()) {
            $str = addslashes($str);
        }
        return $str;
    }   

    /**
    *
    *
    *
    */
    private static function validar($data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://www.paypal.com/cgi-bin/webscr");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::$timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = trim(curl_exec($curl));
        curl_close($curl);
        return $result;    
    }


    /**
    *
    *
    *
    *
    */
    private static function getPayPalCallBack($input)
    {
        if(count($input) > 0):
            $valido = self::notificationPost();
            if($valido=="VERIFIED"):
                $transacao_cod        = $input['txn_id'];
                $usuario_id           = $input['custom'];
                $data_transacao       = date('Y-m-d H:i:s');
                $tipo_pagamento       = $input['payment_type'];
                $num_itens            = $input['num_cart_items'];
                $email                = $input['email'];
                $nome                 = $input['first_name']." ".$input['last_name'];          
                $status_transacao     = $input['payment_status'];


                switch($status_transacao):
                    case 'Canceled_Reversal':
                    $status_transacao = 'Cancelado';
                    break;
                    
                    case 'Completed':
                    $status_transacao = 'Aprovado';
                    break;
                    
                    case 'Denied':
                    $status_transacao = 'Cancelado';
                    break;
                    
                    case 'Expired':
                    $status_transacao = 'Cancelado';
                    break;
                    
                    case 'Failed':
                    $status_transacao = 'Cancelado';
                    break;
                    
                    case 'Voided':
                    $status_transacao = 'Cancelado';
                    break;
                    
                    case 'Pending':
                    $status_transacao = 'Aguardando Pagamento';
                    break;
                    
                    case 'Refunded':
                    $status_transacao = 'Cancelado';
                    break;
                    
                    case 'Reversed':
                    $status_transacao = 'Cancelado';
                    break;
                    
                    case 'Processed':
                    $status_transacao = 'Aprovado';
                    break;
                endswitch;
            endif;

            $dados = [
                'user_id'           => $usuario_id,
                'ins_tran_name'     => $nome,
                'ins_tran_email'    => $email,
                'ins_tran_cod'      => $transacao_cod,
                'ins_tran_data'     => $data_transacao,
                'ins_tran_status'   => $status_transacao
            ];

            // Salvando no banco de dados
            $ver = InstagramTransaction::where('user_id', $usuario_id)->first();
            if(!empty($ver)):
                InstagramTransaction::where('user_id', $usuario_id)->update($dados);
            endif;
        endif;
    }




    /**
    *
    *
    *
    */
    public static function checkoutPagSeguro($pid, $product, $price)
    {
        $query   = [
            'currency'          => 'BRL', # USD
            'receiverEmail'     => 'victorleonarty@msn.com', // E-mail do vendedor
            'encoding'          => 'utf8', // Condificação
            'reference'         => $pid,
            'itemId1'           => 'PROD'. $pid,
            'itemDescription1'  => $product,
            'itemQuantity1'     => 1,
            'itemAmount1'       => $price,
            'itemWeight1'       => 750,
        ];

        //$data = http_build_query($query);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://pagseguro.uol.com.br/v2/checkout/payment.html");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);        
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");

        $result = curl_exec($ch);

        curl_close($ch);
        //return $result;
    }







	
}
