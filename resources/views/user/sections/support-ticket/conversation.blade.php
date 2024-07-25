@extends('user.layouts.master')

@push('css')
    
@endpush

@section('content')
    <div class="table-content">
        <div class="my-3 card-chat">
            <div class="row">
                <div class="user-text pb-4">
                    <h4>{{ __("Support Chat") }}</h4>
                    <hr>
                </div>
                <div class="col-12 overflow-hidden">
                    <div class="chat-area support-chat-area">
                        <div class="row messages">
                            @foreach ($support_ticket->conversations ?? [] as $item)
                                <div class="d-grid @if ($item->sender_type == "USER") justify-content-end @else justify-content-start @endif col-12">
                                    <div class="d-flex @if ($item->sender_type == "USER") justify-content-end @endif">
                                        @if ($item->sender_type == "ADMIN")
                                            <img class="img" src="{{ $item->senderImage }}" alt="client">
                                        @endif
                                        <div class="chat-body @if ($item->sender_type != "USER") recive @endif ps-3">
                                            <p>{{ $item->message }}</p>
                                        </div>
                                        @if ($item->sender_type == "USER")
                                            <img class="img" src="{{ $item->senderImage }}" alt="client">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="pt-40">
                        <hr>
                        @if ($support_ticket->status != support_ticket_const()::SOLVED)
                            <div action="" class="chat-form row pt-3">
                                <div class="col-lg-9 col-xl-10 col-md-9 col-12">
                                    <input type="text" class="form-control message-input-event message-input text-light" placeholder="{{ __('Write Message') }}">
                                </div>
                                <div class="col-lg-3 col-xl-2 col-md-3 col-12 d-flex justify-content-end pt-lg-0 pt-md-0 pt-3">
                                    {{-- <div>
                                        <span class="publisher-btn file-group me-3 mt-2">
                                            <input type="file" name="image" id="data">
                                            <label for="data"><i class="fa fa-paperclip"></i></label>
                                        </span>
                                    </div> --}}
                                    <div>
                                        <button type="button" class="btn--base chat-submit-btn-event">{{ __("Send") }} <i class="las la-paper-plane"></i></button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-warning">{{ __("This ticket is solved, you can't send message right now.") }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('admin.components.support-ticket.conversation.connection-user',[
    'support_ticket' => $support_ticket,
    'route'          => setRoute('user.support.ticket.messaage.send'),
])