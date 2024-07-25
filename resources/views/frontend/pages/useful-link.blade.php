@php
    $app_local_lang     = get_default_language_code();  
@endphp

@extends('frontend.layouts.master')

@section('content')

    <section class="useful pt-150 pb-80">
        <div class="container mx-auto">
            {!! $useful_link->content?->language?->$app_local_lang->content ?? "" !!}
        </div>
    </section>

    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    @include('frontend.sections.newsletter')
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Subscribe
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection