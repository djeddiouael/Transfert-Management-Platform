@extends('layouts.guest')
@section('content')
<div class="login-container">
    <div class="login-box">
        <div class="login-header">
            <img src="{{ asset('images/logo_umbb.png') }}" alt="@lang('auth.logo_alt')" class="login-logo">
            <h2 class="login-title">@lang('auth.reset_password')</h2>
        </div>
        <form class="login-form" action="{{ route('change_password') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token ?? '' }}">
            <div class="form-group">
                <label class="form-label">@lang('auth.current_password')</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" 
                           name="c_password" 
                           class="form-control" 
                           required 
                           placeholder="@lang('auth.current_password')">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">@lang('auth.new_password')</label>
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
                    <i class="fas fa-key"></i> @lang('auth.update')
                </button>
            </div>
            @error('c_password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </form>
        {{-- <div class="login-footer">
            <div class="language-switcher">
                <a href="{{ route('language.switch', 'en') }}" class="btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">@lang('auth.language.en')</a>
                <a href="{{ route('language.switch', 'fr') }}" class="btn {{ app()->getLocale() == 'fr' ? 'active' : '' }}">@lang('auth.language.fr')</a>
                <a href="{{ route('language.switch', 'ar') }}" class="btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">@lang('auth.language.ar')</a>
            </div>
        </div> --}}
    </div>
</div>
@endsection
