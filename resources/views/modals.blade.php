<!-- Modal add resource -->
<div class="modal fade" id="modal-add-resource-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="content-create-resource-component">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			{!! Form::open(['id' => 'form-create-resource-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body">
					<div id="error-resource-component" class="alert alert-danger"></div>
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<!-- Modal add resource -->
<div class="modal fade" id="modal-edit-resource-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="content-edit-resource-component">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			{!! Form::open(['id' => 'form-edit-resource-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body">
					<div id="error-edit-resource-component" class="alert alert-danger"></div>
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary btn-sm submit-edit-modal">Continuar</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<!-- Modal add tcontacto -->
<div class="modal fade" id="modal-tcontacto-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="content-tcontacto-component">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title">Buscador de contactos</h4>
			</div>
			{!! Form::open(['id' => 'form-tcontacto-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body">
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<!-- Modal generic producto -->
<div class="modal fade" id="modal-tiempop-edit-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			{!! Form::open(['id' => 'form-edit-tiempop-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body" id="modal-tiempop-wrapper">
					<div id="error-eval-tiempop" class="alert alert-danger"></div>
					<div class="content-modal">
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary btn-sm submit-modal-tiempop">Continuar</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<!-- Modal address -->
<div class="modal fade" id="modal-address-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-address-component-validacion" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search factura -->
<div class="modal fade" id="modal-search-factura-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search productos pre-cotizacion -->
<div class="modal fade" id="modal-search-productos-precotizacion-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search productos cotizacion -->
<div class="modal fade" id="modal-search-productos-cotizacion-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search productos orden -->
<div class="modal fade" id="modal-search-productos-orden-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search precotizaciones -->
<div class="modal fade" id="modal-search-precotizacion-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search cotizaciones -->
<div class="modal fade" id="modal-search-cotizacion-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search ordenp -->
<div class="modal fade" id="modal-search-ordenp-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal show productos -->
<div class="modal fade" id="modal-show-productos-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			<div class="modal-body">
				<div class="content-modal"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal search producto -->
<div class="modal fade" id="modal-search-producto-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search productop -->
<div class="modal fade" id="modal-search-productop-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search contacto -->
<div class="modal fade" id="modal-search-contacto-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal import file -->
<div class="modal fade" id="modal-import-file-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			<div class="box box-solid" id="modal-wrapper-import-file">
				<form  id="form-import-component" data-toggle="validator">
					<div class="modal-body">
						<div class="content-modal"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary btn-sm btn-import">Continuar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal search -->
<div class="modal fade" id="modal-search-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal confirm -->
<div class="modal fade" id="modal-confirm-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			<div class="modal-body">
				<div class="content-modal"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary btn-sm confirm-action">Confirmar</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal inventario -->
<div class="modal fade" id="modal-inventario-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>

			<form id="form-create-inventario-component-source" data-toggle="validator">
				<div class="modal-body" id="modal-wrapper-inventario">
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary btn-sm">Continuar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal historial insumo -->
<div class="modal fade" id="modal-historial-resource-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content" id="content-edit-resource-component">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			<div class="modal-body">
				<div class="content-modal">
					<div class=" table-responsive">
						<table id="browse-historial-producto-list" class="table table-striped table-condensed" cellspacing="0">
							<thead>
								<tr>
									<th width="30%"></th>
									<th width="30%">Fecha</th>
									<th width="40%">Costo</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

{{-- templates --}}
<script type="text/template" id="koi-address-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Generador de direcciones</h4>
	</div>

	{!! Form::open(['id' => 'form-address-component', 'data-toggle' => 'validator', 'role' => 'form']) !!}
	<div class="modal-body koi-component-address-modal-body">
		<div class="row">
			<div class="col-md-offset-2">
				<label for="koi_direccion" class="col-md-1 control-label">Direccion</label>
				<div class="form-group col-md-8">
					{!! Form::text('koi_direccion', null, ['id' => 'koi_direccion', 'class' => 'form-control input-sm','disabled']) !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-12 col-sm-12 col-xs-12">
				@foreach(config('koi.direcciones.nomenclatura') as $key => $value)
					<div class="col-md-2 col-sm-4 col-xs-6 koi-component-add address-nomenclatura">
						<a class="btn btn-default btn-block" data-key="{{$key}}">{{ $value }}</a>
					</div>
				@endforeach
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<ul class="list-inline address-digitos">
					<!-- Leters -->
					@foreach(config('koi.direcciones.alfabeto') as $key => $value)
						<li>
							<a class="btn btn-default btn-block koi-component-add" data-key="{{$key}}">{{ $value }}</a>
						</li>
					@endforeach

					<!-- Numbers -->
					@for($i=0; $i<=9; $i++)
						<li>
							<a class="btn btn-default btn-block koi-component-add">{{ $i }}</a>
						</li>
					@endfor
				</ul>
			</div>
		</div>

		<div class="row other-controls ">
			<label for="koi_direccion" class="col-md-2 col-xs-12 control-label text-right">Dirección DIAN</label>
			<div class="col-md-6">
				{!! Form::text('koi_direccion_nm', null, ['id' => 'koi_direccion_nm', 'class' => 'form-control input-sm','disabled']) !!}
			</div>
			<div class="col-md-2 koi-component-remove-last">
				<a class="btn btn-default btn-block"><i class="fa fa-backward"> Regresar</i></a>
			</div>
			<div class="col-md-2 koi-component-remove">
				<a class="btn btn-default btn-block"><i class="fa fa-trash-o"> Limpiar</i></a>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
		<button type="submit" class="btn btn-primary btn-sm btn-address-component-add-address">Continuar</button>
	</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-search-tercero-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de terceros</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-tercero-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_tercero_nit" class="col-md-1 control-label">Documento</label>
				<div class="col-md-2">
					{!! Form::text('koi_search_tercero_nit', null, ['id' => 'koi_search_tercero_nit', 'class' => 'form-control input-sm']) !!}
				</div>

				<label for="koi_search_tercero_nombre" class="col-md-1 control-label">Nombre</label>
				<div class="col-md-8">
					{!! Form::text('koi_search_tercero_nombre', null, ['id' => 'koi_search_tercero_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-tercero-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-tercero-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-tercero-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
				                <th>Documento</th>
				                <th>Nombre</th>
				                <th>Razon Social</th>
				                <th>Nombre1</th>
				                <th>Nombre2</th>
				                <th>Apellido1</th>
				                <th>Apellido2</th>
		                    </tr>
		                </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-search-plancuenta-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de cuentas</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-plancuenta-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_plancuentas_cuenta" class="col-md-1 control-label">Cuenta</label>
				<div class="col-md-2">
					{!! Form::text('koi_search_plancuentas_cuenta', null, ['id' => 'koi_search_plancuentas_cuenta', 'class' => 'form-control input-sm']) !!}
				</div>

				<label for="koi_search_plancuentas_nombre" class="col-md-1 control-label">Nombre</label>
				<div class="col-md-8">
					{!! Form::text('koi_search_plancuentas_nombre', null, ['id' => 'koi_search_plancuentas_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-plancuenta-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-plancuenta-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-plancuenta-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Cuenta</th>
				                <th>Nivel</th>
				                <th>Nombre</th>
				                <th>Naturaleza</th>
				                <th>Tercero</th>
				            </tr>
				        </thead>
				    </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-search-cotizacion-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de <%- state == 'P' ? 'pre-' : '' %>cotizaciones</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-cotizacion-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="search_cotizacion_numero" class="col-md-1 control-label">Codigo</label>
				<div class="col-md-2">
					<input id="search_cotizacion_numero" placeholder="Codigo" class="form-control input-sm" name="search_cotizacion_numero" type="text" maxlength="15">
				</div>
				<label for="search_cotizacion_tercero" class="col-sm-1 control-label">Tercero</label>
				<div class="form-group col-sm-3">
		      		<div class="input-group input-group-sm">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="search_cotizacion_tercero">
								<i class="fa fa-user"></i>
							</button>
						</span>
						<input id="search_cotizacion_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="search_cotizacion_tercero" type="text" maxlength="15" data-wrapper="modal-asiento-wrapper-cotizacion" data-name="search_cotizacion_tercero_nombre">
					</div>
				</div>
				<div class="col-sm-5">
					<input id="search_cotizacion_tercero_nombre" name="search_cotizacion_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-cotizacion-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-cotizacion-component">Limpiar</button>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-cotizacion-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th width="10%">Código</th>
			                	<th>Ano</th>
				                <th>Numero</th>
			                	<th width="70%">Tercero</th>
			                	<th width="10%">Fecha</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-search-ordenp-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de ordenes</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-ordenp-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="searchordenp_ordenp_numero" class="col-md-1 control-label">Codigo</label>
				<div class="col-md-2">
					<input id="searchordenp_ordenp_numero" placeholder="Codigo" class="form-control input-sm" name="searchordenp_ordenp_numero" type="text" maxlength="15">
				</div>
				<label for="searchordenp_tercero" class="col-sm-1 control-label">Tercero</label>
				<div class="form-group col-sm-3">
		      		<div class="input-group input-group-sm">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchordenp_tercero">
								<i class="fa fa-user"></i>
							</button>
						</span>
						<input id="searchordenp_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchordenp_tercero" type="text" maxlength="15" data-wrapper="modal-asiento-wrapper-ordenp" data-name="searchordenp_tercero_nombre">
					</div>
				</div>
				<div class="col-sm-5">
					<input id="searchordenp_tercero_nombre" name="searchordenp_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-ordenp-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-ordenp-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-ordenp-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th width="10%">Código</th>
			                	<th>Ano</th>
				                <th>Numero</th>
			                	<th width="70%">Tercero</th>
			                	<th width="10%">Fecha</th>
			                	<th width="10%">Estado</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<!-- Script productos -->
<script type="text/template" id="koi-search-productos-cotizacion-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador productos de <%- state == 'P' ? 'pre-' : '' %>cotizaciones</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-producto-cotizacion-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="row">
                <label for="search_cotizacion" class="col-md-1 control-label"><%- state == 'P' ? 'Pre-c' : 'C' %>otización</label>
                <div class="form-group col-md-3 col-sm-8 col-xs-8">
                    <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-flat btn-koi-search-cotizacion-component-table" data-field="search_cotizacion" data-state="<%- state %>">
                                <i class="fa fa-building-o"></i>
                            </button>
                        </span>
                        <input id="search_cotizacion" name="search_cotizacion" placeholder="Código" class="form-control cotizacion-koi-component" type="text" maxlength="15" data-name="search_cotizacion_nombre">
                    </div>
                </div>
                <div class="col-sm-6 col-md-8 col-xs-10">
                    <input id="search_cotizacion_nombre" name="search_cotizacion_nombre" placeholder="Cliente" class="form-control input-sm" type="text" readonly>
                </div>
            </div>
			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-producto-cotizacion-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-producto-cotizacion-component">Limpiar</button>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-productos-cotizacion-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th width="10%">Código</th>
			                	<th width="10%">Cotización</th>
			                	<th width="75%">Producto</th>
								<th>Ano</th>
				                <th>Numero</th>
				                <th width="5%"></th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-search-productos-orden-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador productos de ordenes</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-producto-orden-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="row">
                <label for="search_ordenp" class="col-md-1 control-label">Orden</label>
                <div class="form-group col-md-3 col-sm-8 col-xs-8">
                    <div class="input-group input-group-sm">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-flat btn-koi-search-orden-component-table" data-field="search_ordenp">
                                <i class="fa fa-building-o"></i>
                            </button>
                        </span>
                        <input id="search_ordenp" placeholder="Orden" class="form-control ordenp-koi-component orden-change-koi" name="search_ordenp" type="text" maxlength="15" data-factura="true" data-name="search_ordenp_nombre">
                    </div>
                </div>
                <div class="col-sm-6 col-md-8 col-xs-10">
                    <input id="search_ordenp_nombre" name="search_ordenp_nombre" placeholder="Tercero" class="form-control input-sm" type="text" readonly>
                </div>
            </div>
			<div class="row">
                <label for="search_ordenp_estado" class="col-md-1 control-label col-md-offset-3">Estado</label>
				<div class="col-md-5">
					<select name="search_ordenp_estado" id="search_ordenp_estado" class="form-control">
						<option value="" selected>Todas</option>
						<option value="A">Abiertas</option>
						<option value="N">Anuladas</option>
						<option value="C">Cerradas</option>
						<option value="T">Culminadas</option>
					</select>
				</div>
            </div><br>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-producto-orden-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-producto-orden-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-productos-orden-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th width="10%">Código</th>
			                	<th width="10%">Orden</th>
			                	<th width="75%">Producto</th>
								<th>Ano</th>
				                <th>Numero</th>
				                <th width="5%"></th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<!-- Script producto -->
<script type="text/template" id="koi-search-producto-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de insumos</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-producto-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_producto_codigo" class="col-md-1 control-label">Código</label>
				<div class="col-md-2">
					{!! Form::text('koi_search_producto_codigo', null, ['id' => 'koi_search_producto_codigo', 'class' => 'form-control input-sm']) !!}
				</div>

				<label for="koi_search_producto_nombre" class="col-md-1 control-label">Nombre</label>
				<div class="col-md-8">
					{!! Form::text('koi_search_producto_nombre', null, ['id' => 'koi_search_producto_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-producto-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-producto-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-producto-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th>Código</th>
			                	<th>Nombre</th>
			                	<th>Maneja</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<!-- Script productop -->
<script type="text/template" id="koi-search-productop-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de productos</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-productop-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_productop_codigo" class="col-md-1 control-label">Código</label>
				<div class="col-md-2">
					{!! Form::text('koi_search_productop_codigo', null, ['id' => 'koi_search_productop_codigo', 'class' => 'form-control input-sm']) !!}
				</div>

				<label for="koi_search_productop_nombre" class="col-md-1 control-label">Nombre</label>
				<div class="col-md-8">
					{!! Form::text('koi_search_productop_nombre', null, ['id' => 'koi_search_productop_nombre', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-productop-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-productop-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-productop-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th>Código</th>
			                	<th>Nombre</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-search-contacto-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de contactos</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-contacto-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="koi_search_contacto_nombres" class="col-md-1 control-label">Nombres</label>
				<div class="col-md-5">
					{!! Form::text('koi_search_contacto_nombres', null, ['id' => 'koi_search_contacto_nombres', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
				<label for="koi_search_contacto_apellidos" class="col-md-1 control-label">Apellidos</label>
				<div class="col-md-5">
					{!! Form::text('koi_search_contacto_apellidos', null, ['id' => 'koi_search_contacto_apellidos', 'class' => 'form-control input-sm input-toupper']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-contacto-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-contacto-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-contacto-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				            	<th>Id</th>
			                	<th>Nombres</th>
			                	<th>Apellidos</th>
				                <th>Nombre</th>
				                <th>Teléfono</th>
				                <th>Municipio</th>
				                <th>Dirección</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-component-select-tpl">
	<div class="modal-header">
		<h4 class="modal-title"></h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="form-group col-md-12">
			<label class="col-md-2 col-xs-12 control-label">Nombre</label>
				<div class="col-md-5">
				    <select name="component-select" id="component-select" class="form-control" required>
	                    <option value="" selected>Seleccione</option>
	                    <option value="si">Si</option>
	                    <option value="no">No</option>
	                </select>
				</div>
				<div class="col-md-5" id="component-input" hidden>
					<input type="text" class="form-control input-sm" name="component-input-text" id="component-input-text">
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="koi-search-factura-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de facturas</h4>
	</div>

	{!! Form::open(['id' => 'form-koi-search-factura-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="row">
				<label for="searchfactura_tercero" class="col-sm-1 control-label">Tercero</label>
				<div class="col-md-3">
		      		<div class="input-group input-group-sm">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchfactura_tercero">
								<i class="fa fa-user"></i>
							</button>
						</span>
						<input id="searchfactura_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchfactura_tercero" type="text" maxlength="15" data-wrapper="modal-asiento-wrapper-ordenp" data-name="searchfactura_tercero_nombre">
					</div>
				</div>
				<div class="col-sm-5">
					<input id="searchfactura_tercero_nombre" name="searchfactura_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly>
				</div>

				<label for="searchfactura_numero" class="col-sm-1 control-label">Numero</label>
				<div class="col-md-2">
					<input id="searchfactura_numero" placeholder="Numero" class="form-control input-sm" name="searchfactura_numero" type="text" maxlength="15">
				</div>
			</div>

			<div class="row"><br>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-2 col-xs-6">
						<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-factura-component">Buscar</button>
					</div>
					<div class="col-md-2 col-xs-6">
						<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-factura-component">Limpiar</button>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-factura-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th width="10%">Numero</th>
								<th width="10%">Prefijo</th>
			                	<th width="15%">Tercero</th>
			                	<th width="65%">Nombre</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<!-- Modal show info detalle asiento -->
<div class="modal fade" id="modal-asiento-show-info-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title">Información del asiento</h4>
			</div>
			<div class="modal-body" id="modal-asiento-wrapper-show-info">
				<div class="content-modal"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/template" id="import-data-tpl">
	<% if (title == 'asiento') { %>
		<div class="row">
            <div class="form-group col-sm-4">
                <select name="ano" id="ano" class="form-control" required>
                    @for ($i = config('koi.app.ano'); $i <= date('Y'); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group col-sm-5">
                <select name="mes" id="mes" class="form-control" required>
                    @foreach (config('koi.meses') as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-sm-2">
                <select name="dia" id="dia" class="form-control" required>
                    @for ($i = 1; $i <= 31; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
		<div class="row">
			<div class="form-group col-md-4">
				<div class="input-group input-group-sm">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="tercero">
							<i class="fa fa-user"></i>
						</button>
					</span>
					<input id="tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="tercero" type="text" maxlength="15" data-wrapper="modal-wrapper-import-file" data-name="tercero_nombre" required>
				</div>
			</div>
			<div class="col-md-8">
				<input id="tercero_nombre" name="tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="folder" class=" control-label">Folder</label>
				<select name="folder" id="folder" class="form-control select2-default select-filter-document-koi-component" data-wrapper="spinner-main" data-documents="documento" required>
					@foreach (App\Models\Accounting\Folder::getFolders() as $key => $value)
						<option value="{{ $key }}">{{ $value }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="documento" class="control-label">Documento</label>
				<select name="documento" id="documento" class="form-control select2-default" required>
					@foreach (App\Models\Accounting\Documento::getDocuments() as $key => $value)
						<option value="{{ $key }}">{{ $value }}</option>
					@endforeach
				</select>
			</div>
		</div>
	<% } %>
	<div class="row">
		<div class="form-group col-md-12">
			<label for="file" class="control-label">Archivo</label>
			<div class="input-group">
				<label class="input-group-btn">
					<span class="btn btn-primary btn-sm">
						Buscar <input type="file" id="file" name="file" class="selectfile">
					</span>
				</label>
				<input type="text" class="form-control input-sm" readonly>
			</div>
			<span class="help-block">
				Por favor, seleccione un archivo de tipo <b>.xls</b>
				<% if (title == 'asiento') { %>
					<div class="dropdown">
						<span class="dropspan"><i class="fa fa-question-circle"></i></span>
						<div class="dropdown-content">
							<b>Tips</b>
							<li>Número de cuenta valido para realizar asientos</li>
							<li>Diferencia ente débito y crédito sen igual a 0</li>
							<li>Valores positivos, sin puntos y/o comas</li>
							<li>Nit del beneficiario debe existir en el módulo de terceros</li>
							<li>Encabezado del documento: cuenta, centrocosto, beneficiario, debito, credito, base, detalle</li>
						</div>
					</div>
				<% } %>
				<small class="pull-right"><b><a href="<%- title == 'asiento' ? '{{ config('koi.formatos')['asiento'] }}' : '{{ config('koi.formatos')['asientos'] }}' %>" download>Descargar formato</a></b></small>
			</span>
		</div>
	</div>
</script>

<script type="text/template" id="add-generic-tercero-tpl">
	<form method="POST" accept-charset="UTF-8" id="form-tercero" data-toggle="validator">
		<div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_nit" class="control-label">Documento</label>
				<div class="row">
					<div class="col-md-9">
						<input id="tercero_nit" placeholder="Nit" class="form-control input-sm change-nit-koi-component" name="tercero_nit" type="text" required data-field="tercero_digito" data-modal="true">
					</div>
					<div class="col-md-3">
						<input id="tercero_digito" class="form-control input-sm" name="tercero_digito" type="text" readonly required>
					</div>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="tercero_tipo" class="control-label">Tipo</label>
				<select name="tercero_tipo" id="tercero_tipo" class="form-control" required>
					<option value="" selected>Seleccione</option>
					@foreach( config('koi.terceros.tipo') as $key => $value)
						<option value="{{ $key }}">{{ $value }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_persona" class="control-label">Persona</label>
				<select name="tercero_persona" id="tercero_persona" class="form-control" required>
					<option value="" selected>Seleccione</option>
					@foreach( config('koi.terceros.persona') as $key => $value)
						<option value="{{ $key }}">{{ $value }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-md-6">
				<label for="tercero_regimen" class="control-label">Regimen</label>
				<select name="tercero_regimen" id="tercero_regimen" class="form-control" required>
					<option value="" selected>Seleccione</option>
					@foreach( config('koi.terceros.regimen') as $key => $value)
						<option value="{{ $key }}">{{ $value }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_nombre1" class="control-label">1er. Nombre</label>
				<input id="tercero_nombre1" placeholder="1er. Nombre" class="form-control input-sm input-toupper" name="tercero_nombre1" type="text">
			</div>
			<div class="form-group col-md-6">
				<label for="tercero_nombre2" class="control-label">2do. Nombre</label>
				<input id="tercero_nombre2" placeholder="2do. Nombre" class="form-control input-sm input-toupper" name="tercero_nombre2" type="text">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_apellido1" class="control-label">1er. Apellido</label>
				<input id="tercero_apellido1" placeholder="1er. Apellido" class="form-control input-sm input-toupper" name="tercero_apellido1" type="text">
			</div>
			<div class="form-group col-md-6">
				<label for="tercero_apellido2" class="control-label">2do. Apellido</label>
				<input id="tercero_apellido2" placeholder="2do. Apellido" class="form-control input-sm input-toupper" name="tercero_apellido2" type="text">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="tercero_razonsocial" class="control-label">Razón Social, Comercial o Establecimiento</label>
				<input id="tercero_razonsocial" placeholder="Razón Social, Comercial o Establecimiento" class="form-control input-sm input-toupper" name="tercero_razonsocial" type="text">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_nombre_comercial" class="control-label">Nombre Comercial</label>
				<input id="tercero_nombre_comercial" placeholder="Nombre Comercial" class="form-control input-sm input-toupper" name="tercero_nombre_comercial" type="text">
			</div>
			<div class="form-group col-md-6">
				<label for="tercero_sigla" class="control-label">Sigla</label>
				<input id="tercero_sigla" placeholder="Sigla" class="form-control input-sm input-toupper" name="tercero_sigla" type="text" maxlength="200">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_direccion" class="control-label">Dirección</label> <small id="tercero_nomenclatura"></small>
	      		<div class="input-group input-group-sm">
      		 		<input type="hidden" id="tercero_direccion_nomenclatura" name="tercero_direccion_nomenclatura" value="<%- tercero_direccion_nomenclatura %>">
					<input id="tercero_direccion" value="<%- tercero_direccion %>" placeholder="Dirección" class="form-control address-koi-component" name="tercero_direccion" type="text" data-nm-name="tercero_nomenclatura" data-nm-value="tercero_direccion_nomenclatura" required>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-flat btn-address-koi-component" data-field="tercero_direccion">
							<i class="fa fa-map-signs"></i>
						</button>
					</span>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="tercero_municipio" class="control-label">Municipio</label>
				<select name="tercero_municipio" id="tercero_municipio" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('search.municipios'))%>" data-placeholder="Seleccione" placeholder="Seleccione">
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				<label for="tercero_email" class="control-label">Email</label>
				<input id="tercero_email" placeholder="Email" class="form-control input-sm" name="tercero_email" type="email">
			    <div class="help-block with-errors"></div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_email_factura1" class="control-label">Email Factura 1</label>
				<input id="tercero_email_factura1" placeholder="Email Factura 1" class="form-control input-sm" name="tercero_email_factura1" type="email">
			    <div class="help-block with-errors"></div>
			</div>
			<div class="form-group col-md-6">
				<label for="tercero_email_factura2" class="control-label">Email Factura 2</label>
				<input id="tercero_email_factura2" placeholder="Email Factura 2" class="form-control input-sm" name="tercero_email_factura2" type="email">
			    <div class="help-block with-errors"></div>
			</div>
	    </div>
		<div class="row">
            <div class="form-group col-md-6">
                <label for="tercero_codigopostal" class="control-label">Código postal</label>
                <input id="tercero_codigopostal" placeholder="Código postal" class="form-control input-sm" name="tercero_codigopostal" type="text" maxlength="6">
            </div>
            <div class="form-group col-md-6">
                <label for="tercero_formapago" class="control-label">Forma de pago <small>(dias)</small></label>
                <input id="tercero_formapago" placeholder="Forma de pago" class="form-control input-sm input-toupper" name="tercero_formapago" type="text" maxlength="30" required>
            </div>
        </div>
	    <div class="row">
	    	<div class="form-group col-md-6">
				<label for="tercero_telefono1" class="control-label">Teléfono</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-phone"></i>
					</div>
					<input id="tercero_telefono1" class="form-control input-sm" name="tercero_telefono1" type="text" data-inputmask="'mask': '(999) 999-99-99 EXT 99999'" data-mask>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="tercero_telefono2" class="control-label">2do. Teléfono</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-phone"></i>
					</div>
					<input id="tercero_telefono2" class="form-control input-sm" name="tercero_telefono2" type="text" data-inputmask="'mask': '(999) 999-99-99 EXT 99999'" data-mask>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_fax" class="control-label">Fax</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-fax"></i>
					</div>
					<input id="tercero_fax" class="form-control input-sm" name="tercero_fax" type="text" data-inputmask="'mask': '(999) 999-99-99 EXT 99999'" data-mask>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="tercero_celular" class="control-label">Celular</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-mobile"></i>
					</div>
					<input id="tercero_celular" class="form-control input-sm" name="tercero_celular" type="text" data-inputmask="'mask': '(999) 999-99-99'" data-mask>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-xs-12 col-sm-4 col-md-3">
				<label for="tercero_vendedor" class="control-label">Vendedor</label>
				<div class="input-group input-group-sm">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="tercero_vendedor">
							<i class="fa fa-user"></i>
						</button>
					</span>
					<input id="tercero_vendedor" placeholder="Documento" class="form-control tercero-koi-component" name="tercero_vendedor" type="text" maxlength="15" data-name="tercero_vendedor_nombre" data-vendedor="true">
				</div>
			</div>
			<div class="col-sm-6"><br>
				<input id="tercero_vendedor_nombre" name="tercero_vendedor_nombre" placeholder="Nombre vendedor" class="form-control input-sm" type="text" maxlength="15" readonly>
			</div>
			<div class="form-group col-md-3">
				<label for="tercero_comision" class="control-label">Comisión Vendedor</label>
				<input type="number" id="tercero_comision" name="tercero_comision" placeholder="Vendedor" class="form-control input-sm" min="0" step="0.1" max="100">
			</div>
		</div>
	    <div class="row">
			<div class="form-group col-md-6">
				<label for="tercero_representante" class="control-label">Representante Legal</label>
				<input id="tercero_representante" placeholder="Representante Legal" class="form-control input-sm input-toupper" name="tercero_representante" type="text" maxlength="200">
			</div>
			<div class="form-group col-md-6">
	    		<label for="tercero_cc_representante" class="control-label">Cédula</label>
	    		<input id="tercero_cc_representante" placeholder="Cédula" class="form-control input-sm" name="tercero_cc_representante" type="text" maxlength="15">
	    	</div>
		</div>
	    <div class="row">
            <div class="col-md-offset-4 col-md-3 col-sm-5 col-xs-6">
                <button type="submit" class="btn btn-primary btn-sm btn-block">{{ trans('app.save') }}</button>
            </div>
        </div>
		<div class="row">
			<div class="form-group col-md-10">
				<label for="tercero_actividad" class="control-label">Actividad Económica</label>
				<select name="tercero_actividad" id="tercero_actividad" class="form-control choice-select-autocomplete" data-ajax-url="<%- window.Misc.urlFull(Route.route('search.actividades'))%>" data-placeholder="Seleccione" placeholder="Seleccione">
				</select>
			</div>
			<div class="form-group col-md-2">
				<label for="tercero_retecree" class="control-label">% Cree</label>
				<div id="tercero_retecree"></div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_cliente">
					<input type="checkbox" id="tercero_cliente" name="tercero_cliente" value="tercero_cliente"> Cliente
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_acreedor">
					<input type="checkbox" id="tercero_acreedor" name="tercero_acreedor" value="tercero_acreedor"> Acreedor
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_proveedor">
					<input type="checkbox" id="tercero_proveedor" name="tercero_proveedor" value="tercero_proveedor"> Proveedor
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_autoretenedor_ica">
					<input type="checkbox" id="tercero_autoretenedor_ica" name="tercero_autoretenedor_ica" value="tercero_autoretenedor_ica"> Autorretenedor ICA
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_responsable_iva">
					<input type="checkbox" id="tercero_responsable_iva" name="tercero_responsable_iva" value="tercero_responsable_iva"> Responsable de IVA
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_empleado">
					<input type="checkbox" id="tercero_empleado" name="tercero_empleado" value="tercero_empleado"> Empleado
				</label>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_interno">
					<input type="checkbox" id="tercero_interno" name="tercero_interno" value="tercero_interno"> Interno
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_extranjero">
					<input type="checkbox" id="tercero_extranjero" name="tercero_extranjero" value="tercero_extranjero"> Extranjero
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_afiliado">
					<input type="checkbox" id="tercero_afiliado" name="tercero_afiliado" value="tercero_afiliado"> Afiliado
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_autoretenedor_cree">
					<input type="checkbox" id="tercero_autoretenedor_cree" name="tercero_autoretenedor_cree" value="tercero_autoretenedor_cree"> Autorretenedor CREE
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_socio">
					<input type="checkbox" id="tercero_socio" name="tercero_socio" value="tercero_socio"> Socio
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_mandatario">
					<input type="checkbox" id="tercero_mandatario" name="tercero_mandatario" value="tercero_mandatario"> Mandatario
				</label>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_gran_contribuyente">
					<input type="checkbox" id="tercero_gran_contribuyente" name="tercero_gran_contribuyente" value="tercero_gran_contribuyente"> Gran contribuyente
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_autoretenedor_renta">
					<input type="checkbox" id="tercero_autoretenedor_renta" name="tercero_autoretenedor_renta" value="tercero_autoretenedor_renta"> Autorretenedor renta
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_vendedor_estado">
					<input type="checkbox" id="tercero_vendedor_estado" name="tercero_vendedor_estado" value="tercero_vendedor_estado"> Vendedor
				</label>
			</div>
			<div class="form-group col-md-2">
				<label class="checkbox-inline" for="tercero_otro">
					<input type="checkbox" id="tercero_otro" name="tercero_otro" value="tercero_otro"> Otro
				</label>
			</div>
			<div class="form-group col-md-4">
				<input id="tercero_cual" placeholder="¿Cual?" class="form-control input-sm" name="tercero_cual" type="text" maxlength="15">
			</div>
		</div>
	</form>
</script>

<!-- Modal add tcontacto -->
<div class="modal fade" id="modal-event-component" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header small-box {{ config('koi.template.bg') }}">
				<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="inner-title-modal modal-title"></h4>
			</div>
			{!! Form::open(['id' => 'form-event-component', 'data-toggle' => 'validator']) !!}
				<div class="modal-body">
					<div class="content-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<script type="text/template" id="producto-historial-item-list-tpl">
	<% if (productohistorial_tipo == 'COT') { %>
		<td><span class="label label-danger">COTIZACIÓN</span></td>
	<% } else { %>
		<td><span class="label label-info">ORDEN DE PRODUCCIÓN</span></td>
	<% } %>
	<td><%- moment(productohistorial_fh_elaboro).format('YYYY-MM-DD') %></td>
	<td class="text-right"><%- window.Misc.currency(productohistorial_valor) %></td>
</script>

<script type="text/template" id="add-producto-component-tpl">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <label class="col-sm-2 control-label">Referencia</label>
                <div class="form-group col-md-6">
                    <%- producto_referencia %>
                </div>
                <label class="col-sm-1 control-label">Cantidad</label>
                <div class="form-group col-sm-1">
                    <%- producto_cantidad %>
                </div>
                <label class="col-sm-1 control-label">Saldo</label>
                <div class="form-group col-sm-1">
                    <%- producto_saldo %>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2 control-label">Observaciones</label>
                <div class="form-group col-sm-10">
                    <textarea class="form-control" rows="3" disabled><%- producto_observaciones %></textarea>
                </div>
            </div>
        </div>
    </div>
    <% if (producto.productop_abierto || producto.productop_cerrado) { %>
        <div class="box box-primary">
            <div class="box-body">
                <% if (producto.productop_abierto) { %>
                    <div class="row">
                        <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Abierto</label>
                        <label class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                        <div class="form-group col-xs-10 col-sm-3">
                            <div class="col-xs-10 col-sm-9">
								<%- producto_ancho %>
							</div>
                            <div class="col-xs-2 col-sm-3 text-left"><%- producto.m1_sigla %></div>
                        </div>
                        <label class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                        <div class="form-group col-xs-10 col-sm-3">
                            <div class="col-xs-10 col-sm-9">
								<%- producto_alto %>
							</div>
                            <div class="col-xs-2 col-sm-3 text-left"><%- producto.m2_sigla %></div>
                        </div>
                    </div>
                <% } %>
                <% if (producto.productop_cerrado) { %>
                    <div class="row">
                        <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">Cerrado</label>
                        <label class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                        <div class="form-group col-xs-10 col-sm-3">
                            <div class="col-xs-10 col-sm-9">
								<%- producto_c_ancho %>
							</div>
                            <div class="col-xs-2 col-sm-3 text-left"><%- producto.m3_sigla %></div>
                        </div>
                        <label class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                        <div class="form-group col-xs-10 col-sm-3">
                            <div class="col-xs-10 col-sm-9">
								<%- producto_c_alto %>
							</div>
                            <div class="col-xs-2 col-sm-3 text-left"><%- producto.m4_sigla %></div>
                        </div>
                    </div>
                <% } %>
            </div>
        </div>
    <% } %>
    <% if (producto.productop_3d) { %>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <label class="col-xs-12 col-sm-1 col-sm-offset-1 control-label">3D</label>
                    <label class="col-xs-2 col-sm-1 control-label text-right">Ancho</label>
                    <div class="form-group col-xs-10 col-sm-2">
                        <div class="col-xs-10 col-sm-9">
                            <%- producto_3d_ancho %>
                        </div>
                        <div class="col-xs-2 col-sm-3 text-left"><%- producto.m5_sigla %></div>
                    </div>
                    <label class="col-xs-2 col-sm-1 control-label text-right">Alto</label>
                    <div class="form-group col-xs-10 col-sm-2">
                        <div class="col-xs-10 col-sm-9">
                            <%- producto_3d_alto %>
                        </div>
                        <div class="col-xs-2 col-sm-3 text-left"><%- producto.m6_sigla %></div>
                    </div>
                    <label class="col-xs-2 col-sm-1 control-label text-right">Profundidad</label>
                    <div class="form-group col-xs-10 col-sm-2">
                        <div class="col-xs-10 col-sm-9">
                            <%- producto_3d_profundidad %>
                        </div>
                        <div class="col-xs-2 col-sm-3 text-left"><%- producto.m7_sigla %></div>
                    </div>
                </div>
            </div>
        </div>
    <% } %>
    <% if (producto.productop_tiro || producto.productop_retiro) { %>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3 col-xs-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center">C</th>
                                    <th class="text-center">M</th>
                                    <th class="text-center">Y</th>
                                    <th class="text-center">K</th>
                                    <th class="text-center">P1</th>
                                    <th class="text-center">P2</th>
                                </tr>
                            </thead>
                            <tbody>
                                <% if (producto.productop_tiro) { %>
                                    <tr>
                                        <th class="text-center">T <input type="checkbox" disabled <%- parseInt(producto_tiro) ? 'checked': ''%>></th>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_yellow) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_magenta) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_cyan) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_key) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_color1) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_color2) ? 'checked': ''%>></td>
                                    </tr>
                                <% } %>
                                <% if (producto.productop_retiro) { %>
                                    <tr>
                                        <th class="text-center">R <input type="checkbox" disabled <%- parseInt(producto_retiro) ? 'checked': ''%>></th>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_yellow2) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_magenta2) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_cyan2) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_key2) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_color12) ? 'checked': ''%>></td>
                                        <td class="text-center"><input type="checkbox" disabled <%- parseInt(producto_color22) ? 'checked': ''%>></td>
                                    </tr>
                                <% } %>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <% if (producto.productop_tiro) { %>
                        <div class="form-group <%- (producto.productop_tiro && producto.productop_retiro) ? 'col-sm-6' : 'col-sm-12' %>">
                            <label class="control-label">Nota tiro</label>
                            <textarea class="form-control" rows="2" placeholder="Nota tiro" disabled><%- producto_nota_tiro %></textarea>
                        </div>
                    <% } %>

                    <% if (producto.productop_retiro) { %>
                        <div class="form-group <%- (producto.productop_tiro && producto.productop_retiro) ? 'col-sm-6' : 'col-sm-12' %>">
                            <label class="control-label">Nota retiro</label>
                            <textarea class="form-control" rows="2" placeholder="Nota retiro" disabled><%- producto_nota_retiro %></textarea>
                        </div>
                    <% } %>
                </div>
            </div>
        </div>
    <% } %>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Imágenes</h3>
        </div>
        <div class="box-body table-responsive no-padding">
            <div class="fine-uploader"></div>
        </div>
    </div>
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Máquinas de producción</h3>
		</div>
		<div class="box-body">
			<table id="browse-component-producto-maquinas-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Nombre</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="text-center">Ningún dato disponible en esta tabla.</th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Acabados de producción</h3>
		</div>
		<div class="box-body">
			<table id="browse-component-producto-acabados-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Nombre</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="text-center">Ningún dato disponible en esta tabla.</th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Materiales de producción</h3>
        </div>
        <div class="box-body">
            <table id="browse-component-producto-materiales-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="25%">Insumo</th>
                        <th width="10%">Medidas</th>
                        <th width="10%">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
					<tr>
						<th colspan="3" class="text-center">Ningún dato disponible en esta tabla.</th>
					</tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Áreas de producción</h3>
        </div>
        <div class="box-body">
            <table id="browse-component-producto-areas-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="30%">Área</th>
                        <th width="30%">Nombre</th>
                        <th width="20%">Tiempo</th>
                    </tr>
                </thead>
                <tbody>
					<tr>
						<th colspan="3" class="text-center">Ningún dato disponible en esta tabla.</th>
					</tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Empaques de producción</h3>
        </div>
        <div class="box-body">
            <table id="browse-component-producto-empaques-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="25%">Empaque</th>
                        <th width="25%">Insumo</th>
                        <th width="15%">Medidas</th>
                        <th width="15%">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
					<tr>
						<th colspan="4" class="text-center">Ningún dato disponible en esta tabla.</th>
					</tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Transportes de producción</h3>
        </div>
        <div class="box-body">
            <table id="browse-component-producto-transportes-list" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="25%">Transporte</th>
                        <th width="25%">Insumo</th>
                        <th width="15%">Medidas</th>
                        <th width="15%">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
					<tr>
						<th colspan="4" class="text-center">Ningún dato disponible en esta tabla.</th>
					</tr>
                </tbody>
            </table>
        </div>
    </div>
</script>

<script type="text/template" id="qq-template-component-producto">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="{{ trans('app.files.drop') }}">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
            <li>
                <div class="qq-progress-bar-container-selector">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <a class="preview-link" target="_blank">
                    <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                </a>
                <span class="qq-upload-file-selector qq-upload-file"></span>
                <span class="qq-upload-size-selector qq-upload-size"></span>
            </li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Cerrar</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">No</button>
                <button type="button" class="qq-ok-button-selector">Si</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">{{ trans('app.cancel') }}</button>
                <button type="button" class="qq-ok-button-selector">{{ trans('app.continue') }}</button>
            </div>
        </dialog>
    </div>
</script>

<script type="text/template" id=add-producto-component-maquinas-item-tpl>
	<% if (parseInt(activo)) { %>
		<tr>
			<td><%- maquinap_nombre %></td>
		</tr>
	<% } %>
</script>

<script type="text/template" id=add-producto-component-acabados-item-tpl>
	<% if (parseInt(activo)) { %>
		<tr>
			<td><%- acabadop_nombre %></td>
		</tr>
	<% } %>
</script>

<script type="text/template" id=add-producto-component-materiales-item-tpl>
	<tr>
		<td><%- producto_nombre || '-' %></td>
	    <td><%- material_medidas %></td>
	    <td><%- material_cantidad %></td>
	</tr>
</script>

<script type="text/template" id=add-producto-component-areas-item-tpl>
	<tr>
		<td><%- areap_nombre || '-' %></td>
		<td><%- area_nombre || '-' %></td>
		<td class="text-center"><%- area_horas %>:<%- area_minutos %></td>
	</tr>
</script>

<script type="text/template" id=add-producto-component-empaques-item-tpl>
	<tr>
		<td><%- empaque_nombre || '-' %></td>
		<td><%- producto_nombre || '-' %></td>
		<td><%- empaque_medidas %></td>
		<td><%- empaque_cantidad %></td>
	</tr>
</script>

<script type="text/template" id=add-producto-component-transportes-item-tpl>
	<tr>
		<td><%- transporte_nombre || '-' %></td>
	    <td><%- producto_nombre || '-' %></td>
	    <td><%- transporte_medidas %></td>
	    <td><%- transporte_cantidad %></td>
	</tr>
</script>

<script type="text/template" id="producto-materialp-validate-confirm-tpl">
	<p><%- message %></p>
</script>
