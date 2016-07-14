
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
               <span>Área do Cliente</span>
            </li>

            <li class="{{ \App\Library\CoreHelpers::Ativate("cliente", "active") }}">
               <a href="{{ URL::to('cliente/') }}" title="Painel Principal">
                  <em class="icon-home"></em>
                  <span>Painel Principal</span>
               </a>               
            </li> 

            <li class="{{ \App\Library\CoreHelpers::Ativate(['cliente/mensagens', 'cliente/nova/mensagem'], 'active') }} {{ (Request::is('cliente/editar/mensagem/*') ? 'active' : '') }} {{ (Request::is('cliente/view/*') ? 'active' : '') }}">
               <a href="{{ URL::to('cliente/mensagens') }}" title="Mensagens">
                  <em class="icon-envelope-open"></em>
                  <span>Mensagens</span>
               </a>               
            </li>
            <!--
            <li class="{{ \App\Library\CoreHelpers::Ativate(['cliente/chat'], 'active') }} ">
               <a href="{{ URL::to('cliente/chat') }}" title="Bate Papo">
                  <em class="fa fa-whatsapp"></em>
                  <span>Bate Papo</span>
               </a>               
            </li>

            <li class="{{ \App\Library\CoreHelpers::Ativate(['cliente/grupos'], 'active') }}">
               <a href="{{ URL::to('cliente/grupos') }}" title="Meus Grupos">
                  <em class="fa fa-group"></em>
                  <span>Grupos</span>
               </a>               
            </li>
            
            <li class="{{ \App\Library\CoreHelpers::Ativate(['cliente/campanhas', 'cliente/new/campaign'], 'active') }} {{ (Request::is('cliente/edit/campaign/*') ? 'active' : '') }}">
               <a href="{{ URL::to('cliente/campanhas') }}" title="Campanhas">
                  <em class="icon-grid"></em>
                  <span>Campanhas</span>
               </a>               
            </li>
            -->
            <li class="{{ \App\Library\CoreHelpers::Ativate(['cliente/agenda'], 'active') }} {{ (Request::is('admin/editar-escritorio/*') ? 'active' : '') }}">
               <a href="{{ URL::to('cliente/agenda') }}" title="Agenda">
                  <em class="icon-notebook"></em>
                  <span>Minha Agenda</span>
               </a>               
            </li>
            
            <li class="{{ \App\Library\CoreHelpers::Ativate(['cliente/videos'], 'active') }} {{ (Request::is('admin/editar-escritorio/*') ? 'active' : '') }}">
               <a href="{{ URL::to('cliente/videos') }}" title="Vídeo Aulas">
                  <em class="icon-social-youtube"></em>
                  <span>Vídeo Aulas</span>
               </a>               
            </li>

            <li class="{{ \App\Library\CoreHelpers::Ativate(['cliente/suporte'], 'active') }} {{ (Request::is('admin/editar-escritorio/*') ? 'active' : '') }}">
               <a href="{{ URL::to('cliente/suporte') }}" title="Suporte Técnico">
                  <em class="icon-earphones"></em>
                  <span>Suporte Técnico</span>
               </a>               
            </li>
            
            <li class="{{ \App\Library\CoreHelpers::Ativate(['cliente/configuracoes'], 'active') }} {{ (Request::is('admin/configuracao/*') ? 'active' : '') }}">
               <a href="{{ URL::to('cliente/configuracoes') }}" title="Agenda">
                  <em class="icon-settings"></em>
                  <span>Configuração</span>
               </a>               
            </li>        

         </ul>
      </nav>
   </div>
</aside>