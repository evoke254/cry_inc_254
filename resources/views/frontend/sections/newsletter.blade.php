<section class="subscribe-section pt-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="subscribe-area">
                    <div class="subscribe-content">
                        <h2 class="title">{{ __("Stay connected with us for regular updates") }}</h2>
                    </div>
                    <form class="subscribe-form bounce-safe" id="subscribe-form" action="{{ setRoute('frontend.subscribe') }}" method="POST">
                        @csrf
                        <input type="email" class="form--control" placeholder="{{ __('Enter Your Email...') }}" name="email" value="{{ old('email') }}">
                        <button type="submit"><i class="las la-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>