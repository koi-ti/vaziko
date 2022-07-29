@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th align="center">CUENTA</th>
				<th align="center">NOMBRE</th>
				<th align="center">INICIAL</th>
				<th align="center">DEBITO</th>
				<th align="center">CREDITO</th>
				<th align="center">FINAL</th>
			</tr>
		</thead>
		<tbody>
            @foreach ($data as $item)
            {{-- {{ dd($data->toArray()) }} --}}
                <tr>
                    <th align="center">{{ $item->plancuentas_cuenta }}</th>
                    <th align="center">{{ $item->plancuentas_nombre }}</th>
                    <th align="center">IN---ICIAL</th>
                    <th align="center">DEB---ITO</th>
                    <th align="center">CR---EDITO</th>
                    <th align="center">FI--NAL</th>
                </tr>
                @foreach ($item->saldosterceros as $saldotercero)
                    <tr>
                        <td align="center">{{ $saldotercero->cuenta->plancuentas_cuenta }}</td>
                        <td align="center">{{ $saldotercero->cuenta->plancuentas_nombre }}</td>
                        <td align="center">{{ $saldotercero->debitomes }}</td>
                        <td align="center">{{ $saldotercero->creditomes }}</td>
                        <td align="center">{{ $saldotercero->inicial }}</td>
                        <td align="center">fin--al</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
	</table>
@stop
