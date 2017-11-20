<table class="tbtitle">
	<thead>
		<tr>
			<th width="15%" class="left size-6">{{ $empresa->tercero_razonsocial }}</th>
			<td rowspan="6" class="center">
				<img src="{{ asset(config('koi.app.image.logo')) }}" alt="" style="width: 70px; height: 70px;">
			 </td>
			<th width="15%" class="center size-7 titleespecial">Cotización</th>
		</tr>
		<tr>
			<th width="15%" class="left size-6">{{ $empresa->tercero_direccion }}</th>
			<th width="15%" class="center size-7">{{ $cotizacion->cotizacion_codigo }}</th>
		</tr>
		<tr>
			<th width="15%" class="left size-6">Código postal: 760042</th>
			<th width="15%" class="left size-6">{{ $empresa->tercero_gran_contribuyente ? 'SI' : 'NO' }} Gran Contribuyente</th>
		</tr>
		<tr>
			<th width="15%" class="left size-6">PBX: {{ $empresa->tercero_telefono1 }}</th>
			<th width="15%" class="left size-6">Actividad económica {{ $empresa->tercero_actividad }}</th>
		</tr>
		<tr>
			<th width="15%" class="left size-6">www.vaziko.com</th>
			<th width="15%" class="left size-6">Régimen {{ config('koi.terceros.regimen')[$empresa->tercero_regimen] }}</th>
		</tr>
		<tr>
			<th width="15%" class="left size-6">{{ $empresa->tercero_email }}</th>
			<th width="15%" class="left size-6">Nit: {{ $empresa->tercero_nit }}</th>
		</tr>
	</thead>
</table>
