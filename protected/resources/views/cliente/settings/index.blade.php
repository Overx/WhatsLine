@extends('cliente.app')
@section('title', 'Configurações')
@section('descricao', 'Configurações gerais do sistema')
@section('content')

<div id="debug"></div>
<div class="row">
   <div class="col-lg-12">
      <!-- START panel-->
      <div id="panelDemo14" class="panel panel-default">
         
         <div id="j_load" class="panel-body">
            <div role="tabpanel">
               <!-- Nav tabs-->
               <ul role="tablist" class="nav nav-tabs">
                  <li role="presentation" class="{{ (!empty($settings->set_number) ? 'active' : '') }} width-100">
                  	<a href="#account" aria-controls="account" role="tab" data-toggle="tab">
                        <i class="fa fa-chevron-right"></i> &nbsp Condigurações de Conta
                     </a>
                  </li>
                  <li role="presentation" class=" width-100">
                     <a href="#vcard" aria-controls="vcard" role="tab" data-toggle="tab">
                        <i class="fa fa-chevron-right"></i> &nbsp Cartão de Visita
                     </a>
                  </li> 
                  <li role="presentation" class="{{ (empty($settings->set_number) ? 'active' : '') }} width-100">
                     <a href="#number" aria-controls="number" role="tab" data-toggle="tab">
                        <i class="fa fa-chevron-right"></i> &nbsp Registrar Numero
                     </a>
                  </li>               
               </ul>
               <!-- Tab panes-->
               <div class="tab-content">
                  <div id="account" role="tabpanel" class="tab-pane {{ (!empty($settings->set_number) ? 'active' : '') }}">
                    <form id="j_update_dados" class="form-horizontal">
                      <br/>
                      <div class="form-group">
                        <label class="col-lg-2 control-label">Nome do Usuário</label>
                        <div class="col-lg-2">
                          <input type="text" name="set_name" class="form-control" value="{{ (!empty($settings->set_name) ? $settings->set_name : '') }}" required/>
                        </div>
                        <button type="button" class="btn btn-oval btn-default visible-lg" data-container="body" data-toggle="popover" data-placement="right" data-content="Nome que ira mostrar para o cliente quando receber a mensagem">
                          <i class="fa fa-exclamation-triangle" style="font-size:18px"></i> 
                        </button>                     
                      </div>
                      <div class="form-group">
                        <label class="col-lg-2 control-label">Numero</label>
                        <div class="col-lg-2">
                          <input id="j_contato_cel" type="text" name="set_number" class="form-control" value="{{ (!empty($settings->set_number) ? $settings->set_number : '') }}" required/>
                        </div> 
                        <button id="j_button_number" type="button" class="btn btn-oval btn-default visible-lg" data-container="body" data-toggle="popover" data-placement="right" data-content="Nome que ira mostrar para o cliente quando receber a mensagem">
                          <i id="j_triangle" class="fa fa-exclamation-triangle" style="font-size:18px"></i> 
                        </button>                 
                      </div> 
                      <div class="form-group">
                        <label class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-4">
                          <input type="text" name="set_password" class="form-control" value="{{ (!empty($settings->set_password) ? $settings->set_password : '') }}" required/>
                        </div> 
                        <button type="button" class="btn btn-oval btn-default visible-lg" data-container="body" data-toggle="popover" data-placement="right" data-content="Nome que ira mostrar para o cliente quando receber a mensagem">
                          <i class="fa fa-exclamation-triangle" style="font-size:18px"></i> 
                        </button>                     
                      </div> 
                      <div class="form-group">
                        <label class="col-lg-2 control-label">Upload Cover</label>
                        <div class="col-lg-4">
                          <input type="file" name="img" data-classbutton="btn btn-default" data-classinput="form-control inline" class="form-control filestyle">
                        </div> 
                        <button type="button" class="btn btn-oval btn-default visible-lg" data-container="body" data-toggle="popover" data-placement="right" data-content="Nome que ira mostrar para o cliente quando receber a mensagem">
                          <i class="fa fa-exclamation-triangle" style="font-size:18px"></i> 
                        </button>                      
                      </div> 
                      <br/>
                      <br/>
                      <hr/>

                      <div class="row">
                        <div class="col-md-3 col-xs-12">
                          <div class="form-group">
                            <div class="col-lg-12">
                              <button type="button" data-toggle="modal" data-target="#novoNumero" class="btn btn-sm btn-green btn-block pull-right">
                                <em class="fa fa-plus"></em> Novo Numero
                              </button>
                            </div>
                          </div>    
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-3 col-xs-12">
                          <div class="form-group">
                            <div class="col-lg-12">
                              <button type="submit" class="btn btn-sm btn-success btn-block pull-right">
                                <em class="fa fa-save"></em> Atualizando informações
                              </button>
                            </div>
                          </div>    
                        </div>
                      </div>
                    </form> 

                    @if(count($allsetgs) > 0)
                    <div class="row">
                      <div class="col-md-12">
                        <div role="tabpanel" class="panel">
                          <!-- Nav tabs-->
                          <ul role="tablist" class="nav nav-tabs nav-justified">
                            <li role="presentation" class="active">
                              <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                                <em class="icon-call-end fa-fw" style="margin-right: 5px"></em> Meus Numeros</a>
                              </li>
                            </ul>
                            <!-- Tab panes-->
                            <div class="tab-content p0">
                              <div id="home" role="tabpanel" class="tab-pane active">
                                <!-- START list group-->
                                <div class="list-group mb0">
                                  @foreach($allsetgs as $con)
                                  <a href="#" id="{{ base64_encode($con->set_id) }}" class="list-group-item j_change_status">
                                    <?php 
                                      if($con->set_status == 'active'){
                                        echo '<span class="label label-green pull-right">Ativado</span>';
                                      }
                                    ?>
                                    <em class="fa fa-fw fa-fax mr"></em>
                                    <?php 

                                      if(strlen($con->set_number) > 10): 
                                         echo "+".substr($con->set_number, 0, 2)
                                         ."(".substr($con->set_number, 2, 2).") "
                                         .substr($con->set_number, 4, 4)."-"
                                         .substr($con->set_number, 8, 5);
                                      else:
                                         echo "+".substr($con->set_number, 0, 2)
                                         ."(".substr($con->set_number, 2, 2).") "
                                         .substr($con->set_number, 4, 4)."-"
                                         .substr($con->set_number, 8, 4);
                                      endif;
                                   ?>
                                  </a>
                                  @endforeach    
                                </div>                              
                              </div>
                            </div>
                          </div>              
                        </div>
                      </div>
                    @endif

                  </div>

                  <div id="vcard" role="tabpanel" class="tab-pane">                     
                     <div class="row">
                        <div class="col-lg-4">                           
                           <!-- START widget-->
                           <div class="panel widget" style="margin-top: 10px;">
                              <div class="half-float">
                                 <img src="{{ URL::to('app/img/bg3.jpg') }}" alt="" class="img-responsive">
                                 <div class="half-float-bottom">
                                    @if(!empty($vcard->vcard_photo))
                                      <img src="{{ URL::to('uploads/' . (!empty($vcard->vcard_photo) ? $vcard->vcard_photo : '')) }}" alt="Image" class="img-thumbnail img-circle thumb128">
                                    @else
                                      <img src="{{ URL::to('app/img/user/02.jpg') }}" alt="Image" class="img-thumbnail img-circle thumb128">
                                    @endif
                                 </div>
                              </div>
                              <div class="panel-body text-center">
                                 <h3 class="m0">
                                    {{ (!empty($vcard->vcard_display_name) ? $vcard->vcard_display_name : '') }}
                                 </h3>
                                 <p class="text-muted">
                                    {{ (!empty($vcard->vcard_company) ? $vcard->vcard_company : '') }}
                                 </p>     
                                 <ul class="vcard_list">
                                    <li>{{ (!empty($vcard->vcard_office_tel) ? $vcard->vcard_office_tel : '') }}</li>
                                    <li>{{ (!empty($vcard->vcard_home_tel) ? $vcard->vcard_home_tel : '') }}</li>
                                    <li>{{ (!empty($vcard->vcard_cell_tel) ? $vcard->vcard_cell_tel : '') }}</li>
                                    <li>{{ (!empty($vcard->vcard_email1) ? $vcard->vcard_email1 : '') }}</li>
                                    <li>{{ (!empty($vcard->vcard_url) ? $vcard->vcard_url : '') }}</li>
                                    <br/>
                                    <li>{{ (!empty($vcard->vcard_note) ? $vcard->vcard_note : '') }}</li>
                                    <br/>
                                    <li>{{ (!empty($vcard->vcard_work_extended_address) ? $vcard->vcard_work_extended_address : '') }}</li>
                                    <li>{{ (!empty($vcard->vcard_work_city) ? $vcard->vcard_work_city : '') }}</li>
                                    <li>{{ (!empty($vcard->vcard_work_state) ? $vcard->vcard_work_state : '') }}</li>
                                    <li>{{ (!empty($vcard->vcard_work_postal_code) ? $vcard->vcard_work_postal_code : '') }}</li>
                                 </ul>                            
                              </div>
                              <div class="panel-body text-center bg-green-dark">
                                 <div class="row row-table">
                                    <h4 style="margin: 0;">Cartão de Visita</h4>
                                 </div>
                              </div>
                           </div>
                           <!-- END widget-->
                        </div> 
                        <div class="col-lg-8">
                           <form id="j_update_vcard" class="form-horizontal">
                              <br/>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Nome do Usuário</label>
                                 <div class="col-lg-5">
                                    <input type="text" name="vcard_display_name" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_display_name) ? $vcard->vcard_display_name : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Nome da Empresa</label>
                                 <div class="col-lg-5">
                                    <input type="text" name="vcard_company" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_company) ? $vcard->vcard_company : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Telefone</label>
                                 <div class="col-lg-3">
                                    <input type="text" name="vcard_office_tel" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_office_tel) ? $vcard->vcard_office_tel : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Casa</label>
                                 <div class="col-lg-3">
                                    <input type="text" name="vcard_home_tel" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_home_tel) ? $vcard->vcard_home_tel : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Celular</label>
                                 <div class="col-lg-3">
                                    <input type="text" name="vcard_cell_tel" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_cell_tel) ? $vcard->vcard_cell_tel : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">E-mail</label>
                                 <div class="col-lg-5">
                                    <input type="email" name="vcard_email1" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_email1) ? $vcard->vcard_email1 : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">URL</label>
                                 <div class="col-lg-5">
                                    <input type="text" name="vcard_url" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_url) ? $vcard->vcard_url : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Nota</label>
                                 <div class="col-lg-9">
                                    <textarea name="vcard_note" class="form-control" >{{ (!empty($vcard->vcard_note) ? $vcard->vcard_note : '') }}</textarea>                                    
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Endereço</label>
                                 <div class="col-lg-9">
                                    <input type="text" name="vcard_work_extended_address" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_work_extended_address) ? $vcard->vcard_work_extended_address : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Cidade</label>
                                 <div class="col-lg-3">
                                    <input type="text" name="vcard_work_city" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_work_city) ? $vcard->vcard_work_city : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Estado</label>
                                 <div class="col-lg-3">
                                    <input type="text" name="vcard_work_state" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_work_state) ? $vcard->vcard_work_state : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Cep</label>
                                 <div class="col-lg-3">
                                    <input type="text" name="vcard_work_postal_code" 
                                           class="form-control" 
                                           value="{{ (!empty($vcard->vcard_work_postal_code) ? $vcard->vcard_work_postal_code : '') }}" 
                                           />
                                 </div>                                                   
                              </div>
                              
                              <div class="form-group">
                                 <label class="col-lg-3 control-label">Upload Imagem</label>
                                 <div class="col-lg-9">
                                    <input type="file" name="img" data-classbutton="btn btn-default" data-classinput="form-control inline" class="form-control filestyle">
                                 </div>                      
                              </div> 
                              <br/>
                              <br/>
                              <hr/>

                              <div class="form-group">
                                 <div class="col-lg-offset-2 col-lg-10">
                                    <button type="submit" class="btn btn-sm btn-success pull-right">Salvar</button>
                                 </div>
                              </div>
                           </form> 
                        </div>  
                     </div>              
                  </div>

                  <div id="number" role="tabpanel" class="tab-pane {{ (empty($settings->set_number) ? 'active' : '') }}">    
                     <form id="j_register_number" class="form-horizontal">
                        <br/>                       
                        <div class="form-group">
                           <label class="col-lg-2 control-label">Numero</label>
                           <div class="col-lg-2">
                              <input id="j_number" type="text" name="reg_number" class="form-control" value="" required/>
                           </div> 
                           <button id="" type="button" class="btn btn-oval btn-default visible-lg" data-container="body" data-toggle="popover" data-placement="right" data-content="Numero do telefone">
                              <i id="" class="fa fa-exclamation-triangle" style="font-size:18px"></i> 
                           </button>                 
                        </div> 
                        <div class="form-group">
                           <label class="col-lg-2 control-label">Tipo</label>
                           <div class="col-lg-2">
                              <select name="reg_tipo" class="form-control">
                                 <option value="sms">SMS</option>
                                 <option value="voice">Ligação</option>
                              </select>
                           </div> 
                           <button type="button" class="btn btn-oval btn-default visible-lg" data-container="body" data-toggle="popover" data-placement="right" data-content="Código enviado pro celular">
                              <i class="fa fa-exclamation-triangle" style="font-size:18px"></i> 
                           </button>                     
                        </div>
                        <div class="form-group">
                           <label class="col-lg-2 control-label">Code</label>
                           <div class="col-lg-1">
                              <input type="text" name="reg_code" class="form-control" value=""/>
                           </div> 
                           <button type="button" class="btn btn-oval btn-default visible-lg" data-container="body" data-toggle="popover" data-placement="right" data-content="Código enviado pro celular">
                              <i class="fa fa-exclamation-triangle" style="font-size:18px"></i> 
                           </button>                     
                        </div>

                        <div class="form-group">
                           <label class="col-lg-2 control-label">Password</label>
                           <div class="col-lg-4">
                              <input type="text" name="reg_password" class="form-control" value="{{ (!empty($settings->set_password) ? $settings->set_password : '') }}" />
                           </div> 
                           <button type="button" class="btn btn-oval btn-default visible-lg" data-container="body" data-toggle="popover" data-placement="right" data-content="Senha gerada">
                              <i class="fa fa-exclamation-triangle" style="font-size:18px"></i> 
                           </button>                     
                        </div>  
                        
                        <br/>
                        <br/>
                        <hr/>

                        <div class="form-group">
                           <div class="col-lg-offset-2 col-lg-10">
                              <button type="submit" class="btn btn-sm btn-success pull-right">Gerar Password</button>
                           </div>
                        </div>
                     </form>                  
                  </div>

                  <div id="settings" role="tabpanel" class="tab-pane">                     
                        
                                         
                  </div>                  
               </div>
            </div>
         </div><!-- End panel body -->
      <!-- END panel-->
      </div>
   </div>
</div>


<div id="novoNumero" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success-dark">
        <button type="button" data-dismiss="modal" aria-label="Close" class="close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 id="" class="modal-title">Adicionar novo numero</h4>
      </div>
      <form id="j_add_number">
        <div class="modal-body">
          
          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <label>Nome</label>
                <input name="set_name" type="text" class="form-control">
              </div>                          
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4 col-xs-12">
                <label>Numero</label>
                <input id="j_add_new_number" name="set_number" type="text" class="form-control">
              </div>
              <div class="col-md-8 col-xs-12">
                <label>Password</label>
                <input name="set_password" type="text" class="form-control">
              </div>              
            </div>
          </div>

        </div>  
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-default">Fechar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>




@endsection