<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		{{-- Format title --}}
		<title>{{ $type == 'xls' ? substr($title, 0 , 31) : $title }}</title>

		{{-- Include css pdf --}}
		@if($type == 'pdf')
			<style type="text/css">
				body {
					font-size: 9;
					font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
					font-weight: normal;
				}

				@page{
					margin-top: 35px;
					margin-right: 30px;
					margin-left: 30px;
					margin-bottom: 35px;
				}

				.tbtitle {
					width: 100%;
				}

				.company{
					font-size: 16px;
					font-weight: bold;
					text-align: center;
				}

				.nit{
					font-size: 12px;
					font-weight: bold;
					text-align: center;
					border-bottom: 1px solid black;
				}

				.title{
					font-size: 12px;
					font-weight: bold;
					text-align: center;
				}

				.rtable{
					width: 100%;
				}

				.rtable th {
					border: 1px solid black;
					padding-left: 2px;
				}

				.rtable td, th {
					height: 19px;
				}

				.rtable tr:nth-child(even) {
					background-color: #f2f2f2
				}

				.left {
					text-align: left;
				}

				.right {
					text-align: right;
				}

				.center{
					text-align: center;
				}
			</style>
		@endif
	</head>
	<body>
		{{--*/ $empresa = App\Models\Base\Empresa::getEmpresa(); /*--}}
		<table class="tbtitle">
			<thead>
				<tr><td class="company">{{ $empresa->tercero_razonsocial }}</td></tr>
				<tr><td class="nit">NIT: {{ $empresa->tercero_nit }}</td></tr>
				<tr><td class="title">{{ $title }}</td></tr>
			</thead>
		</table>
		<br/>

		@yield('content')
	</body>
</html>