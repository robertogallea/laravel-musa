<header id="site-header">
    <div class="row">
        <div class="col-md-4 col-sm-5 col-xs-8">
            <div class="logo">
                <h1><a href="{{ route('index') }}"><b>{{ config('app.name') }}</b></a></h1>
            </div>
        </div><!-- col-md-4 -->
        <div class="col-md-8 col-sm-7 col-xs-4">
            <nav class="main-nav" role="navigation">
                <div class="navbar-header">
                    <button type="button" id="trigger-overlay" class="navbar-toggle">
                        <span class="ion-navicon"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="cl-effect-11"><a href="{{ route('index') }}" data-hover="Home">Home</a></li>
                        <li class="cl-effect-11"><a href="full-width.html" data-hover="Blog">Blog</a></li>
                        <li class="cl-effect-11"><a href="about.html" data-hover="About">About</a></li>
                        <li class="cl-effect-11"><a href="contact.html" data-hover="Contact">Contact</a></li>
                        @if (\Illuminate\Support\Facades\Auth::user())
                            <li class="cl-effect-11"><a href="{{ route('notifications.index') }}" data-hover="Contact">Notifications ({{ \Illuminate\Support\Facades\Auth::user()->unreadNotifications->count() }})</a></li>
                        @endif
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
            <div id="header-search-box">
                <a id="search-menu" href="#"><span id="search-icon" class="ion-ios-search-strong"></span></a>
                <div id="search-form" class="search-form">
                    <form role="search" method="get" id="searchform" action="#">
                        <input type="search" placeholder="Search" required>
                        <button type="submit"><span class="ion-ios-search-strong"></span></button>
                    </form>
                </div>
            </div>
        </div><!-- col-md-8 -->
    </div>
</header>
