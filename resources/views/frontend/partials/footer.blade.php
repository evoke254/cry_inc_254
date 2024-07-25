@php
    $footer_section       = $__website_sections->where('key',Str::slug(site_section_const()::FOOTER_SECTION))->first();
    $app_local_lang             = get_default_language_code();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Footer 
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <footer class="footer-section">
        <div class="container mx-auto">
            <div class="footer-content pt-100 pb-30">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                            <div class="footer-text">
                                <img src="{{ get_logo() }}" alt="image">
                                <p>{{ $footer_section?->value?->contact?->language?->$app_local_lang?->contact_desc ?? null }}</p>

                                <div class="lang-select">

                                    <select class="form--control nice-select" name="lang_switcher">
                                        @foreach ($__languages as $__item)
                                            <option value="{{ $__item->code }}" @if ($app_local_lang == $__item->code)
                                                @selected(true)
                                            @endif>{{ $__item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>{{ __("Useful Links") }}</h3>
                            </div>
                            <ul>
                                @foreach ($__website_useful_link as $item)
                                    <li><a href="{{ route('frontend.useful.links',$item->slug) }}">{{ $item->title?->language?->$app_local_lang?->title ?? "" }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>{{ __("Download App") }}</h3>
                            </div>
                            <ul>
                                <li><a href="{{ $__app_settings->android_url ?? "javascript:void(0)" }}" class="app-img"><img src="{{ asset('public/frontend/images/app/play_store.png') }}" alt="app"></a></li>
                                <li><a href="{{ $__app_settings->iso_url ?? "javascript:void(0)" }}" class="app-img"><img src="{{ asset('public/frontend/images/app/app_store.png') }}" alt="app"></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mb-50">
                        <div class="footer-widget">
                            <div class="footer-widget-heading contact">
                                <h3>{{ __("Contact Us") }}</h3>
                                <p>{{ $footer_section?->value?->contact?->address ?? "" }}</p>
                                <p>{{ __("Contact Us:") }} {{ $footer_section?->value?->contact?->phone ?? "" }}</p>
                            </div>
                            <div class="footer-social-icon mt-4">
                                @foreach ($footer_section?->value?->contact?->social_links ?? [] as $item)
                                    <a href="{{ $item?->link ?? "javascript:void(0)" }}" target="_blank"><i class="facebook-bg {{ $item?->icon ?? "" }}"></i></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center text-lg-left">
                        <div class="copyright-text">
                            <p>{{ __("Copyright") }} &copy; {{ date("Y") }}, {{ __("All Right Reserved") }} <a href="{{ setRoute('frontend.index') }}" class="text--base">{{ $basic_settings->site_name }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Footer 
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@push('script')
    <script>
        $("select[name=lang_switcher]").change(function(){
            var selected_value = $(this).val();
            var submitForm = `<form action="{{ setRoute('frontend.languages.switch') }}" id="local_submit" method="POST"> @csrf <input type="hidden" name="target" value="${$(this).val()}" ></form>`;
            $("body").append(submitForm);
            $("#local_submit").submit();
        });
    </script>
@endpush