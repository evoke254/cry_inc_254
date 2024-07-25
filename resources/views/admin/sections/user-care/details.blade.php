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
        'active' => __('User Care'),
    ])
@endsection

@section('content')
    <div class="dashboard-area">
        <div class="dashboard-item-area">
            <div class="row">
                @php
                    $success_pending_add_money = ($user_success_add_money + $user_pending_add_money);
                    $one_percent_of_add_Money = (($success_pending_add_money / 100) == 0) ? 1 : ($success_pending_add_money / 100);
                @endphp

                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Current Balance") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ $default_currency->symbol }} 
                                        {{ numeric_unit_converter(get_amount($user_wallet?->balance ?? 0,null))->number . 
                                        numeric_unit_converter(get_amount($user_wallet?->balance ?? 0,null))->unit }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Success") }} 
                                        {{ numeric_unit_converter(get_amount($user_success_add_money,null))->number . 
                                        numeric_unit_converter(get_amount($user_success_add_money,null))->unit }}
                                    </span>
                                    <span class="badge badge--warning">{{ __("Pending") }} 
                                        {{ numeric_unit_converter(get_amount($user_pending_add_money,null))->number . 
                                        numeric_unit_converter(get_amount($user_pending_add_money,null))->unit }}
                                    </span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart6" data-percent="{{ floor($user_pending_add_money / $one_percent_of_add_Money) }}"><span>{{ floor($user_pending_add_money / $one_percent_of_add_Money) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    @php
                        $total_send_receive = ($user_send_total + $user_receive_total);
                        $one_percent_of_send_receive = (($total_send_receive / 100) == 0) ? 1 : ($total_send_receive / 100);
                    @endphp
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Transactions") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ $default_currency->symbol }} {{ numeric_unit_converter(get_amount($user_total_transactions,null))->number . numeric_unit_converter(get_amount($user_total_transactions,null))->unit }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--danger">{{ __("Send") }} {{ numeric_unit_converter(get_amount($user_send_total,null))->number . numeric_unit_converter($user_send_total)->unit }}</span>
                                    <span class="badge badge--success">{{ __("Receive") }} {{ numeric_unit_converter(get_amount($user_receive_total,null))->number . numeric_unit_converter($user_receive_total)->unit }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart7" data-percent="{{ floor($user_receive_total / $one_percent_of_send_receive) }}"><span>{{ floor($user_receive_total / $one_percent_of_send_receive) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    @php
                        $total_money_out_cancel_pending = ($user_pending_money_out + $user_reject_money_out);
                        $one_percent_of_money_out = (($total_money_out_cancel_pending / 100) == 0) ? 1 : ($total_money_out_cancel_pending / 100);
                    @endphp
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Money Out") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ $default_currency->symbol }} {{ numeric_unit_converter(get_amount($user_money_out,null))->number . numeric_unit_converter(get_amount($user_money_out,null))->unit }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--danger">{{ __("Canceled") }} {{ numeric_unit_converter(get_amount($user_reject_money_out,null))->number . numeric_unit_converter(get_amount($user_reject_money_out,null))->unit }}</span>
                                    <span class="badge badge--warning">{{ __("Pending") }} {{ numeric_unit_converter(get_amount($user_pending_money_out,null))->number . numeric_unit_converter(get_amount($user_pending_money_out,null))->unit }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart8" data-percent="{{ floor($user_pending_money_out / $one_percent_of_money_out) }}"><span>{{ floor($user_pending_money_out / $one_percent_of_money_out) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    @php
                        $total_pending_solved_support_ticket = ($pending_support_ticket + $solved_support_ticket);
                        $one_percent_of_support_ticket = (($total_pending_solved_support_ticket / 100) == 0) ? 1 : ($total_pending_solved_support_ticket / 100);
                    @endphp
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __('Active Tickets') }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ $active_support_ticket }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--danger">{{ __("Pending") }} {{ $pending_support_ticket }}</span>
                                    <span class="badge badge--success">{{ __("Solved") }} {{ $solved_support_ticket }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart9" data-percent="{{ floor($pending_support_ticket / $one_percent_of_support_ticket) }}"><span>{{ floor($pending_support_ticket / $one_percent_of_support_ticket) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    @php
                        $total_invest_plan_complete_ongoing = ($ongoing_invest_plans + $complete_invest_plans);
                        $one_percent_of_invest_plan = (($total_invest_plan_complete_ongoing / 100) == 0) ? 1 : ($total_invest_plan_complete_ongoing / 100);
                    @endphp
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Invest Plan") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ numeric_unit_converter($total_invest_plans)->number . numeric_unit_converter($total_invest_plans)->unit }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Complete") }} {{ numeric_unit_converter(get_amount($complete_invest_plans,null))->number . numeric_unit_converter(get_amount($complete_invest_plans,null))->unit }}</span>
                                    <span class="badge badge--warning">{{ __("Ongoing") }} {{ numeric_unit_converter(get_amount($ongoing_invest_plans,null))->number . numeric_unit_converter(get_amount($ongoing_invest_plans,null))->unit }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart13" data-percent="{{ floor($ongoing_invest_plans / $one_percent_of_invest_plan) }}"><span>{{ floor($ongoing_invest_plans / $one_percent_of_invest_plan) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    @php
                        $total_invest_complete_ongoing = ($complete_invest_amount + $ongoing_invest_amount);
                        $one_percent_of_invest = (($total_invest_complete_ongoing / 100) == 0) ? 1 : ($total_invest_complete_ongoing / 100);
                    @endphp
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Invest Amount") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ $default_currency->symbol }} {{ numeric_unit_converter(get_amount($total_invest_amount,null))->number . numeric_unit_converter(get_amount($total_invest_amount,null))->unit }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Complete") }} {{ numeric_unit_converter(get_amount($complete_invest_amount,null))->number . numeric_unit_converter(get_amount($complete_invest_amount,null))->unit }}</span>
                                    <span class="badge badge--warning">{{ __("Ongoing") }} {{ numeric_unit_converter(get_amount($ongoing_invest_amount,null))->number . numeric_unit_converter(get_amount($ongoing_invest_amount,null))->unit }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart10" data-percent="{{ floor($complete_invest_amount / $one_percent_of_invest) }}"><span>{{ floor($complete_invest_amount / $one_percent_of_invest) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Profit Amount") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ $default_currency->symbol }} {{ numeric_unit_converter(get_amount($total_profit_amount,null))->number . numeric_unit_converter(get_amount($total_profit_amount,null))->unit }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Success") }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart11" data-percent="100"><span>100%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    @php
                        $total_money_transfer_complete_pending = ($pending_money_transfer + $success_money_transfer);
                        $one_percent_of_money_transfer = (($total_money_transfer_complete_pending / 100) == 0) ? 1 : ($total_money_transfer_complete_pending / 100);
                    @endphp
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Money Transfer") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ $default_currency->symbol }} {{ numeric_unit_converter(get_amount($total_money_transfer,null))->number . numeric_unit_converter(get_amount($total_money_transfer,null))->unit }}</h2>
                                </div>
                                <div class="user-badge">
                                    <span class="badge badge--success">{{ __("Complete") }} {{ numeric_unit_converter(get_amount($success_money_transfer,null))->number . numeric_unit_converter(get_amount($success_money_transfer,null))->unit }}</span>
                                    <span class="badge badge--warning">{{ __("Pending") }} {{ numeric_unit_converter(get_amount($pending_money_transfer,null))->number . numeric_unit_converter(get_amount($pending_money_transfer,null))->unit }}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="chart" id="chart12" data-percent="{{ floor($pending_money_transfer / $one_percent_of_money_transfer) }}"><span>{{ floor($pending_money_transfer / $one_percent_of_money_transfer) }}%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Refer Level") }}</h6>
                                <div class="user-info">
                                    <h5 class="user-count">{{ $user->referLevel?->title ?? "-" }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxxl-4 col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-15">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <div class="left">
                                <h6 class="title">{{ __("Total Refers") }}</h6>
                                <div class="user-info">
                                    <h2 class="user-count">{{ $user->refer_users_count }}</h2>
                                </div>
                            </div>
                            <div class="right">
                                <a href="{{ setRoute('admin.users.refers',$user->username) }}" class="btn--base bg--primary">{{ __("View All") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-card mt-15">
        <div class="card-header">
            <h6 class="title">{{ __("User Overview") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form">
                <div class="row align-items-center mb-10-none">
                    <div class="col-xl-4 col-lg-4 form-group">
                        <div class="user-action-btn-area">
                            <div class="user-action-btn">
                                @include('admin.components.button.custom',[
                                    'type'          => "button",
                                    'class'         => "wallet-balance-update-btn bg--danger one",
                                    'text'          => "Add/Subtract Balance",
                                    'icon'          => "las la-wallet me-1",
                                    'permission'    => "admin.users.wallet.balance.update",
                                ])
                            </div>
                            <div class="user-action-btn">
                                @include('admin.components.link.custom',[
                                    'href'          => setRoute('admin.users.login.logs',$user->username),
                                    'class'         => "bg--base two",
                                    'icon'          => "las la-sign-in-alt me-1",
                                    'text'          => "Login Logs",
                                    'permission'    => "admin.users.login.logs",
                                ])
                            </div>
                            <div class="user-action-btn">
                                @include('admin.components.link.custom',[
                                    'href'          => "#email-send",
                                    'class'         => "bg--base three modal-btn",
                                    'icon'          => "las la-mail-bulk me-1",
                                    'text'          => "Send Email",
                                    'permission'    => "admin.users.send.mail",
                                ])
                            </div>
                            <div class="user-action-btn">
                                @include('admin.components.link.custom',[
                                    'class'         => "bg--base four login-as-member",
                                    'icon'          => "las la-user-check me-1",
                                    'text'          => "Login as Member",
                                    'permission'    => "admin.users.login.as.member",
                                ])
                            </div>
                            <div class="user-action-btn">
                                @include('admin.components.link.custom',[
                                    'href'          => setRoute('admin.users.mail.logs',$user->username),
                                    'class'         => "bg--base five",
                                    'icon'          => "las la-history me-1",
                                    'text'          => "Email Logs",
                                    'permission'    => "admin.users.mail.logs",
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 form-group">
                        <div class="user-profile-thumb">
                            <img src="{{ $user->userImage }}" alt="user">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 form-group">
                        <ul class="user-profile-list">
                            <li class="bg--base one">{{ __("Full Name:") }} <span>{{ $user->fullname }}</span></li>
                            <li class="bg--info two">{{ __("Username:") }} <span>{{ "@".$user->username }}</span></li>
                            <li class="bg--success three">{{ __("Email:") }} <span>{{ $user->email }}</span></li>
                            <li class="bg--warning four">{{ __("Status:") }} <span>{{ $user->stringStatus->value }}</span></li>
                            <li class="bg--danger five">{{ __("Last Login:") }} <span>{{ $user->lastLogin }}</span></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="custom-card mt-15">
        <div class="card-header">
            <h6 class="title">{{ __("Information of User") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="{{ setRoute('admin.users.details.update',$user->username) }}">
                @csrf
                <div class="row mb-10-none">
                    <div class="col-xl-6 col-lg-6 form-group">
                        @include('admin.components.form.input',[
                            'label'         => "First Name",
                            'label_after'   => '*',
                            'name'          => "firstname",
                            'value'         => old("firstname",$user->firstname),
                            'attribute'     => "required",
                            'placeholder'   => "Write Here...",
                        ])
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @include('admin.components.form.input',[
                            'label'         => "Last Name",
                            'label_after'   => '*',
                            'name'          => "lastname",
                            'value'         => old("lastname",$user->lastname),
                            'attribute'     => "required",
                            'placeholder'   => "Write Here...",
                        ])
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        <label>{{ __("Country") }}<span>*</span></label>
                        <select name="country" class="form--control select2-auto-tokenize country-select" data-placeholder="{{ __('Select Country') }}" data-old="{{ old('country',$user->address->country ?? "") }}"></select>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        <label>{{ __("Phone Number") }}<span>*</span></label>
                        <div class="input-group">
                            <div class="input-group-text phone-code">+{{ $user->mobile_code }}</div>
                            <input class="phone-code" type="hidden" name="mobile_code" value="{{ $user->mobile_code }}" />
                            <input type="text" class="form--control" placeholder="{{ __('Write Here...') }}" name="mobile" value="{{ old('mobile',$user->mobile) }}">
                        </div>
                        @error("mobile")
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @php
                            $old_state = old('state',$user->address->state ?? "");
                        @endphp
                        <label>{{ __("State") }}</label>
                        <select name="state" class="form--control select2-auto-tokenize state-select" data-placeholder="{{ __('Select State') }}" data-old="{{ $old_state }}">
                            @if ($old_state)
                                <option value="{{ $old_state }}" selected>{{ $old_state }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @php
                            $old_city = old('city',$user->address->city ?? "");
                        @endphp
                        <label>{{ __("City") }}</label>
                        <select name="city" class="form--control select2-auto-tokenize city-select" data-placeholder="{{ __('Select City') }}" data-old="{{ $old_city }}">
                            @if ($old_city)
                                <option value="{{ $old_city }}" selected>{{ $old_city }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @include('admin.components.form.input',[
                            'label'         => "Zip/Postal",
                            'name'          => "zip_code",
                            'placeholder'   => "Write Here...",
                            'value'         => old('zip_code',$user->address->zip ?? "")
                        ])
                    </div>
                    <div class="col-xl-6 col-lg-6 form-group">
                        @include('admin.components.form.input',[
                            'label'         => "Address",
                            'name'          => 'address',
                            'value'         => old("address",$user->address->address ?? ""),
                            'placeholder'   => "Write Here...",
                        ])
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                        @include('admin.components.form.switcher', [
                            'label'         => 'User Status',
                            'value'         => old('status',$user->status),
                            'name'          => "status",
                            'options'       => [__('Active') => 1, __('Banned') => 0],
                            'permission'    => "admin.users.details.update",
                        ])
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                        @include('admin.components.form.switcher', [
                            'label'         => 'Email Verification',
                            'value'         => old('email_verified',$user->email_verified),
                            'name'          => "email_verified",
                            'options'       => [__('Verified') => 1, __('Unverified') => 0],
                            'permission'    => "admin.users.details.update",
                        ])
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                        @include('admin.components.form.switcher', [
                            'label'     => '2FA Verification',
                            'value'     => old('two_factor_status',$user->two_factor_status),
                            'name'      => "two_factor_status",
                            'options'   => [__('Verified') => 1, __('Unverified') => 0],
                            'permission'    => "admin.users.details.update",
                        ])
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 form-group">
                        @include('admin.components.form.switcher', [
                            'label'     => 'KYC Verification',
                            'value'     => old('kyc_verified',$user->kyc_verified),
                            'name'      => "kyc_verified",
                            'options'   => [__('Verified') => 1, __('Unverified') => 0],
                            'permission'    => "admin.users.details.update",
                        ])
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 form-group mt-4">
                        @include('admin.components.button.form-btn',[
                            'text'          => "Update",
                            'permission'    => "admin.users.details.update",
                            'class'         => "w-100 btn-loading",
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Send Email Modal --}}
    @include('admin.components.modals.send-mail-user',compact("user"))

    {{-- User Balance Update Modal --}}
    @if (admin_permission_by_name("admin.users.wallet.balance.update"))
        <div id="wallet-balance-update-modal" class="mfp-hide large">
            <div class="modal-data">
                <div class="modal-header px-0">
                    <h5 class="modal-title">{{ __("Add/Subtract Balance") }}</h5>
                </div>
                <div class="modal-form-data">
                    <form class="modal-form" method="POST" action="{{ setRoute('admin.users.wallet.balance.update',$user->username) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-10-none">
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label for="balance">{{ __("Type") }}<span>*</span></label>
                                <select name="type" id="balance" class="form--control nice-select">
                                    <option disabled selected>{{ __("Select Type") }}</option>
                                    <option value="add">Balance Add</option>
                                    <option value="subtract">Balance Subtract</option>
                                </select>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                <label for="wallet">{{ __("User Wallet") }}<span>*</span></label>
                                <select name="wallet" id="wallet" class="form--control select2-auto-tokenize">
                                    <option disabled selected>{{ __("Select User Wallet") }}</option>
                                    @foreach ($user->wallets()->get() ?? [] as $item)
                                        <option value="{{ $item->id }}">{{ $item->currency->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => 'Amount',
                                    'label_after'   => "<span>*</span>",
                                    'name'          => 'amount',
                                    'value'         => old("amount"),
                                    'class'         => "number-input",
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'label'         => "Remark",
                                    'name'          => "remark",
                                    'value'         => old("remark"),
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                                <button type="button" class="btn btn--danger modal-close">{{ __("Close") }}</button>
                                <button type="submit" class="btn btn--base">{{ __("Action") }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('script')
    <script>
        getAllCountries("{{ setRoute('global.countries') }}");
        $(document).ready(function() {

            openModalWhenError("email-send","#email-send");
            openModalWhenError("wallet-balance-update-modal","#wallet-balance-update-modal");
            
            $("select[name=country]").change(function(){
                var phoneCode = $("select[name=country] :selected").attr("data-mobile-code");
                placePhoneCode(phoneCode);
            });

            setTimeout(() => {
                var phoneCodeOnload = $("select[name=country] :selected").attr("data-mobile-code");
                placePhoneCode(phoneCodeOnload);
            }, 400);

            countrySelect(".country-select",$(".country-select").siblings(".select2"));
            stateSelect(".state-select",$(".state-select").siblings(".select2"));


            $(".login-as-member").click(function() {
                var action  = "{{ setRoute('admin.users.login.as.member',$user->username) }}";
                var target  = "{{ $user->username }}";
                postFormAndSubmit(action,target);
            });

            $(".wallet-balance-update-btn").click(function(){
                openModalBySelector("#wallet-balance-update-modal");
            });
        })
    </script>
@endpush
