		<!-- FAVICON -->
		<link rel="shortcut icon" type="image/x-icon" href="{{URL::asset('assets/images/brand/fav.ico')}}" />

		<!-- TITLE -->
		<title>APCO - Pest Control Redefined</title>
                <meta name="csrf-token" content="{{ csrf_token() }}" />
                <base href="<?php echo URL::to('/'); ?>">
                <script>
                    var base_url = "<?php echo URL::to('/'); ?>";

                </script>

		<!-- BOOTSTRAP CSS -->
		<link href="{{URL::asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
				<!-- SWEET ALERT CSS -->

		<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />

		<!-- STYLE CSS -->
		<link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" />
               
		<link href="{{URL::asset('assets/css/skin-modes.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/css/dark-style.css')}}" rel="stylesheet" />

		<!-- SIDE-MENU CSS -->
		<link href="{{URL::asset('assets/css/sidemenu.css')}}" rel="stylesheet">

		<!--PERFECT SCROLL CSS-->
		<link href="{{URL::asset('assets/plugins/p-scroll/perfect-scrollbar.css')}}" rel="stylesheet" />

		<!-- CUSTOM SCROLL BAR CSS-->
		<link href="{{URL::asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" />

		<!--- FONT-ICONS CSS -->
		<link href="{{URL::asset('assets/css/icons.css')}}" rel="stylesheet" />


		@yield('css')
		<!-- SIDEBAR CSS -->
		<link href="{{URL::asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">

		<!-- COLOR SKIN CSS -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{URL::asset('assets/colors/color1.css')}}" />
                <!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL  MULTI SELECT CSS -->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">
                <link href="{{URL::asset('assets/plugins/notify/css/jquery.growl.css')}}" rel="stylesheet" />
				 <!-- APCO CSS -->
				 <link href="{{URL::asset('assets/css/multi-select-style.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('assets/css/cn-style.css')}}" rel="stylesheet" />
		<!-- INTERNAL  TABS STYLES -->
<link href="{{URL::asset('assets/plugins/tabs/tabs.css')}}" rel="stylesheet" />