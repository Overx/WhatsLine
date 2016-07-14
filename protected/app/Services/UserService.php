<?php

namespace App\Services;

use App\Repositories\WhatsRepository;
use App\Models\User;

class UserService
{

	private static $Dados = array();
	/**
	* @var EquipeRepository;
	*/
	private $whatsRepository;

	public function __construct(WhatsRepository $whatsRepository)
	{
		$this->whatsRepository = $whatsRepository;
	}


     /**
     * LOGIN
     *
     * @param  Request  $request
     * @return Response
     */
    public static function setLogin($request)
    {
        if(!empty($request['email']) and !empty($request['password'])):
            $remember = true;
             if(\Auth::attempt(['email' => $request['email'], 'password' => $request['password']], $remember)):
                return 'sucesso';            
             else:
                return 'error';
             endif;
        endif;
    }   



    /**
     * CADASTRANDO NOVO USUÁRIO
     * Metodo estatico para cadastrar novo usuário
     * @param  Id (int)
     * @param  Senha A (String)
     * @param  Senha B (String)
     * @param  Imagem (String)
     * @return Response
     */
    public static function setRegister($dados, $senha_a, $senha_b, $image = null)
    {
        self::$Dados = $dados;
       
        if(self::$Dados['name'] == '' || self::$Dados['email'] == '' || $senha_a == '' || $senha_b == ''):
            return 'camposvazio'; # verifica se existe campos vazio
        else:       
            // Verificando se a senha confere.
            if($senha_a == $senha_b):
                # Preparando pra salvar a senha no banco de dados
                self::$Dados['password'] = \Hash::make($senha_a); 
            else:
                return 'senhanaoconfere';
            endif;       

            // Verificando se já existe um e-mail semelhante cadastrado
            $verEmail   = \App\Models\User::where('email', self::$Dados['email'])->first();
            if(count($verEmail) > 0):
                return 'jaexisteemail'; # Notificação informando que o email existe
            else:
                // fazendo upload do avatar
                if (!empty($image)):
                    $upload = new \App\Library\UploadHelpers();
                    if ($upload->ImageUpload($image)):
                        self::$Dados['avatar'] = $upload->NomeArquivo(); // Criando o valor a ser enviado para o banco de dados com o nome e caminho do arquivo
                    endif;
                endif;

                $email      = self::$Dados['email'];
                $password   = $senha_a;
                
                // Criando um usuário
                if(\App\Models\User::create(self::$Dados)):                    
                    if (\Auth::attempt(['email' => $email, 'password' => $password])) {
                        return 'sucesso';
                    }                    
                endif;
            endif;            
        endif;
    }

    /**
     * ATUALIZANDO DADOS
     * Metodo estatico para cadastrar novo usuário
     * @param  Dados (Array)
     * @param  Id (int)
     * @param  Senha A (String)
     * @param  Senha B (String)
     * @param  Imagem (String)
     * @return Response
     */
    public static function updateUser($dados, $id, $senha_a = null, $senha_b = null, $image = null)
    {
        self::$Dados = $dados;

        if(self::$Dados['name'] == '' || self::$Dados['email'] == '')
        {
            return 'camposvazio'; // Verifica campos vazios
        }else{
            // Verificando se já existe um CPF semelhante cadastrado
            $verCpf   = \App\Models\User::where('id', '!=', $id)->where('info_cpf', self::$Dados['info_cpf'])->where('info_cpf', '!=', '')->first();
            if(count($verCpf) > 0)
            {
                return 'existecpf';
            }
            else
            {
                // verifica a senha
                if(isset($senha_a) && isset($senha_b) ){
                    if($senha_a != '' && $senha_b != ''){
                        if($senha_a == $senha_b){
                            //Preparando pra salvar a senha no banco de dados
                            self::$Dados['password']      = \Hash::make($senha_a); 
                        }else{
                            return 'senhanaoconfere';
                        }
                    }
                }                

                // Data Atual
                self::$Dados['updated_at'] = date('Y-m-d H:i:s');  

                // Deixando somente numeros
                self::$Dados['info_cpf']  = preg_replace("/[^0-9]/", "", self::$Dados['info_cpf']);

                // Upload da imagem
                if (!empty($image)) {
                    $upload = new \App\Library\UploadHelpers();

                    // Verificando se existe
                    $imagem = \App\Models\User::where("id", $id)->where("info_image", "!=", '')->first();
                    if (isset($imagem) && $imagem->info_image != '' && \File::exists('uploads/' . $imagem->info_image)) {
                        \File::delete('uploads/' . $imagem->info_image);
                    }

                    if ($upload->ImageUpload($image)) {
                        self::$Dados['info_image'] = $upload->NomeArquivo(); // Criando o valor a ser enviado para o banco de dados com o nome e caminho do arquivo
                    }
                }  

                // Atualizando dados do usuário usuário           
                if(\App\Models\User::where("id", $id)->update(self::$Dados))
                {
                    return 'sucesso';
                }
            }

        }
    }

    /**
     * EXCLUINDO USUÁRIO
     * Metodo para excluir usuários cadastrados
     * @return Response
     */
    public static function deleteUser($id)
    {
        $user = \App\Models\User::all();
        if(count($user) > 1)
        {
            if(!empty($id))
            {
                // Verificando se existe imagem
                $imagem = \App\Models\User::where("id", $id)->where("info_image", "!=", '')->first();
                if (isset($imagem) && $imagem->info_image != '' && \File::exists('uploads/' . $imagem->info_image)) {
                    \File::delete('uploads/' . $imagem->info_image);
                }

                if(\App\Models\User::where("id", $id)->delete())
                {
                     return 'sucesso';
                }
            }

        }else{
            return 'ultimousuario';
        }    
    }

   



	
}
