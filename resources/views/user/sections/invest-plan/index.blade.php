@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')
    <div class="row g-5 ptb-40">

        @forelse ($investment_plans as $item)
            <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                <div class="pricing-card text-center">
                    <div class="top-text">
                        <h3>{{ $item->name }}</h3>
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
                        <p><i class="la la-check"></i> {{ __("Profit Return Type") }} <span>{{ ucwords(strtolower(remove_speacial_char($item->profit_return_type," "))) }}</span></p>
                        <p><i class="la la-check"></i>{{ __("Maximum Investment") }} {{ $default_currency->symbol . get_amount($item->max_invest,null) }}</p>
                        <p><i class="la la-check"></i> {{ __("Fixed Profit") }} {{ $default_currency->symbol . get_amount($item->profit_fixed,null) }}</p>
                        <p><i class="la la-check"></i> {{ __("Percentage Profit") }} {{ get_amount($item->profit_percent,"%",2) }}</p>
                        <p><i class="la la-check"></i> {{ __("Just Click to Try This") }}</p>
                    </div>
                    <div class="mt-4">
                        <button class="btn--base choose-plan-btn" data-item='{{ json_encode($item->only(['name','duration','min_invest_requirement','profit_fixed','profit_percent','max_invest'])) }}' data-target="{{ $item->slug }}" data-invest-required="{{ $item->min_invest_requirement }}">{{ __("Choose Plan") }}</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-data-found alert alert-warning text-center">{{ __("No data found!") }}</div>
        @endforelse

    </div>

    {{-- Purchase Modal --}}
    <div id="purchase-step" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("Purchase Plan") }}</h5>
            </div>
            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="javascript:void(0)" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-10-none mt-3">

                        <div class="mb-4">
                            <div class="d-flex justify-content-between info">
                                <h3>{{ __("Plan") }}</h3>
                                <h3 class="plan-name"></h3>
                            </div>
                            <div class="d-flex justify-content-between info">
                                <h3>{{ __("Duration") }}</h3>
                                <h3 class="plan-duration"></h3>
                            </div>
                            <div class="d-flex justify-content-between info">
                                <h3>{{ __("Maximum Invest Amount") }}</h3>
                                <h3 class="plan-max-invest"></h3>
                            </div>
                            <div class="d-flex justify-content-between info">
                                <h3>{{ __("Fixed Profit") }}</h3>
                                <h3 class="plan-fixed-profit"></h3>
                            </div>
                            <div class="d-flex justify-content-between info">
                                <h3>{{ __("Percent Profit") }}</h3>
                                <h3 class="plan-percent-profit"></h3>
                            </div>
                        </div>
                        
                        <div class="col-12 form-group">
                            <label for="invest_amount">{{ __("Invest Amount*") }}</label>
                            <input type="text" class="form-control number-input" id="invest_amount" placeholder="Enter Invest Amount" name="invest_amount" value="{{ old('invest_amount') }}">
                        </div>
                        <div class="col-12 form-group">
                            <div class="form-check">
                                @php
                                    $privacy_policy_link = ($__website_privacy_policy) ?  route('frontend.useful.links',$__website_privacy_policy->slug) : "javascript:void(0)";
                                @endphp
                                <input type="checkbox" class="form-check-input p-2" id="exampleCheck1" name="agree" />
                                <label class="form-check-label ms-2 text-light" for="exampleCheck1">{{ __("I Have Agree With") }} <a href="{{ $privacy_policy_link }}" class="text--base">{{ __("Terms and Conditions") }}</a></label>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn--base btn-danger bg-danger modal-close border-0">{{ __("Cancel") }}</button>
                            <button type="submit" class="btn--base bg--info border-0">{{ __("Purchase") }}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>

        let precision = "{{ $basic_settings->precision ?? 2 }}";

        $(document).ready(function() {
            // openModalWhenError('purchase-step','#purchase-step');
        });

        let defaultCurrency = "{{ get_default_currency_code() }}";

        $(".choose-plan-btn").click(function() {
            let actionURL = "{{ setRoute('user.invest.plan.purchase') }}";
            let slug = $(this).data('target');
            actionURL = actionURL + `/${slug}`;
            $("#purchase-step").find("form").first().attr("action",actionURL).find("input[name=invest_amount]").val($(this).data("invest-required"));

            let data = $(this).data('item');

            $("#purchase-step").find(".plan-name").text(data?.name);
            $("#purchase-step").find(".plan-duration").text(data?.duration + " Days");
            $("#purchase-step").find(".plan-max-invest").text(removeTrailingZeros(parseFloat(data?.max_invest ?? 0).toFixed(precision)) + " " + defaultCurrency);
            $("#purchase-step").find(".plan-fixed-profit").text(removeTrailingZeros(parseFloat(data?.profit_fixed ?? 0).toFixed(precision)) + " " + defaultCurrency);
            $("#purchase-step").find(".plan-percent-profit").text(removeTrailingZeros(parseFloat(data?.profit_percent ?? 0).toFixed(2)) + "%");

            openModalBySelector("#purchase-step");
        });
    </script>
@endpush