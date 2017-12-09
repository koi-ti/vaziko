<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		{{-- Format title --}}
		<title>{{ $type == 'xls' ? substr($title, 0 , 31) : $title }}</title>

		{{-- Include css pdf --}}
		@if($type == 'pdf')
			<style type="text/css">
				body {
					font-size: 7;
					font-family: firefly, DejaVu Sans, sans-serif;
					font-weight: normal;
				}

				@page{
					margin-top: 35px;
					margin-right: 30px;
					margin-left: 30px;
					margin-bottom: 35px;
				}

				.table  {
					display: table;
					border-collapse: collapse;
					width: 100%;
				}

				.heading {
					display: table-row;
				}

				.rows {
					display: table-row;
				}

				.cell {
					display: table-cell;
					border: 1px solid black;
					padding-left: 1px;
					padding-right: 1px;
				}

				.titleespecial{
					font-size: 10;
					background-color: #000000;
					color: #FFFFFF;
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

				.size-6 {
					font-size: 6;
				}

				.size-7 {
					font-size: 7;
				}

				.size-8 {
					font-size: 8;
				}

				.size-10 {
					font-size: 10;
				}

				.noborder {
					border: none;
				}

				.border {
					border: 1px solid black;
				}

				.border-cell {
					border-left: 1px solid black;
					border-right: 1px solid black;
					border-top: none;
					border-bottom: none;
				}

				.border-left {
					border-left: 1px solid black;
					border-right: none;
					border-top: none;
					border-bottom: none;
				}

				.border-right {
					border-left: none;
					border-right: 1px solid black;
					border-top: none;
					border-bottom: none;
				}

				.border-top {
					border-left: none;
					border-right: none;
					border-top: 1px solid black;
					border-bottom: none;
				}

				.border-bottom {
					border-left: none;
					border-right: none;
					border-top: none;
					border-bottom: 1px solid black;
				}

				.border-tbr {
					border-top: 1px solid black;
					border-bottom: 1px solid black;
					border-left: none;
					border-right: 1px solid black;
				}

				.border-tbl {
					border-top: 1px solid black;
					border-bottom: 1px solid black;
					border-left: 1px solid black;
					border-right: none;
				}

				.bold{
					font-weight: bold;
				}

				.container {
					min-height:100%;
  					position:relative;

					.header {
						background:#ff0;
					}

					.body {
  						padding-bottom:100px;   /* Height of the footer */
					}

					.footer {
						position:absolute;
						bottom:0;
						width:100%;
						height:100px;   /* Height of the footer */
					}
				}
			</style>
		@endif
	</head>
	<body>
		<script type="text/php">
		    if (isset($pdf)) {
				// Configurar (positionX, positionY, textp, font-family, font-size, font-color, word_space, char_space, angle)
				$pdf->page_text(279, $pdf->get_height() - 15, utf8_decode("Pagina {PAGE_NUM} de {PAGE_COUNT}"), 'DejaVu Sans', 7, array(0,0,0), 0.0, 0.0, 0.0);
		    }
		</script>
		<div class="container">
			{{-- Title --}}
			{{--*/ $empresa = App\Models\Base\Empresa::getEmpresa(); /*--}}
			<div class="header">
				@include('production.cotizaciones.report.title')
			</div>

			@yield('content')
		</div>
	</body>
</html>
