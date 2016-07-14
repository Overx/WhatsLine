<div>
	<h4>E-mail de Cliente</h4>
	<p>Você recebeu um e-mail do <strong>{{ $contato_name }}</strong></p>
	<div style="background:#F1F1F1; padding:20px; color:#000; border: 1px solid #DCDADA; border-radius: 5px;margin: 10px">
		<p><strong>Nome:</strong> {{ $contato_name }}</p>
		<p><strong>E-mail:</strong> {{ $contato_email }}</p>
		<p><strong>Telefone:</strong> {{ $contato_telefone }}</p>
		<br/>
		<p>
			{{ $contato_mensagem }}
		</p>
	</div>
	<small>Data: {{ date('d/m/Y H:i:s') }}</small>
</div>