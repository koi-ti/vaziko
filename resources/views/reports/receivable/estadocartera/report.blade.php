@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')

	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th class="center size-7" width="20%">Documento</th>
                <th class="center size-7" width="30%">Fecha</th>
                <th class="center size-7" width="15%">Detalle</th>
                <th class="center size-7" width="15%">Vencimiento</th>
                <th class="center size-7" width="20%">N. días</th>
                <th class="center size-7" width="20%">Saldo</th>
			</tr>
		</thead>
		<tbody>
            {{--*/ $tercero = ''; $tsaldo = 0; /*--}}
            @foreach($data as $key => $item)
                @if($tercero != $item->tercero_nit)
                    @if ($key > 0) {
                        <tr>
                            <td colspan="5">Total</td>
                            <td>{{ number_format ($tsaldo,2,',' , '.') }}</td>
                        </tr>
                        {{--*/ $tsaldo = 0; /*--}}
                    @endif
                    <tr>
                        <td colspan="6">{{ $item->tercero_nit }} {{ $item->tercero_nombre }} {{ $item->tercero_telefono1 }} |{{ $item->tercero_direccion}} | {{ $item->municipio_nombre }} </td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $item->factura1_numero }} -  {{ $item->factura1_prefijo }}</td>
                    <td>{{ $item->factura1_fecha }}</td>
                    <td></td>
                    <td>{{ $item->factura4_vencimiento }}</td>
                    <td>{{ $item->days }}</td>
                    <td>{{ number_format ($item->factura4_saldo,2,',' , '.') }}</td>
                </tr>
                @if ( $key == $data->count()-1) {
                    <tr>
                        <td colspan="5" class="text-rigth">Total</td>
                        <td>{{ number_format ($tsaldo,2,',' , '.') }}</td>
                    </tr>
                    {{--*/ $tsaldo = 0; /*--}}
                @endif
                {{--*/ $tercero = $item->tercero_nit ; $tsaldo += $item->factura4_saldo/*--}}
            @endforeach
		</tbody>
	</table>
@stop
