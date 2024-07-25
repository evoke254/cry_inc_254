
@extends('layouts.master')

@push('css')
    
@endpush

@section('content')

    @include('frontend.partials.preloader')
    @include('frontend.partials.scroll-to-top')
    @include('frontend.partials.header')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Login 
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="login pt-150 pb-80">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-md-6 d-grid my-auto py-5 login-img">
                    <img src="{{ asset("public/frontend/images/element/login-signup.png") }}" alt="Image" class="img-fluid">
                </div>

                <div class="col-md-6 my-auto">
                    <div class="content">
                        <div class="my-4">
                            <h3 class="pb-2 text-capitalize fw-bold">{{ __("Log in and Stay Connected") }}</h3>
                            <p class="pb-2 text-light">{{ __("Our secure login process ensures the confidentiality of your information. Log in today and stay connected to your finances, anytime and anywhere.") }}</p>
                        </div>
                        <form action="{{ setRoute('user.login.submit') }}" method="POST">
                            @csrf
                            <div class="form-group ">
                                <label for="email">{{ __("Email") }}</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter Email" name="credentials" value="{{ old('credentials') }}">
                            </div>
                            
                            <div class="form-group mb-4 show_hide_password">
                                <label for="password">{{ __("Password") }}</label>
                                <input type="password" required class="form-control" name="password" placeholder="Password">
                                <span class="show-pass profile" role="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>

                            <a href="{{ setRoute('user.password.forgot') }}" class="account-forgot-btn">{{ __("Forgot Password?") }}</a>

                            <button type="submit" class="btn--base w-100 text-center mt-2">{{ __("Login") }}</button>

                            @if ($basic_settings->user_registration)
                                <p class="d-block text-center mt-5 create-acc">
                                    &mdash; {{ __("Don't have an account?") }}
                                    <a href="{{ route('user.register') }}">{{ __("Register") }}</a>
                                    &mdash;
                                </p>
                            @endif
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Login 
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @include('frontend.sections.newsletter')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    @include('frontend.partials.footer')

@endsection

@push('script')
@endpush