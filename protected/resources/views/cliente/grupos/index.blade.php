@extends('cliente.app')
@section('title', 'Grupos')
@section('descricao', 'Gerenciamento de grupos')
@section('content')

<div id="debug"></div>
<div class="row">
	<div class="col-md-6">
		<button data-toggle="modal" data-target="#novoGrupo" class="btn btn-success">
			<i class="fa fa-group"></i> Novo Grupo
		</button>
	</div>
	<div class="col-md-6">
		
	</div>
</div> <br/>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">Todos os Grupos</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Capa</th>
								<th>Assunto</th>
								<th>Data</th>
								<th>Excluir</th>
							</tr>
						</thead>
						<tbody>
						@foreach($grupos as $gp)
							<tr>
								<td>
									@if(!empty($gp->gp_image))
										<img src="{{ $gp->gp_image }}" width="30" height="30" class="img-responsive img-circle" style="height: 30px !important;">
									@else
										<img src="{{ urlBase('app/img/user/02.jpg') }}" alt="" width="30" height="30" class="img-responsive img-circle">
									@endif
								</td>
								<td><a href="{{ URL::to('cliente/grupo/chat/' . base64_encode($gp->gp_group_id)) }}"> {{ $gp->gp_subject }}</a></td>
								<td>{{ date('d/m/Y', strtotime($gp->gp_data)) }}</td>
								<td>
									<button id="{{ $gp->gp_group_id }}" class="btn btn-danger btn-xs j_delete"><i class="fa fa-times"></i> Excluir</button>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>


<div id="novoGrupo" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-success-dark">
				<button type="button" data-dismiss="modal" aria-label="Close" class="close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 id="" class="modal-title">Adicionar novo grupo</h4>
			</div>
			<form id="j_add_group" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>Nome do Grupo</label>
								<input name="gp_title" type="text" class="form-control">
							</div>							
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>Contatos</label>
								<select id="j_contact" name="gp_participants[]" multiple class="chosen-select form-control">
	                                @if(count($contatos) > 0)
	                                	@foreach($contatos as $con)
	                                		<option value="{{ $con->con_number }}">{{ $con->con_name }}</option>
	                                	@endforeach
	                                @endif		                                 
	                            </select>                           
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12" style="margin-top:25px">
								<div class="checkbox c-checkbox">
									<label>
									<input id="j_select_contact" name="all_con"  type="checkbox">
									<span class="fa fa-check"></span>Todos os contatos</label>
								</div> <br>
							</div>
						</div>
					</div>	
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label>Upload de Image</label>
								<input type="file" name="img" data-classbutton="btn btn-default" data-classinput="form-control inline" class="form-control filestyle">
								<span class="help-block">Envio de Imagem em JPG ou PNG</span>
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