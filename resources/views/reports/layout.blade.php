<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{{ $title }}</title>
        <link href="{{ asset("/css/report.min.css") }}" rel="stylesheet" type="text/css" />
	</head>
	<body>
		{{--*/ $empresa = App\Models\Base\Empresa::getEmpresa(); /*--}}
		<table class="tbtitle">
			<thead>
				<tr><td class="company">{{ $empresa->tercero_razonsocial }}{{ asset("/css/report.min.css") }}</td></tr>
				<tr><td class="nit">NIT: {{ $empresa->tercero_nit }}</td></tr>
				<tr><td class="title">{{ $title }}</td></tr>
			</thead>
		</table>
		<br/>

		@yield('content')
	</body>
</html>