@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')
    
    <div class="table-content">
        <div class="row">
            <div class="card-1 mb-30">
                <div class="row form-area">
                    <div class="col-lg-10 col-md-10 col-12">
                        <div class="form-area-tab">
                            <div class="user-text pb-4">
                                <h4>{{ __("Create Ticket") }}</h4>
                            </div>
                            <form action="{{ setRoute('user.support.ticket.store') }}" role="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row  mb-20-none">
                                    <div class="col-xl-12 form-group mb-20">
                                        <label class="mb-3">{{ __("Subject") }} <span class="text-danger">*</span></label>
                                        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="{{ __('Enter Subject') }}">
                                    </div>
                                    <div class="col-xl-12 form-group mb-20">
                                        <label class="mb-3">{{ __("Message") }} <span class="text-danger">*</span></label>
                                        <textarea class="form-control h-75" name="desc" placeholder="{{ __('Enter Message') }}" aria-label="textarea" rows="4">{{ old('desc') }}</textarea>
                                    </div>
                                    <div class="col-12 form-group mb-20 mt-10">
                                        <label class="mb-3">{{ __("Attachment") }}</label>
                                        <div class="file-holder-wrapper">
                                            <input type="file" class="form-control" name="attachments" multiple>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 form-group mb-30">
                                        <button type="submit" class="btn--base mt-4 w-100">{{ __("Submit_WEB") }}</button>
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