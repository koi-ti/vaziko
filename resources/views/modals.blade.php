<!-- Modal add resource -->
<div class="modal fade" id="modal-add-resource-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
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

<!-- Modal add tcontacto -->
<div class="modal fade" id="modal-tcontacto-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
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

<!-- Modal address -->
<div class="modal fade" id="modal-address-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-address-component-validacion" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search factura -->
<div class="modal fade" id="modal-search-factura-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search ordenp2 -->
<div class="modal fade" id="modal-search-ordenp2-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-xlg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search ordenp -->
<div class="modal fade" id="modal-search-ordenp-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search cotizaciones -->
<div class="modal fade" id="modal-search-cotizacion-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search producto -->
<div class="modal fade" id="modal-search-producto-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search productop -->
<div class="modal fade" id="modal-search-productop-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search contacto -->
<div class="modal fade" id="modal-search-contacto-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal search -->
<div class="modal fade" id="modal-search-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="content-modal"></div>
		</div>
	</div>
</div>

<!-- Modal confirm -->
<div class="modal fade" id="modal-confirm-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
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
<div class="modal fade" id="modal-inventario-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
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
			                	<th width="20%">Fecha</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="koi-search-ordenp2-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de ordenes</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-ordenp2-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
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
                        <input id="search_ordenp" placeholder="Orden" class="form-control ordenp-koi-component orden-change-koi" name="search_ordenp" type="text" maxlength="15" data-factura="true" data-name="search_ordenpnombre">
                    </div>
                </div>
                <div class="col-sm-6 col-md-8 col-xs-10">
                    <input id="search_ordenpnombre" name="search_ordenpnombre" placeholder="Tercero" class="form-control input-sm" type="text" readonly>
                </div>
            </div>

			<div class="form-group">
				<div class="col-md-offset-4 col-md-2 col-xs-6">
					<button type="button" class="btn btn-primary btn-block btn-sm btn-search-koi-search-ordenp2-component">Buscar</button>
				</div>
				<div class="col-md-2 col-xs-6">
					<button type="button" class="btn btn-default btn-block btn-sm btn-clear-koi-search-ordenp2-component">Limpiar</button>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 table-responsive">
					<table id="koi-search-ordenp2-component-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
				            <tr>
				                <th width="10%">Código</th>
			                	<th width="10%">Orden</th>
				                <th>Año</th>
				                <th>Numero</th>
			                	<th width="60%">Producto</th>
			                	<th width="10%">Saldo</th>
			                	<th width="10%">Facturadas</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

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
				                <th width="5%">Código</th>
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
<div class="modal fade" id="modal-asiento-show-info-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
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

<script type="text/template" id="koi-search-cotizacion-component-tpl">
	<div class="modal-header small-box {{ config('koi.template.bg') }}">
		<button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="inner-title-modal modal-title">Buscador de cotizaciones</h4>
	</div>
	{!! Form::open(['id' => 'form-koi-search-cotizacion-component', 'class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form']) !!}
		<div class="modal-body">
			<div class="form-group">
				<label for="searchcotizacion_cotizacion_numero" class="col-md-1 control-label">Codigo</label>
				<div class="col-md-2">
					<input id="searchcotizacion_cotizacion_numero" placeholder="Codigo" class="form-control input-sm" name="searchcotizacion_cotizacion_numero" type="text" maxlength="15">
				</div>
				<label for="searchcotizacion_tercero" class="col-sm-1 control-label">Tercero</label>
				<div class="form-group col-sm-3">
		      		<div class="input-group input-group-sm">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-flat btn-koi-search-tercero-component-table" data-field="searchcotizacion_tercero">
								<i class="fa fa-user"></i>
							</button>
						</span>
						<input id="searchcotizacion_tercero" placeholder="Tercero" class="form-control tercero-koi-component input-sm" name="searchcotizacion_tercero" type="text" maxlength="15" data-wrapper="modal-asiento-wrapper-cotizacion" data-name="searchcotizacion_tercero_nombre">
					</div>
				</div>
				<div class="col-sm-5">
					<input id="searchcotizacion_tercero_nombre" name="searchcotizacion_tercero_nombre" placeholder="Tercero beneficiario" class="form-control input-sm" type="text" maxlength="15" readonly>
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
			                	<th width="20%">Fecha</th>
				            </tr>
				        </thead>
		            </table>
	           	</div>
	     	</div>
		</div>
	{!! Form::close() !!}
</script>

<!-- Modal generic producto -->
<div class="modal fade" id="modal-tiempop-edit-component" data-backdrop="static" data-keyboard="true" aria-hidden="true" tabindex="-1">
	<div class="modal-dialog" role="document">
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
					<button type="button" class="btn btn-primary btn-sm submit-ordenp">Continuar</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
