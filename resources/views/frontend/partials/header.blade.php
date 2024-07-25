    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        Start Header
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <header class="header-section">
        <div class="header">
            <div class="header-bottom-area">
                <div class="container">
                    <div class="header-menu-content">
                        <nav class="navbar navbar-expand-lg p-0">
                            <a class="site-logo site-title" href="{{ setRoute('frontend.index') }}"><img src="{{ get_logo() }}"
                                    alt="site-logo"></a>
                            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="fas fa-bars"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav main-menu ms-auto">

                                    @foreach ($__setup_pages as $item)
                                        <li><a href="{{ setRoute($item->route_name) }}" class="{{ Route::is($item->route_name) ? "active" : "" }}">{{ __($item->title) }}</a></li>
                                    @endforeach
                                    <li><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target=".bd-example-modal-app">{{ __("Download App") }}</a></li>
                                </ul>
                                <div class="header-action  ms-lg-3 ms-0">
                                    @auth
                                        <a href="{{ setRoute('user.dashboard') }}" class="btn--base">{{ __("Dashboard") }}</a>
                                    @else
                                        <a href="{{ setRoute('user.login') }}" class="btn--base">{{ __("Login") }}</a>
                                    @endauth
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        End Header
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->