@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th>Cuenta</th>
                <th>Descripción</th>
                <th>Debitos</th>
                <th>Creditos</th>
			</tr>
		</thead>
		<tbody>
			{{--*/ $ttdebito = $ttcredito = 0; /*--}}
            @foreach($data as $item)
                {{--*/ $tdebito = $tcredito = 0; /*--}}
                <tr>
                    <td>{{ $item->plancuentas_cuenta }}</td>
                    <td>{{ $item->plancuentas_nombre }}</td>
					<td>{{ number_format($item->debito, 2, ',', '.') }}</td>
                    <td>{{ number_format(0,2,',' , '.') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format(0, 2, ',', '.') }}</td>
					<td>{{ number_format($item->credito, 2, ',', '.') }}</td>
                </tr>

                {{--*/
					$tdebito += $item->debito;
					$tcredito += $item->credito;

					$ttdebito += $item->debito;
					$ttcredito += $item->credito;
				/*--}}

                <tr style="border-top: 1px dashed #000">
                    <td class="size-8 right bold" colspan="3">Totales CUENTA {{ $item->plancuentas_cuenta }}</td>
                    <td class="size-8 bold">{{ number_format($tdebito, 2, ',', '.') }}</td>
                    <td class="size-8 bold">{{ number_format($tcredito, 2, ',', '.') }}</td>
                </tr>
            @endforeach
			<tr>
				<td class="size-8 right bold" colspan="3">Totales Movimiento</td>
				<td class="size-8 bold">{{ number_format($ttdebito, 2, ',', '.') }}</td>
				<td class="size-8 bold">{{ number_format($ttcredito, 2, ',', '.') }}</td>
			</tr>
		</tbody>
	</table>
@stop
