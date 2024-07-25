@extends('admin.layouts.master')

@push('css')
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
            [
                'name' => __('Money Out Logs'),
                'url' => setRoute('admin.money.out.index'),
            ],
        ],
        'active' => __('Details'),
    ])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __($page_title) }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form">
                <div class="row align-items-center mb-10-none">
                    <div class="col-xl-4 col-lg-4 form-group">
                        <ul class="user-profile-list-two">
                            <li class="one">{{ __("Date:") }} <span>{{ $transaction->created_at->format("Y-m-d h:i A") }}</span></li>
                            <li class="two">{{ __("Transaction ID:") }} <span>{{ $transaction->trx_id }}</span></li>
                            <li class="three">{{ __("Sender Mail:") }} <span>{{ $transaction->creator->email }}</span></li>
                            <li class="four">{{ __("Reseiver Mail:") }} <span>{{ $transaction->receiver->email }}</span></li>
                            <li class="five">{{ __("Request Amount:") }} <span>{{ get_amount($transaction->request_amount,$transaction->creator_wallet->currency->code) }}</span></li>
                        </ul>
                    </div>
                    <div class="col-xl-4 col-lg-4 form-group">
                        <div class="user-profile-thumb">
                            <img src="{{ get_image($transaction->creator->image,'user-profile') }}" alt="payment">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 form-group">
                        <ul class="user-profile-list two">
                            <li class="one">{{ __("Charge:") }} <span>{{ get_amount($transaction->total_charge,$transaction->payment_currency) }}</span></li>
                            <li class="two">{{ __("After Charge:") }} <span>{{ get_amount($transaction->total_payable,$transaction->payment_currency) }}</span></li>
                            <li class="three">{{ __("Rate:") }} <span>1 {{ get_default_currency_code() }} = {{ get_amount($transaction->exchange_rate,$transaction->request_currency) }}</span></li>
                            <li class="four">{{ __("Receiver Will Get:") }} <span>{{ get_amount($transaction->receive_amount,$transaction->request_currency) }}</span></li>
                            <li class="five">{{ __("Status:") }} <span class="{{ $transaction->StringStatus->class }}">{{ $transaction->StringStatus->value }}</span></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script')
    <script>
        openModalWhenError("reject-modal","#reject-modal");
        $(".approve-btn").click(function(){
            var actionRoute = "{{ setRoute('admin.money.out.approve') }}";
            var target      = "{{ $transaction->trx_id }}";
            var message     = `{{ __('Are you sure to approve this') }} ({{ $transaction->trx_id }}) {{ __('transaction') }}.`;
            openDeleteModal(actionRoute,target,message,"{{ __('Approve') }}","POST", "{{ __('Close') }}");
        });
    </script>
@endpush
