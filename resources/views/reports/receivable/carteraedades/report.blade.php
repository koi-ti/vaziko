@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')

	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th class="center size-7 width-20">Prefijo</th>
                <th class="center size-7 width-20">Número</th>
                <th class="center size-7 width-30">Cuota</th>
                <th class="center size-7 width-15">Documento</th>
                <th class="center size-7 width-15">Cliente</th>
                <th class="center size-7 width-20">MORA > 360</th>
                <th class="center size-7 width-20">MORA > 180 Y <= 360</th>
                <th class="center size-7 width-20">MORA > 90 Y <= 180</th>
                <th class="center size-7 width-20">MORA > 60 Y <= 90</th>
                <th class="center size-7 width-20">MORA > 30 Y <= 60</th>
                <th class="center size-7 width-20">MORA > 0 Y <= 30</th>
                <th class="center size-7 width-20">DE 0 A 30</th>
                <th class="center size-7 width-20">DE 31 A 60</th>
                <th class="center size-7 width-20">DE 61 A 90</th>
                <th class="center size-7 width-20">DE 91 A 180</th>
                <th class="center size-7 width-20">DE 181 A 360</th>
                <th class="center size-7 width-20">> 360</th>
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
