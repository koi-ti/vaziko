@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')

	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
                <th>Cuenta</th>
                <th>Nombre</th>
                <th>Debito</th>
                <th>Credito</th>
			</tr>
		</thead>
		<tbody>
            @foreach($asiento as $key => $items)
                {{--*/ $tdebito = $tcredito = 0; /*--}}
                <tr>
                    <td class="size-8 bold" colspan="4">{{$key}}</td>
                </tr>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->plancuentas_cuenta }}</td>
                        <td>{{ $item->plancuentas_nombre }}</td>
                        <td>{{ number_format ($item->debito,2,',' , '.') }}</td>
                        <td>{{ number_format ($item->credito,2,',' , '.') }}</td>
                    </tr>
                    {{--*/  $tdebito += $item->debito; $tcredito += $item->credito; /*--}}
                @endforeach
                <tr>
                    <td></td>
                    <td class="size-8 bold">TOTAL</td>
                    <td class="size-8 bold">{{ number_format ($tdebito,2,',' , '.') }}</td>
                    <td class="size-8 bold">{{ number_format ($tcredito,2,',' , '.') }}</td>
                </tr>
            @endforeach
		</tbody>
	</table>
@stop
