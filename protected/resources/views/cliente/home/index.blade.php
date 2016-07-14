@extends('cliente.app')
@section('title', 'Painel do usuário')
@section('descricao', 'Links para acesso rápido de tudo que oferecemos.')
@section('content')

<div class="row">
	<div class="col-lg-3 col-sm-6">
		<!-- START widget-->
		<a href="{{ URL::to('cliente/agenda') }}" class="link-button">
			<div class="panel widget bg-primary">
				<div class="row row-table">
					<div class="col-xs-4 text-center bg-primary-dark pv-lg">
						<em class="icon-notebook fa-3x"></em>
					</div>
					<div class="col-xs-8 pv-lg">
						<div class="h2 mt0">{{ (count($contatos) > 0 ? count($contatos) : '0') }}</div>
						<div class="text-uppercase">Minha Agenda</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-sm-6">
		<a href="{{ URL::to('cliente/mensagens') }}" class="link-button">
			<!-- START widget-->
			<div class="panel widget bg-purple">
				<div class="row row-table">
					<div class="col-xs-4 text-center bg-purple-dark pv-lg">
						<em class="icon-envelope fa-3x"></em>
					</div>
					<div class="col-xs-8 pv-lg">
						<div class="h2 mt0">
							{{ (count($mensagens) > 0 ? count($mensagens) : '0') }}
						</div>
						<div class="text-uppercase">Minhas Mensagens</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-12">
		<a href="{{ URL::to('cliente/configuracoes') }}" class="link-button">
			<div class="panel widget bg-green">
				<div class="row row-table">
					<div class="col-xs-4 text-center bg-green-dark pv-lg">
						<em class="icon-settings fa-3x"></em>
					</div>
					<div class="col-xs-8 pv-lg">
						<div class="h2 mt0"><br/></div>
						<div class="text-uppercase">Configurações</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<!--
	<div class="col-lg-3 col-md-6 col-sm-12">
		<a href="" class="link-button">
			<div class="panel widget bg-green">
				<div class="row row-table">
					<div class="col-xs-4 text-center bg-green-dark pv-lg">
						<em class="icon-grid fa-3x"></em>
					</div>
					<div class="col-xs-8 pv-lg">
						<div class="h2 mt0">3</div>
						<div class="text-uppercase">Campanhas</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	-->
	<div class="col-lg-3 col-md-6 col-sm-12">
		<!-- START date widget-->
		<div class="panel widget">
			<div class="row row-table">
				<div class="col-xs-4 text-center bg-green pv-lg">
					<!-- See formats: https://docs.angularjs.org/api/ng/filter/date-->
					<div data-now="" data-format="MMMM" class="text-sm"></div>
					<br>
					<div data-now="" data-format="D" class="h2 mt0"></div>
				</div>
				<div class="col-xs-8 pv-lg">
					<div data-now="" data-format="dddd" class="text-uppercase"></div>
					<br>
					<div data-now="" data-format="h:mm" class="h2 mt0"></div>
					<div data-now="" data-format="a" class="text-muted text-sm"></div>
				</div>
			</div>
		</div>
		<!-- END date widget    -->
	</div>
</div>




@endsection