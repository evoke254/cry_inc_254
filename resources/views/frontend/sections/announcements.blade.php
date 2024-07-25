@php
    $announcements              = $__announcements;
    $announcement_section       = $__website_sections->where('key',Str::slug(site_section_const()::ANNOUNCEMENT_SECTION))->first();

    $app_local_lang             = get_default_language_code();
@endphp

<section class="blog pt-80">
    <div class="container mx-auto">
        <div class="text-content text-center">
            <span class="sub-title">{{ $announcement_section?->value?->language?->$app_local_lang?->heading ?? "" }}</span>
            <h3>{{ $announcement_section?->value?->language?->$app_local_lang?->sub_heading ?? "" }}</h3>
        </div>
        <div class="row g-5 ptb-40">
            @foreach ($announcements as $item)

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                        <div class="img-wrapper">
                            <img src="{{ get_image($item?->data?->image ?? null,'site-section') }}" class="img-fluid main-img" alt="image">
                        </div>
                        <div class="card-body">
                            <a href="{{ setRoute('frontend.announcement.details',$item?->slug) }}">
                                <h5 class="text-capitalize fw-bold fs-4 title">{{ Str::words($item?->data?->language?->$app_local_lang?->title ?? "", 8, '...') }}</h5>
                            </a>
                        </div>
                        <a href="{{ setRoute('frontend.announcement.details',$item?->slug) }}" class="btn--base w-100 mt-4">{{ __("Read More") }} <i class="las la-arrow-right"></i></a>
                    </div>
                </div>

            @endforeach

        </div>
    </div>
</section>