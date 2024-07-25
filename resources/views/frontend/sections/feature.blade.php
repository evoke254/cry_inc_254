@php
    $feature_section    = $__website_sections->where('key',Str::slug(site_section_const()::FEATURE_SECTION))->first();
    $app_local_lang     = get_default_language_code();
@endphp

@isset($feature_section)
    <section class="feature ptb-60">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 my-auto">
                    <div class="text-content">
                        <span class="sub-title">{{ $feature_section?->value?->language?->$app_local_lang?->heading ?? "" }}</span>
                        <h3>{{ $feature_section?->value?->language?->$app_local_lang?->sub_heading ?? "" }}</h3>
                    </div>
                    <div>
                        <p>{{ $feature_section?->value?->language?->$app_local_lang?->description ?? "" }}</p>
                    </div>
                    @if ($feature_section?->value?->language?->$app_local_lang?->button_name ?? false)
                        <div class="mt-30">
                            <a href="{{ $feature_section?->value?->language?->$app_local_lang?->button_link ?? "javascript:void(0)" }}" class="btn--base">{{ $feature_section?->value?->language?->$app_local_lang?->button_name ?? "" }}</a>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 col-md-12 col-12 mt-4 mt-lg-0 mt-md-0">
                    <div>
                        <img src="{{ get_image($feature_section?->value?->image ?? null, 'site-section') }}" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endisset