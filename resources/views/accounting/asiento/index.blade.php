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
							<label for="search_documento" class="col-md-1 control-label">Documento</label>
							<div class="col-md-4">
								<select name="search_documento" id="search_documento" class="form-control select2-default-clear">
									@foreach (App\Models\Accounting\Documento::getDocuments() as $key => $value)
										<option value="{{ $key }}" {{ session('search_documento') == $key ? 'selected': '' }}>{{ $value }}</option>
									@endforeach
								</select>
							</div>
							<label for="search_fecha_asiento" class="col-md-1 control-label">Fecha asiento</label>
							<div class="col-md-2">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" id="search_fecha_asiento" name="search_fecha_asiento" placeholder="Fecha asiento" value="{{ session('search_fecha_asiento') }}" class="form-control input-sm datepicker">
								</div>
							</div>
							<label for="search_fecha_elaboro" class="col-md-1 control-label">Fecha elaboro</label>
							<div class="col-md-2">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" id="search_fecha_elaboro" name="search_fecha_elaboro" placeholder="Fecha elaboro" value="{{ session('search_fecha_elaboro') }}" class="form-control input-sm datepicker">
								</div>
							</div>
							@ability ('importar' | 'asientos')
								<div class="col-md-1">
									<div class="btn-group">
										<button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
											Importar <span class="fa fa-upload"></span>
										</button>
										<ul class="dropdown-menu pull-right">
											<li><a href="#" class="btn-import-modal" data-option="I">Individual</a></li>
											<li><a href="#" class="btn-import-modal" data-option="G">Grupal</a></li>
										</ul>
									</div>
								</div>
							@endability
						</div>
						<div class="form-group">
                            <div class="@ability ('crear' | 'asientos') col-md-offset-3 @elseability col-md-offset-4 @endability col-md-2 col-xs-4">
                                <button type="button" class="btn btn-default btn-block btn-sm btn-clear">Limpiar</button>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <button type="button" class="btn btn-primary btn-block btn-sm btn-search">Buscar</button>
                            </div>
							@ability ('crear' | 'asientos')
	                            <div class="col-md-2 col-xs-4">
	                                <a href="{{ route('asientos.create') }}" class="btn btn-default btn-block btn-sm">
	                                    <i class="fa fa-plus"></i> Nuevo
	                                </a>
	                            </div>
							@endability
                        </div>
                    {!! Form::close() !!}

					<div class="box-body table-responsive">
						<table id="asientos-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%" data-pagination="{{ $companyPagination }}">
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
