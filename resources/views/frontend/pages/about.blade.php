@php
    $app_local_lang     = get_default_language_code();  
@endphp

@extends('frontend.layouts.master')

@section('content')

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start About
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @isset($about_page_section->value->items)
        <section class="about pt-150 pb-80">
            <div class="container mx-auto">
                <div class="row g-5">
                    @foreach ($about_page_section?->value?->items ?? [] as $item)
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="card-side">
                                <h3>{{ $item?->language?->$app_local_lang?->title ?? "" }}</h3>
                                <p>{{ $item?->language?->$app_local_lang?->description ?? "" }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endisset

    @isset($about_page_section)
        <section class="about ptb-60">
            <div class="container mx-auto">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12 mt-4 mt-lg-0 mt-md-0">
                        <div class="page-item-ele">
                            <img src="{{ get_image($about_page_section?->value?->image ?? null,'site-section') }}" alt="Image">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 my-auto">
                        <div class="text-content">
                            <span class="sub-title">{{ $about_page_section?->value?->language?->$app_local_lang?->heading ?? "" }}</span>
                            <h3>{{ $about_page_section?->value?->language?->$app_local_lang?->sub_heading ?? "" }}</h3>
                        </div>
                        <div>
                            <p>{{ $about_page_section?->value?->language?->$app_local_lang?->desc ?? "" }}</p>
                        </div>

                        @if ($about_page_section?->value?->language?->$app_local_lang?->button_name ?? false)
                            <div class="mt-4">
                                <a href="{{ $about_page_section?->value?->language?->$app_local_lang?->button_link ?? "javascript:void(0)" }}" class="btn--base">{{ $about_page_section?->value?->language?->$app_local_lang?->button_name ?? "" }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endisset
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End About
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @include('frontend.sections.newsletter')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection