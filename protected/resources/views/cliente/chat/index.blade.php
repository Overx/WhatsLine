@extends('cliente.app')
@section('title', 'Bate Papo')
@section('descricao', 'Sessão de bate papo com seus contatos')
@section('content')

<div id="debug"></div>

<section>
<!-- Page content-->
<div class="flatdoc-wrapper">
	<div class="flatdoc">
		<div id="j_load_contacts" class="flatdoc-menu">
			<div id="search">
				<input id="j_search" type="text" class="form-control" />
			</div>
			<ul class="level-1" id="root-list" data-height="450" data-scrollable="">
				<div id="search_results">
					

				</div>
			</ul>		
		</div>
		<div id="j_load_messages" class="flatdoc-content">
			<div class="message-send-container">
				<div id="j_message_send" class="messages">
					
				</div><!--.messages-->
			</div><!--.message-send-container-->
			<div id="j_load_composing" class="send-message">
				<div class="input-wrapper">
					<input id="" type="text" placeholder="Digite aqui" class="form-control j_send_message">
				</div>
			</div><!--.send-message-->
		</div>

	</div>
</div>

</section>


@endsection