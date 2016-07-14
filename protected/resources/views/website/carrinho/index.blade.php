@extends('website.layout')
@section('content')


<header>
	<nav class="navbar navbar-custom navbar-top navbar-fixed-top sticky-navigation" >
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
					<i class="fa fa-bars"></i>
				</button>
				<!-- LOGO -->
				<a class="navbar-brand nav-logo page-scroll" href="#page-top">
					<img src="{{ URL::to('assets/images/logo.png') }}" alt="{{ Lang::get('home.title') }}"/>
				</a>
			</div>

			<a href="{{ URL::to('login') }}" class="pull-right btn btn-primary btn-login visible-lg">Login</a>
			<!-- NAVIGATION LINKS -->
			<div class="collapse navbar-collapse navbar-right navbar-main-collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="{{ URL::to('/') }}">Home</a></li>                    
				</ul>
			</div><!-- /.navbar-collapse -->

		</div><!-- /.container -->
	</nav>
</header><!-- Header end -->


<section id="intro-page" >
	<div class="container">
		<div class="row relative">
			<div class="col-md-6">
				<img src="{{ URL::to('assets/images/cart-add-icon.png') }}" alt="WhatsLine" class="pull-left img-responsive"/>                
			</div><!-- col-md-6 end -->

			<div class="col-md-6 text-right">
				<h1 class="">CARRINHO</h1>
				<span>Carrinho de compra, abaixo detalhes do seu pedido.</span>
			</div>
		</div><!-- row end -->
	</div><!-- container end -->
</section><!-- intro end -->


<section id="app-brief2" class="section" >
	<div class="container">
		<div class="row relative">
			<div class="col-md-2">
				<div class="panel panel-default border-top-blue" style="text-align: center">
					<div class="panel-body">
						<a id="_login" href="">
							<img src="{{ URL::to('assets/images/auth.png') }}" class="img-responsive" alt="" style="margin-bottom: 5px;">
						</a>
					</div>
				</div>
			</div>
			<div class="col-md-10">
				<div class="panel panel-default border-top-blue">				
					<div id="_load" class="panel-body" style="padding: 10px 0 0 0;font-size: 14px;">
						<div class="table-responsive">
							<table class="table table-striped" style="margin-bottom: 0;"> 
								<thead> 
									<tr> 
										<th width="30%">Plano</th> 
										<th>Tipo de Pagamento</th> 
										<th>Mêses</th> 
										<th>Preço</th> 
										<th>Total</th> 
									</tr> 
								</thead> 
								<tbody> 
									<?php 
									$plans = '';

									if(!empty($plan)):
										switch ($plan):
									case 'P101':
									$plans = 'Plano Padrão';
									break;
									case 'P102':
									$plans = 'Plano Econômico';
									break;
									case 'P103':
									$plans = 'Plano corporativo';
									break;
									endswitch;
									endif;
									?>
									<tr> 
										<input id="_plano" type="hidden" value="{{ (!empty($plan) ? $plan : '') }}">
										<td>{{ $plans }}</td> 
										<td style="padding: 4px 5px;">
											<select id="_tipop" class="form-control" style="margin-bottom: 0">
												<option value="avista">Depósito ou Transferência bancária</option>
												<!--<option value="pagseguro">Cartão Crédito - Pagseguro</option> -->
												<option value="paypal">Cartão Crédito - Paypal</option>
											</select>
										</td>
										<td style="padding: 4px 5px;">
											<select id="_month" class="form-control" style="margin-bottom: 0">
												<option value="30">30 dias</option>
												<option value="90">3 mêses</option>
												<option value="180">6 mêses</option>
												<option value="360">1 ano</option>
											</select>
										</td> 
										<td>R$ <span id="_valor">{{ $price }}</span></td> 
										<td>R$ <span id="_total">{{ $price }}</span></td> 
									</tr>
									<tr id="_email_field">
										<td style="padding: 4px 5px;">
											<input id="_full_name" type="text" name="full_name" class="form-control" placeholder="Seu nome completo" value="" style="margin-bottom: 0"></input>
										</td>
										<td style="padding: 4px 5px;">
											<input id="_email" type="email" name="email" class="form-control" placeholder="Seu e-mail" value="" style="margin-bottom: 0"></input>
										</td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody> 
							</table>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-6">
								<a href="{{ URL::to('/') }}" class="btn btn-black pull-left"> Voltar</a>
							</div>
							<div class="col-md-6">
								<button id="_submit" class="btn btn-primary pull-right"> Finalizar o Pedido</button>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div><!-- container end -->
</section><!-- #app-brief2 section end -->

@endsection


@section('post-script')
<!-- PRELOADER -->
<script src="{{ URL::to('assets/js/payment.js') }}"></script>
@endsection