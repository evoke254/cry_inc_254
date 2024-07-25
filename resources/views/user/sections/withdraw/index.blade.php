@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')
    @if ($money_out_settings?->c_balance == false && $money_out_settings?->p_balance == false)
        <div class="form-error text-warning mb-4 text-center"> {{ __("Withdraw service is temporary unavailable. If you have any queries, feel free to contact support. Thanks") }} </div>
    @else

        <div class="send-add-form row g-4">
            <div class="col-lg-8 col-md-8 col-12 form-area">
                <div class="add-money-text pb-20">
                    <h4>{{ __("Withdraw") }}</h4>
                </div>
                <form class="row g-4" method="POST" action="{{ setRoute('user.withdraw.submit') }}">
                    @csrf

                    <div class="col-12">
                        <h3 class="fs-6 p-0">{{ __("Balance Type") }}</h3>
                        <div class="">
                            @php
                                $old_wallet_type = old('wallet_type');
                            @endphp
                            <select class="form-control select-item-2 py-0 w-100 nice-select" name="wallet_type">
                                <option selected disabled>Choose One</option>

                                @if ($money_out_settings?->c_balance == true)
                                    <option value="c_balance" @if ($old_wallet_type == 'c_balance') @selected(true) @endif>{{ __("Wallet Balance") }}</option>
                                @endif

                                @if ($money_out_settings?->p_balance == true)
                                    <option value="p_balance" @if ($old_wallet_type == 'p_balance') @selected(true) @endif>{{ __("Profit Balance") }}</option>
                                @endif

                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <h3 class="fs-6 p-0">{{ __("Payment Gateway") }}</h3>
                        <div class="">
                            @php
                                $old_payment_gateway = old('payment_gateway');
                            @endphp
                            <select class="form-control select-item-2 py-0 w-100 nice-select" name="payment_gateway">
                                <option selected disabled>Select Gateway</option>
                                @foreach ($payment_gateways as $item)
                                    <option value="{{ $item->alias }}" data-item="{{ json_encode($item->currencies()->select(['name','rate','currency_code','percent_charge','fixed_charge','min_limit','max_limit'])->first()) }}" @if ($old_payment_gateway == $item->alias) @selected(true) @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="row">
                            <h3 class="fs-6">{{ __("Amount_WEB") }}</h3>
                            <div class="col-lg-12">
                                <input type="text" class="form-control number-input" maxlength="20" id="input1" name="amount" placeholder="Enter Amount" value="{{ old('amount') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 mt-5">
                        <button type="submit" class="btn--base w-100 text-center">{{ __("Proceed_WEB") }}</button>
                    </div>
                </form>
            </div>

            <div class="col-lg-4 col-md-4 col-12">
                <div class="col-12 preview">
                    <div class="row">
                        <h3>{{ __("Preview_WEB") }}</h3>

                        <div class="py-3">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h4>{{ __("Withdraw Amount") }}</h4>
                                <h4 class="withdraw-amount">--</h4>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h4>{{ __("Exchange Rate_WEB") }}</h4>
                                <h4 class="exchange-rate">--</h4>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h4>{{ __("Fees_WEB") }}</h4>
                                <h4 class="total-charges">--</h4>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h4>{{ __("Will Get") }}</h4>
                                <h4 class="will-get">--</h4>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h4>{{ __("Total Payable_WEB") }}</h4>
                                <h4 class="payable">--</h4>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @endif
@endsection

@push('script')
    <script>

        let default_currency_code = "{{ get_default_currency_code() }}";

        let precision = "{{ $basic_settings->precision ?? 2 }}";

        $("select[name=payment_gateway]").change(function() {
            run();
        });

        $("input[name=amount]").keyup(function() {
            run();
        });

        function run() {
            let paymentGatewaySelect = $("select[name=payment_gateway]");
            let gatewaySelectedValue = paymentGatewaySelect.val();

            if(gatewaySelectedValue == null || gatewaySelectedValue == "") return false;

            let amount = $("input[name=amount]").val();

            let gatewayCurrency = JSON.parse(paymentGatewaySelect.find(":selected").attr("data-item"));

            (amount == null || amount == "" || !$.isNumeric(amount)) ? amount = 0 : amount = amount;

            $(".withdraw-amount").text(`${parseFloat(amount).toFixed(precision)} ${default_currency_code}`);

            let fixedCharge         = gatewayCurrency.fixed_charge ?? 0;
            let percentCharge       = gatewayCurrency.percent_charge ?? 0;
            let minLimit            = gatewayCurrency.min_limit ?? 0;
            let maxLimit            = gatewayCurrency.max_limit ?? 0;
            let rate                = gatewayCurrency.rate ?? 1;
            let gatewayCurrencyCode = gatewayCurrency.currency_code ?? "-";

            $(".exchange-rate").text(`1.00 ${default_currency_code} = ${parseFloat(rate).toFixed(precision)} ${gatewayCurrencyCode}`);

            let fixedChargeCalc = (parseFloat(fixedCharge) / parseFloat(rate)); // default currency fixed charge
            let percentChargeCalc = ((((parseFloat(amount) * parseFloat(rate)) / 100) * parseFloat(percentCharge)) / parseFloat(rate));

            let totalCharge = parseFloat(fixedChargeCalc) + parseFloat(percentChargeCalc) // total charge in default currency
            $(".total-charges").text(`${parseFloat(totalCharge).toFixed(precision)} ${default_currency_code}`);

            let willGet = parseFloat(amount) * parseFloat(rate); // get amount with gateway currency

            $('.will-get').text(`${parseFloat(willGet).toFixed(precision)} ${gatewayCurrencyCode}`);

            let totalPayable = parseFloat(amount) + parseFloat(totalCharge);
            $(".payable").text(`${parseFloat(totalPayable).toFixed(precision)} ${default_currency_code}`);

        }
    </script>
@endpush