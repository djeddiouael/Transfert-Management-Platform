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
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #16a085;
            --background-color: #f5f6fa;
            --text-color: #2c3e50;
            --border-radius: 12px;
            --box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
            color: var(--text-color);
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-box {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2rem;
            transition: var(--transition);
        }

        .login-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            width: 120px;
            height: auto;
            margin-bottom: 1rem;
        }

        .login-title {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .login-form .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: var(--primary-color);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-group {
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
        }

        .input-group:focus-within {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .input-group-text {
            background: #f8f9fa;
            border: none;
            color: var(--primary-color);
        }

        .form-control {
            border: none;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 1rem;
            margin-top: 1rem;
            background: #fff3f3;
            color: #dc3545;
            font-weight: 500;
        }

        .login-footer {
            margin-top: 2rem;
            text-align: center;
        }

        .language-switcher {
            display: inline-flex;
            gap: 0.5rem;
        }

        .language-switcher .btn {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            background: #fff;
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .language-switcher .btn.active {
            background: var(--secondary-color);
            color: white;
            border-color: var(--secondary-color);
        }

        [dir="rtl"] .login-box {
            text-align: right;
        }

        [dir="rtl"] .input-group-text {
            border-right: none;
            border-left: 2px solid #e9ecef;
        }

        [dir="rtl"] .form-control {
            border-right: none;
            border-left: 2px solid #e9ecef;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
