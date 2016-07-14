@extends('cliente.app')
@section('title', 'Agenda de Contato')
@section('descricao', 'Agenda numero de celular de seus contatos')
@section('content')

<div class="row">
   <div class="titulo col-md-5"> 
      <h1 class="title-row"><i class="fa fa-sort-alpha-asc fa-x3"></i> CONTATOS</h1>
   </div>
   <div class="col-md-3">              
      <div class="panel-header">
         <button data-toggle="modal" data-target="#novoContato" class="btn btn-success btn-block" style="margin-top:10px; float:right"><i class="icon-plus"></i> &nbsp Novo Contato</button>
      </div>
   </div>
   <form id="j_upload" method="post" enctype="multipart/form-data">
      <div class="col-md-3">
         <div class="form-group" style="margin-top:10px; float:right">
            <input type="file" name="file" data-classbutton="btn btn-default" data-classinput="form-control inline" class="form-control filestyle">
         </div>
      </div> 
      <div class="col-md-1">
         <button type="submit" class="btn btn-success btn-block pull-right" style="margin-top:10px; float:right"><i class="fa fa-cloud-upload fa-x3"></i> </button>
      </div> 
   </form>

   <div class="col-md-12">
      <div id="progresso"></div>      
   </div>    
</div>



<div class="row">
   <div class="col-lg-12">
      <div id="debug"></div>
      <div class="panel panel-success animated pulse">  
         <div class="panel-heading">
            Lista de todos os contatos
         </div>       
         <div class="panel-body" id="j_contato_editar">
            <div id="datatable1_wrapper" class="dataTables_wrapper form-inline no-footer table-responsive">
               <table id="datatable1" class="table table-striped table-hover dataTable no-footer" role="grid" aria-describedby="datatable1_info">
                  <thead>
                     <tr>
                        <th width="7%">Avatar</th>
                        <th>Nome do Contato</th>
                        <th>E-mail</th>            
                        <th>Numero</th>            
                        <th width="20%">Opções</th>
                     </tr>
                  </thead>
                  <tbody>  
                     @if(count($contatos) > 0)
                        @foreach($contatos as $con)
                           <tr>                                   
                              <td>
                                 <img src="{{ urlBase('app/img/user/02.jpg') }}" alt="" width="30" height="30" class="img-responsive img-circle">
                              </td>
                              <td>{{ $con->con_name }}</td>
                              <td>{{ $con->con_email }}</td>
                              <td>
                                 <?php 

                                    if(strlen($con->con_number) > 10): 
                                       echo "+".substr($con->con_number, 0, 2)
                                       ."(".substr($con->con_number, 2, 2).") "
                                       .substr($con->con_number, 4, 4)."-"
                                       .substr($con->con_number, 8, 5);
                                    else:
                                       echo "+".substr($con->con_number, 0, 2)
                                       ."(".substr($con->con_number, 2, 2).") "
                                       .substr($con->con_number, 4, 4)."-"
                                       .substr($con->con_number, 8, 4);
                                    endif;
                                 ?>
                              </td>                
                              <td>
                                 <button id="{{ base64_encode($con->con_id) }}" class="btn btn-xs btn-primary j_edt_contato"><i class="fa fa-pencil-square-o"></i> Editar</button>
                                 <button id="{{ $con->con_id }}" class="btn btn-xs btn-danger j_del_contato"><i class="fa fa-close"></i> Excluir</button>
                              </td>
                           </tr>
                        @endforeach
                     @endif  
                  </tbody>
               </table>
            </div>
         </div>
         <div class="panel-footer">
            <div class="row">
               <div class="col-md-12">
                  <div class="pull-right"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="novoContato" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-success-dark">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h4 id="" class="modal-title">Adicionar Contato</h4>
         </div>
         <form id="j_novoContato" enctype="multipart/form-data">
            <div id="j_load" class="modal-body">
            <div id="debug"></div>
               <div class="form-group">
                  <div class="row">
                     <div class="col-md-12">
                        <label>Nome</label>
                         <div class="input-group m-b">
                           <span class="input-group-addon"><i class="fa fa-pencil-square"></i></span>
                           <input name="con_name" type="text" placeholder="Nome Completo" class="form-control" >
                        </div>
                     </div>                                         
                  </div>
               </div>  
               <input name="user_id" type="hidden" value="{{ \Auth::user()->id }}">
               <div class="form-group">
                  <div class="row">                    
                     <div class="col-md-12">
                        <label>E-mail</label>
                        <div class="input-group m-b">
                           <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                           <input name="con_email" type="email" placeholder="E-mail" class="form-control">
                        </div>
                     </div>                     
                  </div>
               </div>
               <div class="form-group">
                  <div class="row">                     
                     <div class="col-md-12">
                        <label>Telefone</label>
                        <div class="input-group m-b">   
                           <span class="input-group-addon"><i class="fa fa-phone"></i></span>                               
                           <input id="j_contato_tel" name="con_number" data-masked="" type="text" placeholder="Telefone" class="form-control">
                        </div>
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

<div id="editarContato" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-primary-dark">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h4 id="" class="modal-title">Editar Contato</h4>
         </div>
         <form id="j_editarContato">
            <div id="j_contato_editar_load" class="modal-body">
            <div id="debug"></div>
               <div class="form-group">
                  <div class="row">
                     <div class="col-md-12">
                        <label>Nome</label>
                         <div class="input-group m-b">
                           <span class="input-group-addon"><i class="fa fa-pencil-square"></i></span>
                           <input id="con_name" name="con_name" type="text" placeholder="Nome Completo" class="form-control" required>
                        </div>
                     </div>                                         
                  </div>
               </div>  
               <input id="j_id_editar" name="id_editar" type="hidden" value="">
               <div class="form-group">
                  <div class="row">                    
                     <div class="col-md-12">
                        <label>E-mail</label>
                        <div class="input-group m-b">
                           <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                           <input id="con_email" name="con_email" type="email" placeholder="E-mail" class="form-control">
                        </div>
                     </div>                     
                  </div>
               </div>
               <div class="form-group">
                  <div class="row">                     
                     <div class="col-md-12">
                        <label>Telefone</label>
                        <div class="input-group m-b">   
                           <span class="input-group-addon"><i class="fa fa-phone"></i></span>                               
                           <input id="j_contato_cel" name="con_number" data-masked data-inputmask="'mask': '(999) 999-9999'" type="text" placeholder="Telefone" class="form-control con_number" required>
                        </div>
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

@endsection