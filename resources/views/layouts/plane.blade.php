<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>{{ config('app.name', 'Laravel') }}</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>

	<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />
</head>
<body>
	@yield('body')
	<!-- Scripts -->
	<script src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
	<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
		if ( $( "[name=downloaddocument_description_th]" ).length )
		{
			CKEDITOR.replace( 'downloaddocument_description_th' );
	    CKEDITOR.replace( 'downloaddocument_description_en' );
		}

		if ( $( "[name=aboutus_description_th]" ).length )
		{
			CKEDITOR.replace( 'aboutus_description_th' );
	    CKEDITOR.replace( 'aboutus_description_en' );
		}
	</script>
</body>
</html>
