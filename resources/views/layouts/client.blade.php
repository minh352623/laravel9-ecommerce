<!DOCTYPE html>
<html lang="en">
<head>
	@yield('title')
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{asset('/Themes/images/icons/favicon.png')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/fonts/iconic/css/material-design-iconic-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/fonts/linearicons-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/vendor/animate/animate.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/vendor/slick/slick.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/vendor/MagnificPopup/magnific-popup.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('/Themes/css/main.css')}}">
<!--===============================================================================================-->

</head>
<body class="animsition">
	
	@yield('header')
    @include('clients.components.sidebar')
    @include('clients.components.cart')

	@yield('content')


    @include('clients.components.footer')
	<script src="{{asset('/Themes/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <!--===============================================================================================-->
        <script src="{{asset('/Themes/vendor/animsition/js/animsition.min.js')}}"></script>
    <!--===============================================================================================-->
        <script src="{{asset('/Themes/vendor/bootstrap/js/popper.js')}}"></script>
        <script src="{{asset('/Themes/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <!--===============================================================================================-->
        <script src="{{asset('/Themes/vendor/select2/select2.min.js')}}"></script>
		  <!--===============================================================================================-->
		  <script src="{{asset('/Themes/vendor/daterangepicker/moment.min.js')}}"></script>
		  <script src="{{asset('/Themes/vendor/daterangepicker/daterangepicker.js')}}"></script>
	  <!--===============================================================================================-->
		  <script src="{{asset('/Themes/vendor/slick/slick.min.js')}}"></script>
  
		  <script src="{{asset('/Themes/js/slick-custom.js')}}"></script>
	  <!--===============================================================================================-->
		  <script src="{{asset('/Themes/vendor/parallax100/parallax100.js')}}"></script>
		  <script src="{{asset('/Themes/vendor/MagnificPopup/jquery.magnific-popup.min.js')}}"></script>
 <!--===============================================================================================-->
 <script src="{{asset('/Themes/vendor/isotope/isotope.pkgd.min.js')}}"></script>
 <!--===============================================================================================-->
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	 <script src="{{asset('/Themes/vendor/sweetalert/sweetalert.min.js')}}"></script>
	 {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
 <!--===============================================================================================-->
	 <script src="{{asset('/Themes/vendor/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>

    @yield('js')
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

	
		
		</script>

<script src="{{asset('/Themes/js/main.js')}}"></script>


</body>
</html>