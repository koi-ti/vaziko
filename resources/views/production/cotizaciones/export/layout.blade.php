<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		{{-- Format title --}}
		<title>{{ $type == 'xls' ? substr($title, 0 , 31) : $title }}</title>

		{{-- Include css pdf --}}
		@if($type == 'pdf')
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
					border-collapse: collapse;
				}

				.intertable {
					width: 100%;
					border-collapse: collapse;
				}

				.intertable td {
					padding-left: 2px;
				}

				.titleespecial{
					font-size: 10;
					background-color: #000000;
					color: #FFFFFF;
				}

				.brtable {
					page-break-before:auto;
					width: 100%;
				    border-collapse: collapse;
				}

				.brtable td {
					padding-left: 2px;
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

				.bold{
					font-weight: bold;
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

				.border {
					border: 1px solid black;
				}

				.noborder {
					border: 1px solid white;
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

				.margin-top-60 {
					margin-top: 60px;
				}

				.margin-bottom-60 {
					margin-bottom: 60px;
				}
			</style>
		@endif
	</head>
	<body>
		<script type="text/php">
		    if (isset($pdf)) {
				// Configurar (positionX, positionY, textp, font-family, font-size, font-color, word_space, char_space, angle)
				$pdf->page_text(279, $pdf->get_height() - 15, utf8_encode("Pagina {PAGE_NUM} de {PAGE_COUNT}"), 'DejaVu Sans', 7, array(0,0,0), 0.0, 0.0, 0.0);
		    }
		</script>

		{{-- Title --}}
		{{--*/ $empresa = App\Models\Base\Empresa::getEmpresa(); /*--}}
		@include('production.cotizaciones.export.title')
		<br/>

		@yield('content')
	</body>
</html>
