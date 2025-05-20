@extends('layouts.guest')

@section('content')
<style>
    .language-switcher {
        position: absolute;
        top: 10px;
        right: 15px;
        z-index: 1000;
    }

    .dropdown-lang {
        position: relative;
        display: inline-block;
    }

    .lang-btn {
        background-color: transparent;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 5px;
    }

    .lang-dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        min-width: 100px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 6px;
        overflow: hidden;
    }

    .lang-dropdown-content a {
        color: black;
        padding: 8px 12px;
        text-decoration: none;
        display: block;
    }

    .lang-dropdown-content a:hover,
    .lang-dropdown-content a.active {
        background-color: #f0f0f0;
        font-weight: bold;
    }

    .show {
        display: block;
    }
</style>

<div class="login-container position-relative">
    <!-- Menu de langue en 3 points -->
    <div class="language-switcher">
        <div class="dropdown-lang">
            <button onclick="toggleLangMenu()" class="lang-btn">&#x22EE;</button> <!-- 3 vertical dots -->
            <div id="langDropdown" class="lang-dropdown-content">
                <a href="{{ route('language.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">
                    @lang('auth.language.en')
                </a>
                <a href="{{ route('language.switch', 'fr') }}" class="{{ app()->getLocale() == 'fr' ? 'active' : '' }}">
                    @lang('auth.language.fr')
                </a>
                <a href="{{ route('language.switch', 'ar') }}" class="{{ app()->getLocale() == 'ar' ? 'active' : '' }}">
                    @lang('auth.language.ar')
                </a>
            </div>
        </div>
    </div>

    <div class="login-box">
        <div class="login-header">
            <img src="{{ asset('images/logo_umbb.png') }}" alt="@lang('auth.logo_alt')" class="login-logo">
            <h2 class="login-title">@lang('auth.login')</h2>
        </div>
        <form class="login-form" action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group">
                <label class="form-label">@lang('auth.username')</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" 
                           name="username" 
                           class="form-control" 
                           required 
                           placeholder="@lang('auth.enter_username')"
                           value="{{ old('username') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">@lang('auth.password')</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           required 
                           placeholder="@lang('auth.enter_password')">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt"></i> @lang('auth.login')
                </button>
            </div>
            @error('username')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </form>
        <div class="login-footer">
            <p class="text-center">
                @lang('auth.dont_have_account') 
                <a href="{{ route('register') }}">@lang('auth.register')</a>
            </p>
        </div>
    </div>
</div>

<script>
    function toggleLangMenu() {
        document.getElementById("langDropdown").classList.toggle("show");
    }

    // Fermer le menu si on clique ailleurs
    window.onclick = function (event) {
        if (!event.target.matches('.lang-btn')) {
            var dropdowns = document.getElementsByClassName("lang-dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                dropdowns[i].classList.remove('show');
            }
        }
    };
</script>
@endsection
