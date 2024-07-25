<nav class="navbar-wrapper">
    <div class="navbar-wrapper-area">
        <div class="dashboard-title-part d-flex">
            <h4 class="title">{{ __($page_title ?? "Dashboard") }}</h4>
        </div>
        <div class="navbar__right ">
            <ul class="navbar__action-list" style="list-style: none;">
                <li class="dropdown">
                    <a href="{{ setRoute('user.profile.index') }}">
                        <span class="navbar-user">
                            <span class="navbar-user__thumb"><img src="{{ auth()->user()->userImage }}" alt="user"></span>
                            <span class="navbar-user__info">
                                <span class="navbar-user__name">{{ auth()->user()->full_name }}</span>
                            </span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>