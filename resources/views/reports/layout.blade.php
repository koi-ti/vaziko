<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>{{ $title }}</title>
		<style type="text/css">
			body {
				/*margin: 20px 10px 20px 10px;*/
				font-size: 10px;
			}
		</style>
	</head>
	<body>
		<div style="width:100%;text-align:center;">
			<h2>{{ config('koi.app.name') }}</h2>
			<h4>{{ $title }}</h4>
		</div>

		@yield('content')
	</body>
</html>