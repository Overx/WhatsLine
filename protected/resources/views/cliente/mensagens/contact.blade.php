@extends('cliente.app')
@section('title', 'Histórico de conversas')
@section('descricao', 'Histórico de mensagens enviadas e recebidas')
@section('content')
<div class="row visible-lg">				
	<div class="col-md-12">					
		<a href="{{ URL::to('cliente/mensagens') }}" class="btn btn-inverse" style="margin:10px 0; float:right"><i class="icon-arrow-left"></i> &nbsp Voltar</a>				
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div id="panelDemo9" class="panel panel-primary">
			<div class="panel-heading">Painel de diálogos
				<a href="#" id="{{ $contacts->con_id }}" data-toggle="tooltip" class="pull-right j_atualizar_mensagem" data-original-title="Atualizar Mensagens">
                  <em class="fa fa-refresh"></em>
               </a>
            </div>
			<div class="panel-body">
				<div class="col-md-12">
					<div class="message-send-container">

						<div id="j_message_send" data-height="350" data-scrollable="" class="messages" style="height: calc(100% - 89px);">
							
						</div><!--.messages-->

					</div><!--.message-send-container-->
				</div><!--.col-->
			</div>

			<div class="panel-footer">
				<div class="send-message">
					<div class="input-group">
						<div class="inputer inputer-blue">
							<div class="input-wrapper">
								<textarea rows="1" id="send-message-input" class="form-control js-auto-size" placeholder="Escreva uma mensagem" style="height: 38px;"></textarea>
							</div>
						</div><!--.inputer-->
						<span class="input-group-btn">
							<button data-number="{{ $contacts->con_number }}" id="send-message-button" class="btn btn-primary btn-ripple" type="button" style="height: 36px;">Enviar mensagem</button>
						</span>
					</div>
				</div><!--.send-message-->

				<div class="mobile-back">
					<div class="mobile-back-button"><i class="ion-android-arrow-back"></i></div>
				</div><!--.mobile-back-->
			</div>
		</div>
	</div>
</div>



@endsection