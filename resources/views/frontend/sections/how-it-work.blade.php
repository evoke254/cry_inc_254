@php
    $how_it_work_section    = $__website_sections->where('key',Str::slug(site_section_const()::HOW_IT_WORK_SECTION))->first();
    $app_local_lang         = get_default_language_code();
@endphp

@isset($how_it_work_section)
    <section class="how-it-work ptb-60">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="left-side shadow-lg">
                        {!! $how_it_work_section?->value->language?->$app_local_lang?->content ?? "" !!}
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 my-auto mt-4 mt-lg-0 mt-md-4">
                    <div class="text-content">
                        <span class="sub-title">{{ $how_it_work_section?->value->language?->$app_local_lang?->heading ?? "" }}</span>
                        <h3>{{ $how_it_work_section?->value->language?->$app_local_lang?->sub_heading ?? "" }}</h3>
                    </div>
                    <div>
                        <p>{{ $how_it_work_section?->value->language?->$app_local_lang?->description ?? "" }}</p>
                    </div>

                    @if ($how_it_work_section?->value->language?->$app_local_lang?->button_name ?? false)
                        <div class="mt-30 how-it-work-btn-area">
                            <a 
                                href="{{ $how_it_work_section?->value->language?->$app_local_lang?->button_link ?? "" }}" 
                                class="btn--base me-3">
                                
                                {{ __($how_it_work_section?->value->language?->$app_local_lang?->button_name ?? "") }}
                            </a>
                        </div>
                    @endif

                    <div class="right-thumb">
                        <img src="{{ get_image($how_it_work_section?->value->image ?? null, 'site-section') }}" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endisset