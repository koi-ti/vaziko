<table class="rtable" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td rowspan="8">
			<br><br>
			<div align="left">
				<small>Váziko S.A.S.</small><br>
				<small>{{ $empresa->tercero_direccion }}</small><br>
				<small>Código postal: 760042</small><br>
				<small>PBX: (572) 890 06 06</small><br>
				<small>www.vaziko.com</small><br>
				<small>info@vaziko.com</small><br>
				<small>Cali ‐ Colombia</small>
			</div>
		</td>
		<td rowspan="8" align="center" valign="middle">
			<img src="{{ asset(config('koi.app.image.header-pdf')) }}" alt="" style="width: 235px; height: 115px;">
		</td>

		<th class="border-tbl size-8" align="left">Fecha</th>
		<th class="border-tbr size-8" align="right">{{ $cotizacion->cotizacion1_fecha_inicio }}</th>
	</tr>
	<tr>
		<th class="titleespecial size-8" align="left">Cotizacion</th>
		<th class="titleespecial size-8" align="right">{{ $cotizacion->cotizacion_codigo }}</th>
	</tr>
	<tr>
		<td rowspan="6" colspan="2">
			<div align="right">
				<small>{{ config('koi.app.image.header-pdf') }} NO Gran Contribuyente</small><br>
				<small>{{ url( config('koi.app.image.header-pdf') ) }}Actividad económica 1811</small><br>
				<small>Régimen común</small><br>
				<small>Nit: 900.474.161‐6</small><br>
				<small>Actividad ICA 102‐116</small><br>
				<small>ICA 6.6X 1000</small>
			</div>
		</td>
	</tr>
</table>
