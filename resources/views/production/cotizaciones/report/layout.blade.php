<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	{{-- Format title --}}
	<title>{{ $type == 'xls' ? substr($title, 0 , 31) : $title }}</title>

	{{-- Include css pdf --}}
	@if($type == 'pdf')
		<style type="text/css">
			body {
				font-size: 7;
				/* font-family: firefly, DejaVu Sans, sans-serif; */
				font-weight: normal;
			}

			@page{
				margin-top: 35px;
				margin-right: 30px;
				margin-left: 30px;
				margin-bottom: 35px;
			}

			.rtable {
				width: 100%;
				font-size: 6;
			    border-collapse: collapse;
			}

			.rtable th {
				padding-left: 2px;
			}

			.rtable td {
				padding-left: 4px;
			}

			.rtable td, th {
				height: 14px;
			}

			.titleespecial{
				background-color: #000000;
				border: 1px solid black;
				color: #FFFFFF;
			}

			.size-8 {
				font-size: 8;
			}

			.noborder {
				border: none;
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

			.border-top {
				border-left: none;
				border-right: none;
				border-top: 1px solid black;
				border-bottom: none;
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

			.border {
				border: 1px solid black;
			}

			.body {
				padding-bottom: 100px;   /* Height of the footer */
			}

			.footer {
				position: absolute;
				bottom: 0;
				width: 100%;
				height: 100px;   /* Height of the footer */
			}
		</style>
	@endif
</head><body>
	<script type="text/php">
		if (isset($pdf)) {
			$font = Font_Metrics::get_font("DejaVu Sans", "normal");
			$text = html_entity_decode("P&aacute;gina {PAGE_NUM} de {PAGE_COUNT}", ENT_QUOTES, "UTF-8");

			// Configurar (positionX, positionY, textp, font-family, font-size, font-color, word_space, char_space, angle)
			$pdf->page_text(279, $pdf->get_height() - 15, $text, $font, 7, array(0,0,0), 0.0, 0.0, 0.0);
		}
	</script>
	@yield('content')
</body></html>
