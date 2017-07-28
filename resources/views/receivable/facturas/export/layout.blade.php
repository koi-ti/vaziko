<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		{{-- Include css pdf --}}
		@if($type == 'pdf')
			<style type="text/css">
				body {
					font-size: 8;
					font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
					font-weight: normal;
				    margin: 0px 0px 0px 25px:
				}

				@page {
					size: letter;
				}

				.container-factura {
					display: table;
					width: 100%;
					margin-top: 22px;
				}

				.rtable {
					margin: 16px 5px 0px 2px;
					font-size: 6;
					width: 100%;
				    border-collapse: collapse;
				}

				.rtable th {
					padding-left: 2px;
				}

				.rtable td, th {
					height: 16px;
				}

				.rtable tfoot {
					font-size: 8;
				}

				tfoot td {
					padding: 2px 0px 0px 2px;
				}

				.htable {
					margin-top: 65px;
					width: 100%;
					font-size: 8;
				    border-collapse: collapse;
				}

				.htable th {
					padding: 9px 0px 0px 2px;
				}

				.htable td, th {
					height: 14px;
				}

				.rtable tbody {
					page-break-after: always;
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
			</style>
		@endif
	</head>
	<body>
		@yield('content')
	</body>
</html>