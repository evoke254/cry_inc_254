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
                        <h3 class="pb-2 text-capitalize fw-bold">{{ __("Reset Your Password") }}</h3>
                        <span class="text-warning">{{ __("Take control of your account by resetting your password.") }}</span>
                    </div>
                    <form action="{{ setRoute('user.password.reset',$token) }}" method="POST">
                        @csrf

                        <div class="form-group mb-4 show_hide_password">
                            <label for="password">{{ __("New Password") }}</label>
                            <input type="password" required class="form-control" name="password" placeholder="Enter Password">
                            <span class="show-pass profile" role="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                        </div>

                        <div class="form-group mb-4 show_hide_password">
                            <label for="password">{{ __("Confirm Password") }}</label>
                            <input type="password" required class="form-control" name="password_confirmation" placeholder="Enter Confirm Password">
                            <span class="show-pass profile" role="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                        </div>

                        <button type="submit" class="btn--base w-100 text-center mt-2">{{ __("Reset") }}</button>
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