@extends('cliente.app')
@section('title', 'Campanhas')
@section('descricao', 'Crie e gerencie suas campanhas')
@section('content')

<div class="row">
	<div class="col-lg-6">
	</div>
	<div class="col-lg-6">
		<a href="{{ URL::to('cliente/campanhas') }}" class="btn btn-inverse pull-right margin-bottom-20"><i class="icon-arrow-left"></i>&nbsp Voltar</a>
	</div>
</div>

<div id="debug"></div>


@endsection