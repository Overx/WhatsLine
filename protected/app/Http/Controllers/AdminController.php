<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\LayoutRepository;

class AdminController extends Controller
{
   
    /** ADMIN ***************************************************************************************/

    /*
    * VIEW HOME
    * Mostrando a view para home
    */
    public function index()
    {
        $style      = LayoutRepository::renderStyle()->tables;

        $script     = LayoutRepository::renderScript()->tables;
        $script    .= LayoutRepository::createScript('app/js/ajax/admin/home.js');

                
        $dados      = array(
            'style'         => $style,
            'script'        => $script
        );        
        return view('admin.home.index', $dados);
    }

   


}
