<table class="htable" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<th rowspan="2" width="15%">
			<img src="{{ asset('images/logo-header-pdf.png') }}" alt="logo-vaziko" style="width: 90px; height: 40px;">
		</th>
		<th class="bold" width="15%">Remisión</th>
		<th class="bold" width="15%">OP</th>
		<th class="bold" width="15%">Fecha</th>
		<th class="bold" width="15%">Revisado</th>
		<th rowspan="2" width="15%">
			{{ $empresa->tercero_razonsocial }}<br>
			NIT: {{ $empresa->tercero_nit }}
		</th>
	</tr>
	<tr>
		<td>{{ sprintf('%s-%s', $despacho->id, substr($despacho->despachop1_fecha, -8, 2)) }}</td>
		<td>{{ $despacho->orden_codigo }}</td>
		<td>{{ $despacho->despachop1_fecha }}</td>
		<td>{{ auth()->user()->getName() }}</td>
	</tr>
</table>

<table class="hrtable" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<th width="10%" class="border-left">Compañia</th>
			<td class="size-7">{{ $despacho->tercero_nombre }}</td>
			<th width="10%">Nit</th>
			<td class="size-7 border-right">{{ $despacho->tercero_nombre }}</td>
		</tr>
		<tr>
			<th width="10%" class="border-left">Contacto</th>
			<td width="50%" class="size-7">{{ $despacho->tcontacto_nombre }}</td>
			<th width="10%">Teléfonos</th>
			<td width="30%" class="size-7 border-right">{{ join(' - ', [$despacho->tcontacto_telefono, $despacho->tcontacto_celular]) }}</td>
		</tr>
		<tr>
			<th class="border-left">Dirección</th>
			<td class="size-7">{{ $despacho->tcontacto_direccion }}</td>
			<th>Ciudad</th>
			<td class="size-7 border-right">{{ $despacho->tcontacto_municipio }}</td>
		</tr>
	</tbody>
</table>

<table class="brtable" border="0" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th class="left" width="45%">Referencia</th>
			<th class="left" width="45%">Términos</th>
			<th class="center" width="10%">Transporte</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="height-40">{{ $despacho->orden_referencia }}</td>
			<td class="height-40"></td>
			<td class="height-40">{{ $despacho->despachop1_transporte }}</td>
		</tr>
	</tbody>
</table>

<table class="rtable" border="0" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th class="center bold" width="10%">Item</th>
			<th class="center bold" width="80%">Descripción</th>
			<th class="center bold" width="10%">Cantidad</th>
		</tr>
	</thead>
	<tbody>
		@foreach($detalle as $key => $despacho2)
			<tr>
				<td class="center size-7 border-left">{{ $key+1 }}</td>
				<td class="left size-7 border-left">{{ $despacho2->productop_nombre }}</td>
				<td class="center size-7 border-right border-left">{{ $despacho2->despachop2_cantidad }}</td>
			</tr>
		@endforeach
		@if (count($detalle) < 9)
			@for($i = count($detalle); $i < 9; $i++)
				<tr>
					<td class="center size-7 border-left"></td>
					<td class="left size-7 border-left"></td>
					<td class="center size-7 border-right border-left"></td>
				</tr>
			@endfor
		@endif
	</tbody>
</table>

<table class="brtable" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td class="height-40">
				Notas {{ $despacho->despachop1_observacion }}
			</td>
		</tr>
	</tbody>
</table>

{{-- Empresa --}}
<table class="hrtable" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="center size-7">
			{{ "$empresa->tercero_razonsocial | $empresa->tercero_direccion | Código postal: 760042 | PBX : $despacho->empresa_telefono | www.vaziko.com | $empresa->tercero_email | Cali - Colombia | ".auth()->user()->username.' - '.date('Y-m-d H:i:s') }}
		</td>
	</tr>
</table>

{{-- Firma --}}
<table class="hrtable margin-top-50" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%">&nbsp;</td>
		<td width="30%" class="center border-top">Nombre y firma del cliente</td>
		<td width="20%">&nbsp;</td>
		<td width="30%" class="center border-top">Autorizado por:</td>
		<td width="10%">&nbsp;</td>
	</tr>
</table>
