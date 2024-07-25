@extends('layouts.master')

@push('css')
    
@endpush

@section('content')

    @include('frontend.partials.preloader')
    @include('frontend.partials.scroll-to-top')
    @include('frontend.partials.header')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Authorization
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="login pt-150 pb-80">
        <div class="container mx-auto">
            <div class="row justify-content-center">
                <div class="col-md-6 content">
                    <div class="my-4">
                        <h3 class="pb-2 text-capitalize fw-bold">{{ __("Account Authorization") }}</h3>
                        <span class="text-warning">{{ __("Need to verify your account. Please check your mail inbox/spam to get the authorization code.") }}</span>
                    </div>
                    <form action="{{ setRoute('user.authorize.mail.verify',$token) }}" method="POST">
                        @csrf
                        <div class="form-group col-12">
                            <label for="firstname">{{ __("OTP") }}</label>
                            <input type="number" class="form-control" name="code" placeholder="Enter OTP" value="{{ old('code') }}">
                        </div>
                        <button type="submit" class="btn--base w-100 text-center mt-2">{{ __("Verify") }}</button>

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
        End Authorization
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