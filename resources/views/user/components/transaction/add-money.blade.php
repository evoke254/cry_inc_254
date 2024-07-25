@isset($transaction)
    <div class="accordion-item">
        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $transaction->id }}" aria-expanded="true" aria-controls="collapse-{{ $transaction->id }}">
            <div class="card-text">
                <div class="d-sm-flex d-sm-block justify-content-between">
                    <div class="d-flex">
                        <i class="las la-dot-circle my-auto fs-3 me-4"></i>
                        <div class="">
                            <h4 class="text-capitalize text-white">{{ $transaction->creator->full_name }}</h4>
                            <span>{{ $transaction->created_at->format("H.iA - M-d-Y") }}</span>
                            <br>
                            <span class="fs-6 pt-1 fw-bold">{{ $transaction->string_status->value }}</span>
                            <span class="badge badge-success">{{ __("Add Money") }}</span>
                        </div>
                    </div>

                    <div class="my-auto text-sm-end pt-sm-0 pt-3 ps-sm-0 ps-5">
                        <span class="text-white fs-6 fw-lighter pb-2">{{ __("TRX") }} - {{ $transaction->trx_id }}</span>
                        @if ($transaction->user_id == auth()->user()->id)
                            <br>
                            <span class="text-white fs-5 pb-2">{{ get_amount($transaction->request_amount,$transaction->request_currency)  }}</span>
                        @endif
                        <br>
                        <span class="text-white">{{ get_amount($transaction->total_payable,$transaction->payment_currency) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="collapse-{{ $transaction->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionTransaction">
            <div class="accordion-body acc">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h4>{{ __("Transaction Type:") }}</h4>
                        <h4>{{ ucwords(strtolower(remove_speacial_char($transaction->type," "))) }}</h4>
                    </div>
                </div>
                <hr>
                @if ($transaction->user_id == auth()->user()->id)
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("Request Amount:") }}</h4>
                            <h4>{{ get_amount($transaction->request_amount,$transaction->request_currency) }}</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("Exchange Rate:") }}</h4>
                            <h4>{{ get_amount(1,$transaction->request_currency) . " = " . get_amount($transaction->exchange_rate,$transaction->payment_currency) }}</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("Fees:") }}</h4>
                            <h4>{{ get_amount($transaction->total_charge,$transaction->request_currency) }}</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("Pay In Total:") }}</h4>
                            <h4>{{ get_amount($transaction->total_payable,$transaction->payment_currency) }}</h4>
                        </div>
                    </div>
                    <hr>
                @endif
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h4>{{ __("Received Amount:") }}</h4>
                        <h4>{{ get_amount($transaction->receive_amount,$transaction->request_currency) }}</h4>
                    </div>
                </div>
                <hr>
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h4>{{ __("Status:") }}</h4>
                        <h4>{{ $transaction->string_status->value }}</h4>
                    </div>
                </div>
                <hr>

                @if ($transaction->gateway_currency->gateway->isTatum($transaction->gateway_currency->gateway) && $transaction->status == payment_gateway_const()::STATUSWAITING)
                    <div class="col-12">
                        <form action="{{ setRoute('user.add.money.payment.crypto.confirm', $transaction->trx_id) }}" method="POST">
                            @csrf
                            @php
                                $input_fields = $transaction->details->payment_info->requirements ?? [];
                            @endphp

                            @foreach ($input_fields as $input)
                                <div class="">
                                    <h4 class="mb-0">{{ $input->label }}</h4>
                                    <input type="text" class="form-control" name="{{ $input->name }}" placeholder="{{ $input->placeholder ?? "" }}">
                                </div>
                            @endforeach

                            <div class="text-end">
                                <button type="submit" class="btn--base my-2">{{ __("Process") }}</button>
                            </div>

                        </form>
                    </div>
                @endif

                <hr>
                @if ($transaction->status == payment_gateway_const()::STATUSREJECTED)
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <h4>{{ __("Reject Reason:") }}</h4>
                            <h4>{{ $transaction->reject_reason }}</h4>
                        </div>
                    </div>
                    <hr>
                @endif
            </div>
        </div>
    </div>
@endisset