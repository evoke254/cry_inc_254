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
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __("Create new investment plan") }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" method="POST" action="{{ setRoute('admin.invest.plan.update',$invest_plan->slug) }}">
                @csrf
                @method("PUT")

                <div class="row">
                    <div class="col-6 form-group">
                        @include('admin.components.form.input',[
                            'label'         => "Plan Name*",
                            'type'          => "text",
                            'placeholder'   => "Write Name...",
                            'name'          => "name",
                            'value'         => old('name',$invest_plan->name),
                        ])
                    </div>
                    <div class="col-6 form-group">
                        @include('admin.components.form.input',[
                            'label'         => "Plan Title (Optional)",
                            'type'          => "text",
                            'placeholder'   => "Write Title...",
                            'name'          => "title",
                            'value'         => old('title',$invest_plan->title),
                        ])
                    </div>
                    <div class="col-6 form-group">
                        @include('admin.components.form.input',[
                            'label'         => "Plan Duration (Day)*",
                            'type'          => "text",
                            'class'         => "number-input",
                            'placeholder'   => "Write Plan Duration...",
                            'name'          => "duration",
                            'value'         => old('duration',$invest_plan->duration),
                        ])
                    </div>
                    <div class="col-6 form-group">
                        @php
                            $old_prt = old('profit_return_type',$invest_plan->profit_return_type);
                        @endphp
                        <label for="profit-return-type" class="form-label">{{ __("Profit Return Type*") }}</label>
                        <select name="profit_return_type" id="profit-return-type" class="form--control nice-select @error('profit_return_type') is-invalid @enderror">
                            <option value="" selected disabled>Choose One</option>
                            <option value="{{ global_const()::INVEST_PROFIT_DAILY_BASIS }}" @if ($old_prt == global_const()::INVEST_PROFIT_DAILY_BASIS) selected @endif>Day</option>
                            <option value="{{ global_const()::INVEST_PROFIT_ONE_TIME }}" @if ($old_prt == global_const()::INVEST_PROFIT_ONE_TIME) selected @endif>One Time</option>
                        </select>
                        @error('profit_return_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label>{{ __("Minimum investment*") }}</label>
                        <div class="input-group">
                            <input type="text" class="form--control number-input @error('min_invest') is-invalid @enderror" value="{{ old('min_invest',$invest_plan->min_invest) }}" name="min_invest" placeholder="Write Minimum Invest Amount...">
                            <span class="input-group-text">{{ get_default_currency_code($default_currency) }}</span>
                        </div>
                        @error('min_invest')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label>{{ __("Minimum investment Offer (Optional)") }}</label>
                        <div class="input-group">
                            <input type="text" class="form--control number-input @error('min_invest_offer') is-invalid @enderror" value="{{ old('min_invest_offer',$invest_plan->min_invest_offer) }}" name="min_invest_offer" placeholder="Write Minimum Invest Offer Amount...">
                            <span class="input-group-text">{{ get_default_currency_code($default_currency) }}</span>
                        </div>
                        @error('min_invest_offer')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label>{{ __("Maximum investment*") }}</label>
                        <div class="input-group">
                            <input type="text" class="form--control number-input @error('max_invest') is-invalid @enderror" value="{{ old('max_invest',$invest_plan->max_invest) }}" name="max_invest" placeholder="Write Maximum Invest Amount...">
                            <span class="input-group-text">{{ get_default_currency_code($default_currency) }}</span>
                        </div>
                        @error('max_invest')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label>{{ __("Profit (Fixed)*") }}</label>
                        <div class="input-group">
                            <input type="text" class="form--control number-input @error('profit_fixed') is-invalid @enderror" value="{{ old('profit_fixed',$invest_plan->profit_fixed) }}" name="profit_fixed" placeholder="Write Fixed Profit...">
                            <span class="input-group-text">{{ get_default_currency_code($default_currency) }}</span>
                        </div>
                        @error('profit_fixed')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6 form-group">
                        <label>{{ __("Profit (Percentage)*") }}</label>
                        <div class="input-group">
                            <input type="text" class="form--control number-input @error('profit_percent') is-invalid @enderror" value="{{ old('profit_percent',$invest_plan->profit_percent) }}" name="profit_percent" placeholder="Write Percentage Profit...">
                            <span class="input-group-text">%</span>
                        </div>
                        @error('profit_percent')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12">
                    @include('admin.components.button.form-btn',[
                        'class'         => "w-100 btn-loading",
                        'text'          => "Update",
                        'permission'    => "admin.invest.plan.update",
                    ])
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')

@endpush
