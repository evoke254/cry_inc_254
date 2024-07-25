@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')
    <div class="table-content">
        <div class="row">
            <div class="card-1">
                <div class="row form-area">
                    <div class="col-lg-10 col-md-10 col-12">
                        <div class="form-area-tab">
                            <div class="user-text pb-4">
                                <h4>{{ __("Change Password_WEB") }}</h4>
                            </div>
                            <form action="{{ setRoute('user.profile.password.update') }}" method="post" role="form">
                                @csrf
                                @method("PUT")
                                <div class="row justify-content-center mb-20-none">
                                    <div class="col-xl-12 form-group mb-20 show_hide_password">
                                        <label class="mb-3">{{ __("Current Password") }}*</label>
                                        <input type="password" name="current_password" class="form-control" placeholder="{{ __('Enter Currenct Password') }}">
                                        <span class="show-pass change--password" role="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="col-xl-12 form-group mb-20 show_hide_password">
                                        <label class="mb-3">{{ __("New Password") }}*</label>
                                        <input type="password" name="password" class="form-control" placeholder="{{ __('Enter New Password') }}">
                                        <span class="show-pass change--password" role="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="col-xl-12 form-group mb-20 show_hide_password">
                                        <label class="mb-3">{{ __("Confirm Password") }}*</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Enter Confirm Password') }}">
                                        <span class="show-pass change--password" role="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="col-xl-12 form-group mb-20">
                                        <button type="submit" class="btn--base mt-4 w-100">{{ __("Change") }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')

@endpush