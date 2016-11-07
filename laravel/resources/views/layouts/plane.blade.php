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
	<link rel="stylesheet" href="{{ asset("assets/stylesheets/bootstrap-tagsinput.css") }}" />
	<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
</head>
<body>
	@yield('body')
	<!-- Scripts -->
	<script src="{{ asset('/js/jquery-1.11.3.js') }}"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
	<script src="//maps.google.com/maps/api/js?key=AIzaSyCTyLJemFK5wu_ONI1iZobLGK9pP1EVReo"></script>
	<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
	<script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/scripts/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
	<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
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

		if ( $( "[name=contactus_address_th]" ).length )
		{
			CKEDITOR.replace( 'contactus_address_th' );
	    CKEDITOR.replace( 'contactus_address_en' );
		}

		if ( $( "[name=faq_answer_th]" ).length )
		{
			CKEDITOR.replace( 'faq_answer_th' );
			CKEDITOR.replace( 'faq_answer_en' );
		}

		if ( $( "[name=faqcategory_description_th]" ).length )
		{
			CKEDITOR.replace( 'faqcategory_description_th' );
	    CKEDITOR.replace( 'faqcategory_description_en' );
		}
		if ( $( "[name=news_description_th]" ).length )
		{
			CKEDITOR.replace( 'news_description_th' );
    			CKEDITOR.replace( 'news_description_en' );
		}

	</script>
	@stack('scripts')
</body>
</html>
