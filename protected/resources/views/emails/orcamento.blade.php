<div class="container">
	<div class="well">
		<p><strong>Nome:</strong> {{ $os_nome }}</p>
		<p><strong>E-mail:</strong> {{ $os_email }}</p>
		<p><strong>Telefone:</strong> {{ $os_telefone }}</p>
		<hr>
		<p><strong>Serviço:</strong> {{ $os_servico }}</p>
		<p><strong>Empresa:</strong> {{ $os_empresa }}</p>
		<hr>
		<p><strong>Mensagem:</strong><br> {{ $os_mensagem }}</p>
		<p><strong>Como conheceu:</strong> {{ $os_sabendo }} | <small>{{ date('d-m-Y') }}</small> </p>
	</div>
</div>