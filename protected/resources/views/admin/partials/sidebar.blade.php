
<!-- sidebar-->
<aside class="aside">
   <div class="aside-inner">
      <nav class="sidebar">
         <ul class="nav">
            <li class="has-user-block">
               <div id="user-block">
                  <div class="item user-block">
                     <div class="user-block-picture">
                        <div class="user-block-status">
                           @if( \Auth::user()->avatar != '')
                              {!! \App\Library\CoreHelpers::Image( \Auth::user()->avatar, '', '60', '60', 'img-thumbnail img-circle') !!}
                           @else
                              <img src="{{ urlBase('app/img/user/02.jpg') }}" alt="" width="60" height="60" class="img-thumbnail img-circle">
                           @endif
                           <div class="circle circle-success circle-lg"></div>
                        </div>
                     </div>
                     <div class="user-block-info">
                        <span class="user-block-name">Olá {{ \Auth::user()->name . ' ' . \Auth::user()->last_name }}</span>
                        <span class="user-block-role">{{ nivelStatus(\Auth::user()->nivel ) }}</span>
                     </div>
                  </div>
               </div>
            </li>

            <!-- Área do Administrador -->
            <li class="nav-heading ">
               <span>Área do Administrador</span>
            </li>

            <li class="{{ \App\Library\CoreHelpers::Ativate("admin", "active") }}">
               <a href="{{ URL::to('admin/') }}" title="Painel Principal">
                  <em class="icon-home"></em>
                  <span>Painel Principal</span>
               </a>               
            </li> 

            <li class="{{ \App\Library\CoreHelpers::Ativate(['admin/escritorio','admin/novo-escritorio'], 'active') }} {{ (Request::is('admin/editar-escritorio/*') ? 'active' : '') }}">
               <a href="{{ URL::to('admin/escritorio') }}" title="Escritório">
                  <em class="fa fa-building-o"></em>
                  <span>Escritório</span>
               </a>               
            </li>

            <li class="{{ \App\Library\CoreHelpers::Ativate(['admin/area-de-atuacao'], 'active') }} {{ (Request::is('admin/atuacao/*') ? 'active' : '') }}">
               <a href="{{ URL::to('admin/area-de-atuacao') }}" title="Área de Atuação">
                  <em class="icon-layers"></em>
                  <span>Área de Atuação</span>
               </a>               
            </li>
                     
            <li class="">
               <a href="#usuarios" title="Gestão de Usuários" data-toggle="collapse">
                  <em class="icon-users"></em>
                  <span>Gestão de Usuários</span>
               </a>
               <ul id="usuarios" class="nav sidebar-subnav collapse">
                  <li class="{{ \App\Library\CoreHelpers::Ativate(['admin/usuarios', 'admin/novo-usuario'], 'active') }} {{ (Request::is('admin/editar-usuario/*') ? 'active' : '') }}">
                     <a href="{{ URL::to('admin/usuarios') }}" title="Usuários">
                        <em></em>
                        <span>Usuários</span>
                     </a>
                  </li>
                  <li class="{{ \App\Library\CoreHelpers::Ativate('admin/equipe', 'active') }}">
                     <a href="{{ URL::to('admin/equipe') }}" title="Equipe">
                        <em></em>
                        <span>Equipe</span>
                     </a>
                  </li>                 
                                     
               </ul>
            </li>

            
            
            <li class="{{ \App\Library\CoreHelpers::Ativate(['admin/configuracoes'], 'active') }} {{ (Request::is('admin/configuracao/*') ? 'active' : '') }}">
               <a href="{{ URL::to('admin/configuracoes') }}" title="Agenda">
                  <em class="icon-settings"></em>
                  <span>Configuração geral</span>
               </a>               
            </li>


         </ul>
      </nav>
   </div>
</aside>