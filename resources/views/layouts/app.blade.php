<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Library Management System') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @if(app()->getLocale() == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="{{ asset('css/appstyle2.css') }}">
    <style>
    .menu-select {
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
        width: 100%;
        max-width: 300px;
    }

    .menu-select option.active {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }
</style>

</head>

<body>
    @if (auth()->check() && auth()->user()->user_type == 'agent')
        @include('demende')
    @else
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">

            <nav class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home menu-icon"></i>
                    @lang('dashboard.dashboard')
                </a>
                @if(auth()->user()->user_type == 'admin')
                <a href="{{ route('admin.transfer-requests.index') }}" class="menu-item {{ request()->routeIs('admin.transfer-requests.*') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt menu-icon"></i>
                    @lang('dashboard.transfer_requests')
                </a>
                @endif
                <a href="{{ route('chefdomaine.index') }}" class="menu-item {{ request()->routeIs('chefdomaine.*') ? 'active' : '' }}">
                    <i class="fas fa-users menu-icon"></i>
                    @lang('dashboard.chef_domaine')
                </a>
                <a href="{{ route('faculte.index') }}" class="menu-item {{ request()->routeIs('faculte.*') ? 'active' : '' }}">
                    <i class="fas fa-building menu-icon"></i>
                    @lang('dashboard.faculties')
                </a>
                <a href="{{ route('categories') }}" class="menu-item {{ request()->routeIs('categories') ? 'active' : '' }}">
                    <i class="fas fa-bookmark menu-icon"></i>
                    @lang('dashboard.categories')
                </a>
                <a href="{{ route('books') }}" class="menu-item {{ request()->routeIs('books') ? 'active' : '' }}">
                    <i class="fas fa-book menu-icon"></i>
                    @lang('dashboard.books')
                </a>
                {{-- <a href="{{ route('students') }}" class="menu-item {{ request()->routeIs('students') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap menu-icon"></i>
                    @lang('dashboard.students')
                </a> --}}
              
            </nav>
            <div class="sidebar-footer">
                {{-- <div class="language-switcher">
                    <a href="{{ route('language.switch', 'en') }}" class="btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                    <a href="{{ route('language.switch', 'ar') }}" class="btn {{ app()->getLocale() == 'fr' ? 'active' : '' }}">FR</a>
                    <a href="{{ route('language.switch', 'ar') }}" class="btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">عربي</a>
                </div> --}}
                <a href="{{ route('change_password') }}" class="menu-item">
                    <i class="fas fa-key menu-icon"></i>
                    @lang('dashboard.change_password')
                </a>
                <a href="#" onclick="document.getElementById('logoutForm').submit()" class="menu-item">
                    <i class="fas fa-sign-out-alt menu-icon"></i>
                    @lang('dashboard.logout')
                </a>
                <form method="post" id="logoutForm" action="{{ route('logout') }}">
                    @csrf
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->

            <!-- Page Content -->
            <div class="page-content">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="main-footer">
                <div class="footer-content">
                    <p class="copyright">@lang('dashboard.copyright') © {{ now()->format("Y") }} -Promo Si</p>
                </div>
            </footer>
        </main>
    </div>

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @endif
</body>

</html>
