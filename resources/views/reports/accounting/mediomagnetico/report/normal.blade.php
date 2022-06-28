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
            
        </tbody>
	</table>
@stop
