@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')
    <div class="send-add-form row g-4">
        <div class="col-lg-8 col-md-8 col-12 form-area mb-40">
            <div class="add-money-text pb-20">
                <h4>{{ __("Withdraw instructions") }}</h4>
            </div>
            <form class="row g-4 submit-form" method="POST" action="{{ setRoute('user.withdraw.instruction.submit',$token) }}" enctype="multipart/form-data">

                @csrf

                <div class="withdraw-instructions mb-4">
                    {!! $gateway->desc ?? "" !!}
                </div>

                <div class="row">
                    @include('user.components.payment-gateway.generate-dy-input',['input_fields' => array_reverse($gateway->input_fields)])
                </div>

                <div class="col-12 mt-5">
                    <button type="submit" class="btn--base w-100 text-center">{{ __("Submit_WEB") }}</button>
                </div>

            </form>
        </div>
    </div>
    
@endsection

@push('script')

@endpush