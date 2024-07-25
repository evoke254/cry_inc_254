@php
    $brand_sections    = $__website_sections->where('key',Str::slug(site_section_const()::BRAND_SECTION))->first();
    $app_local_lang     = get_default_language_code();
@endphp

@isset($brand_sections)
    <section class="brand ptb-50">
        <div class="container mx-auto">
            <div class="brand-slider overflow-hidden">
                <div class="swiper-wrapper">

                    @foreach ($brand_sections?->value?->items ?? [] as $item)
                        <div class="swiper-slide">
                            <div class="brand-item">
                                <img src="{{ get_image($item?->image,'site-section') }}" alt="brand">
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endisset
