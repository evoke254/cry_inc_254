@php
    $client_feedback_section    = $__website_sections->where('key',Str::slug(site_section_const()::CLIENT_FEEDBACK_SECTION))->first();
    $app_local_lang             = get_default_language_code();
@endphp

@if ($client_feedback_section)

    <section class="client ptb-60">
        <div class="container mx-auto">
            <div class="text-content text-center">
                <span class="sub-title">{{ $client_feedback_section?->value?->language?->$app_local_lang?->heading ?? "" }}</span>
                <h3>{{ $client_feedback_section?->value?->language?->$app_local_lang?->sub_heading ?? "" }}</h3>
            </div>

            <div class="row pt-40">
                <div class="col-12">
                    <div class="client-slider mt-2 overflow-hidden">
                        <div class="swiper-wrapper">
                            @foreach ($client_feedback_section?->value?->items ?? [] as $item)
                                <div class="swiper-slide">
                                    <div class="d-flex flex-wrap card">
                                        <div class="small-ratings">
                                            @if ($item?->star ?? false)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i > $item?->star)
                                                        <i class="fa fa-star un-rating"></i>
                                                    @else
                                                        <i class="fa fa-star"></i>
                                                    @endif
                                                @endfor
                                            @endif
                                        </div>
                                        <div class="client-content">
                                            <p>{{ $item?->language?->$app_local_lang?->comment ?? "" }}</p>
                                        </div>
                                        <div class="client-thumb d-flex mt-5">
                                            <div class="client-thumb-wrapper me-3">
                                                <img src="{{ get_image($item?->image ?? null,"site-section") }}" alt="client">
                                            </div>
                                            <div>
                                                <h3>{{ $item?->name ?? "" }}</h3>
                                                <p class="sub">{{ $item?->designation ?? "" }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif