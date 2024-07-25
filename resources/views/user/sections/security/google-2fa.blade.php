@extends('user.layouts.master')

@push('css')
    
@endpush

@section('breadcrumb')
    @include('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("2fa Security")])
@endsection

@section('content')
    <div class="card-area mt-30">
        <div class="row justify-content-center mb-20-none">
            <div class="col-lg-6 col-md-6 col-12 mb-20">
                <div class="card custom--card">
                    <div class="user-text">
                        <h4>{{ __("Two Factor Authenticator") }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" value="{{ auth()->user()->two_factor_secret }}" class="form-control form--control ref-input text-light copiable" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text copytext copy-button">
                                        <i class="la la-copy"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mx-auto mt-4 text-center">
                            <img class="mx-auto" src="{{ $qr_code }}" alt="Qr Code">
                        </div>
                        <div class="form-group mx-auto text-center mt-4">
                            @if (auth()->user()->two_factor_status)
                                <button type="button" class="btn--base bg--warning w-100 active-deactive-btn">{{ __("Disable Two Factor Authenticator") }}</button>
                                <br>
                                <div class="text--danger mt-3">{{ __("Don't forget to add this application in your google authentication app. Otherwise you can't login in your account.") }}</div>
                            @else
                                <button type="button" class="btn--base w-100 active-deactive-btn">{{ __("Enable Two Factor Authenticator") }}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mb-20">
                <div class="card custom--card">
                    <div class="user-text">
                        <h4>{{ __("Google Authenticator") }}</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="mb-3">{{ __("Download Google Authenticator App") }}</h5>
                        <p>{{ __("Google Authenticator is a product based authenticator by Google that executes two-venture confirmation administrations for verifying clients of any programming applications.") }}</p>
                        <hr />
                        <a class="btn--base" href="https://www.apple.com/app-store/">{{ __("Download App") }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(".active-deactive-btn").click(function(){
            var actionRoute =  "{{ setRoute('user.security.google.2fa.status.update') }}";
            var target      = 1;
            var btnText     = $(this).text();
            var message     = `Are you sure to <strong>${btnText}</strong> 2 factor authentication (Powered by google)?`;
            openAlertModal(actionRoute,target,message,btnText,"POST", "{{ __('Close') }}");
        });
    </script>
@endpush