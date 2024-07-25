@extends('admin.layouts.master')

@push('css')

@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Investment Plan")])
@endsection

@section('content')

    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("Investment Plan") }}</h5>
                <div class="table-btn-area">
                    {{-- @include('admin.components.search-input',[
                        'name'  => 'plan_search',
                    ]) --}}
                    @include('admin.components.link.add-default',[
                        'text'          => "Create Plan",
                        'href'          => setRoute('admin.invest.plan.create'),
                        'permission'    => "admin.invest.plan.create", 
                    ])
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __("Name") }}</th>
                            <th>{{ __("Title") }}</th>
                            <th>{{ __("Duration") }}</th>
                            <th>{{ __("Profit Return Type") }}</th>
                            <th>{{ __("Min Invest") }}</th>
                            <th>{{ __("Min Invest (Offer)") }}</th>
                            <th>{{ __("Max Invest") }}</th>
                            <th>{{ __("Profit (Fixed)") }}</th>
                            <th>{{ __("Profit (%)") }}</th>
                            <th>{{ __("Status") }}</th>
                            <th>{{ __("Created At") }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($investment_plans as $key => $item)
                            <tr>
                                <td>{{ ($investment_plans->perPage() * ($investment_plans->currentPage() - 1)) + ($key + 1) }}</td>
                                <td>{{ $item->name }}</td>
                                <td title="{{ $item->title }}">{{ Str::words($item->title, 4, '...') }}</td>
                                <td>{{ $item->duration }}</td>
                                <td>{{ $item->profit_return_type }}</td>
                                <td>{{ get_amount($item->min_invest,$default_currency->code) }}</td>
                                <td>{{ get_amount($item->min_invest_offer,$default_currency->code) }}</td>
                                <td>{{ get_amount($item->max_invest,$default_currency->code) }}</td>
                                <td>{{ get_amount($item->profit_fixed,$default_currency->code) }}</td>
                                <td>{{ get_amount($item->profit_percent,"%") }}</td>
                                <td>
                                    @include('admin.components.form.switcher',[
                                        'name'          => 'plan_status',
                                        'value'         => $item->status,
                                        'options'       => [__('Enable') => 1,__('Disable') => 0],
                                        'onload'        => true,
                                        'data_target'   => $item->id,
                                        'permission'    => "admin.plan.status.update",
                                    ])
                                </td>
                                <td>{{ $item->created_at->format("d-m-Y H:i A") }}</td>
                                <td>
                                    @include('admin.components.link.edit-default',[
                                        'href'          => setRoute('admin.invest.plan.edit',$item->slug),
                                        'class'         => "edit-modal-button",
                                        'permission'    => "admin.invest.plan.edit",
                                    ])
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 13])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ get_paginate($investment_plans) }}
    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            switcherAjax("{{ setRoute('admin.invest.plan.status.update') }}");
        });
    </script>
@endpush
