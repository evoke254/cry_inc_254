@php
    $services_section    = $__website_sections->where('key',Str::slug(site_section_const()::SERVICES_SECTION))->first();
    $app_local_lang     = get_default_language_code();
@endphp

@isset($services_section)
    <section class="services ptb-60">
        <div class="container mx-auto">
            <div class="text-content text-center">
                <span class="sub-title">{{ $services_section?->value->language?->$app_local_lang?->heading ?? "" }}</span>
                <h3>{{ $services_section?->value->language?->$app_local_lang?->sub_heading ?? "" }}</h3>
            </div>
            <div class="row g-5 pt-40">
                @foreach ($services_section?->value?->items ?? [] as $item)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card">
                            <div class="thumb">
                                <i class="{{ $item?->icon ?? "" }}" style="font-size: 30px; margin-bottom: 15px;"></i>
                            </div>
                            <div>
                                <h3>{{ $item?->language?->$app_local_lang?->title ?? "" }}</h3>
                                <p>{{ $item?->language?->$app_local_lang?->description ?? "" }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endisset
