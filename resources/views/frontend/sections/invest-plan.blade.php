@php
    $investment_plans       = $__invest_plans;
    $app_local_lang         = get_default_language_code();
@endphp


@if ($investment_plans->count() > 0)
    <section class="pricing {{ $section_class ?? "ptb-60" }}">
        <div class="container mx-auto">
            <div class="text-content text-center">
                <span class="sub-title">{{ __("pricing plan") }}</span>
                <h3>{{ __('Best Plan for you') }}</h3>
            </div>

            <div class="row g-5 ptb-40 justify-content-center">

                @foreach ($investment_plans as $item)
                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12">
                        <div class="pricing-card text-center">
                            <div class="top-text">
                                <h3>{{ __($item->name) }}</h3>
                            </div>
                            <div class="amount">
                                @if ($item->min_invest_offer > 0)
                                    {{-- Have Offer --}}
                                    <p>
                                        <span>{{ __("from") }} /</span>
                                        <del>{{ $default_currency->symbol . get_amount($item->min_invest,null) }}</del>
                                        <span>{{ $default_currency->symbol . get_amount($item->min_invest_offer,null) }}</span>
                                    </p>
                                @else
                                    <p><span>{{ __("from") }} /</span>{{ $default_currency->symbol . get_amount($item->min_invest,null) }}</p>
                                @endif
                            </div>
                            <div class="details">
                                <p><i class="la la-check"></i> {{ __("Duration") }} <span>{{ $item->duration }} {{ __("Days") }}</span></p>
                                <p><i class="la la-check"></i> {{ __("Profit Return Type") }} <span>{{ __(ucwords(strtolower(remove_speacial_char($item->profit_return_type," ")))) }}</span></p>
                                <p><i class="la la-check"></i>{{ __("Maximum Investment") }} {{ $default_currency->symbol . get_amount($item->max_invest,null) }}</p>
                                <p><i class="la la-check"></i> {{ __("Fixed Profit") }} {{ $default_currency->symbol . get_amount($item->profit_fixed,null) }}</p>
                                <p><i class="la la-check"></i> {{ __("Percentage Profit") }} {{ get_amount($item->profit_percent,"%",2) }}</p>
                                <p><i class="la la-check"></i> {{ __("Just Click to Try This") }}</p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ setRoute('user.invest.plan.index') }}" class="btn--base choose-plan-btn">{{ __("Choose Plan") }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endif