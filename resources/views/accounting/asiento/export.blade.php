@extends('reports.layout', ['type' => 'pdf', 'title' => $title])

@section('content')

	<table class="htable" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<th width="15%">Fecha</th>
				<td width="10%">{{ sprintf('%s-%s-%s', $asiento->asiento1_ano, $asiento->asiento1_mes, $asiento->asiento1_dia) }}</td>
				@if($asiento->asiento1_preguardado)
					<th colspan="4" class="right">PRE-GUARDADO</th>
				@endif
			</tr>
			<tr>
				<th width="15%">Folder</th>
				<td width="10%">{{ $asiento->folder_nombre }}</td>
				<th width="15%">Documento</th>
				<td width="20%">{{ $asiento->documento_nombre }}</td>
				<th width="15%">Número</th>
				<td width="10%">{{ $asiento->asiento1_numero }}</td>
			</tr>
			<tr>
				<th width="15%">Beneficiario</th>
				<td colspan="5">{{ sprintf('%s %s', $asiento->tercero_nit, $asiento->tercero_nombre) }}</td>
			</tr>
			<tr>
				<th width="15%">Detalle</th>
				<td colspan="5">{{ $asiento->asiento1_detalle }}</td>
			</tr>
			<tr>
				<th width="15%">Usuario elaboro</th>
				<td width="10%">{{ $asiento->username_elaboro }}</td>
				<th width="15%">Fecha elaboro</th>
				<td width="10%">{{ $asiento->asiento1_fecha_elaboro }}</td>
			</tr>
		</tbody>
	</table>

	<br />
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
        <thead>
	        <tr>
	            <th>Cuenta</th>
	            <th>Nombre</th>
	            <th>Beneficiario</th>
	            <th>Centro Costo</th>
	            <th>Base</th>
	            <th>Debito</th>
	            <th>Credito</th>
	        </tr>
       	<thead>
   		<tbody>
			@if(count($detalle) > 0)
				{{--*/ $tdebito = $tcredito = 0; /*--}}
				@foreach($detalle as $asiento2)
					<tr>
						<td class="left">{{ $asiento2->plancuentas_cuenta }}</td>
						<td class="left">{{ $asiento2->plancuentas_nombre }}</td>
						<td class="left">{{ $asiento2->tercero_nit }}</td>
						<td class="left">{{ $asiento2->centrocosto_nombre }}</td>
						<td class="right">{{ number_format($asiento2->asiento2_base,2,'.',',') }}</td>
						<td class="right">{{ number_format($asiento2->asiento2_debito,2,'.',',') }}</td>
						<td class="right">{{ number_format($asiento2->asiento2_credito,2,'.',',') }}</td>
					</tr>

					{{-- Calculo totales --}}
					{{--*/
						$tcredito += $asiento2->asiento2_credito;
						$tdebito += $asiento2->asiento2_debito;
					/*--}}
				@endforeach
				<tr>
					<td colspan="5" class="right bold">TOTAL</td>
					<td class="right bold">{{ number_format($tcredito,2,'.',',') }}</td>
					<td class="right bold">{{ number_format($tdebito,2,'.',',') }}</td>
				</tr>
			@endif
		</tbody>
    </table>

@stop
