@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')

    <div class="send-add-form row g-4">
        <div class="col-xxl-8 col-lg-12 col-12 form-area mb-40">
            <div class="add-money-text pb-20">
                <h4>{{ __("Add Money") }}</h4>
            </div>
            <form class="row g-4 submit-form" method="POST" action="{{ setRoute('user.add.money.submit') }}">
                @csrf
                <div class="col-12">
                    <h3 class="fs-6 p-0">{{ __("Payment Gateway") }}</h3>
                    <div class="">
                        <select class="form-control select-item-2 py-0 w-100 select2-basic" name="gateway_currency">
                            <option value="" selected disabled>Choose Gateway</option>
                            @foreach ($payment_gateways ?? [] as $gateway)
                                @foreach ($gateway->currencies as $currency)
                                    <option data-item="{{ $currency->getOnly(['currency_code','rate','min_limit','max_limit','percent_charge','fixed_charge','crypto'])->makeJson() }}" value="{{ $currency->alias }}">{{ $gateway->name . " " . $currency->currency_code }} @if ($gateway->isManual()) (Manual)@endif</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <div class="ps-4">
                        <h3 class="fs-6 fw-lighter py-1 text-capitalize limit-show">--</h3>
                        <h3 class="fs-6 fw-lighter text-capitalize charge-show">--</h3>
                        <h3 class="fs-6 fw-lighter text-capitalize exchange-rate-show">--</h3>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        <h3 class="fs-6">{{ __("Amount_WEB") }}</h3>
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" class="form-control select-input number-input" placeholder="{{ __('Enter Amount') }}" name="amount" maxlength="20">
                                <span class="input-group-text">{{ get_default_currency_code() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5">
                    <button type="submit" class="btn--base w-100 text-center">{{ __("Proceed_WEB") }}</button>
                </div>
            </form>
        </div>

        <div class="col-xxl-4 col-lg-12 col-12">
            <div class="col-12 preview">
                <div class="row">
                    <h3>{{ __("Preview_WEB") }}</h3>

                    <div class="py-3">
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("Request Amount") }}</h4>
                            <h4 class="enter-amount">--</h4>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("Exchange Rate_WEB") }}</h4>
                            <h4 class="exchange-rate">--</h4>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("Fees_WEB") }}</h4>
                            <h4 class="fees">--</h4>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("Total Payable_WEB") }}</h4>
                            <h4 class="payable">--</h4>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("You Will Get_WEB") }}</h4>
                            <h4 class="will-get">--</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
@endsection

@push('script')
    <script>
        let defaultCurrency = "{{ get_default_currency_code() }}";
        let precision = "{{ $basic_settings->precision ?? 2 }}";

        $("select[name=gateway_currency]").change(function() {
            var selectedItem = $(this).find(":selected");
            var currency = JSON.parse(selectedItem.attr("data-item"));

            run(currency);
        });

        $(".submit-form").submit(function(e) {
            e.preventDefault();
            let selectedCurrency = $("select[name=gateway_currency]").find(":selected");
            let result = false;
            if(selectedCurrency.length > 0) {
                result = run(selectedCurrency.attr("data-item"));
            }
            
            if(result == true) {
                $(this).find("button[type=submit]").click();
                $(this).unbind('submit').submit();
            }
        });

        function run(currency) {

            if(currency == "" || currency == null) {
                return false;
            }

            if(typeof currency == "string") {
                try {
                    currency = JSON.parse(currency);
                } catch (error) {
                    throwMessage('error',['Unaccepted Data Format!']);
                    return false;
                }
            }

            if(!$.isNumeric(currency.min_limit) || !$.isNumeric(currency.max_limit) || !$.isNumeric(currency.rate) || !$.isNumeric(currency.percent_charge) || !$.isNumeric(currency.fixed_charge)) {
                throwMessage('error',['Unaccepted Data Format!']);
                return false;
            }

            let enterAmount = $("input[name=amount]").val();
            (enterAmount == null || enterAmount == "") ? enterAmount = 0 : enterAmount = parseFloat(enterAmount);

            // get limit
            let minLimit = parseFloat(currency.min_limit);
            let maxLimit = parseFloat(currency.max_limit);

            // console.log(minLimit,maxLimit);
            $(".limit-show").text(`• Limit ${parseFloat(minLimit).toFixed(precision)} ${defaultCurrency} - ${parseFloat(maxLimit).toFixed(precision)} ${defaultCurrency}`);

            // get charges
            let percentChargeCalc = (((parseFloat(enterAmount) * parseFloat(currency.rate)) / 100) * parseFloat(currency.percent_charge) / parseFloat(currency.rate));

            let fixedChargeCalc = parseFloat(currency.fixed_charge);

            $(".charge-show").text(`• Charge ${parseFloat(fixedChargeCalc).toFixed(precision)} ${defaultCurrency} + ${parseFloat(currency.percent_charge).toFixed(2)}% `);

            let totalCharges = parseFloat(fixedChargeCalc) + parseFloat(percentChargeCalc);

            $(".exchange-rate-show").text(`• Rate 1.00 ${defaultCurrency} = ${removeTrailingZeros(parseFloat(currency.rate).toFixed(precision))} ${currency.currency_code}`);

            // Preview Section
            $(".enter-amount").text(`${parseFloat(enterAmount).toFixed(precision)} ${defaultCurrency}`);
            $(".fees").text(`${parseFloat(totalCharges).toFixed(precision)} ${defaultCurrency}`);

            let payable = (parseFloat(enterAmount) * parseFloat(currency.rate)) + (parseFloat(totalCharges) * parseFloat(currency.rate));

            // $(".payable").text(`${parseFloat(payable).toFixed(precision)} ${currency.currency_code}`);
            $(".payable").text(`${removeTrailingZeros(parseFloat(payable).toFixed(precision))} ${currency.currency_code}`);

            $(".will-get").text(`${parseFloat(enterAmount).toFixed(precision)} ${defaultCurrency}`);

            $(".exchange-rate").text(`1.00 ${defaultCurrency} = ${removeTrailingZeros(parseFloat(currency.rate).toFixed(precision))} ${currency.currency_code}`);

            return true;
        }

        $("input[name=amount]").keyup(function() {
            let selectedCurrency = $("select[name=gateway_currency]").find(":selected");
            if(selectedCurrency.length > 0) {
                run(selectedCurrency.attr("data-item"));
            }
        });

    </script>
@endpush