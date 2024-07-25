<!DOCTYPE html>
<html lang="{{ get_default_language_code() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ (isset($page_title) ? __($page_title) : __("Dashboard")) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200;300;400;500;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    @include('partials.header-asset')
    
    @stack("css")
</head>
<body class="{{ get_default_language_dir() }}">


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.partials.preloader')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


  <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Dashboard
  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
  <div class="page-wrapper">
    @include('user.partials.side-nav')

    <div class="main-wrapper">
      <div class="main-body-wrapper">
          <!-- navbar-wrapper-start -->
          @include('user.partials.top-nav')
          <!-- body-wrapper-start -->
          <div class="body-wrapper ">
            @yield('content')
          </div>
      </div>
    </div>
  </div>
  <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Dashboard
  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

  @include('partials.footer-asset')

  @stack("script")

</body>
</html>