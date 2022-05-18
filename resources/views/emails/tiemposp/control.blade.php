@extends('emails.layout')

@section('content')
    <p>A continuación se muestra un listado de los operarios que no ingresaron tiempos de producción <br><b>{{ $fecha }}<b><br><br>Lista de operarios</p>
    <table class="rtable" border="1" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td width="20%">Nit</td>
            <td width="60%">Nombres</td>
        </tr>
        @foreach($operarios as $operario)
            <tr>
                <td>{{ $operario->tercero_nit }}</td>
                <td>{{ $operario->tercero_nombre }}</td>
            </tr>
        @endforeach
    </table>
@stop
