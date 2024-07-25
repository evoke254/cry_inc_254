@php
    $about_us_sections    = $__website_sections->where('key',Str::slug(site_section_const()::ABOUT_US_SECTION))->first();
    $app_local_lang     = get_default_language_code();
@endphp

@isset($about_us_sections)
    <section class="about ptb-60">
        <div class="container mx-auto">
            <div class="row">

                <div class="col-lg-6 col-md-12 col-12 mt-4 mt-lg-0 mt-md-0">
                    <div class="page-item-ele">
                        <img src="{{ get_image($about_us_sections?->value?->image ?? null,'site-section') }}" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12 my-auto">

                    <div class="text-content">
                        <span class="sub-title">{{ $about_us_sections?->value?->language?->$app_local_lang?->heading ?? "" }}</span>
                        <h3>{{ $about_us_sections?->value?->language?->$app_local_lang?->sub_heading ?? "" }}</h3>
                    </div>

                    <div class="about-item-area">
                        @foreach ($about_us_sections?->value?->items ?? [] as $item)
                            <div class="about-item">
                                <div class="about-icon">
                                    <i class="{{ $item?->icon ?? "" }}" style="font-size: 40px"></i>
                                </div>
                                <div class="about-content">
                                    <h3 class="title">{{ $item?->language?->$app_local_lang?->title ?? "" }}</h3>
                                    <p>{{ $item?->language?->$app_local_lang?->description ?? "" }}</p>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>
    </section>
@endisset
