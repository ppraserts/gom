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
	<script src="//maps.google.com/maps/api/js?key=AIzaSyCTyLJemFK5wu_ONI1iZobLGK9pP1EVReo"></script>
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

		if ( $( "[name=contactus_address_th]" ).length )
		{
			CKEDITOR.replace( 'contactus_address_th' );
	    CKEDITOR.replace( 'contactus_address_en' );
		}
	</script>
	<?php
		if(isset($controllerAction) && $controllerAction == "contactus.update")
		{
	?>
	<script type="text/javascript">
	  $(function() {
			var myLatLng = {lat: <?php echo $item->contactus_latitude; ?>, lng: <?php echo $item->contactus_longitude; ?>};

			 var map = new google.maps.Map(document.getElementById('map'), {
				 zoom: 10,
				 center: myLatLng
			 });

			var marker = new google.maps.Marker({
				 position: myLatLng,
				 draggable: true,
				 animation: google.maps.Animation.DROP,
				 map: map,
				 title: 'Hello World!'
			});

			google.maps.event.addListener(marker, 'dragend', function (event) {
			    $( "[name=contactus_latitude]" ).val(this.getPosition().lat());
			    $( "[name=contactus_longitude]" ).val(this.getPosition().lng());
			});
	  })
	</script>
	<?php
		}
	?>
</body>
</html>
