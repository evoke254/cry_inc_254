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
        ],
        'active' => __('Refer Users'),
    ])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("All Refers") }}</h5>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Joined Date</th>
                            <th>Refers</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user->referUsers ?? [] as $key => $item)
                            <tr>
                                <td>
                                    <ul class="user-list">
                                        <li><img src="{{ $item->user->userImage }}" alt="user"></li>
                                    </ul>
                                </td>
                                <td><span>{{ $item->user->username }}</span></td>
                                <td>{{ $item->user->email }}</td>
                                <td>{{ $item->user->created_at->format("d-m-Y") }}</td>
                                <td>{{ $item->user->refer_users_count }}</td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 7])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
