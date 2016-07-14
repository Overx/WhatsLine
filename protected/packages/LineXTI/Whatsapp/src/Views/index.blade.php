@extends('admin.app')
@section('title', 'Whatsapp')
@section('descricao', 'Sistema para gerenciamento de mensagens por Whatsapp')
@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="row">	
			<div class="col-md-2">
				<div style="margin-top:10px"></div>
				<div class="input-group m-b">
					<span class="input-group-addon"><i class="fa fa-phone"></i></span>										
					<input name="" type="text" placeholder="Numero" class="form-control">
				</div>
			</div>	
			<div class="col-md-4">
				<div style="margin-top:10px"></div>
				<div class="input-group m-b">
					<span class="input-group-addon"><i class="fa fa-key"></i></span>										
					<input name="" type="text" placeholder="Sua senha" class="form-control">
				</div>
			</div>		
			<div class="col-md-3" style="padding: 0;">	
				<button type="button" style="margin:10px 0;" class="btn btn-labeled btn-success pull-left">
					<span class="btn-label"><i class="fa fa-save"></i>
					</span>Salvar
				</button>
				<button type="button" style="margin:10px 5px;" class="btn btn-labeled btn-primary pull-left">
					<span class="btn-label"><i class="fa fa-phone"></i>
					</span>Gerir Senha
				</button>
			</div>
			<div class="col-md-3">					
				<button data-toggle="modal" data-target="#novaMensagem" class="btn btn-success" style="margin:10px 0; float:right"><i class="icon-plus"></i> &nbsp Nova Mensagem</button>				
			</div>
		</div>
		<div class="panel panel-default animated pulse">			
			<div class="panel-body">
				<table id="datatable1" class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Mensagem</th>
							<th class="sort-alpha">Numero</th>
							<th class="sort-alpha">Data</th>
							<th width="8%" class="sort-alpha" style="text-align:center">Status</th>
							<th width="25%" class="sort-alpha">Opções</th>
						</tr>
					</thead>
					<tbody>						
						
							<tr class="">
								<td></td>
								<td></td>
								<td></td>
								<td style="text-align:center"><i class="fa fa-check-circle" style="color:green;font-size: 20px;"></i> </td> <!-- fa-minus-circle -->
								<td>
									<button id="" class="btn btn-xs btn-success j_editar_cat"><i class="fa fa-pencil-square-o"></i> Reenviar</button>
									<button id="" class="btn btn-xs btn-danger j_excluir_cat"><i class="fa fa-close"></i> Excluir</button>
								</td>
							</tr>
							
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- NOVA CATEGORIA -->
<div id="novaMensagem" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-success-dark">
				<button type="button" data-dismiss="modal" aria-label="Close" class="close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 id="" class="modal-title">Nova Mensagem</h4>
			</div>
			<form id="j_nova_mensagem">
				<div class="modal-body">
				<div id="debug"></div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label>Numero</label>
								<div class="input-group m-b">
									<span class="input-group-addon"><i class="fa fa-phone"></i></span>										
									<input name="whatsapp_numero" type="text" placeholder="Telefone" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<label>Mídia</label>
								<input type="file" name="img" data-classbutton="btn btn-default" data-classinput="form-control inline" class="form-control filestyle">
							</div>							
						</div>
					</div>	
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>Mensagem</label>
								<textarea name="whatsapp_mensagem" class="form-control" placeholder="Digite aqui"></textarea>
							</div>							
						</div>
					</div>	
					<div class="form-group">
						<div class="row">
	                       <div class="col-md-12">	                       		
		                        <label class="switch switch-lg">
		                            <input type="checkbox" >
		                            <span></span>
		                        </label>	
		                        <label style="margin-left: 20px;">Enviar para todos contatos</label>	                        
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


<!-- EXCLUINDO O CATEGORIA -->
<div id="excluidoCategoria" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header bg-danger-dark">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h4 id="" class="modal-title">Excluindo categoria</h4>
         </div>
         <div id="j_editar_load" class="modal-body">
			<p class="text-center">Você tem certeza que deseja excluir esse categoria?<br> Excluindo essa categoria você ira remover automaticamente dos seus posts</p>			
         </div>
         <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Não</button>
            <button id="" type="button" class="btn btn-danger j_excluir_accept">Sim</button>
         </div>
      </div>
   </div>
</div>


@endsection