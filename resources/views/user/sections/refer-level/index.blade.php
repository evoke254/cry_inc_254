@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')
    <div class="table-content">
        <div class="row">
            <div>
                <div class="row justify-content-center mb-30-none">
                    <div class="col-xxl-5 col-xl-4 col-md-12 mb-30">
                        <div class="p-4 card-user h-100">
                            <div class="account-avatar-wrapper">
                                <div class="account-avatar">
                                    <img class=" d-block mx-auto avater" src="{{ get_image($auth_user->image,'user-profile') }}" alt="" height="200" width="200">
                                    <div class="avatar-level-badge">
                                        <span>{{ __($auth_user->referLevel?->title ?? "") }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div
                                    class="d-flex justify-content-between mt-4 rounded-2 p-2 user-card">
                                    <p class=" m-0 fw-bold">{{ __("Total Refers:") }}</p>
                                    <p class=" m-0 text--base">{{ $auth_user->referUsers->count() }}</p>
                                </div>
                                <div
                                    class="d-flex justify-content-between mt-4 rounded-2 p-2 user-card">
                                    <p class=" m-0 fw-bold">{{ __("Total Invested:") }}</p>
                                    <p class=" m-0 text--base">{{ get_amount($auth_user->investPlans->sum('invest_amount'), $default_currency?->code ?? "") }}</p>
                                </div>
                                <div
                                    class="d-flex justify-content-between mt-4 rounded-2 p-2 user-card">
                                    <p class=" m-0 fw-bold">{{ __("Current Position:") }}</p>
                                    <p class=" m-0">{{ $auth_user->referLevel?->title ?? "" }}</p>
                                </div>
                                <div
                                    class="d-flex justify-content-between mt-4 rounded-2 p-2 user-card">
                                    <p class=" m-0 fw-bold">{{ __("Refer code:") }}</p>
                                    <div class="refer-code-area">
                                        <p class=" m-0 copiable">{{ $auth_user->referral_id }}</p> 
                                        <button class="copy-button"><i class="las la-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="refer-link-wrapper">
                                <h4 class="title">{{ __("Refer Link_WEB") }}:</h4>
                                <span class="refer-link">{{ setRoute('user.register',$auth_user->referral_id) }}</span>
                                <ul class="refer-btn-list">
                                    <li>
                                        <button class="refer-btn copy-button">
                                            <i class="las la-link"></i>
                                        </button>
                                        <span class="d-none copiable">{{ setRoute('user.register',$auth_user->referral_id) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="level-progress-area">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7 col-xl-8 col-md-12 mb-30">
                        <div class="account-level-wrapper h-100">
                            <h3 class="title">{{ __("Account Level") }}</h3>
                            <div class="row mb-30-none">
                                @php
                                    $auth_user_earned_levels_ids = $auth_user->earnedLevels->pluck("referral_level_package_id")->toArray();
                                @endphp

                                @foreach ($referral_levels as $item)

                                    @php
                                        $current_refer_id = $auth_user->referLevel?->id ?? "";
                                    @endphp

                                    <div class="col-lg-4 col-md-4 col-sm-6 mb-30">
                                        <div class="account-level-item 
                                        @if ($current_refer_id == $item->id)
                                            curent
                                        @endif
                                        
                                        @if (!in_array($item->id,$auth_user_earned_levels_ids) && $current_refer_id != $item->id)
                                            off
                                        @endif
                                        ">
                                            <div class="account-level-header">
                                                <span>{{ $item->title }}</span>
                                            </div>
                                            <div class="content">
                                                <h6 class="level-title">{{ __("Requirement") }}</h6>
                                                <ul>
                                                    <li>{{ __("Refer:") }} <span>{{ $item->refer_user }}</span></li>
                                                    <li>{{ __("Invest:") }} <span>{{ get_amount($item->invested_amount,$default_currency?->code ?? "") }}</span></li>
                                                </ul>
                                                <h6 class="level-title">{{ __("Commission") }}</h6>
                                                <ul>
                                                <li>{{ __("Per Refer:") }} <span>{{ get_amount($item->commission, $default_currency?->code ?? "") }}</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- table -->
                <div class="table-area pt-40 pb-30">
                    <div class="d-flex justify-content-between align-items-center my-escrow">
                        <div class="dash-section-title">
                            <h4>{{ __("Referral Users") }}</h4>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <div class="table-area">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('User Name') }}</th>
                                            <th>{{ __('Refer Code') }}</th>
                                            <th>{{ __('Joined Date') }}</th>
                                            <th>{{ __('Referred Users') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($refer_users as $item)
                                            <tr>
                                                <td data-label="{{ __('User Name') }}">{{ $item->user->fullname }}</td>
                                                <td data-label="{{ __('Refer Code') }}">{{ $item->user->referral_id }}</td>
                                                <td data-label="{{ __('Joined Date') }}">{{ $item->user->created_at->format('d-m-Y') }}</td>
                                                <td data-label="{{ __('Referred Users') }}">{{ $item->user->referUsers->count() }}</td>
                                            </tr>
                                        @empty
                                            @include('admin.components.alerts.empty',['colspan' => 4])
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ get_paginate($refer_users) }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush