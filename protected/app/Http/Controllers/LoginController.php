<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;

use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

// Repositories
use App\Repositories\LayoutRepository;

// Services
use App\Services\UserService;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.auth.login');
    }

    /**
     * LOGIN
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(LoginRequest $request)
    {
        if($request->has('email') and $request->has('password'))
        {
            $remember = true;
             if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']], $remember))
             {
                return 'sucesso';
             }
             else if(Auth::attempt(['info_cpf' => $request['email'], 'password' => $request['password']], $remember))
             {
                return 'sucesso';
             }
             else
             {
                return 'error';
             }
        }
    }   

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function logout()
    {
       Auth::logout();
       return Redirect::to('login');
    }


    public function viewRegistrar()
    {
        return view('admin.auth.registrar');
    }

    public function registrar()
    {   
        $senhaA = \Input::get('rg_senha');
        $senhaB = \Input::get('rg_rep_senha');
        $termos = \Input::get('rg_concordo');

        $dados  = \Input::except('_token', 'rg_rep_senha', 'rg_concordo', 'rg_senha');

        if(!empty($termos))
        {
            return UserService::register($dados, $senhaA, $senhaB); 
        }
        else{  
            return 'aceitartermos';
        }
        
    }

    public function viewRecover()
    {
        return view('admin.auth.recover');
    }

}
