@php
    $contact_section            = $__website_sections->where('key',Str::slug(site_section_const()::CONTACT_US_SECTION))->first();
    $app_local_lang             = get_default_language_code();
@endphp

@extends('frontend.layouts.master')

@section('content')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Contact
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="contact pt-150 pb-60">
        <div class="container mx-auto">
            <div class="text-content text-center">
                <span class="sub-title">{{ $contact_section?->value?->language?->$app_local_lang?->heading ?? "" }}</span>
                <h3>{{ $contact_section?->value?->language?->$app_local_lang?->sub_heading ?? "" }}</h3>
            </div>
            <div class="row g-5 ptb-60">
                <div class="col-lg-6 col-md-12 col-12 thumb-left mb-lg-0 mb-md-0 mb-4">
                    <div>
                        <img src="{{ get_image($contact_section?->value?->image ?? null, 'site-section') }}" alt="image">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 mt-md-5 my-auto mx-auto">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="">

                                <form class="contact-form" action="{{ setRoute('frontend.contact.message.send') }}" method="POST">
                                    @csrf
                                    <div class="row justify-content-center mb-10-none">
                                        <div class="col-xl-6 col-lg-6 col-md-12 form-group pb-3">
                                            <label for="name">{{ __("Full Name") }}*</label>
                                            <input type="text" name="name" class="form-control" placeholder="{{ __('Enter Your Name...') }}">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                            <label for="email">{{ __("Email") }}*</label>
                                            <input type="email" name="email" class="form-control" placeholder="{{ __('Enter Your Email...') }}">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 form-group pb-3">
                                            <label for="phone">{{ __("Phone") }}*</label>
                                            <input type="number" name="phone" class="form-control"
                                                placeholder="{{ __('Enter Your Numbe...') }}">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                            <label for="subject">{{ __("Subject") }}*</label>
                                            <input type="text" name="subject" class="form-control" placeholder="{{ __('Enter Your Subject...') }}">
                                        </div>
                                        <div class="col-lg-12 form-group">
                                            <label for="message">{{ __("Message") }}*</label>
                                            <textarea class="form-control text-area" name="message" placeholder="{{ __('Enter Your Message...') }}"
                                                rows="3"></textarea>
                                        </div>
                                        <div class="col-lg-12 form-group text-center">
                                            <button type="submit" class="btn--base mt-30 w-100">{{ __("Send Message") }}</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Contact
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @include('frontend.sections.newsletter')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection