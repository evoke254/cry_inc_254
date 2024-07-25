@isset($transaction)
    <div class="accordion-item">
        <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $transaction->id }}" aria-expanded="true" aria-controls="collapse-{{ $transaction->id }}">
            <div class="card-text">
                <div class="d-sm-flex d-sm-block justify-content-between">
                    <div class="d-flex">
                        <i class="las la-dot-circle my-auto fs-3 me-4"></i>
                        <div class="">
                            <h4 class="text-capitalize text-white">{{ __("Registration Bonus") }}</h4>
                            <span>{{ $transaction->created_at->format("H.iA - M-d-Y") }}</span>
                            <br>
                            <span class="fs-6 pt-1 fw-bold">{{ $transaction->string_status->value }}</span>
                            <span class="badge badge-success">{{ __("Bonus Added") }}</span>
                        </div>
                    </div>

                    <div class="my-auto text-sm-end pt-sm-0 pt-3 ps-sm-0 ps-5">
                        <span class="text-white fs-6 fw-lighter pb-2">{{ __("TRX") }} - {{ $transaction->trx_id }}</span>
                        <br>
                        <span class="text-white fs-5 pb-2">{{ get_amount($transaction->receive_amount,$transaction->request_currency)  }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="collapse-{{ $transaction->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionTransaction">
            <div class="accordion-body acc">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h4>{{ __("Transaction Type:") }}</h4>
                        <h4>{{ __("Registration Bonus") }}</h4>
                    </div>
                </div>
                <hr>
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h4>{{ __("Received Amount:") }}</h4>
                        <h4>{{ get_amount($transaction->receive_amount,$transaction->request_currency) }}</h4>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
@endisset