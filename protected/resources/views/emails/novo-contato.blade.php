<style type="text/css">
	* {
	    margin-bottom: 5px;
	    margin-top: 5px;
	    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	    font-size: 15px;
	}

	.texto-rodape{
		text-align: center;
	}
</style>
<div style="
	margin: 0px auto;
    width: 800px;
    ">
    <div style="background:#F1F1F1;padding: 50px;">		
		<div class="texto">			
			<p>
				{!! $conteudo !!}
			</p>
		</div>
		<br/>
		<div class="texto-rodape">
			<p>{{ $nome }} | {{ $email }} | {{ $telefone }}</p>
			<small>Data: {{ date('d/m/Y H:i:s') }}</small>
		</div>
		
	</div>
</div>