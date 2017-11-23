<table class="tbtitle"="1">
	<tr>
		<td width="30%">
			<table class="intertable">
				<tr>
					<td class="left size-7">{{ $empresa->tercero_razonsocial }}</td>
				</tr>
				<tr>
					<td class="left size-7">{{ $empresa->tercero_direccion }}</td>
				</tr>
				<tr>
					<td class="left size-7">Código postal: 760042</td>
				</tr>
				<tr>
					<td class="left size-7">PBX: {{ $empresa->tercero_telefono1 }}</td>
				</tr>
				<tr>
					<td class="left size-7">www.vaziko.com</td>
				</tr>
				<tr>
					<td class="left size-7">{{ $empresa->tercero_email }}</td>
				</tr>
				<tr>
					<td class="left size-7">{{ $empresa->municipio_nombre }}</td>
				</tr>
			</table>
		</td>
		<td width="40%">
			<table class="intertable">
				<tr>
					<td class="center">
						<img src="{{ asset(config('koi.app.image.logo')) }}" alt="" style="width: 70px; height: 70px;">
					</td>
				</tr>
			</table>
		</td>
		<td width="30%">
			<table class="intertable">
				<tr>
					<td width="50%" class="left size-8">Fecha</td>
					<th width="50%" class="right size-8">{{ $cotizacion->cotizacion1_fecha_inicio }}</th>
				</tr>
				<tr>
					<th class="left size-8 titleespecial">Cotización</th>
					<th class="right size-8">{{ $cotizacion->cotizacion_codigo }}</th>
				</tr>
				<tr>
					<th colspan="2" class="right size-7">{{ $empresa->tercero_gran_contribuyente ? 'SI' : 'NO' }} Gran Contribuyente</th>
				</tr>
				<tr>
					<th colspan="2" class="right size-7">Actividad económica {{ $empresa->tercero_actividad }}</th>
				</tr>
				<tr>
					<th colspan="2" class="right size-7">Régimen {{ config('koi.terceros.regimen')[$empresa->tercero_regimen] }}</th>
				</tr>
				<tr>
					<th colspan="2" class="right size-7">Nit: {{ $empresa->tercero_nit }}</th>
				</tr>
			</table>
		</td>
	</tr>
</table>
