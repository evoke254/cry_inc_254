@extends('layouts.master')

@push('css')
    
@endpush

@section('content')

    @include('frontend.partials.preloader')
    @include('frontend.partials.scroll-to-top')
    @include('frontend.partials.header')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Register 
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="login pt-150 pb-80">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-md-6 d-grid my-auto py-5 login-img">
                    <img src="{{ asset("public/frontend/images/element/login-signup.png") }}" alt="Image" class="img-fluid">
                </div>

                <div class="col-md-6 content">
                    <div class="my-4">
                        <h3 class="pb-2 text-capitalize fw-bold">{{ __("Sign Up") }}</h3>
                    </div>
                    <form action="{{ setRoute('user.register.submit') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="form-group col-lg-6 col-md-12 col-12">
                                <label for="firstname">{{ __("First Name") }}</label>
                                <input type="text" class="form-control" name="firstname" placeholder="Enter First Name" value="{{ old('firstname') }}">
                            </div>
                            <div class="form-group col-lg-6 col-md-12 col-12">
                                <label for="lastname">{{ __("Last Name") }}</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter Last Name" value="{{ old('lastname') }}">
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="email">{{ __("Email") }}</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group mb-4 show_hide_password">
                            <label for="password">{{ __("Password") }}</label>
                            <input type="password" required class="form-control" name="password" placeholder="Password">
                            <button type="button" class="btn show-pass p-0 pe-2"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                        </div>
                        <div class="form-group col-12">
                            <label for="referralId">{{ __("Referral Code") }} ({{ __("Optional") }})</label>
                            <input type="text" class="form-control" name="refer" id="referralId" placeholder="Enter Referral Code" value="{{ old('refer', $refer) }}">
                        </div>
                        <button type="submit" class="btn--base w-100 text-center mt-2">{{ __("Register") }}</button>

                        <p class="d-block text-center mt-5 create-acc">
                            &mdash; {{ __("Already an account?") }}
                            <a href="{{ setRoute('user.login') }}">{{ __("Login") }}</a>
                            &mdash;
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Register 
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