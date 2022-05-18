@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="center size-7" colspan="2">CLIENTE</th>
                <th class="center size-7 width-5">PREFIJO</th>
                <th class="center size-7 width-10">NÚMERO</th>
                <th class="center size-7 width-5">CUOTA</th>
				@foreach( $headerdays as $header )
					<th class="center size-7 width-20">{{ $header }}</th>
				@endforeach
				<th class="center size-7 width-20">TOTAL</th>
			</tr>
		</thead>
		<tbody>
			{{--*/ $menor360 = $menor180 = $menor90 = $menor60 = $menor30 = $menor0 = $mayor0 = $mayor31 = $mayor61 = $mayor91 = $mayor181 = $mayor360 = $totalfinal = 0 /*--}}
            @foreach($data as $key => $item)
				{{--*/ $total = 0; /*--}}
				<tr>
					<td>{{ $item->tercero_nit }}</td>
					<td>{{ $item->tercero_nombre }}</td>
					<td>{{ $item->factura1_prefijo }}</td>
					<td>{{ $item->factura1_numero }}</td>
					<td>{{ $item->factura4_cuota }}</td>
					<td>{{ $item->days < -360 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days >= -360 && $item->days <= -180 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days >= -180 && $item->days <= -90 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days >= -90 && $item->days <= -60 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days >= -60 && $item->days <= -30 ? $item->factura4_saldo : '0' }}</td>
					<td>{{ $item->days >= -30 && $item->days <= 0 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days > 0 && $item->days <= 30 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days > 31 && $item->days <= 60 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days > 61 && $item->days <= 90 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days > 91 && $item->days <= 180 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days > 181 && $item->days <= 360 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $item->days > 360 ? $item->factura4_saldo : '0' }}</td>
                    <td>{{ $total += $item->factura4_saldo }}</td>
                </tr>
				{{--*/
					if( $item->days < -360 )
						$menor360 += $item->factura4_saldo;
					else if( $item->days >= -360 && $item->days <= -180 )
						$menor180 += $item->factura4_saldo;
					else if( $item->days >= -180 && $item->days <= -90 )
						$menor90 += $item->factura4_saldo;
					else if( $item->days >= -90 && $item->days <= -60 )
						$menor60 += $item->factura4_saldo;
					else if( $item->days >= -60 && $item->days <= -30 )
						$menor30 += $item->factura4_saldo;
					else if( $item->days >= -30 && $item->days <= 0 )
						$menor0 += $item->factura4_saldo;
					else if( $item->days > 0 && $item->days <= 30 )
						$mayor0 += $item->factura4_saldo;
					else if( $item->days > 31 && $item->days <= 60 )
						$mayor31 += $item->factura4_saldo;
					else if( $item->days > 61 && $item->days <= 90 )
						$mayor61 += $item->factura4_saldo;
					else if( $item->days > 91 && $item->days <= 180 )
						$mayor91 += $item->factura4_saldo;
					else if( $item->days > 181 && $item->days <= 360 )
						$mayor181 += $item->factura4_saldo;
					else if( $item->days > 360 )
						$mayor360 += $item->factura4_saldo;

					$totalfinal += $total;
				/*--}}
            @endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="5" class="text-left">TOTAL</th>
				<th>{{ $menor360 }}</th>
				<th>{{ $menor180 }}</th>
				<th>{{ $menor90 }}</th>
				<th>{{ $menor60 }}</th>
				<th>{{ $menor30 }}</th>
				<th>{{ $menor0 }}</th>
				<th>{{ $mayor0 }}</th>
				<th>{{ $mayor31 }}</th>
				<th>{{ $mayor61 }}</th>
				<th>{{ $mayor91 }}</th>
				<th>{{ $mayor181 }}</th>
				<th>{{ $mayor360 }}</th>
				<th>{{ $totalfinal }}</th>
			</tr>
		</tfoot>
	</table>
@stop
