<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		{{-- Format title --}}
		<title>{{ $type == 'xls' ? substr($title, 0 , 31) : $title }}</title>

		{{-- Include css pdf --}}
		<style type="text/css">
			body {
				font-size: 8;
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

			.company {
				font-size: 12;
				font-weight: bold;
				text-align: center;
			}

			.nit {
				font-size: 10;
				font-weight: bold;
				text-align: center;
				border-bottom: 1px solid black;
			}

			.title {
				font-size: 10;
				font-weight: bold;
				text-align: center;
			}

			.titleespecial {
				font-size: 10;
				background-color: #000000;
				color: #FFFFFF;
			}

			.htable {
				width: 100%;
			}

			.htable td {
				padding-left: 2px;
				text-align: center;
				border: 1px solid black;
			}

			.htable th {
				padding-left: 2px;
				text-align: center;
				border: 1px solid black;
			}

			.hrtable {
				width: 100%;
			}

			.brtable {
				width: 100%;
			    border-collapse: collapse;
			}

			.brtable th {
				border: 1px solid black;
				padding-left: 2px;
			}

			.brtable td {
				border: 1px solid black;
				padding-left: 2px;
			}

			.rtable {
				width: 100%;
			    border-collapse: collapse;
			}

			.rtable th {
				border: 1px solid black;
				padding-left: 2px;
			}

			.rtable td, th {
				height: 19px;
			}

			.rtable tr:nth-child(even) {
				background-color: #F2F2F2;
			}

			.left {
				text-align: left;
			}

			.right {
				text-align: right;
			}

			.center {
				text-align: center;
			}

			.bold {
				font-weight: bold;
				background-color: #D3D3D3 !important;
			}

			.size-7 {
				font-size: 7;
			}

			.size-8 {
				font-size: 8;
			}

			.border-left {
				border-left: 1px solid black;
				padding-left: 2px;
			}

			.border-right {
				border-right: 1px solid black;
				padding-left: 2px;
			}

			.border-top {
				border-top: 1px solid black;
				padding-top: 2px;
			}

			.height-40 {
				height: 40px;
			}

			.height-19 {
				height: 19px;
			}

			.margin-top-50 {
				margin-top: 50px;
			}

			.margin-bottom-10 {
				margin-bottom: 10px;
			}
		</style>
	</head>
	<body>
		@yield('content')
	</body>
</html>
