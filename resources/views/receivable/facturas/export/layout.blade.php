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

				@page{
					size: letter;
				}

				.container-factura{
					display: table;
					width: 100%;
					margin-top: 22px;
				}

				.container-encabezado {
					margin-top: 64px;
					height: 100px;
				}

				.tercero-info {
					display: table;
					border-spacing: 7;
					margin-left: 29px;
				}

				.tercero-info2 {
					display: table;
					width: 100%;
				}

				.tercero-info3 {
					display: table;
					padding-top: 10px;
					width: 100%;
				}

				.container-body {
					display: table;
					width: 100%;
					margin: 24px 15px 0px 5px;
					height: 383px;
				}

				.container-footer {
					display: table;
					width: 100%;
					border-spacing: 3;
					height: 110px;
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
		@yield('content')
	</body>
</html>