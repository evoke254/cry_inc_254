@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')


    <div class="table-content">
        <div class="row">
            <div>
                <div class="p-4 card-user mt-30 mb-40">
                    <div class="row g-5 d-flex justify-content-center">
                        <div class="col-lg-4 col-md-12 col-12">
                            <img class=" d-block mx-auto avater" src="{{ auth()->user()->userImage }}"
                                alt="" height="200" width="200">
                            <div>
                                <div
                                    class="d-flex flex-wrap justify-content-between mt-4 rounded-2 p-2 user-card">
                                    <p class=" m-0 fw-bold">{{ __("Name:") }}</p>
                                    <p class=" m-0 ">{{ auth()->user()->full_name }}</p>
                                </div>
                                <div
                                    class="d-flex flex-wrap justify-content-between mt-4 rounded-2 p-2 user-card">
                                    <p class=" m-0 fw-bold">{{ __("Username:") }}</p>
                                    <p class=" m-0 ">{{ auth()->user()->username }}</p>
                                </div>
                                <div
                                    class="d-flex flex-wrap justify-content-between mt-4 rounded-2 p-2 user-card">
                                    <p class=" m-0 fw-bold">{{ __("Email:") }}</p>
                                    <p class=" m-0 ">{{ auth()->user()->email }}</p>
                                </div>
                                <div
                                    class="d-flex flex-wrap justify-content-between mt-4 rounded-2 p-2 user-card">
                                    <p class=" m-0 fw-bold">{{ __("Phone:") }}</p>
                                    <p class=" m-0 ">{{ auth()->user()->full_mobile }}</p>
                                </div>

                                <button type="button" class="btn--base bg-danger border-0 w-100 mt-4 delete-btn">{{ __("Delete Account") }}</button>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-12 col-12 pt-4">
                            <form action="{{ setRoute('user.profile.update') }}" class="form-dashboard user-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method("PUT")

                                <div class="row g-4k">
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label for="text1" class="form-label ">{{ __("First Name") }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="firstname" id="text1" value="{{ old('firstname',auth()->user()->firstname) }}" placeholder="{{ __('Enter First Name') }}">
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label for="text1" class="form-label ">{{ __("Last Name") }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="lastname" id="text1" value="{{ old('lastname',auth()->user()->lastname) }}" placeholder="{{ __('Enter Last Name') }}">
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label for="text2" class="form-label ">{{ __("Email") }}<span class="text-danger">&nbsp; ({{ __("Not Changable") }})</span></label>
                                        <input type="text" class="form-control" id="text2" readonly value="{{ auth()->user()->email }}" placeholder="{{ __('Email Address') }}">
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label for="phone" class="form-label ">{{ __("Phone") }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone',auth()->user()->full_mobile) }}" placeholder="{{ __('Enter Phone Number') }}">
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label>{{ __("Country") }}<span class="text-danger">*</span></label>
                                        <select name="country" class="form-control select2-basic country-select" data-placeholder="Select Country" data-old="{{ old('country',auth()->user()->address->country ?? "") }}"></select>
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label for="city" class="form-label ">{{ __("City") }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city',auth()->user()->address->city ?? "") }}" placeholder="{{ __('Enter City') }}">
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label for="State" class="form-label ">{{ __("State") }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="State" name="state" value="{{ old('state',auth()->user()->address->state ?? "") }}" placeholder="{{ __('Enter State') }}">
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label for="Address" class="form-label ">{{ __("Address") }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="Address" name="address" value="{{ old('address',auth()->user()->address->address ?? "") }}" placeholder="{{ __('Enter Address') }}">
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label for="Zip Code" class="form-label ">{{ __("Zip Code") }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="postal_code" id="Zip Code" value="{{ old('postal_code',auth()->user()->address->zip ?? "") }}" placeholder="{{ __('Enter Zip Code') }}">
                                    </div>
                                    <div class="mb-4 col-lg-6 col-md-6 col-12 pe-4">
                                        <label for="date1" class="form-label ">{{ __("Image") }}</label>
                                        <div class="file-holder-wrapper">
                                            <input type="file" class="form-control file-holder" name="image">
                                        </div>
                                    </div>
                                    <div class="my-3 col-12">
                                        <button class="btn--base w-100" type="submit">{{ __("Save") }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- Account Delete Modal --}}
    <div id="account-delete" class="mfp-hide large">
        <div class="modal-data">
            <div class="modal-header px-0">
                <h5 class="modal-title text-danger">{{ __("Are you sure to delete your account?") }}</h5>
            </div>

            <div class="card-content mt-4">
                <p class="text-light">{{ __("If you do not think you will use") }} <strong class="text--warning">{{ $basic_settings->site_name }}</strong> {{ __("again and like your account deleted, we can take card of this for you. Keep in mind you will not be able to reactivate your account or retrieve any of the content or information you have added. If you would still like your account deleted, click “Delete Account”.?") }}</p>
            </div>

            <div class="modal-form-data">
                <form class="modal-form" method="POST" action="{{ setRoute('user.profile.delete') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-10-none mt-3">
                        <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                            <button type="button" class="btn--base bg-secondary modal-close border-0">{{ __("Cancel") }}</button>
                            <button type="submit" class="btn--base bg-danger border-0">{{ __("Delete") }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>

        getAllCountries("{{ setRoute('global.countries') }}");
        $(document).ready(function(){
            countrySelect(".country-select",$(".country-select").siblings(".select2"));
            stateSelect(".state-select",$(".state-select").siblings(".select2"));


            $(".delete-btn").click(function() {
                // console.log("working");
                openModalBySelector("#account-delete");
            });
        });
    </script>
@endpush