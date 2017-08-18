<table class="brtable" border="0" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th width="15%" class="title left">Fecha</th>
			<th width="20%" class="title left">Cotización</th>
			<th width="20%" class="title left">C.C o Nit</th>
			<th width="25%" class="title left">Revisado por</th>
			<th width="20%" class="titleespecial center">Remisión</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th class="title left">{{ $despacho->despachoc1_fecha }}</th>
			<th class="title left">{{ $despacho->cotizacion_codigo }}</th>
			<th class="title left">{{ $despacho->tercero_nit }}</th>
			<th class="title left">IGN</th>
			<th class="title left">{{ sprintf('%s-%s', $despacho->id, substr($despacho->despachoc1_fecha, -8, 2)) }}</th>
		</tr>
		<tr>
			<th colspan="5" class="title left">Cliente</th>
		</tr>
	</tbody>
</table>

<table class="htable" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<th width="10%" class="border-left">Compañia</th>
			<td colspan="3" class="size-7 border-right">{{ $despacho->tercero_nombre }}</td>
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
			<th width="50%">Referencia</th>
			<th width="30%">Términos</th>
			<th width="20%">Transporte</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="height-40">{{ $despacho->cotizacion1_referencia }}</td>
			<td class="height-40"></td>
			<td class="height-40">{{ $despacho->despachoc1_transporte }}</td>
		</tr>
	</tbody>
</table>

<table class="rtable" border="0" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th width="80%" class="center title">Descripción</th>
			<th width="20%" class="center title">Cantidad</th>
		</tr>
	</thead>
	<tbody>
		@if(count($detalle) > 0)
			@foreach($detalle as $despacho2)
				<tr>
					<td class="left size-7 border-left">{{ $despacho2->productop_nombre }}</td>
					<td class="center size-7 border-right border-left">{{ $despacho2->despachoc2_cantidad }}</td>
				</tr>
			@endforeach
		@endif
	</tbody>
</table>

<table class="brtable size-7" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td class="size-7 height-19">{{ $despacho->despachoc1_observacion }}</td>
		</tr>
		<tr>
			<td class="size-7 height-19">&nbsp;</td>
		</tr>
	</tbody>
</table>

{{-- Empresa --}}
<table class="width-100" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="center size-7">
			{{ "$empresa->tercero_razonsocial | $empresa->tercero_direccion | Código postal: 760042 | PBX : $despacho->empresa_telefono | www.vaziko.com | $empresa->tercero_email | Cali - Colombia | ".Auth::user()->username.' - '.date('Y-m-d H:i:s') }}
		</td>
	</tr>
</table>

{{-- Firma --}}
<table class="width-100 margin-top-60" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="10%">&nbsp;</td>
		<td width="30%" class="center border-top">Nombre y firma del cliente</td>
		<td width="20%">&nbsp;</td>
		<td width="30%" class="center border-top">Autorizado por:</td>
		<td width="10%">&nbsp;</td>
	</tr>
</table>
