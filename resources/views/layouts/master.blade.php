<!DOCTYPE html>
<html lang="{{ get_default_language_code() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ (isset($page_title) ? __($page_title) : __("Public")) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200;300;400;500;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    @include('partials.header-asset')
    @stack('css')
</head>
<body class="{{ get_default_language_dir() }}">

    @include('frontend.partials.preloader')

    @yield('content')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Download App Modal
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="modal fade bd-example-modal-app" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="payment-form-modal-wrapper">
                <div class="date-select-wrapper mb-60">
                    <h4 class="title"><i class="fas fa-cloud-download-alt"></i> {{ __("Download App...!") }}</h4>
                </div>
                <div class="footer-download d-flex justify-content-center">
                    <div class="footer-download-btn">
                        <a href="{{ $__app_settings->iso_url ?? "javascript:void(0)" }}" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="{{ asset('public/frontend/images/app/play_store.png') }}" alt="app"></a>
                    </div>
                    <div class="footer-download-btn ms-4">
                        <a href="{{ $__app_settings->android_url ?? "javascript:void(0)" }}" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="{{ asset('public/frontend/images/app/app_store.png') }}" alt="app"></a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Download App Modal
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    @include('partials.footer-asset')
    
    @stack('script')

</body>
</html>