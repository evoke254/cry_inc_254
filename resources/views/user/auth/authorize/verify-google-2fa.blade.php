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
                        <h3 class="pb-2 text-capitalize fw-bold">{{ __("Two Factor Authorization") }}</h3>
                        <span class="text-warning">{{ __("Please enter your authorization code to access dashboard.") }}</span>
                    </div>
                    <form action="{{ setRoute('user.authorize.google.2fa.submit') }}" method="POST">
                        @csrf
                        <div class="form-group col-12">
                            <label for="firstname">{{ __("Authorization Code") }}</label>
                            <input type="number" class="form-control" name="code" placeholder="Enter Authorization Code" value="{{ old('code') }}">
                        </div>
                        <button type="submit" class="btn--base w-100 text-center mt-2">{{ __("Authorize") }}</button>
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