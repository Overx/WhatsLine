@extends('site.layout')
@section('content')
<section id="title_breadcrumbs_bar">
	<div class="container">
		<div class="row">
			<div class="span8">
				<h1>Erro 404</h1>
			</div>
			<div class="span4 right_aligned">
				<div class="breadcrumbs">
					<a href="{{ URL::to('/') }}">Home</a> 
					<i class="ABdev_icon-chevron-right"></i> 
					<span class="current">Erro 404</span>
				</div>									
			</div>
		</div>
	</div>
</section>

<section id="page404" class="container">
	<p class="big_404">404</p>
	<h2>Oops, desculpe essa página não existe!</h2>
</section>
@endsection