<div class="table">
	<!-- Encabezado Empresa -->
	<div class="rows">
		<div class="cell noborder" style="width: 30%;">
			<br><br>
			<div class="left">
				<small>Váziko S.A.S.</small><br>
				<small>{{ $empresa->tercero_direccion }}</small><br>
				<small>Código postal: 760042</small><br>
				<small>PBX: (572) 890 06 06</small><br>
				<small>www.vaziko.com</small><br>
				<small>info@vaziko.com</small><br>
				<small>Cali ‐ Colombia</small>
			</div>
		</div>
		<div class="cell noborder" style="width: 40%;">
			<div class="center">
				<img src="{{ asset(config('koi.app.image.logo')) }}" alt="" style="width: 70px; height: 70px; padding-top:15;">
			</div>
		</div>
		<div class="cell noborder" style="width: 30%;">
			<div class="table">
				<div class="rows">
					<div class="cell left size-8 border">Fecha</div>
					<div class="cell right size-8 border bold">{{ $cotizacion->cotizacion1_fecha_inicio }}</div>
				</div>
				<div class="rows">
					<div class="cell left size-8 titleespecial border bold">Cotización</div>
					<div class="cell right size-8 titleespecial border bold">{{ $cotizacion->cotizacion_codigo }}</div>
				</div>
			</div>
			<div class="right">
				<small>NO Gran Contribuyente</small><br>
				<small>Actividad económica 1811</small><br>
				<small>Régimen común</small><br>
				<small>Nit: 900.474.161‐6</small><br>
				<small>Actividad ICA 102‐116</small><br>
				<small>ICA 6.6X 1000</small>
			</div>
		</div>
	</div>
</div>
<!-- Encabezado Cliente -->
<div class="table">
	<div class="rows">
		<div class="cell" style="width:10%;">Referencia</div>
		<div class="cell" colspan="2" style="width:40%;">{{ $cotizacion->cotizacion1_referencia }}</div>
		<div class="cell" style="width:10%;">Terminos</div>
		<div class="cell" colspan="2" style="width:40%;">{{ $cotizacion->cotizacion1_terminado }}</div>
	</div>
	<div class="rows">
		<div colspan="4" class="cell bold">Cliente</div>
		<div class="cell bold">Asegurado por</div>
		<div class="cell bold">Transporte</div>
	</div>
	<div class="rows">
		<div class="cell" colspan="4" rowspan="4">
			<div class="table">
				<div class="rows">
					<div class="cell left size-7 noborder bold" style="width:10%;">Compañia</div>
					<div class="cell left size-7 noborder bold" style="width:55%;">{{ $cotizacion->tercero_nombre }}</div>

					<div class="cell left size-7 noborder bold">Nit</div>
					<div class="cell left size-7 noborder bold">{{ $cotizacion->tercero_nit }}</div>
				</div>
				<div class="rows">
					<div class="cell left size-7 noborder bold">Contacto</div>
					<div class="cell left size-7 noborder bold">{{ $cotizacion->tcontacto_nombre }}</div>

					<div class="cell left size-7 noborder bold">Email</div>
					<div class="cell left size-7 noborder">{{ $cotizacion->tcontacto_email }}</div>
				</div>
				<div class="rows">
					<div class="cell left size-7 noborder bold">Teléfono</div>
					@if( !empty( $cotizacion->tercero_telefono1 ) )
						<div class="cell left size-7 noborder bold">{{ $cotizacion->tercero_telefono1 }}</div>
					@else
						<div class="cell left size-7 noborder bold">{{ $cotizacion->tercero_telefono2 }}</div>
					@endif

					<div class="cell left size-7 noborder bold">Celular</div>
					<div class="cell left size-7 noborder bold">{{ $cotizacion->tercero_celular }}</div>
				</div>
				<div class="rows">
					<div class="cell left size-7 noborder bold">Direccion</div>
					<div class="cell left size-7 noborder bold">{{ $cotizacion->tercero_direccion }}</div>

					<div class="cell left size-7 noborder bold">Ciudad</div>
					<div class="cell left size-7 noborder bold">{{ $cotizacion->municipio_nombre }}</div>
				</div>
			</div>
		</div>
		<div class="cell" rowspan="2">No aplica</div>
		<div class="cell" rowspan="2">No aplica</div>
	</div>
	<div class="rows">
	</div>
	<div class="rows">
		<div class="cell" colspan="2">Tomado por</div>
	</div>
	<div class="rows">
		<div class="cell" colspan="2">{{ Auth::user()->getName() }}</div>
	</div>
</div>
