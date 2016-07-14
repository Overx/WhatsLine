@extends('cliente.app')
@section('title', 'Mensagens')
@section('descricao', 'Sessão para listagem de mensagens')
@section('content')

<div class="row">
   <div class="col-md-12"><div id="debug"></div> </div>
</div>

<div class="row">
   <div class="titulo col-md-6"> 
      <h1 class="title-row"><i class="icon-bubbles fa-x3"></i> MENSAGENS</h1>
   </div>
   <div class="col-md-3"> 
      <a href="{{ URL::to('cliente/nova/mensagem') }}" class="btn btn-success btn-block" style="margin:10px 0px;">
         <i class="icon-plus"></i> &nbsp Nova Mensagem
      </a>
   </div>  
   <div class="col-md-3">              
      <button data-toggle="modal" data-target="#deleteMensagens" class="btn btn-danger btn-block j_delete_all" style="margin:10px 0;">
         <i class="fa fa-times"></i> &nbsp Apaga Mansagens
      </button>
   </div>
</div>

<div class="row">
   <div class="col-lg-9 visible-lg">
      <div class="panel panel-success animated pulse">  
         <div class="panel-heading">
            Lista de mensages 
         </div>       
         <div class="panel-body" id="j_contato_editar">
            <div class="row">
               <div class="col-lg-12">
                  <div class="table-responsive">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th>Numero</th>
                              <th>Tipo</th>
                              <th>Data</th>
                              <th>Status</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if(count($messages) > 0)
                              @foreach($messages as $msg)
                                 <tr>
                                    <td>
                                       <?php 
                                          if(strlen($msg->message_to) > 10): 
                                             echo "+".substr($msg->message_to, 0, 2)
                                             ."(".substr($msg->message_to, 2, 2).") "
                                             .substr($msg->message_to, 4, 4)."-"
                                             .substr($msg->message_to, 8, 5);
                                          else:
                                             echo "+".substr($msg->message_to, 0, 2)
                                             ."(".substr($msg->message_to, 2, 2).") "
                                             .substr($msg->message_to, 4, 4)."-"
                                             .substr($msg->message_to, 8, 4);
                                          endif;
                                       ?>
                                    </td>
                                    <td>
                                    <?php 
                                       switch ($msg->message_type) {
                                          case 'message':
                                             echo '<strong>Mensagem</strong>';
                                             break;
                                          case 'image':
                                             echo '<strong>Imagem</strong>';
                                             break;
                                          case 'audio':
                                             echo '<strong>Audio</strong>';
                                             break;
                                          case 'video':
                                             echo '<strong>Vídeo</strong>';
                                             break;
                                          case 'vcard':
                                             echo '<strong>Cartão</strong>';
                                             break;
                                       }
                                    ?>
                                    </td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($msg->message_data)) }}</td>
                                    <td>
                                    <?php
                                       switch ($msg->message_status) {
                                          case 'done':
                                             echo '<div class="label label-success">Enviado</div>';
                                             break;
                                          case 'send':
                                             echo '<div class="label label-primary">aguardando</div>';
                                             break;
                                       }
                                    ?>
                                    </td>
                                 </tr>                                 
                              @endforeach   
                           @endif
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="panel-footer">
            <div class="row">
               <div class="col-lg-12">
                  <div style="text-align: center">{!! (count($messages) > 0 ? @$messages->render() : '' ) !!}</div>
               </div>
            </div>
         </div>
      </div>

   </div><!-- col-lg-12 -->
   <div class="col-lg-3 col-sm-12">

      <div class="panel panel-success animated pulse">           
         <div id="j_load" class="panel-body">
            <a href="#" class="text-muted pull-right">
               <em class="fa fa-arrow-right"></em>
            </a>
            <div class="text-info">Mensagens</div>
            <div id="j_graph_messages"></div>
            
            <div data-sparkline="" data-bar-color="#048904" data-height="30" data-bar-width="5" data-bar-spacing="2" data-values="5,4,8,7,8,5,4,6,5,5,9,4,6,3,4,7,5,4,7" class="text-center"></div>
         </div>
         <div class="panel-footer">
            <p class="text-muted">
               <em class="fa fa-upload fa-fw"></em>
               <span>Total:</span>
               <span class="text-dark"></span>
            </p>
         </div>
      </div><!-- panel -->

   </div><!-- col-lg-3 -->
</div>


<div id="excluidoContato" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-danger-dark">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h4 id="" class="modal-title">Excluindo Contato</h4>
         </div>
         <div id="j_contato_del_load" class="modal-body">
         <p class="text-center">Você tem certeza que deseja excluir esse contato?</p>       
         </div>
         <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Não</button>
            <button id="" type="button" class="btn btn-danger j_excluir_accept">Sim</button>
         </div>
      </div>
   </div>
</div>

<div id="deleteMensagens" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-danger-dark">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h4 id="" class="modal-title">Excluindo mensagens </h4>
         </div>
         <div id="j_editar_load" class="modal-body">
         <p class="text-center">Você tem certeza que deseja excluir essas mensagens?<br> Excluindo essas mensagens você ira remover automaticamente todas as respostas</p>       
         </div>
         <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Não</button>
            <button type="button" class="btn btn-danger j_delete_accept_messages">Sim</button>
         </div>
      </div>
   </div>
</div>

@endsection