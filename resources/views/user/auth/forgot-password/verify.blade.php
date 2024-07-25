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
                        <h3 class="pb-2 text-capitalize fw-bold">{{ __("Please Enter the Code") }}</h3>
                        <span class="text-light">{{ __("We sent a 6-digit code to your email") }}</span>
                    </div>
                    <form action="{{ setRoute('user.password.forgot.verify.code',$token) }}" method="POST">
                        @csrf
                        <div class="form-group col-12">
                            <label for="firstname">{{ __("OTP Code") }}</label>
                            <input type="text" class="form-control" name="code" placeholder="Enter OTP Code" value="{{ old('code') }}">
                        </div>
                        <button type="submit" class="btn--base w-100 text-center mt-2">{{ __("Verify") }}</button>
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