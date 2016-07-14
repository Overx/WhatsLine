@extends('cliente.app')
@section('title', 'Nova Mensagem')
@section('descricao', 'Sessão para envio de nova mensagem')
@section('content')

<div class="row"><div class="col-md-12"><div id="debug"></div></div></div>

<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="titulo col-md-6"> 
				<h1 class="title-row"><i class="icon-bubbles fa-x3"></i> NOVA MENSAGEM</h1>
			</div>				
			<div class="col-md-6">					
				<a href="{{ URL::to('cliente/mensagens') }}" class="btn btn-inverse" style="margin:10px 0; float:right"><i class="icon-arrow-left"></i> &nbsp Voltar</a>				
			</div>
		</div>

		<div class="row"><div class="col-md-12"><div id="progresso"></div></div></div>

		<div id="j_load" class="panel panel-default animated bounceInLeft">		
			<form id="j_nova_mensagem" class="form-horizontal" enctype="multipart/form-data">	
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12" style="margin-top: 10px;">							
							<div class="form-group">
								<div class="col-md-5">
									<label>Contatos</label>
									<select id="j_contact" name="con_contatcs[]" multiple class="chosen-select form-control">
		                                <option>Selecione os contatos</option>
		                                @if(count($contatos) > 0)
		                                	@foreach($contatos as $con)
		                                		<option value="{{ $con->con_number }}">{{ $con->con_name }}</option>
		                                	@endforeach
		                                @endif		                                 
		                            </select>                           
								</div>
								<div class="col-md-2" style="margin-top:25px">
									<div class="checkbox c-checkbox">
										<label>
										<input id="j_select_contact" name="all_con"  type="checkbox">
										<span class="fa fa-check"></span>Todos os contatos</label>
									</div> <br>
								</div>
								
								<div class="col-md-5">
									<label>Tipo de Mensagem</label>
									<select id="j_type_message" name="message_type" name="post_categoria_id" class="form-control" required>
										<option value="">Selecione o tipo de mensagem</option>
										<option value="message">Mensagem</option>
										<option value="image">Imagem</option>
										<option value="audio">Audio</option>
										<option value="video">Vídeo</option>										
										<option value="locationname">Localização</option>
										<option value="vcard">vCard</option>										
									</select>
								</div>																
							</div>
							
							<hr/>

							<div id="j_message" class="form-group">
								<div class="col-sm-12">
									<textarea name="message_content" class="form-control" rows="6"></textarea>
								</div>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">	
							</div>
							<hr/>

							<div id="j_location" class="form-group" style="display:none">
								<div class="col-sm-5">
									<label>Localização</label>
									<div class="input-group m-b">
		                                <span class="input-group-addon"><i class="icon-compass"></i> </span>
		                                <input type="text" name="" class="form-control" placeholder="Sua localização">										
		                            </div>	
		                            <span class="help-block">Digite seu endereço completo para obter a localização</span>								
								</div>
								<div class="col-sm-1" style="margin-top: 25px;">
									<button type="button" class="btn btn-default"><i class="icon-target"></i> </button>
								</div>
								<div class="col-sm-3">
									<label>Latitude</label>
									<div class="input-group m-b">
		                                <span class="input-group-addon"><i class="icon-globe"></i> </span>
		                                <input name="message_latitude" type="text" name="" class="form-control" placeholder="Latitude">										
		                            </div>
								</div>
								<div class="col-sm-3">
									<label>Longitude</label>
									<div class="input-group m-b">
		                                <span class="input-group-addon"><i class="icon-globe"></i> </span>
		                                <input name="message_longitude" type="text" name="" class="form-control" placeholder="Longitude">										
		                            </div>
								</div>	
							</div>

							<div id="j_midia" class="form-group" style="display:none">
								<div class="col-md-6">
									<label>Upload de Midia</label>
									<input type="file" name="file" data-classbutton="btn btn-default" data-classinput="form-control inline" class="form-control filestyle">
									<span class="help-block">Envio de Audio em mp3, Vídeo em mp4 e Imagem em JPG ou PNG</span>
								</div>
							</div>

							<div>
								<div id="vcard" style="display:none">
									

								</div>
							</div>
						</div>
						<div class="panel-footer">
							<div class="row">
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary pull-right">Enviar</button>
								</div>
							</div>							
						</div>
					</form>
				</div>	
			</div>			
		</form>
	</div>
</div>

@endsection