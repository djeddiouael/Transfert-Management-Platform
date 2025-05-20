@extends('layouts.guest')
@section('content')
<div class="login-container">
    <div class="login-box">
        <div class="login-header">
            <img src="{{ asset('images/logo_umbb.png') }}" alt="@lang('auth.logo_alt')" class="login-logo">
            <h2 class="login-title">@lang('auth.register')</h2>
        </div>
        <form class="login-form" action="{{ route('register') }}" method="post">
            @csrf
            <div class="form-group">
                <label class="form-label">@lang('auth.name')</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" 
                           name="name" 
                           class="form-control" 
                           required 
                           placeholder="@lang('auth.enter_name')"
                           value="{{ old('name') }}">
                </div>
            </div>
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
                <label class="form-label">@lang('auth.email')</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" 
                           name="email" 
                           class="form-control" 
                           required 
                           placeholder="@lang('auth.enter_email')"
                           value="{{ old('email') }}">
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
                <label class="form-label">@lang('auth.confirm_password')</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" 
                           name="password_confirmation" 
                           class="form-control" 
                           required 
                           placeholder="@lang('auth.confirm_password')">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-user-plus"></i> @lang('auth.register')
                </button>
            </div>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('username')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </form>
        <div class="login-footer">
            <p class="text-center">
                @lang('auth.already_have_account') 
                <a href="{{ route('login') }}">@lang('auth.login')</a>
            </p>
            <!-- <div class="language-switcher">
                <a href="{{ route('language.switch', 'en') }}" class="btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">@lang('auth.language.en')</a>
                <a href="{{ route('language.switch', 'fr') }}" class="btn {{ app()->getLocale() == 'fr' ? 'active' : '' }}">@lang('auth.language.fr')</a>
                <a href="{{ route('language.switch', 'ar') }}" class="btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">@lang('auth.language.ar')</a>
            </div> -->
        </div>
    </div>
</div>
@endsection 