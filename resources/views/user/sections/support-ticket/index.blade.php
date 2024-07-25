@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')

    <div class="table-content">
        <div class="row">
            <div class="header-title">
                <!-- table -->
                <div class="table-area pt-20 pb-30">
                    <div class="d-flex justify-content-end align-items-center my-escrow">
                        <div>
                            <a href="{{ setRoute('user.support.ticket.create') }}" class="btn--base">{{ __("Create New Ticket") }}</a>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="table-area">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Ticket ID') }}</th>
                                            <th>{{ __('Subject') }}</th>
                                            <th>{{ __('Message') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Last Reply') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($support_tickets as $item)
                                            <tr>
                                                <td>#{{ $item->token }}</td>
                                                <td><span class="text--info">{{ $item->subject }}</span></td>
                                                <td>{{ Str::words($item->desc, 10, '...') }}</td>
                                                <td>
                                                    <span class="{{ $item->stringStatus->class }}">{{ __($item->stringStatus->value) }}</span>
                                                </td>
                                                <td>{{ $item->created_at->format("Y-m-d H:i A") }}</td>
                                                <td>
                                                    <a href="{{ route('user.support.ticket.conversation',encrypt($item->id)) }}" class="btn btn--base"><i class="las la-comment"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                            @include('admin.components.alerts.empty',['colspan' => 6,'class' => 'alert-warning'])
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ get_paginate($support_tickets) }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>

    </script>
@endpush