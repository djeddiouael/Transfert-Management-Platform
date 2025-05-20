<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <!-- Logo Section -->
            <a href="{{ route('/') }}" class="logo d-flex align-items-center me-auto">
                <img src="{{ asset('front/assets/img/logo_umbb_2.png') }}" alt="">
            </a>

            <!-- Navigation Menu -->
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li>
                        <a href="#hero" class="active">
                            {{ trans('index.home') }}
                        </a>
                    </li>

                    
                    <li>
                        <a href="#presentation" class="active">
                            {{ trans('index.presentation') }}
                        </a>
                    </li>

                    <li>
                        <a href="#faculte" class="active">
                            {{ trans('index.faculte') }}
                        </a>
                    </li>

                    <li>
                        <a href="#search">
                            {{ trans('index.search') }}
                        </a>
                    </li>
                    
                    {{-- @if(count($categories) > 0)
                        <li>
                            <a href="#specialities">
                                {{ trans('index.scientific_fields') }}
                            </a>
                        </li>
                    @endif --}}

                    <li>
                        <a href="#position">
                            {{ trans('index.localization') }}
                        </a>
                    </li>

                    <li>
                        <a href="#contact">
                            {{ trans('index.contact_us') }}
                        </a>
                    </li>

                    {{-- <li>
                        <a href="#inscrire">
                            {{ trans('index.register') }}
                        </a>
                    </li>
 --}}
                </ul>

                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="cta-btn d-none d-sm-block" href="/login">
                {{ trans('index.login') }}
            </a>

        </div>
    </header>
</body>
