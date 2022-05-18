@extends('reports.layout', ['type' => $type, 'title' => $title])

@section('content')
	<p>{{ $subtitle }}</p>
	<table class="rtable" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
        <th class="center size-7 width-5">#Doc</th>
        <th class="center size-7 width-5">Tipo Documento</th>
        <th class="center size-7 width-5">Fecha</th>
        <th class="center size-7 width-5">Nit</th>
        <th class="center size-7 width-5">Nombre</th>
        <th class="center size-7 width-5">Detalle</th>
        <th class="center size-7 width-5">Debito</th>
        <th class="center size-7 width-5">Credito</th>
			</tr>
		</thead>
		<tbody>
        {{--*/
						$total_debito = 0;
            $total_credito = 0;
				/*--}}
			@foreach ($data as $item)
				<tr>
					<td class="center size-1 width-1">{{ $item->asientoId }}</td>
					<td class="center size-7 width-5">{{ $item->documento_nombre }}</td>
					<td class="center size-7 width-5">{{ $item->fecha }}</td>
					<td class="center size-7 width-5">{{ $item->tercero_nit }}</td>
					<td class="center size-7 width-5">{{ $item->tercero_nombre }}</td>
					<td class="center size-7 width-5">{{ utf8_decode($item->detalle) }}</td>
          <td align="right">{{ number_format($item->debito, 2, ',', '.') }}</td>
          <td align="right">{{ number_format($item->credito, 2, ',', '.') }}</td>
					{{--
					<td>{{ $item->folder_codigo }}</td>
					<td>{{ $item->documento_nombre }}</td>
					--}}
          {{--*/
						$saldo = $item->debito - $item->credito;
						$cr = '';
					/*--}}

          {{--*/
						$total_debito += $item->debito;
            $total_credito += $item->credito;
					/*--}}
				</tr>
			@endforeach
		</tbody>
    <tfoot>
      <tr style="font-weight: bold">
        <td class="center size-1 width-1" colspan="6">TOTALES</td>
        <td align="right">{{ number_format($total_debito, 2, ',', '.') }}</td>
        <td align="right">{{ number_format($total_credito, 2, ',', '.') }}</td>
      </tr>
    </tfoot>
	</table>
@stop
