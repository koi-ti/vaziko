<style type="text/css">
    .bg-incumplidas {
        background-color: #DD4B39;
        color: #FFF;
    }

    .text-center {
        text-align: center;
    }
</style>

<table class="rtable" border="0" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Tercero</th>
            <th colspan="4" class="text-center">Fecha</th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th>Cantidad</th>
            <th>Facturado</th>
            <th>V. unitario</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        {{--*/ $total = 0; /*--}}

        @foreach($incumplidas as $orden)
            <tr>
                <td class="bg-incumplidas">{{ $orden->orden_codigo }}</td>
                <td class="bg-incumplidas">{{ $orden->tercero_nombre }}</td>
                <td class="bg-incumplidas text-center" colspan="4">{{ $orden->orden_fecha }}</td>
            </tr>
            @foreach ($orden->detalle as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->productop_nombre }}</td>
                    <td>{{ $item->orden2_cantidad }}</td>
                    <td>{{ $item->orden2_facturado }}</td>
                    <td>{{ $item->orden2_total_valor_unitario }}</td>
                    <td>{{ $item->total }}</td>
                </tr>

                {{--*/
                    $total += $item->total;
                /*--}}
            @endforeach
        @endforeach
        <tr>
            <th colspan="4"></th>
            <th>Total</th>
            <th>{{ $total }}</th>
        </tr>
    </tbody>
</table>
