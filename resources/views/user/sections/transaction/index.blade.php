@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')
    <div class="table-content">

        <div class="row">

            <div class="header-title">
                <!-- table -->
                <div class="table-area pt-20 pb-30">
                    <div class="dash-section-title mb-30">
                        <h4>{{ __("Latest Transactions History") }}</h4>
                    </div>

                    <div class="accordion" id="accordionTransaction">
                        @include('user.components.transaction.log',[
                            'logs'      => $transaction_logs,
                        ])
                    </div>

                    @if (count($transaction_logs) == 0)
                        <div class="alert alert-warning text-center">{{ __("No data found!") }}</div>
                    @endif

                    <!-- pagination -->
                    {{ get_paginate($transaction_logs) }}
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')

@endpush