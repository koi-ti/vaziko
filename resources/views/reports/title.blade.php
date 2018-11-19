@if($type == 'pdf')
	<table class="tbtitle">
		<thead>
			<tr><td class="company">{{ $empresa->tercero_razonsocial }}</td></tr>
			<tr><td class="nit">NIT: {{ $empresa->tercero_nit }}</td></tr>
			<tr><td class="title">{{ $title }}</td></tr>
		</thead>
	</table>
@else
	<table class="tbtitle">
		<thead>
			<tr><td colspan="5" class="company">{{ $empresa->tercero_razonsocial }}</td></tr>
			<tr><td colspan="5" class="nit">NIT: {{ $empresa->tercero_nit }}</td></tr>
			<tr><td colspan="5" class="title">{{ $title }}</td></tr>
		</thead>
	</table>
@endif
