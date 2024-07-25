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
                        <h3 class="pb-2 text-capitalize fw-bold">{{ __("Reset Your Forgotten Password") }}</h3>
                        <span class="text-light">{{ __("Take control of your account by resetting your password. Our password recovery page guides you through the necessary steps to securely reset your password.") }}</span>
                    </div>
                    <form action="{{ setRoute('user.password.forgot.send.code') }}" method="POST">
                        @csrf
                        <div class="form-group col-12">
                            <label for="firstname">{{ __("Email") }}</label>
                            <input type="email" class="form-control" name="credentials" placeholder="Enter Email" value="{{ old('credentials') }}">
                        </div>
                        <button type="submit" class="btn--base w-100 text-center mt-2">{{ __("Send Code") }}</button>
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