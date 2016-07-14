@extends('cliente.app')
@section('title', 'Campanhas')
@section('descricao', 'Crie e gerencie suas campanhas')
@section('content')

<div class="row">
	<div class="col-lg-6">
	</div>
	<div class="col-lg-6">
		<a href="{{ URL::to('cliente/new/campaign') }}" class="btn btn-success pull-right margin-bottom-20"><i class="icon-plus"></i>&nbsp Nova Campanha</a>
	</div>
</div>

<div id="debug"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				Minhas Campanhas
			</div>
			<div class="panel-body">
				<table id="datatable2" class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Rendering engine</th>
							<th>Browser</th>
							<th>Platform</th>
							<th class="sort-numeric">Engine version</th>
							<th class="sort-alpha">CSS grade</th>
						</tr>
					</thead>
					<tbody>

						<tr class="gradeX">
							<td>Trident</td>
							<td>Internet Explorer 4.0</td>
							<td>Win 95+</td>
							<td>4</td>
							<td>X</td>
						</tr>

					</tbody>
					<tfoot>
						<tr>
							<th>
								<input type="text" name="filter_rendering_engine" placeholder="Filter Rendering engine" class="form-control input-sm datatable_input_col_search">
							</th>
							<th>
								<input type="text" name="filter_browser" placeholder="Filter Browser" class="form-control input-sm datatable_input_col_search">
							</th>
							<th>
								<input type="text" name="filter_platform" placeholder="Filter Platform" class="form-control input-sm datatable_input_col_search">
							</th>
							<th>
								<input type="text" name="filter_engine_version" placeholder="Filter Engine version" class="form-control input-sm datatable_input_col_search">
							</th>
							<th>
								<input type="text" name="filter_css_grade" placeholder="Filter CSS grade" class="form-control input-sm datatable_input_col_search">
							</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>


@endsection