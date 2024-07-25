
<!-- jquery -->
<script src="{{ asset('public/frontend/js/jquery-3.6.0.min.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ asset('public/frontend/js/bootstrap.bundle.min.js') }}"></script>
<!-- swipper js -->
<script src="{{ asset('public/frontend/js/swiper.min.js') }}"></script>
<!-- lightcase js-->
<script src="{{ asset('public/frontend/js/lightcase.js') }}"></script>
<!-- smooth scroll js -->
<script src="{{ asset('public/frontend/js/smoothscroll.min.js') }}"></script>
<script src="{{ asset('public/frontend/js/jquery.nice-select.js') }}"></script>

<script src="{{ asset('public/frontend/js/apexcharts.min.js') }}"></script>

<!-- Select 2 JS -->
<script src="{{ asset('public/backend/js/select2.min.js') }}"></script>
<script src="{{ asset('public/backend/library/popup/jquery.magnific-popup.js') }}"></script>

@include('admin.partials.notify')

<!-- main -->
<script src="{{ asset('public/frontend/js/main.js') }}"></script>

{{-- Cookie Script START --}}
<script>
    (function ($) {
        "use strict";

        //Allow
        $('.cookie-btn').on('click', function() {
            var postData = {
                type: "allow",
                _token: laravelCsrf(),
            };
            $.post('{{ route('global.set.cookie') }}', postData, function(response) {
                throwMessage('success', [response]);
                setTimeout(function() {
                    location.reload();
                }, 1000);
            });
        });

        //Decline
        $('.cookie-btn-cross').on('click', function() {
            var postData = {
                type: "decline",
                _token: laravelCsrf(),
            };
            $.post('{{ route('global.set.cookie') }}', postData, function(response) {
                throwMessage('error',[response]);
                setTimeout(function(){
                    location.reload();
                },1000);
            });
        });
    })(jQuery)
</script>
{{-- Cookie Script END --}}