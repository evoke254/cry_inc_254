@php
    $app_local_lang             = get_default_language_code();
@endphp


@extends('frontend.layouts.master')

@section('content')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Blog
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <section class="blog-details pt-150 pb-60">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-lg-8">
                    <div class="right-content">
                        <img src="{{ get_image($announcement?->data?->image ?? null,'site-section') }}" alt="image">
                        <h3>{{ $announcement?->data?->language?->$app_local_lang?->title ?? "" }}</h3>
                        <div class="details">
                            <p>{!! $announcement?->data?->language?->$app_local_lang?->description ?? "" !!}</p>
                        </div>
                        <div class="hr"></div>
                        <div class="tag">
                            @foreach ($announcement?->data?->language?->$app_local_lang?->tags ?? [] as $item)
                                <a href="javascript:void(0)">{{ $item }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 left-content pt-lg-0 pt-md-0 pt-3">
                    <h3>{{ __("Recent Posts") }}</h3>
                    <div class="hr"></div>
                    <div>
                        @foreach ($recent_posts as $item)
                            <div class="d-flex mb-4">
                                <div class="recent-post-thumb me-3">
                                    <img src="{{ get_image($item?->data?->image ?? null, 'site-section') }}" alt="image">
                                </div>
                                <a href="{{ setRoute('frontend.announcement.details',$item?->slug) }}">
                                    <p>{{ $item->category->name?->language?->$app_local_lang?->name ?? "" }}</p>
                                    <h4>{{ Str::words($item?->data?->language?->$app_local_lang?->title ?? "", 10, '...') }}</h4>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Blog
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @include('frontend.sections.newsletter')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection