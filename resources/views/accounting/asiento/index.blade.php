@extends('accounting.asiento.main')

@section('module')
	<section class="content-header">
		<h1>
			Asientos contables <small>Administración asientos contables</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ trans('app.home') }}</a></li>
			<li class="active">Asientos contables</li>
		</ol>
	</section>

	<section class="content">
		<div id="asientos-main">
			<div class="box box-success">
                <div class="box-body">
                    {!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
                        <div class="form-group">
                            <label for="search_numero" class="col-sm-1 control-label">Número</label>
                            <div class="col-sm-2">
								<input id="search_numero" name="search_numero" placeholder="Número" class="form-control input-sm" type="text" maxlength="15" value="{{ session('search_numero') }}">
                            </div>

                            <label for="search_tercero" class="col-sm-1 control-label">Tercero</label>
                            <div class="col-sm-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="search_tercero">
                                            <i class="fa fa-user"></i>
                                        </button>
                                    </span>
                                    <input id="search_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="search_tercero" type="text" maxlength="15" data-wrapper="modal-asiento-wrapper-ordenp" data-name="search_tercero_nombre" value="{{ session('search_tercero') }}">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <input id="search_tercero_nombre" name="search_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly value="{{ session('search_tercero_nombre') }}">
                            </div>
                        </div>

                        <div class="form-group">
							<label for="search_documento" class="col-md-offset-3 col-md-1 control-label">Documento</label>
							<div class="col-md-4">
								<select name="search_documento" id="search_documento" class="form-control select2-default-clear">
									@foreach( App\Models\Accounting\Documento::getDocuments() as $key => $value)
									<option value="{{ $key }}" {{ session('search_documento') == $key ? 'selected': '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-1">
								<a href="#" class="btn btn-default btn-sm btn-import-modal"><i class="fa fa-upload"></i> Importar</a>
							</div>
						</div>
						<div class="form-group">
                            <div class="col-md-offset-3 col-md-2 col-xs-4">
                                <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <a href="{{ route('asientos.create') }}" class="btn btn-default btn-block btn-sm">
                                    <i class="fa fa-plus"></i> Nuevo asiento
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}

					<div class="box-body table-responsive">
						<table id="asientos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-paginacion="{{ $empresa->empresa_paginacion }}">
					        <thead>
					            <tr>
					                <th>Número</th>
					                <th>Documento</th>
					                <th>Año</th>
					                <th>Mes</th>
					                <th>Tercero</th>
					                <th>Nombre</th>
					            </tr>
					        </thead>
					    </table>
					</div>
				</div>
			</div>
		</div>
	</section>
@stop
