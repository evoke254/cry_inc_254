@if ($basic_settings->kyc_verification == true && isset($kyc_data) && $kyc_data != null && $kyc_data->fields != null)

    <div class="custom-card mt-30">
        <div class="dashboard-header-wrapper">
            <h4 class="title text-white">{{ __("KYC Information_WEB") }} &nbsp; <span class="{{ auth()->user()->kycStringStatus->class }}">{{ auth()->user()->kycStringStatus->value }}</span></h4>
        </div>
        <div class="card-body">
            @if (auth()->user()->kyc_verified == global_const()::PENDING)
                <div class="pending text--warning kyc-text">{{ __("Your KYC information has been submitted. Please await confirmation from the administrator. Once your KYC verification is complete, your submitted information will be displayed here. Kindly be patient or reach out to our support for further assistance.") }}</div>
            @elseif (auth()->user()->kyc_verified == global_const()::APPROVED)
                <div class="approved text--success kyc-text">{{ __("Your KYC information is verified") }}</div>
                <ul class="kyc-data">
                    @foreach (auth()->user()->kyc->data ?? [] as $item)
                        <li>
                            @if ($item->type == "file")
                                @php
                                    $file_link = get_file_link("kyc-files",$item->value);
                                @endphp
                                <span class="kyc-title text-white">{{ __($item->label) }}:</span> 
                                @if (its_image($item->value))
                                    <div class="kyc-image">
                                        <img src="{{ $file_link }}" alt="{{ $item->label }}">
                                    </div>
                                @else
                                    <span class="text--danger">
                                        @php
                                            $file_info = get_file_basename_ext_from_link($file_link);
                                        @endphp
                                        <a href="{{ setRoute('file.download',["kyc-files",$item->value]) }}" >
                                            {{ Str::substr($file_info->base_name ?? "", 0 , 20 ) ."..." . $file_info->extension ?? "" }}
                                        </a>
                                    </span>
                                @endif
                            @else
                                <span class="kyc-title text-white">{{ __($item->label) }}:</span> 
                                <span class="text-white">{{ $item->value }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @elseif (auth()->user()->kyc_verified == global_const()::REJECTED)
                <div class="unverified text--danger kyc-text d-flex align-items-center justify-content-between mb-4">
                    <div class="title text--warning">{{ __("Your KYC information is rejected.") }}</div>
                </div>
                <div class="rejected">
                    <div class="rejected-reason text-white">{{ auth()->user()->kyc->reject_reason ?? "" }}</div>
                </div>
            @else
                <div class="unverified kyc-text d-flex align-items-center justify-content-between">
                    <div class="title text--danger">{{ __("Please verify KYC information") }}</div>
                </div>
            @endif
        </div>
    </div>

@endif